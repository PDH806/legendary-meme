<?php
error_reporting(E_ALL ^ E_NOTICE);
/******************************************************************************

	 SYSTEM NAME		: 결제완료페이지
	 PROGRAM NAME		: returnPay.php
	 MAKER				: sajang
	 MAKE DATE			: 2017.12.06
	 PROGRAM CONTENTS	: 결제완료페이지

************************* 변 경 이 력 *****************************************
* 번호	작업자		작업일				변경내용
*	1	스마트로	2017.12.06		결제완료페이지
******************************************************************************/
header('Content-Type: text/html; charset=UTF-8');
?>
<?php
/*
foreach($_REQUEST as $key=>$value) {
    echo $key .'=>'. iconv('euc-kr','utf-8',$value);
    echo '<br>';
    
}
exit;
*/


if($_REQUEST['TID']){

	$PayMethod		= $_REQUEST['PayMethod']==null?"":$_REQUEST['PayMethod']; // 지불수단
	$MID			= $_REQUEST['MID']==null?"":$_REQUEST['MID']; // 상점 ID
	$Amt			= $_REQUEST['Amt']==null?"":$_REQUEST['Amt']; // 금액
	$BuyerName		= $_REQUEST['BuyerName']==null?"":$_REQUEST['BuyerName']; // 결제자명
	$GoodsName		= $_REQUEST['GoodsName']==null?"":$_REQUEST['GoodsName']; // 상품명
	$mallUserID     = $_REQUEST['mallUserID']==null?"":$_REQUEST['mallUserID']; // 고객사회원ID
	$TID            = $_REQUEST['TID']==null?"":$_REQUEST['TID']; // 거래번호
	$OID			= $_REQUEST['OID']==null?"":$_REQUEST['OID']; // 주문번호
	$AuthDate		= $_REQUEST['AuthDate']==null?"":$_REQUEST['AuthDate']; // 승인일자
	$AuthCode		= $_REQUEST['AuthCode']==null?"":$_REQUEST['AuthCode']; // 승인번호
	$ResultCode		= $_REQUEST['ResultCode']==null?"":$_REQUEST['ResultCode']; // 결과코드
	$ResultMsg		= $_REQUEST['ResultMsg']==null?"":$_REQUEST['ResultMsg']; // 결과메시지
	$VbankNum		= $_REQUEST['VbankNum']==null?"":$_REQUEST['VbankNum']; // 가상계좌번호
	$VbankName		= $_REQUEST['VbankName']==null?"":$_REQUEST['VbankName']; // 가상계좌은행명
	
	$BankCode		= $_REQUEST['BankCode']==null?"":$_REQUEST['BankCode']; // 계좌이체 은행코드
	$BankName		= $_REQUEST['BankName']==null?"":$_REQUEST['BankName']; // 게좌이체 은행명
	
	
	$fn_cd			= $_REQUEST['fn_cd']==null?"":$_REQUEST['fn_cd']; // 결제카드사코드, 가상계좌, 계좌이체
	$fn_name		= $_REQUEST['fn_name']==null?"":$_REQUEST['fn_name']; // 결제카드사명, 가상계좌, 계좌이체
	$CardQuota		= $_REQUEST['CardQuota']==null?"":$_REQUEST['CardQuota']; // 할부개월수
	$BuyerTel		= $_REQUEST['BuyerTel']==null?"":$_REQUEST['BuyerTel']; // 구매자 전화번호
	$BuyerEmail		= $_REQUEST['BuyerEmail']==null?"":$_REQUEST['BuyerEmail']; // 구매자이메일주소
	$BuyerAuthNum	= $_REQUEST['BuyerAuthNum']==null?"":$_REQUEST['BuyerAuthNum']; // 구매자주민번호
	$ReceiptType	= $_REQUEST['ReceiptType']==null?"":$_REQUEST['ReceiptType']; // 현금영수증유형
	$SignValue		= $_REQUEST['SignValue']==null?"":$_REQUEST['SignValue']; // 위변조 사인값
	
	$TaxCD			= $_REQUEST['TaxCD']==null?"":$_REQUEST['TaxCD']; // TAX 코드
	$SvcAmt			= $_REQUEST['SvcAmt']==null?"":$_REQUEST['SvcAmt']; // 봉사료
	$Tax			= $_REQUEST['Tax']==null?"":$_REQUEST['Tax']; // 부가세
	$AcquCardCode	= $_REQUEST['AcquCardCode']==null?"":$_REQUEST['AcquCardCode']; // 매입사코드 

	$DivideInfo = $_REQUEST['DivideInfo']==null?"":$_REQUEST['DivideInfo']; // 서브몰 정보 

	if (!empty($DivideInfo)) {
		if (strpos($DivideInfo, '%') != false)
			$DivideInfo = urldecode($DivideInfo);

		$byteDivideInfo = base64_decode($DivideInfo);
		$DivideInfo = iconv("utf-8", "euc-kr", $byteDivideInfo); // 가맹점 페이지 인코딩 타입에 따른 처리 필요 (utf-8 로 인코딩 처리 후 전달됨)
	}

	$merchantKey = "0/4GFsSd7ERVRGX9WHOzJ96GyeMTwvIaKSWUCKmN3fDklNRGw3CualCFoMPZaS99YiFGOuwtzTkrLo4bR4V+Ow=="; // SMTPAY001m (MID) 가맹점 키
	//$merchantKey = "nd0So1DPQJEYbLTjyvSAZI8iXf71lL1Kx3klcJZXqmgnVLs3pcpW56D+BItbg2Sxm0vu5nIbP9ShJwqD/5nF4w=="; 실결제키
	
	$VerifySignValue = base64_encode(md5(substr($TID,0,10).$ResultCode.substr($TID,10,5).$merchantKey.substr($TID,15,15)));

	// 웹 링크 버전일 경우에 실제 스마트로 서버의 승인 값을 검증 하기 위해서 아래의 값을 비교 합니다.
    if ($ResultCode == "3001") {// CARD 결제성공
    	// 승인 성공 시 DB 처리 하세요.
		// TID 결제 성공한 데이터 존재시 UPDATE, 존재하지 않을 경우 INSERT
	}
    else if ($ResultCode == "4000") {// BANK 결제성공
    	// 승인 성공 시 DB 처리 하세요.
    	// TID 결제 성공한 데이터 존재시 UPDATE, 존재하지 않을 경우 INSERT
    }
    else if ($ResultCode == "4100") {// VBANK 결제성공
    	// 승인 성공 시 DB 처리 하세요.
    	// TID 결제 성공한 데이터 존재시 UPDATE, 존재하지 않을 경우 INSERT
    }
    else if ($ResultCode == "A000") {// cellphone 결제성공
    	// 승인 성공 시 DB 처리 하세요.
    	// TID 결제 성공한 데이터 존재시 UPDATE, 존재하지 않을 경우 INSERT
    }
    else if ($ResultCode == "B000") {// CLGIFT 결제성공
    	// 승인 성공 시 DB 처리 하세요.
    	// TID 결제 성공한 데이터 존재시 UPDATE, 존재하지 않을 경우 INSERT
    }
    else if ($ResultCode == "9999") {// 사용자에 의한 취소
        echo "<script>window.opener.history.back();window.close();</script>";
    }
    else{
        echo "<script>alert('결제오류입니다.({$ResultMsg}:{$ResultCode})\\n잠시 후 다시 결제부탁드립니다.');</script>";
    }
?>
<script>
 //window.opener.document.tranMgr.action = 'blank.html';
 //window.opener.document.tranMgr.target='';
 //console.log('parent.tranMgr.action : ' + window.opener.document.tranMgr.EncodingType.value);
 
 //window.opener.document.tranMgr.submit();
 //window.close();
 
</script>
<?php 
 
} // if($_REQUEST['TID']) // 의 끝
?>