<?php

	/********************************************************************************	
	  결제창 종료시에 PG사에서 호출하는 페이지 입니다.
	  상점에서 필요한 로직 추가	
	********************************************************************************/

?>
<?php
ini_set( "display_errors", 0 );
ini_set('display_startup_errors', 0);
//error_reporting(E_ALL);

	header('Content-Type: text/html; charset=utf-8');		
	require('utils.php');
	$servername	= "dbserver"; $username = "skiresort"; $password = "ll170505"; $dbname = "skiresort";
	$link = mysqli_connect($servername, $username, $password, $dbname); 	
	$logPath = "/var/www/html/card/app.log"; //디버그 로그위치 (리눅스)

    /********************************************************************************	
	 * 인증이 완료될 경우 PG사에서 호출하는 페이지 입니다. 	     
	 * PG로 부터 전달 받은 인증값을 받아 PG로 승인요청을 합니다.	
	 ********************************************************************************/

	$aid = $_REQUEST["aid"];
	$authToken = $_REQUEST["authToken"];
	$merchantData = $_REQUEST["merchantData"];
	$payType = $_REQUEST["payType"];
	$receiveParam = "## 인증결과.. ## aid:".$aid.", authToken:".$authToken; 
	pintLog("RECEIVE-PARAM: ".$receiveParam, $logPath);
	
	$PAY_query	= "SELECT * FROM 7G_Master_Apply where AID = '$aid'";
	// echo $PAY_query;

	//echo $authToken.'--';




	// exit;
	$PAY_result	= mysqli_query($link, $PAY_query);
	$PAY		= mysqli_fetch_array($PAY_result);

	echo $receiveParam; // 실운영시 제거
	
	/********************************************************************************
     * ready에서 DB에 저장한 요청정보 값 조회해서 사용하세요.
     ********************************************************************************/		
		
	// $API_BASE = "https://api-std.mainpay.co.kr";
	// $apiKey = "U1FVQVJFLTEwNzYwMzIwMjExMTAzMTMxNTM3Njc4OTUx";
	// $mbrNo = "107603";

	// $API_BASE = "https://test-api-std.mainpay.co.kr";
	// $apiKey = "U1FVQVJFLTEwMDAxMTIwMTgwNDA2MDkyNTMyMTA1MjM0";
	// $mbrNo = "100011";

	// $version = "V001";		
	
	include '../pc/config.php';

	$mbrRefNo = $PAY['REF_NO'];
	$paymethod = $PAY['PAY_METHOD'];		
	$amount = $PAY['AMOUNT'];
	$goodsName = $PAY['PRODUCT_NAME'];
	$goodsCode = $PAY['PRODUCT_CODE'];
	$approvalUrl = $payServerDomain."/pc/exam_approve.php";	
	$closeUrl = $payServerDomain."/pc/exam_app_close.php";	
	
	
	$customerName = $PAY['MEMBER_NAME'];
	$customerEmail = $row['MEMBER_EMAIL'];	
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
	
	echo $PAY_API_URL;

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
		
	echo("<br>## 승인요청API 호출 결과 ##<br>" .$result);
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
			$errorMessage = "<br>## 승인요청API 호출 결과 ##<br>resultCode = ".$resultCode.", resultMessage = ".$resultMessage;
			$Result_Code = "결제실패";
			$TRAN_STATUS = "결제실패";
			$Pay_Update = "update 7G_Master_Apply set refNo = '$refNo', TRAN_TIME = '$tranTime', APPROVAL_NO = '$applNo', PAYMENT_STATUS = '$Result_Code', TRAN_STATUS = '$TRAN_STATUS', cardNo = '$cardNo', issueCardName = '$issueCardName', acqCompanyNo = '$acqCompanyNo',acqCompanyName = '$acqCompanyName', AuthToken = '$authToken' where REF_NO = '$mbrRefNo'";
			$result		= mysqli_query($link, $Pay_Update);

			//echo $errorMessage; // 실운영시 제거

			echo "
			<script>
				alert('요청하신 결제가 처리되지 않았습니다.');
				self.close();		
			</script>";

			} 
else
		{
		/*승인요청API 호출 성공*/		
		$refNo = $data->{'refNo'};
		$tranDate = $data->{'tranDate'};
		$mbrRefNo = $data->{'mbrRefNo'};
		$applNo = $data->{'applNo'};
		$payType = $data->{'payType'};
		$cardNo = $data->{'cardNo'};
		$issueCardName = $data->{'issueCardName'};
		$acqCompanyNo = $data->{'acqCompanyNo'};
		$acqCompanyName	= $data->{'acqCompanyName'};
		$tranTime = $data->{'tranTime'};

		$Result_Code = "2";
		$TRAN_STATUS = "1";
		$Pay_Update = "update 7G_Master_Apply set 
		refNo 			= '$refNo', 
		TRAN_TIME 		= '$tranTime', 
		APPROVAL_NO 	= '$applNo', 
		PAYMENT_STATUS 	= '$Result_Code', 
		TRAN_STATUS 	= '$TRAN_STATUS', 
		cardNo 			= '$cardNo', 
		issueCardName 	= '$issueCardName', 
		acqCompanyNo 	= '$acqCompanyNo',
		acqCompanyName 	= '$acqCompanyName', 
		AuthToken 		= '$authToken' 
		where REF_NO 	= '$mbrRefNo'";

		$result		= mysqli_query($link, $Pay_Update);


		echo "
		<script>
			alert('요청하신 결제가 완료되었습니다.');
			self.close();		
		</script>";
	
		}

?>