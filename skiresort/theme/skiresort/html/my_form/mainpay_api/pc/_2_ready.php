<?php

include "../../../../../../common.php";
require('utils.php');                // 유틸리티 포함
//$logPath = "c://app.log";            //디버그 로그위치 (windows)
$logPath = G5_PATH . "/data/app.log"; //디버그 로그위치 (리눅스)
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


$payment_category = $_POST['payment_category'] ?? '';


$version = "V001";
/* 가맹점 아이디(테스트 완료후 real 서비스용 발급필요)*/
$mbrNo = "100011"; //<===테스트용 가맹점아이디입니다.
/* 가맹점 주문번호 (가맹점 고유ID 대체가능) 6byte~20byte*/
/* $mbrRefNo = makeMbrRefNo($mbrNo); */


// 2) 현재년도 (YYYY)
$the_year = date("Y");

$sql = "SELECT MAX(UID) AS max_uid FROM sbak_mainpay";
$row = sql_fetch($sql);

// 3) 최대 UID + 1
$next_uid = ($row['max_uid'] ?? 0) + 1;
// 4) UID 부분을 6자리 고정 (예: 1 -> 000001, 123 -> 000123)
$uid_seq = str_pad($next_uid, 6, "0", STR_PAD_LEFT);

	$mbrRefNo = $goodsCode.'-'.$the_year.'-'.$uid_seq;


//------------------------------------------------------------------여기부터
/* 결제수단 */
$paymethod = $_POST["paymethod"];

/* 상품명 max 30byte, 특수문자 사용금지*/
//$goodsName = urlencode("테스트상품명");	
$goodsName = $_POST["goodsName"];

/* 상품코드 max 8byte*/
$goodsCode = $_POST["goodsCode"];

/* 결제금액 (공급가+부가세)
 	  (#주의#) 페이지에서 전달 받은 값을 그대로 사용할 경우 금액위변조 시도가 가능합니다.
 	  DB에서 조회한 값을 사용 바랍니다. */
$sql = "SELECT Entry_fee FROM SBAK_OFFICE_CONF WHERE Event_code = '{$goodsCode}'";
$row = sql_fetch($sql);
$amount = $row['Entry_fee'];
// $amount = "1004";

/*인증완료 시 호출되는 상점 URL (PG->가맹점)*/
$approvalUrl = G5_THEME_URL . "/html/my_form/mainpay_api/pc/_3_approval.php";
/*결제창 close시 호출되는 상점URL (PG->가맹점)*/
$closeUrl = G5_THEME_URL . "/html/my_form/mainpay_api/pc/_3_close.php";

$customerName = $_POST["mb_name"]; // 고객명
$customerEmail = $_POST["the_email"]; // 고객이메일
$customerID = $_POST["mb_id"]; // 고객ID
$PHONE = $_POST["on_hp"]; // 고객 전화번호
$APPLY_DATE = date("Y-m-d"); // 신청일
$APPLY_TIME = date("H:i:s"); // 신청시간
$THE_MEMO = $_POST['the_memo']; // 메모  

/* timestamp max 20byte*/
$timestamp = makeTimestamp();
/* signature 64byte*/
$signature = makeSignature($mbrNo, $mbrRefNo, $amount, $apiKey, $timestamp);
//--------------------------------------------------------------여기까지 공통


if ($goodsCode == 'A01' || $goodsCode == 'A02' || $goodsCode == 'A03') { // 자격증 재발급 일 경우

$MB_LICENSE_NO = $_POST['mb_license_no'] ?? ''; // o
$ZIP = $_POST['ZIP'] ?? ''; // o
$ADDR1 = $_POST['ADDR1'] ?? ''; // o
$ADDR2 = $_POST['ADDR2'] ?? ''; // o
$ADDR3 = $_POST['ADDR3'] ?? ''; // o
$CATE_1 = $_POST['CATE_1'] ?? ''; // o

$event_year = '';

}elseif ($goodsCode == 'B01' || $goodsCode == 'B04') { //티칭1 일 경우

$T_code = $_POST['t_code'] ?? ''; // o
$THE_TYPE = $_POST['the_type'] ?? ''; // o
$event_year = $_POST['event_year'] ?? ''; // o
$T_Date = $_POST['t_date'] ?? ''; // o

}else{ // 행사 신청 일 경우

    $MB_LICENSE_NO = $_POST['mb_license_no'] ?? ''; // o
    $THE_GENDER = $_POST['the_gender'] ?? ''; // o
    $THE_PROFILE = $_POST['the_profile'] ?? ''; // o
    $ENTRY_INFO_1 = $_POST['entry_info_1'] ?? ''; // o
    $ENTRY_INFO_2 = $_POST['entry_info_2'] ?? ''; // o
    $ENTRY_INFO_3 = $_POST['entry_info_3'] ?? ''; // o
    $ENTRY_INFO_4 = $_POST['entry_info_4'] ?? ''; // o
    $ENTRY_INFO_5 = $_POST['entry_info_5'] ?? ''; // o
    $ENTRY_INFO_6 = $_POST['entry_info_6'] ?? ''; // o
    $event_year = $_POST['event_year'] ?? ''; // o
    $ENTRY_INFO_4_FILE = $_POST['filename1'] ?? ''; // o
    $ENTRY_INFO_6_FILE = $_POST['filename2'] ?? ''; // o
    $ENTRY_INFO_7_FILE = $_POST['filename3'] ?? ''; // o
    $unique_order_id = $_POST['unique_order_id'] ?? ''; // o


}



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
	'customerEmail' => $customerEmail,
	'phone' => $PHONE,
	'timestamp' => $timestamp,
	'event_year' => $event_year,
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
PRODUCT_YEAR,
MEMBER_ID, 
MEMBER_NAME,
EMAIL, 
PHONE, 
mbrRefNo, 
amount, 
PAY_METHOD,
AID,
Unique_order_id	,
INSERT_DATE
) 

