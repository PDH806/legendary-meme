<?php
	require('utils.php');                // 유틸리티 포함
	$servername	= "dbserver"; $username = "skiresort"; $password = "ll170505"; $dbname = "skiresort";
	$link = mysqli_connect($servername, $username, $password, $dbname); 	
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
	
		
	$MEMBER_ID 	= $_POST["MEMBER_ID"];
	$MEMBER_NO 	= $_POST["MEMBER_NO"];
	$BuyerTel 	= $_POST["BuyerTel"];
	$LICENSE 	= $_POST["LICENSE"];
	$TRAN_DATE 	= $_POST["Test_Date"];
	$Test_No 	= $_POST["Test_No"];
	$Apply_date = $_POST["Apply_date"];
	$Skiresort_No		= $_POST["Skiresort_No"];

	$ZONE_CODE 	= $_POST["ZIP"];
	$ADDR1 		= $_POST["ADDRESS1"];
	$ADDR2 		= $_POST["ADDRESS2"];
	$ADDR3 		= $_POST["ADDRESS3"];
	$mbrRefNo 	= $_POST["REF_NO"];
	$type 		= $_POST["type"];

	if ($type == 'T1'){$Test_Name = '스키 티칭1'; $Test_Table = '7G_T1_Schedules'; $Apply_Table = '7G_T1_Apply'; $Product_Name = 'SKI-Teaching1'; $REF_NO = "TA";}
	if ($type == 'T2'){$Test_Name = '스키 티칭2'; $Test_Table = '7G_T2_Schedules'; $Apply_Table = '7G_T2_Apply'; $Product_Name = 'SKI-Teaching2'; $REF_NO = "TB";}
	if ($type == 'T3'){$Test_Name = '스키 티칭3 & 기술선수권대회'; $Test_Table = '7G_T3_Schedules'; $Apply_Table = '7G_T3_Apply'; $Product_Name = 'SKI-Teaching3'; $REF_NO = "TC";}

	if ($type == 'SBT1'){$Test_Name = '스노보드 티칭1'; $Test_Table = '7G_SBT1_Schedules'; $Apply_Table = '7G_SBT1_Apply'; $Product_Name = 'SB-Teaching1'; $REF_NO = "SA";}
	if ($type == 'SBT2'){$Test_Name = '스노보드 티칭2'; $Test_Table = '7G_SBT2_Schedules'; $Apply_Table = '7G_SBT2_Apply';  $Product_Name = 'SB-Teaching2'; $REF_NO = "SB";}
	if ($type == 'SBT3'){$Test_Name = '스노보드 티칭3 & 기술선수권대회'; $Test_Table = '7G_SBT3_Schedules'; $Apply_Table = '7G_SBT3_Apply';  $Product_Name = 'SB-Teaching3'; $REF_NO = "SC";}

	if ($type == 'PATROL'){$Test_Name = '스키구조요원'; $Test_Table = '7G_Patrol_Schedules'; $Apply_Table = '7G_Patrol_Apply';  $Product_Name = 'PATROL'; $REF_NO = "P";}

	/* 가맹점 주문번호 (가맹점 고유ID 대체가능) 6byte~20byte*/
	// $mbrRefNo = makeMbrRefNo($mbrNo);

	$query	= "SELECT * FROM 7G_Master_Apply where TEST_ID = '$type' and MEMBER_ID = '$row[MEMBER_ID]'";
	$result	= mysqli_query($link, $query);
	$count	= mysqli_num_rows($result) + 1;
	$length = strlen($count);
	if($length == 1){$count = "00".$count;}
	if($length == 2){$count = "0".$count;}
	if($length == 3){$count = $count;}

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
	$approvalUrl = "https://skiresort.or.kr/pc/exam_approve.php";
	/*결제창 close시 호출되는 상점URL (PG->가맹점)*/
	$closeUrl = "https://skiresort.or.kr/pc/exam_app_close.php";
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

	$sql = "INSERT INTO 7G_Master_Apply (

		REF_NO,
		Apply_date,
		TEST_ID,
		TRAN_DATE,
		TRAN_TIME,
		Test_No,
		SKIRESORT_NO,
		MEMBER_NO,
		MEMBER_ID,
		MEMBER_NAME,
		MEMBER_PHONE,
		MEMBER_EMAIL,
		T_ZIPCODE,
		T_ADDR1,
		T_ADDR2,
		T_ADDR3,
		APPROVAL_NO,
		PRODUCT_CODE,
		PRODUCT_NAME,
		PAY_METHOD,
		AMOUNT,
		TRAN_STATUS,
		AID
		)

		VALUES
		(
		'$mbrRefNo',
		'$Apply_date',
		'$type',
		'$Apply_date',
		'$TRAN_TIME',
		$Test_No,
		$Skiresort_No,
		'$MEMBER_NO',
		'$MEMBER_ID',
		'$customerName',
		'$BuyerTel',
		'$customerEmail',
		'$ZONE_CODE',
		'$ADDR1',
		'$ADDR2',
		'$ADDR3',
		'',
		'$goodsCode',
		'$goodsName',
		'$paymethod',
		$amount,
		1,
		'$aid')
		";

	$db_result=mysqli_query($link, $sql);

  	if ($db_result === false) { echo mysqli_error($link);}

	// JSON TYPE RESPONSE
	header('Content-Type: application/json');
	echo $result;
?>
