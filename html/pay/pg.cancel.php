<?php
//$cancelUrl = "https://tapproval.smartropay.co.kr/payment/approval/cancel.do";  	// 테스트
$cancelUrl = "https://approval.smartropay.co.kr/payment/approval/cancel.do"; 	// 운영
$Mid = "know00001m";           // 발급받은 테스트 Mid 설정(Real 전환 시 운영 Mid 설정) , !!실값으로 변경필요!!
$MerchantKey = "nd0So1DPQJEYbLTjyvSAZI8iXf71lL1Kx3klcJZXqmgnVLs3pcpW56D+BItbg2Sxm0vu5nIbP9ShJwqD/5nF4w==";   // 발급받은 테스트 상점키 설정(Real 전환 시 운영 상점키 설정) !!실값으로 변경필요!!
$CancelPwd = "934091";

$Tid = $ret['Tid'];			// 취소 요청할 Tid 입력
$CancelAmt = $ret['Amt'];	// 취소할 거래금액
//$CancelAmt = "100";	// 취소할 거래금액
$CancelSeq = "1";		// 취소차수(기본값: 1, 부분취소 시마다 차수가 1씩 늘어남. 첫번째 부분취소=1, 두번째 부분취소=2, ...)
$PartialCancelCode = "0";		// 0: 전체취소, 1: 부분취소

// 검증값 SHA256 암호화(Tid + MerchantKey + CancelAmt + PartialCancelCode)
$HashData = base64_encode(hash('sha256', $Tid.$MerchantKey.$CancelAmt.$PartialCancelCode, true));

// 취소 요청 파라미터 셋팅
$paramData = array(
	'SERVICE_MODE' => 'CL1',
	'Tid' => $Tid,
	'Mid' => $Mid,
	'CancelAmt' => $CancelAmt,
	'CancelPwd' => $CancelPwd,
	'CancelMsg' => $CancelMsg,
	'CancelSeq' => $CancelSeq,
	'PartialCancelCode' => $PartialCancelCode,
	// 과세, 비과세, 부가세 셋팅(부가세 직접 계산 가맹점의 경우 각 값을 계산하여 설정해야 합니다.)
	'CancelTaxAmt' => '',
	'CancelTaxFreeAmt' => '',
	'CancelVatAmt' => '',
	// 서브몰 사용 가맹점의 경우, DivideInfo 파라미터를 가맹점에 맞게 설정해 주세요. (일반연동 참고)
	'DivideInfo' => '',
	// HASH 설정 (필수)
	'HashData' => $HashData
);

//print_r($paramData);exit;

// json 데이터 AES256 암호화
$EncData = base64_encode(openssl_encrypt(json_encode($paramData), 'aes-256-cbc', substr($MerchantKey,0,32), true, str_repeat(chr(0), 16)));

$body = array(
	'EncData' => $EncData,
	'Mid' => $Mid
);
$body = json_encode($body);
//print_r2($body);

$http_status='';
$retCancel = Curl($cancelUrl, $body, $http_status);
$retCancel = json_decode($retCancel,true);
$mobile_str = 'iPhone|iPad|iPod|Android';

$q = "DELETE FROM $table where REF_NO='$od_id' ";
mysql_query($q, $connect);
// 취소성공
if($retCancel['ResultCode']=='2001'){
	$rMsg = "결재오류가 발생하였습니다.";
// 취소에러
}else{
	$rMsg = "결재 취소처리시 오류가 발생했습니다.\\n관리자에게 문의하시기 바랍니다.";
}

if($mode=='payment0'){ // 각 검정결재인 경우
	echo "
	<script>
	 alert('$rMsg');	
	 location.href='/mypage/admin_master_schedule_list.html';
	</script>
	";	
	exit;
}
echo "
	<script>
	 alert('$rMsg');	
	 location.href='/mypage/index.html?category=7';
	</script>";
exit;
?>