<?php
	require('utils.php');                // 유틸리티 포함
	$servername	= "localhost"; $username = "skiresort"; $password = "wints!"; $dbname = "skiresort";
	$link = mysqli_connect($servername, $username, $password, $dbname); 	
	mysqli_set_charset($link, "utf8mb4");
	$logPath = "/var/www/card/app.log"; //디버그 로그위치 (리눅스)

	 /*****************************************************************************************
     * READY API  (결제창 호출 전처리)    
     ******************************************************************************************
	 - API 호출 도메인
     - ## 테스트 완료후 real 서비스용 URL로 변경  ## 
     - 리얼-URL : https://api-std.mainpay.co.kr 
     - 개발-URL : https://test-api-std.mainpay.co.kr  	 	 	 
	 */
	 	
	$API_BASE = "https://api-std.mainpay.co.kr";

    /*
      API KEY (비밀키)  
     - 생성 : http://biz.mainpay.co.kr 고객지원>기술지원>암호화키관리
     - 가맹점번호(mbrNo) 생성시 함께 만들어지는 key (테스트 완료후 real 서비스용 발급필요) */
    $apiKey = "U1FVQVJFLTEwNzYwMzIwMjExMTAzMTMxNTM3Njc4OTUx"; // <===테스트용 API_KEY입니다. 100011		

	/*****************************************************************************************
    *	필수 파라미터 
    ******************************************************************************************/
	$version = "V001";		
    /* 가맹점 아이디(테스트 완료후 real 서비스용 발급필요)*/
	$mbrNo = "107603"; //<===테스트용 가맹점아이디입니다.

    include "../pc/config.php";	
	$MEMBER_ID = $_POST["MEMBER_ID"];	
	$MEMBER_NO = $_POST["MEMBER_NO"];	
	$BuyerTel = $_POST["BuyerTel"];
	$LICENSE = $_POST["LICENSE"];
	$TRAN_DATE = $_POST["Test_Date"];
	
	$ZONE_CODE = $_POST["ZIP"];
	$ADDR1 = $_POST["ADDRESS1"];
	$ADDR2 = $_POST["ADDRESS2"];
	$ADDR3 = $_POST["ADDRESS3"];

	/* 가맹점 주문번호 (가맹점 고유ID 대체가능) 6byte~20byte*/
	// $mbrRefNo = makeMbrRefNo($mbrNo);
	$REF_NO = "A";
	$query	= "SELECT * FROM 7G_License_Renew where MEMBER_ID = '$MEMBER_ID'";
	$result	= mysqli_query($link, $query);
	$count	= mysqli_num_rows($result) + 1;

	$mbrRefNo = $REF_NO.$MEMBER_NO.'-'.$count;

	/* 결제수단 */
	$paymethod = $_POST["paymethod"];		
   	/* 결제금액 (공급가+부가세)
 	  (#주의#) 페이지에서 전달 받은 값을 그대로 사용할 경우 금액위변조 시도가 가능합니다.
 	  DB에서 조회한 값을 사용 바랍니다. */	 

	$amount = $_POST["Amt"];
	/* 상품명 max 30byte, 특수문자 사용금지*/	
	//$goodsName = urlencode("테스트상품명");	
	$goodsName = $_POST["goodsName"];	
	/* 상품코드 max 8byte*/
	$goodsCode = $_POST["goodsCode"];		
	/*인증완료 시 호출되는 상점 URL (PG->가맹점)*/	
	$approvalUrl = $payServerDomain . "/pc/_3_approval.php";	
	/*결제창 close시 호출되는 상점URL (PG->가맹점)*/
	$closeUrl = $payServerDomain . "/pc/_3_close.php";				
	$customerName = $_POST["BuyerName"];
	$customerEmail = $_POST["BuyerEmail"];			
	/* timestamp max 20byte*/
	$timestamp = makeTimestamp();
	/* signature 64byte*/
	$signature = makeSignature($mbrNo,$mbrRefNo,$amount,$apiKey,$timestamp); 
	$TRAN_TIME = str_replace(":", "", date('h:i:s'));
	
	
	/*****************************************************************************************
    *	옵션 파라미터 
    ******************************************************************************************/
	
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

    /*****************************************************************************************
	* READY API 호출
	*****************************************************************************************/
	$READY_API_URL = $API_BASE."/v1/payment/ready"; 
	$result = "";
	$errorMessage = "";
	try{
		pintLog("READY-API: ".$READY_API_URL, $logPath);
		pintLog("PARAM: ".print_r($parameters, TRUE), $logPath);
		$result = httpPost($READY_API_URL, $parameters);
	} catch(Exception $e) {
		$errorMessage = "결제준비API 호출실패: " . $READY_API_URL;
		pintLog("ERROR: ".$errorMessage, $logPath);
		throw new Exception($e);
		return;
	}
	
	pintLog("RESPONSE: ".$result, $logPath);
	$obj = json_decode($result);	
	$resultCode = $obj->{'resultCode'};
	$resultMessage = $obj->{'resultMessage'};
	$aid = "";			
	if($resultCode = "200"){		
		$data = $obj->{'data'};
		$aid = $data->{'aid'};	
	}
	
	/******************************************************************************************
	* 요청정보 DB에 저장 (parameters, apiKey, aid, API_BASE, amount 등)
	* 브라우저 cross-domain session, cookie 정책 강화로 session 사용 지양
	* PG로부터 인증결과 수신후 결제승인 요청시에 필요
	******************************************************************************************/

	$sql = "INSERT INTO 7G_License_Renew
		(
		REF_NO, 
		TRAN_DATE,
		TRAN_TIME,
		MEMBER_NO, 
		MEMBER_ID, 
		MEMBER_NAME, 
		MEMBER_PHONE, 
		MEMBER_EMAIL, 
		ZIPCODE, 
		ADDR1, 
		ADDR2, 
		ADDR3, 
		LICENSE_NO, 
		APPROVAL_NO, 
		PRODUCT_CODE,
		PRODUCT_NAME, 
		PAY_METHOD, 
		AMOUNT, 
		PAYMENT_STATUS,
		DELIVERY_DATE, 
		DELIVERY_AGENCY, 
		TRACKING_NO, 
		DELIVERY_FEE, 
		MEMO1, 
		TRAN_STATUS, 
		AID
		) 

		VALUES 
		(
		'$mbrRefNo', 
		'$TRAN_DATE',
		'$TRAN_TIME',
		'$MEMBER_NO', 
		'$MEMBER_ID', 
		'$customerName', 
		'$BuyerTel',
		'$customerEmail',
		'$ZONE_CODE',
		'$ADDR1', 
		'$ADDR2', 
		'$ADDR3', 
		'$LICENSE', 
		'', 
		'$goodsCode', 
		'$goodsName',
		'$paymethod',
		$amount, 
		0, 
		NULL,
		'미발송', 
		'미발송', 
		0,
		'',
		0,
		'$aid')
		";


	$db_result=mysqli_query($link, $sql);

  	if ($db_result === false) { echo mysqli_error($link);}

	// JSON TYPE RESPONSE
	header('Content-Type: application/json');
	echo $result;
?>    
