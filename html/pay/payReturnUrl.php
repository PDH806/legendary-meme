<script src="https://www.sharoncatdress.com/js/jquery-1.12.4.min.js?ver=210618"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta charset='utf-8' />
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/db_config.html';


		
//$url = "https://tapproval.smartropay.co.kr/payment/approval/urlCallApproval.do";	// 테스트 
$url = "https://approval.smartropay.co.kr/payment/approval/urlCallApproval.do";	// 운영 
        
$approval_data = array(
	'Tid' => $_REQUEST['Tid'],
	'TrAuthKey' => $_REQUEST['TrAuthKey']
);		

// json data
$json = json_encode($approval_data);

$http_status = 0;

$mobile_str = 'iPhone|iPad|iPod|Android';

function Curl($url, $post_data, &$http_status, &$header = null) {

    $ch=curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);

    // post_data
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HEADER, false);

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    $body = null;
    // error
    if (!$response) {
        $body = curl_error($ch);
        // HostNotFound, No route to Host, etc  Network related error
        $http_status = -1;
        Log::error("CURL Error: = " . $body);
    } else {
       //parsing http status code
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (!is_null($header)) {
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

            $header = substr($response, 0, $header_size);
            $body = substr($response, $header_size);
        } else {
            $body = $response;
        }
    }
    curl_close($ch);
    return $body;
}

// https 통신
$ret = Curl($url, $json, $http_status);

$ret = json_decode($ret,true);

// $ret['ResultCode'] = '3001'; // 테스트

// PG강제취소 테스트
/*
include_once "./pgCancel.inc.php";
echo "here";exit;
*/


$tmp01 = explode("&",$ret['MerchantReserved']);
$tmp02 = explode("=", $tmp01[0]);
$mode = $tmp02[1];
unset($tmp02);
$tmp02 = explode("=", $tmp01[1]);
$type = $tmp02[1]; // T1, T2 ...



if($ret['ResultCode']=='W034' || $ret['ResultCode']=='U999'){ // 결제취소
	
	if($_GET['mode']=='payment0'){ // 각 검정결재인 경우
		echo "
			<script>
				location.href='https://{$_SERVER['HTTP_HOST']}/mypage/admin_master_schedule_list.html';
			</script>";
		exit;  	
	}

	echo "
		<script>
			location.href='https://{$_SERVER['HTTP_HOST']}/mypage/index.html?category=7';
		</script>";
	exit;  

} else if($ret['ResultCode']=='3001'){ // 결제성공
   

if($mode=='payment0'){ // 각 검정결재인 경우

	$od_id = $ret['Moid']; // 주문번호
	
	$table00 = "7G_Master_Apply";
	$table = "7G_Master_Apply_TMP";


	$sql	= "UPDATE $table SET
					cardNo = '{$ret['CardNum']}',
					issueCardName = '{$ret['AppCardName']}',
					acqCompanyNo = '{$ret['AppCardCode']}'
				WHERE REF_NO='$od_id' ";

	$rs	= mysql_query($sql,$connect);
	if($rs){
		$sql = "SELECT * FROM $table WHERE REF_NO='$od_id' ORDER BY Apply_No DESC LIMIT 1";
		$data = mysql_fetch_array(mysql_query($sql, $connect));
		$sql = "INSERT INTO  $table00 (
						REF_NO,								Apply_date,							TEST_ID,							TRAN_DATE,
						TRAN_TIME,						Test_No,							SKIRESORT_NO,					MEMBER_NO,
						MEMBER_ID,						MEMBER_NAME,					MEMBER_PHONE,					MEMBER_EMAIL,
						T_ZIPCODE,						T_ADDR1,							T_ADDR2,							T_ADDR3,
						APPROVAL_NO,					PRODUCT_CODE,					PRODUCT_NAME,					PAY_METHOD,
						AMOUNT,							TRAN_STATUS,					GENDER2,							VACCINE,
						PASS,									AID,									RELATED_FILE,					RELATED_IMAGE
					)
					VALUES	(
						'{$data['REF_NO']}',				'{$data['Apply_date']}',			'{$data['TEST_ID']}',			'{$data['TRAN_DATE']}',
						'{$data['TRAN_TIME']}',		'{$data['Test_No']}',				'{$data['SKIRESORT_NO']}',	'{$data['MEMBER_NO']}',
						'{$data['MEMBER_ID']}',		'{$data['MEMBER_NAME']}',	'{$data['MEMBER_PHONE']}',	'{$data['MEMBER_EMAIL']}',
						'{$data['T_ZIPCODE']}',			'{$data['T_ADDR1']}',			'{$data['T_ADDR2']}',			'{$data['T_ADDR3']}',
						'{$data['APPROVAL_NO']}',		'{$data['PRODUCT_CODE']}',	'{$data['PRODUCT_NAME']}',	'{$data['PAY_METHOD']}',
						'{$data['AMOUNT']}',			'{$data['TRAN_STATUS']}',	'{$data['GENDER2']}',			'{$data['VACCINE']}',
						'{$data['PASS']}',					'{$data['AID']}',					'{$data['RELATED_FILE']}',		'{$data['RELATED_IMAGE']}'
					)
		";
		$rs1 = mysql_query($sql, $connect);
		//echo $sql;exit;
		if(!$rs1){
			// 결제취소
			$CancelMsg = "데이터베이스 처리에러";
			// 1. 결제취소 삽입 ( DB delete 포함 )
			include_once "./pg.cancel.php";
		}
	} else {
		// 결제취소
		$CancelMsg = "데이터베이스 처리에러";
		// 1. 결제취소 삽입 ( DB delete 포함 )
		include_once "./pg.cancel.php";
	}
	echo "
			<script>
				location.href='https://{$_SERVER['HTTP_HOST']}/mypage/admin_master_schedule_list.html';
			</script>";
	exit;  	
}


