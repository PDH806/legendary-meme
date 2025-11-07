<?php

include "../../../../../../common.php";
require('utils.php');                // 유틸리티 포함
//$logPath = "c://app.log";            //디버그 로그위치 (windows)
$logPath = "/home/asiaski/public_html/skiresort/data/app.log";         //디버그 로그위치 (리눅스)

/*****************************************************************************************
 * READY API  (결제창 호출 전처리)    
 ******************************************************************************************
	 - API 호출 도메인
     - ## 테스트 완료후 real 서비스용 URL로 변경  ## 
     - 리얼-URL : https://api-std.mainpay.co.kr 
     - 개발-URL : https://test-api-std.mainpay.co.kr  	 	 	 
 */

$API_BASE = "https://test-api-std.mainpay.co.kr";

/*
      API KEY (비밀키)  
     - 생성 : http://biz.mainpay.co.kr 고객지원>기술지원>암호화키관리
     - 가맹점번호(mbrNo) 생성시 함께 만들어지는 key (테스트 완료후 real 서비스용 발급필요) */
$apiKey = "U1FVQVJFLTEwMDAxMTIwMTgwNDA2MDkyNTMyMTA1MjM0"; // <===테스트용 API_KEY입니다. 100011		

/*****************************************************************************************
 *	필수 파라미터 
 ******************************************************************************************/
$version = "V001";
/* 가맹점 아이디(테스트 완료후 real 서비스용 발급필요)*/
$mbrNo = "100011"; //<===테스트용 가맹점아이디입니다.
/* 가맹점 주문번호 (가맹점 고유ID 대체가능) 6byte~20byte*/
/* $mbrRefNo = makeMbrRefNo($mbrNo); */
$mbrRefNo = "P000010001";




// 2) 현재년도 (YYYY)
$event_year = date("Y");

$sql = "SELECT MAX(UID) AS max_uid FROM sbak_mainpay";
$row = sql_fetch($sql);

// 3) 최대 UID + 1
$next_uid = ($row['max_uid'] ?? 0) + 1;
// 4) UID 부분을 6자리 고정 (예: 1 -> 000001, 123 -> 000123)
$uid_seq = str_pad($next_uid, 6, "0", STR_PAD_LEFT);


	$mbrRefNo = $goodsCode.$event_year.'-'.$uid_seq;





/* 결제수단 */
$paymethod = $_POST["paymethod"];
/* 결제금액 (공급가+부가세)
 	  (#주의#) 페이지에서 전달 받은 값을 그대로 사용할 경우 금액위변조 시도가 가능합니다.
 	  DB에서 조회한 값을 사용 바랍니다. */
$amount = "1004";
/* 상품명 max 30byte, 특수문자 사용금지*/
//$goodsName = urlencode("테스트상품명");	
$goodsName = $_POST["goodsName"];
/* 상품코드 max 8byte*/
$goodsCode = $_POST["goodsCode"];
/*인증완료 시 호출되는 상점 URL (PG->가맹점)*/
$approvalUrl = "https://asiaski.org/skiresort/theme/skiresort/html/my_form/php_sample/pc/_3_approval.php";
/*결제창 close시 호출되는 상점URL (PG->가맹점)*/
$closeUrl = "https://asiaski.org/skiresort/theme/skiresort/html/my_form/php_sample/pc/_3_close.php";
$customerName = $_POST["mb_name"]; // o
$customerEmail = $_POST["the_email"]; // o
$customerID = $_POST["mb_id"]; // o
$PHONE = $_POST["on_hp"]; // o

    $APPLY_DATE = date("Y-m-d"); // o
    $APPLY_TIME = date("H:i:s"); // o 
    $MB_LICENSE_NO = $_POST['mb_license_no']; // o
    $THE_GENDER = $_POST['the_gender']; // o

    $THE_PROFILE = $_POST['the_profile']; // o
    $THE_MEMO = $_POST['the_memo']; // o
    $ENTRY_INFO_1 = $_POST['entry_info_1']; // o
    $ENTRY_INFO_3 = $_POST['entry_info_3']; // o
    $ENTRY_INFO_4 = $_POST['entry_info_4']; // o
    $ENTRY_INFO_5 = $_POST['entry_info_5']; // o
    $ENTRY_INFO_6 = $_POST['entry_info_6']; // o
    $EVENT_YEAR = $_POST['event_year']; // o
