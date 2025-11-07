<?php

include "../../../../../../common.php";
//header('Content-Type: application/json; charset=utf-8');

header('Content-Type: text/html; charset=utf-8');
require('utils.php');                // 유틸리티 포함

$logPath = "/home/asiaski/public_html/skiresort/data/app.log"; //디버그 로그위치 (리눅스)


/*****************************************************************************************
 * CANCEL API URL  (결제 취소 URL)    
 ******************************************************************************************
	- API 호출 도메인
    - ## 테스트 완료후 real 서비스용 URL로 변경  ## 
    - 리얼-URL : https://relay.mainpay.co.kr/v1/api/payments/payment/cancel
    - 개발-URL : https://test-relay.mainpay.co.kr/v1/api/payments/payment/cancel  	 	 	 
 */

$CANCEL_API_URL = "https://test-relay.mainpay.co.kr/v1/api/payments/payment/cancel";

/*
      API KEY (비밀키)  
     - 생성 : http://biz.mainpay.co.kr 고객지원>기술지원>암호화키관리
     - 가맹점번호(mbrNo) 생성시 함께 만들어지는 key (테스트 완료후 real 서비스용 발급필요) */
$apiKey = "U1FVQVJFLTEwMDAxMTIwMTgwNDA2MDkyNTMyMTA1MjM0"; // <===테스트용 API_KEY입니다. 100011		


/*****************************************************************************************
 *	취소 요청 파라미터 
 ******************************************************************************************/

if ($is_guest || !$is_member) {
    alert('회원만 이용하실 수 있습니다.', $_SERVER['HTTP_REFERER']);
    exit;
}

if ($member['mb_level'] < 2) {
    alert('이용 권한이 없습니다.', $_SERVER['HTTP_REFERER']);
    exit;
}

$mb_name = $member['mb_name'];



$aid = $_POST['AID'] ?? '';
$is_del = $_POST['is_del'] ?? '';
$payment_category = $_POST['payment_category'] ?? '';

$the_status = $_POST['the_status'] ?? '';

if (empty($aid) || empty($is_del) || empty($payment_category) || empty($the_status)) {
 alert("비정상 접근입니다.", $_SERVER['HTTP_REFERER']);
}




$main_pay_table = "sbak_mainpay";

switch ($payment_category) {
    case 'service':
        $target_table = "SBAK_SERVICE_LIST";
        break;
    case 'event':
        $target_table = "SBAK_Master_Apply";
        break;
    case 't1':
        $target_table = "SBAK_T1_TEST_Apply";
        break;        
    default:
        break;
}







if ($is_del <> 'yes') {
    alert("비정상 접근입니다.", $_SERVER['HTTP_REFERER']);
}

$return_url = $_SERVER['HTTP_REFERER'];
$sql = "SELECT * FROM {$main_pay_table} where AID = '{$aid}'";

$row = sql_fetch($sql);








$version = "V001";
/* 가맹점 아이디(테스트 완료후 real 서비스용 발급필요)*/
$mbrNo = "100011"; //<===테스트용 가맹점아이디입니다.
/* 가맹점 주문번호 (가맹점 고유ID 대체가능) 6byte~20byte*/
$mbrRefNo = $row['mbrRefNo'];
/* 원거래번호 (결제완료시에 수신한 값)*/
$orgRefNo = $row['refNo'];
/* 원거래일자(결제완료시에 수신한 값) YYMMDD */
$orgTranDate = $row['tranDate'];
/* 원거래 지불수단 (CARD:신용카드|VACCT:가상계좌|ACCT:계좌이체|HPP:휴대폰소액) */
$paymethod = $row['PAY_METHOD'];
/* 결제금액 */
$amount = "1004";
/* 결제타입 (결제완로시에 받은 값) */
$payType = $row['payType'];
/* 망취소 유무(Y:망취소, N:일반취소) (주문번호를 이용한 망취소시에 사용) */
$isNetCancel = "N";
/* 고객명 특수문자 사용금지, URL인코딩 필수 max 30byte */
$customerName = $row['MEMBER_NAME'] ?? ''; // 값 없으면 빈 문자열
// $customerName = urlencode($row['MEMBER_NAME']);