VALUES
 (
'{$goodsCode}',
'{$goodsName}',
'{$event_year}',
'{$customerID}',
'{$customerName}',
'{$customerEmail}',
'{$PHONE}',
'{$mbrRefNo}',
'{$amount}',
'{$paymethod}',
'{$aid}',
'{$unique_order_id}',
NOW()
)
"; 

	 sql_query($sql);



switch ($payment_category) {
    
    case 'service':
        $target_table = "SBAK_SERVICE_LIST";
        $sql3 = " INSERT INTO {$target_table}
        SET                 
        REGIS_DATE        = '{$APPLY_DATE}',
        REGIS_TIME           = '{$APPLY_TIME}',
        MEMBER_ID     = '{$customerID}',
        MEMBER_NAME           = '{$customerName}',      
        MEMBER_PHONE      = '{$PHONE}',
        MEMBER_EMAIL        = '{$customerEmail}',
        ZIP      = '{$ZIP}',
        ADDR1        = '{$ADDR1}',
        ADDR2      = '{$ADDR2}',     
        ADDR3      = '{$ADDR3}',                
        LICENSE_NO     = '{$MB_LICENSE_NO}',
        PRODUCT_CODE            = '{$goodsCode}',
        PRODUCT_NAME            = '{$goodsName}',
        CATE_1            = '{$CATE_1}',
        PAY_METHOD            = '{$paymethod}',           
        AMOUNT          = '{$amount}',   		
        MEMO1             = '{$THE_MEMO}',       
        AID          = '{$aid}' ";
        break;

    case 'event':
        $target_table = "SBAK_Master_Apply";
        $sql3 = " INSERT INTO {$target_table}
        SET                     
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
        ENTRY_INFO_2           = '{$ENTRY_INFO_2}',   
        ENTRY_INFO_3           = '{$ENTRY_INFO_3}',  
        ENTRY_INFO_4           = '{$ENTRY_INFO_4}', 
        ENTRY_INFO_4_FILE           = '{$ENTRY_INFO_4_FILE}',
        ENTRY_INFO_5           = '{$ENTRY_INFO_5}',  
        ENTRY_INFO_6           = '{$ENTRY_INFO_6}', 
        ENTRY_INFO_6_FILE           = '{$ENTRY_INFO_6_FILE}', 
        ENTRY_INFO_7_FILE           = '{$ENTRY_INFO_7_FILE}', 
        EVENT_YEAR           = '{$event_year}',    
        AID         = '{$aid}',
        IS_DEL             = '' ";
        break;

    case 't1':
        $target_table = "SBAK_T1_TEST_Apply";
        $sql3 = " INSERT INTO {$target_table}
        SET
        T_code      = '{$T_code}',
        TYPE        = '{$THE_TYPE}',
        T_Date      = '{$T_Date}',
        MEMBER_ID   = '{$customerID}',
        MEMBER_NAME = '{$customerName}',
        PHONE       = '{$PHONE}',
        EMAIL       = '{$customerEmail}',
        TEST_YEAR   = '{$event_year}',
        PAYMETHOD  = '{$paymethod}',           
        AMOUNT      = '{$amount}',  			
        MEMO        = '{$THE_MEMO}',       
        REGIST_DATE  = '{$APPLY_DATE}',
        REGIST_TIME  = '{$APPLY_TIME}',
        AID         = '{$aid}'
        ";
        
        break;        
    default:
        break;
}		



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
