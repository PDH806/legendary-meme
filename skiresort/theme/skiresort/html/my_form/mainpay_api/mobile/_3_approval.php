<?php
header('Content-Type: text/html; charset=utf-8');
include "../../../../../../common.php";
require('utils.php'); // 유틸리티 포함
//$logPath = "c://app.log";     //디버그 로그위치 (windows)
$logPath = G5_PATH . "/data/app.log"; //디버그 로그위치 (리눅스)

/********************************************************************************	
 * 인증이 완료될 경우 PG사에서 호출하는 페이지 입니다. 	     
 * PG로 부터 전달 받은 인증값을 받아 PG로 승인요청을 합니다.	
 ********************************************************************************/

$aid = $_REQUEST["aid"];
$authToken = $_REQUEST["authToken"];
$merchantData = $_REQUEST["merchantData"];
$payType = $_REQUEST["payType"];
$receiveParam = "## 인증결과수신 ## aid:" . $aid . ", authToken:" . $authToken;
pintLog("RECEIVE-PARAM: " . $receiveParam, $logPath);
//echo $receiveParam; // 실운영시 제거

/********************************************************************************
 *	reay에서 DB에 저장한 요청정보 값 조회해서 사용하세요.
 ********************************************************************************/

$sql2 = "SELECT * FROM sbak_mainpay where AID = '{$aid}'";
$row2 = sql_fetch($sql2);

$API_BASE = "https://test-api-std.mainpay.co.kr";
$apiKey = "U1FVQVJFLTEwMDAxMTIwMTgwNDA2MDkyNTMyMTA1MjM0";

$version = "V001";
$mbrNo = "100011";
/*$mbrRefNo = makeMbrRefNo($mbrNo);*/
$mbrRefNo = $row2['mbrRefNo'];
$paymethod = $row2['PAY_METHOD'];
$amount = $row2['amount'];
$goodsName = $row2['PRODUCT_NAME'];
$goodsCode = $row2['PRODUCT_CODE'];
$event_year = $row2['PRODUCT_YEAR'];
$PHONE = $row2['PHONE'];

$sql2 = "SELECT Event_total_limit,Event_extra_cnt FROM SBAK_OFFICE_CONF WHERE Event_code = '{$goodsCode}'";
$row2 = sql_fetch($sql2);
$event_total_limit = $row2['Event_total_limit'];
$event_extra_cnt = $row2['Event_extra_cnt']; //추가모집인원

$approvalUrl = G5_THEME_URL . "/html/my_form/mainpay_api/mobile/_3_approval.php";
$closeUrl = G5_THEME_URL . "/html/my_form/mainpay_api/mobile/_3_close.php";
$customerName = $row2['MEMBER_NAME'];
$customerEmail = $row2['EMAIL'];
$timestamp = makeTimestamp();
$signature = makeSignature($mbrNo, $mbrRefNo, $amount, $apiKey, $timestamp);

$parameters = array(
	'version' => $version,
	'mbrNo' => $mbrNo,
	'mbrRefNo' => $mbrRefNo,
	'paymethod' => $paymethod,
	'amount' => $amount,
	'goodsName' => $goodsName,
	'goodsCode' => $goodsCode,
	'approvalUrl' => $approvalUrl,
	'closeUrl' => $closeUrl,
	'customerName' => $customerName,
	'customerEmail' => $customerEmail,
	'timestamp' => $timestamp,
	'signature' => $signature
);

$parameters["aid"] = $aid;
$parameters["authToken"] = $authToken;
$parameters["merchantData"] = $merchantData;
$parameters["payType"] = $payType;

/********************************************************************************
 * 승인요청 API 호출         	
 *********************************************************************************/
$PAY_API_URL = $API_BASE . "/v1/payment/pay";
$result = "";
$errorMessage = "";

try {
	pintLog("PAY-API: " . $PAY_API_URL, $logPath);
	pintLog("PARAM: " . print_r($parameters, TRUE), $logPath);
	$result = httpPost($PAY_API_URL, $parameters);
} catch (Exception $e) {
	$errorMessage = "승인요청API 호출실패: " . $e;
	pintLog($errorMessage, $logPath);

	/*********************************************************************************
	 * 망취소 처리(승인API 호출 도중 응답수신에 실패한 경우) 
	 *********************************************************************************/
	$NET_CANCEL_URL = $API_BASE . "/v1/payment/net-cancel";
	$result = httpPost($NET_CANCEL_URL, $parameters);
	return;
}
// echo("<br>## 승인요청API 호출 결과 : <br>" . $result); 
pintLog("RESPONSE: " . $result, $logPath);