/* 고객이메일 이메일포멧 체크 필수 max 50byte */
$customerEmail = $row['EMAIL'];

/* timestamp max 20byte*/
$timestamp = makeTimestamp();
/* signature 64byte*/
$signature = makeSignature($mbrNo, $mbrRefNo, $amount, $apiKey, $timestamp);

$parameters = array(
    'version' => $version,
    'mbrNo' => $mbrNo,
    'mbrRefNo' => $mbrRefNo,
    'orgRefNo' => $orgRefNo,
    'orgTranDate' => $orgTranDate,
    'paymethod' => $paymethod,
    'amount' => $amount,
    'payType' => $payType,
    'isNetCancel' => $isNetCancel,
    'customerName' => $customerName,
    'customerEmail' => $customerEmail,
    'timestamp' => $timestamp,
    'signature' => $signature
);

/*****************************************************************************************
 * CANCEL API 호출
 *****************************************************************************************/
$result = "";
$errorMessage = "";
try {
    pintLog("CANCEL-API: " . $CANCEL_API_URL, $logPath);
    pintLog("PARAM: " . print_r($parameters, TRUE), $logPath);
    $result = httpPost($CANCEL_API_URL, $parameters);
} catch (Exception $e) {
    $errorMessage = "결제 취소 API 호출실패 : " . $CANCEL_API_URL;
    //pintLog("ERROR : " . $errorMessage, $logPath);
    pintLog("ERROR : " . $paymethod . " | " . $errorMessage, $logPath);
    throw new Exception($e);
    return;
}

pintLog("RESPONSE : " . $result, $logPath);
$obj = json_decode($result);
$resultCode = $obj->{'resultCode'};
$resultMessage = $obj->{'resultMessage'};


if ($resultCode != "200") {
    /*호출실패*/
    $errorMessage = "<br>## 승인요청API 호출 결과 ##<br>resultCode = " . $resultCode . ", resultMessage = " . $resultMessage;
    $resultCode = "취소실패";



    echo $errorMessage; // 실운영시 제거


    //실패시 쿼리

    echo "<script>
            alert('처리 중 오류가 발생했습니다.');
          </script>";
} else {

    $data = $obj->{'data'};

    //여기에다 DB 업데이트 삽입

    $canceled_date = date("Y-m-d H:i:s");
    $sql = "UPDATE {$main_pay_table} SET STATUS = '취소완료', CANCELED_DATE = '{$canceled_date}' WHERE AID = '{$aid}'";
    sql_query($sql);


if($target_table == 'SBAK_T1_TEST_Apply'){
    $sql3 = "UPDATE {$target_table} SET PAYMENT_STATUS = 'C' , T_status = '{$the_status}' WHERE AID = '{$aid}'";
}else{
    $sql3 = "UPDATE {$target_table} SET PAYMENT_STATUS = 'C' , THE_STATUS = '{$the_status}' WHERE AID = '{$aid}'";

}
    sql_query($sql3);

    //echo $resultCode;


    // 하단 JSON TYPE RESPONSE 참고하여 데이터 저장
}




// JSON TYPE RESPONSE
// echo $result;


?>

<!DOCTYPE html>
<html>

<head>
    <title>상점 도착페이지</title>
</head>

<body>
    <script>
        /* 결제 완료 페이지 호출 */
        var resultCode = "<?php echo $resultCode ?>";
        var resultMessage = "<?php echo $resultMessage ?>";
        var mb_name = "<?php echo $mb_name; ?>";
        sql = "<?php echo $sql; ?>";

        alert(mb_name + "회원님 정상취소됨 : resultCode = " + resultCode + ", resultMessage = " + resultMessage);
        location.href = "<?php echo $return_url; ?>";
    </script>
</body>

</html>