/* timestamp max 20byte*/
$timestamp = makeTimestamp();
/* signature 64byte*/
$signature = makeSignature($mbrNo, $mbrRefNo, $amount, $apiKey, $timestamp);

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
	'customerID' => $customerID,
	'phone' => $PHONE,
	'applyDate' => $APPLY_DATE,
	'applyTime' => $APPLY_TIME,
	'licenseNo' => $MB_LICENSE_NO,
	'gender' => $THE_GENDER,
	'memo' => $THE_MEMO,
	'entryInfo1' => $ENTRY_INFO_1,
	'entryInfo3' => $ENTRY_INFO_3,
	'entryInfo4' => $ENTRY_INFO_4,
	'entryInfo5' => $ENTRY_INFO_5,
	'entryInfo6' => $ENTRY_INFO_6,
	'year' => $EVENT_YEAR,
	'timestamp' => $timestamp,
	'signature' => $signature
);

/*****************************************************************************************
 * READY API 호출
 *****************************************************************************************/
$READY_API_URL = $API_BASE . "/v1/payment/ready";
$result = "";
$errorMessage = "";
try {
	pintLog("READY-API: " . $READY_API_URL, $logPath);
	pintLog("PARAM: " . print_r($parameters, TRUE), $logPath);
	$result = httpPost($READY_API_URL, $parameters);
} catch (Exception $e) {
	$errorMessage = "결제준비API 호출실패: " . $READY_API_URL;
	pintLog("ERROR: " . $errorMessage, $logPath);
	throw new Exception($e);
	return;
}

pintLog("RESPONSE: " . $result, $logPath);
$obj = json_decode($result);
$resultCode = $obj->{'resultCode'};
$resultMessage = $obj->{'resultMessage'};
$aid = "";
if ($resultCode = "200") {
	$data = $obj->{'data'};
	$aid = $data->{'aid'};
}

/******************************************************************************************
 * 요청정보 DB에 저장 (parameters, apiKey, aid, API_BASE, amount 등)
 * 브라우저 cross-domain session, cookie 정책 강화로 session 사용 지양
 * PG로부터 인증결과 수신후 결제승인 요청시에 필요
 ******************************************************************************************/

$sql = "INSERT INTO sbak_mainpay
(
PRODUCT_CODE, 
PRODUCT_NAME, 
MEMBER_ID, 
MEMBER_NAME,
PHONE, 
mbrRefNo, 
amount, 
PAY_METHOD,
AID,
INSERT_DATE
) 

VALUES
 (
'{$goodsCode}',
'{$goodsName}',
'{$customerID}',
'{$customerName}',
'{$PHONE}',
'{$mbrRefNo}',
'{$amount}',
'{$paymethod}',
'{$aid}',
NOW()
)
"; 

	 sql_query($sql);


		


   $sql3 = " insert into SBAK_Master_Apply
                set 
                                       
                    EVENT_CODE        = '{$goodsCode}',
                    EVENT_TITLE        = '{$goodsName}',
                    MB_ID           = '{$customerID}',                   
                    MB_NAME      = '{$customerName}',
                    MB_LICENSE_NO      = 'test',
                    APPLY_DATE        = '{$APPLY_DATE}',
                    APPLY_TIME     = '{$APPLY_TIME}',     
                    THE_BIRTH      = '1999-01-01',                
                    THE_GENDER            = '{$THE_GENDER}',
                    THE_TEL           = '{$PHONE}', 
                    PAY_METHOD           = '{$paymethod}',   
                    AMOUNT           = '{$amount}',        
                    THE_PROFILE          = '{$THE_PROFILE}',  
                    mbrRefNo          = '{$mbrRefNo}',  
                    THE_MEMO          = '{$THE_MEMO}',   
                    ENTRY_INFO_1           = '{$ENTRY_INFO_1}',    
                    ENTRY_INFO_3           = '{$ENTRY_INFO_3}',  
                    ENTRY_INFO_4           = '{$ENTRY_INFO_4}', 
                    ENTRY_INFO_5           = '{$ENTRY_INFO_5}',  
                    ENTRY_INFO_6           = '{$ENTRY_INFO_6}', 
                    EVENT_YEAR           = '{$EVENT_YEAR}',            
                    THE_STATUS         = '66',          
                    AID         = '{$aid}',
                    IS_DEL             = '' ";



		$result3 = sql_query($sql3);

		// sql 검증문
		if (!$result3){
         echo "<script>
            alert('처리 중 오류가 발생했습니다.');
          </script>";			
		}
// JSON TYPE RESPONSE
header('Content-Type: application/json');
echo $result;