//결제내역 다시한번 체크    
$od_id = $ret['Moid']; // 주문번호
$table00 = "7G_License_Renew";
$table = "7G_License_Renew_TMP";
$sql  ="select NO from $table where REF_NO='$od_id' order by no desc limit 1 ";
$rs	= mysql_query($sql,$connect);
$data	= mysql_fetch_array($rs);
//$chk1 = $chk2 = $chk3 = $chk4 = false; // 에러여부 확인변수
$chk1 = false;$chk2 = false;$chk3 = false;$chk4 = false;

/*
print_r($ret);
print_r($data);
exit;
*/

if($data['NO']){
	$q = "update  $table set 
				APPROVAL_NO = '{$ret['Tid']}',				cardNo='{$ret['CardNum']}' ,					issueCardName='{$ret['AppCardName']}' ,  
				acqCompanyNo='{$ret['AppCardCode']}' , TRAN_DATE = '20".substr($ret['AuthDate'],0,2)."-".substr($ret['AuthDate'],2,2)."-".substr($ret['AuthDate'],4,2)."', 
				TRAN_TIME = '".substr($ret['AuthDate'],6)."' 
			where NO='{$data['NO']}' ";
	
	$rs1	= mysql_query($q,$connect);
	if($rs1){
		$q = "select * from $table where NO='{$data['NO']}' ";
		$rs	= mysql_query($q,$connect);
		$data	= mysql_fetch_array($rs);
		/*
		echo 'rs1 내부의 ';
		print_r($data);
		exit;
		*/

		if($data['NO']){
			$q = "insert into $table00( 
			REF_NO,					TRAN_DATE,		TRAN_TIME,			MEMBER_NO, 
			MEMBER_ID, 			MEMBER_NAME, 	MEMBER_PHONE, 	MEMBER_EMAIL, 
			ZIPCODE, 				ADDR1,				ADDR2, 					ADDR3, 
			LICENSE_NO, 			APPROVAL_NO, 	PRODUCT_CODE, 	PRODUCT_NAME, 
			PAY_METHOD, 		AMOUNT,			PAYMENT_STATUS,	DELIVERY_DATE, 
			DELIVERY_AGENCY, TRACKING_NO, 	DELIVERY_FEE, 		MEMO1, 
			TRAN_STATUS, 		AID ,					cardNo,					issueCardName,
			acqCompanyNo
			) 
			values (
			'{$data['REF_NO']}',					'{$data['TRAN_DATE']}',		'{$data['TRAN_TIME']}' ,			'{$data['MEMBER_NO']}',
			'{$data['MEMBER_ID']}',			'{$data['MEMBER_NAME']}',	'{$data['MEMBER_PHONE']}' ,		'{$data['MEMBER_EMAIL']}',
			'{$data['ZIPCODE']}',				'{$data['ADDR1']}',				'{$data['ADDR2']}' ,					'{$data['ADDR3']}',
			'{$data['LICENSE_NO']}',			'{$data['APPROVAL_NO']}',		'{$data['PRODUCT_CODE']}' ,		'{$data['PRODUCT_NAME']}',
			'{$data['PAY_METHOD']}',			'{$data['AMOUNT']}',			'2' ,										'{$data['DELIVERY_DATE']}',
			'{$data['DELIVERY_AGENCY']}',	'{$data['TRACKING_NO']}',	'{$data['DELIVERY_FEE']}' ,		'{$data['MEMO1']}' ,
			'2',											'{$data['AID']}',					'{$data['cardNo']}',					'{$data['issueCardName']}',
			'{$data['acqCompanyNo']}'
			) ";
			//echo $q;exit;

			$rs2 = mysql_query($q ,$connect);
			if($rs2) $chk4 = true;
			$chk3 = true;
		}
		$chk2 = true;
	}
	$chk1 = true;
} 

// DB 에러로 인한 결제취소 진행
if(!$chk1 || !$chk2 || !$chk3 || !$chk4){
	$CancelMsg = "데이터베이스 처리에러";
	// 1. 결제취소 삽입 ( DB delete 포함 )
	include_once "./pg.cancel.php";
}
	// 결제 SMS 보내기??
	// 결제완료후 이동할 페이지
	echo "<script>alert('결재가 완료되었습니다.');location.href='/mypage/my_license_renew.html'</script>";
    exit; 
} // 3001 결제성공




?>