$obj = json_decode($result);
$resultCode = $obj->{'resultCode'};
$resultMessage = $obj->{'resultMessage'};
$data = $obj->{'data'};
/* 추가 항목은 연동매뉴얼 참조*/
$refNo = "";      // 거래번호
$tranDate = "";	  // 거래일자
$mbrRefNo = "";   // 주문번호
$applNo = "";     // 승인번호
$payType = "";    // 인증타입

/*********************************************************************************
 * 승인결과 처리 (결과에 따라 상점 DB처리 및 화면 전환 처리)
 *********************************************************************************/
if ($resultCode != "200") {
	/*호출실패*/
	$errorMessage = "<br>## 승인요청API 호출 결과: resultCode:" . $resultCode . ", resultMessage" . $resultMessage;
	//echo $errorMessage; // 실운영시 제거

	//실패시 쿼리

	$sql = "UPDATE sbak_mainpay SET 
    refNo = '', 
    tranDate = '', 
    tranTime = '', 
    STATUS = '결제실패', 
    resultMessage = '{$resultMessage}'
WHERE AID = '{$aid}'";

	$result = sql_query($sql);

		echo "<script>
            alert('결제실패 했습니다.');
          </script>";


	return;
} else {

	/*승인요청API 호출 성공*/
	$refNo = $data->{'refNo'};
	$tranDate = $data->{'tranDate'};
	$tranTime = $data->{'tranTime'};
	$payType = $data->{'payType'};
	$applNo = $data->{'applNo'};

	$mbrRefNo = $data->{'mbrRefNo'};
	$bankCode = $data->{'bankCode'};
	$bankName = $data->{'bankName'};

	$cardNo = $data->{'cardNo'};
	$installment = $data->{'installment'};
	$issueCompanyNo = $data->{'issueCompanyNo'};
	$acqCompanyNo = $data->{'acqCompanyNo'};

	/*== 가맹점 DB 주문처리 ==*/

	$sql = "UPDATE sbak_mainpay SET
		refNo = '{$refNo}', 
		tranDate = '{$tranDate}', 
		tranTime = '{$tranTime}', 
		applNo = '{$applNo}', 
		payType = '{$payType}',
		bankCode = '{$bankCode}', 
		bankName = '{$bankName}', 
		cardNo = '{$cardNo}', 	
		installment = '{$installment}', 
		issueCompanyNo = '{$issueCompanyNo}', 
		acqCompanyNo = '{$acqCompanyNo}', 
		STATUS = '결제성공', 
		resultMessage = '{$resultMessage}'
		WHERE AID = '{$aid}'";

	// sql 검증문
	$result = sql_query($sql);

	if (!$result) {
		echo "<script>
            alert('처리 중 오류가 발생했습니다.');
          </script>";
	}





	switch ($goodsCode) {

		case 'A01':
		case 'A02':
		case 'A03':
			$target_table = "SBAK_SERVICE_LIST";
			$target_url = G5_THEME_URL . "/html/my_form/sbak_console_05.php";
			$sms_msg = $customerName . " 회원님의 " . $goodsName . " 신청이 정상등록되었습니다. 마이페이지에서 자세한 등록정보를 확인하세요. ";
			$the_status = "77";
			break;

		case 'B01':
			$target_table = "SBAK_T1_TEST_Apply";
			$target_url = G5_THEME_URL . "/html/my_form/sbak_console_T1_test.php?sports=ski";
			$sms_msg = $customerName . " 회원님의 " . $goodsName . " 신청이 정상등록되었습니다. 마이페이지에서 자세한 등록정보를 확인하세요. ";
			$the_status = "77";
			break;
		case 'B04':
			$target_table = "SBAK_T1_TEST_Apply";
			$target_url = G5_THEME_URL . "/html/my_form/sbak_console_T1_test.php?sports=sb";
			$sms_msg = $customerName . " 회원님의 " . $goodsName . " 신청이 정상등록되었습니다. 마이페이지에서 자세한 등록정보를 확인하세요. ";
			$the_status = "77";
			break;

		case 'B02':
		case 'B03':
		case 'B05':
		case 'B06':
		case 'B07':
		case 'C01':
			$target_table = "SBAK_Master_Apply";
			$target_url = G5_THEME_URL . "/html/my_form/sbak_console_04.php";

			$sql = "select count(*) as CNT from {$target_table} where EVENT_CODE = '{$goodsCode}' and (EVENT_YEAR = '{$event_year}' and PAYMENT_STATUS = 'Y')";
			$limit_result = sql_fetch($sql);


			$event_extra_limit = $event_total_limit +  $event_extra_cnt; //총 등록가능인원

			if ($limit_result['CNT'] >= $event_total_limit) {

				$sql = "select UID from {$target_table} where AID = '{$aid}'";
				$result_uid = sql_fetch($sql);
				$uid = $result_uid['UID'];

				// 확정 순서를 뽑아내자
				$sql = "select count(*) as CNT from {$target_table} where EVENT_CODE like '{$goodsCode}' 
                                         and (EVENT_YEAR = '{$event_year}' and THE_STATUS = '77') and PAYMENT_STATUS = 'Y' and UID < {$uid}";


				$result_cnt = sql_fetch($sql);
				$ok_cnt = intval($result_cnt['CNT']);


				if ($ok_cnt > 0 && ($ok_cnt >  $event_total_limit)) {
					if ($ok_cnt < $event_extra_limit) {
						$stanby_no = $ok_cnt - $event_total_limit;

						$sms_msg = $customerName . " 회원님의 " . $goodsName . " 신청은 대기순번 " . $stanby_no . "으로 등록되었습니다. 대기순번은, 먼저 신청한 등록자가 취소하는 경우
					순번대로 참가확정 여부가 달라집니다. 마이페이지에서 자세한 등록정보를 확인하세요. ";
					}
				} else {
					$sms_msg = $customerName . " 회원님의 " . $goodsName . " 신청은 결제완료되었으나, 총 등록인원 초과로  '등록실패' 되었습니다. 마이페이지에서 자세한 등록정보를 확인 후, 결제건을 취소해주세요. ";
				}

				$the_status = "66";
			} else {
				$sms_msg = $customerName . " 회원님의 " . $goodsName . " 신청이 정상등록되었습니다. 마이페이지에서 자세한 등록정보를 확인하세요. ";
				$the_status = "77";
			}


			break;


		default:
			break;
	}


	// 문자발송 시작

	//여기서 부터 문자서비스를 위한 아이코드 모듈 인클루드 및 함수선언
	include_once(G5_LIB_PATH . '/icode.lms.lib.php');  //LMS모듈


	function lmsSend($sHp, $rHp, $msg)
	{
		global $g5, $config;
		$rtn = "";
		try {
			$send_hp = str_replace("-", "", $sHp); // - 제거 
			$recv_hp = str_replace("-", "", $rHp); // - 제거 
			$strDest = array();
			$strDest[0] = $recv_hp;
			$SMS = new LMS; // SMS 연결 
			$SMS->SMS_con(
				$config['cf_icode_server_ip'],
				$config['cf_icode_id'],
				$config['cf_icode_pw'],
				'1'
			);
			$SMS->Add(
				$strDest,
				$send_hp,
				$config['cf_icode_id'],
				"",
				"",
				iconv("utf-8", "euc-kr", $msg),
				"",
				"1"
			);
			//                            iconv("utf-8", "euc-kr", stripslashes($msg)), 
			// 메세지에서 특수문자를 제거하여 발송하려면 stripslashes를 추가하세요
			$SMS->Send();
			$rtn = true;
		} catch (Exception $e) {
			alert("처리중 문제가 발생했습니다." . $e->getMessage());
			$rtn = false;
		}
		return $rtn;
	}


	$msg = $sms_msg; //문자내용
	$sHp = "02-3473-1275"; // 발송번호
	$rHp = $PHONE; // 수신번호

	lmsSend($sHp, $rHp, $msg); //문자발송

	//문자발송 종료



	if ($goodsCode == 'B01' || $goodsCode == 'B04') {

		$sql3 = "UPDATE {$target_table} SET
	PAYMENT_STATUS = 'Y' , T_status='{$the_status}'
	WHERE AID = '{$aid}'";
	} else {

		$sql3 = "UPDATE {$target_table} SET
		PAYMENT_STATUS = 'Y' , THE_STATUS='{$the_status}'
		WHERE AID = '{$aid}'";
	}
	sql_query($sql3);

	// alert($msg, '');

	echo "<script> alert('결제가 완료되었습니다.'); </script>";

}

?>
<!DOCTYPE html>
<html>

<head>
    <title>상점 도착페이지</title>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <script src="https://api-std.mainpay.co.kr/js/mainpay.pc-1.0.js"></script>
</head>

<body>
    <script>
    /* 결제 완료 페이지 호출 */
    // var resultCode = "<?= $resultCode ?>";
    // var resultMessage = "<?= $resultMessage ?>";
    // alert("resultCode:" + resultCode + ": " + resultMessage);

    /* 결제처리 성공 유무에 따른 화면 전환 */
    // self.close();		
    location.href = "<?= $target_url ?>"
    // location.href = "_4_complete.php";	
    </script>
</body>

</html>