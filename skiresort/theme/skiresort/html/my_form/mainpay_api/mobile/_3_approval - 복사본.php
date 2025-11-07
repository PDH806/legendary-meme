<?php
  include "../../../../../../common.php";
	header('Content-Type: text/html; charset=utf-8');		
	require('utils.php'); // 유틸리티 포함
	$logPath = "/home/asiaski/public_html/skiresort/data/app.log"; //디버그 로그위치 (리눅스)
	//$logPath = "c://app.log";     //디버그 로그위치 (windows)

    /********************************************************************************	
	 * 인증이 완료될 경우 PG사에서 호출하는 페이지 입니다. 	     
	 * PG로 부터 전달 받은 인증값을 받아 PG로 승인요청을 합니다.	
	 ********************************************************************************/
     
	$aid = $_REQUEST["aid"];
	$authToken = $_REQUEST["authToken"];
	$merchantData = $_REQUEST["merchantData"];
	$payType = $_REQUEST["payType"];
	$receiveParam = "## 인증결과수신 ## aid:".$aid.", authToken:".$authToken; 
	pintLog("RECEIVE-PARAM: ".$receiveParam, $logPath);
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

	$sql2 = "SELECT Event_total_limit FROM SBAK_OFFICE_CONF WHERE Event_code = '{$goodsCode}'";
	$row2 = sql_fetch($sql2);
	$event_total_limit = $row2['Event_total_limit'];			
	$approvalUrl = "https://asiaski.org/skiresort/theme/skiresort/html/my_form/mainpay_api/mobile/_3_approval.php";	
	$closeUrl = "https://asiaski.org/skiresort/theme/skiresort/html/my_form/mainpay_api/mobile/_3_close.php";				
	$customerName = $row2['MEMBER_NAME'];	
	$customerEmail = $row2['EMAIL'];				
	$timestamp = makeTimestamp();
	$signature = makeSignature($mbrNo,$mbrRefNo,$amount,$apiKey,$timestamp); 
	
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
	$PAY_API_URL = $API_BASE."/v1/payment/pay";
	$result = "";
	$errorMessage = "";
	
	try{
		pintLog("PAY-API: ".$PAY_API_URL, $logPath);
		pintLog("PARAM: ".print_r($parameters, TRUE), $logPath);
		$result = httpPost($PAY_API_URL, $parameters);
	} catch(Exception $e) {
		$errorMessage = "승인요청API 호출실패: " . $e;
		pintLog($errorMessage, $logPath);
		
		/*********************************************************************************
		* 망취소 처리(승인API 호출 도중 응답수신에 실패한 경우) 
		*********************************************************************************/
     	$NET_CANCEL_URL = $API_BASE."/v1/payment/net-cancel"; 
     	$result = httpPost($NET_CANCEL_URL, $parameters);			
		return;			
	}
	// echo("<br>## 승인요청API 호출 결과 : <br>" . $result); 
	pintLog("RESPONSE: ".$result, $logPath);
	
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
	if($resultCode != "200"){		
		/*호출실패*/
		$errorMessage = "<br>## 승인요청API 호출 결과: resultCode:".$resultCode . ", resultMessage". $resultMessage;
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
 // sql 검증문
		if (!$result){
         echo "<script>
            alert('처리 중 오류가 발생했습니다.');
          </script>";			
		}

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

		if (!$result){
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
		$the_status = "77";
        break;

    case 'B01':
		$target_table = "SBAK_T1_TEST_Apply";
		$target_url = G5_THEME_URL . "/html/my_form/sbak_console_T1_test.php?sports=ski";
		$the_status = "77";
        break;   
	case 'B04':
        $target_table = "SBAK_T1_TEST_Apply";
		$target_url = G5_THEME_URL . "/html/my_form/sbak_console_T1_test.php?sports=sb";
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


		if ($limit_result['CNT'] >= $event_total_limit) {
			$the_status = "66";
		}else {
			$the_status = "77";
		}
        break;   
    		     
    default:
        break;
}		



if($goodsCode == 'B01' || $goodsCode == 'B04'){

$sql3 = "UPDATE {$target_table} SET
	PAYMENT_STATUS = 'Y' , T_status='{$the_status}'
	WHERE AID = '{$aid}'";
}else{

$sql3 = "UPDATE {$target_table} SET
		PAYMENT_STATUS = 'Y' , THE_STATUS='{$the_status}'
		WHERE AID = '{$aid}'";
}
sql_query($sql3);

echo "<script>
   alert('결제가 완료되었습니다.');
 </script>";	




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
// var resultCode = "<?=$resultCode ?>";
// var resultMessage = "<?=$resultMessage ?>";
// alert("resultCode:" + resultCode + ": " + resultMessage);

/* 결제처리 성공 유무에 따른 화면 전환 */
// self.close();		
location.href = "<?= $target_url ?>"
// location.href = "_4_complete.php";	
</script> 
</body>
</html>