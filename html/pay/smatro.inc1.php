<?php
$Mid = "know00001m";           // 발급받은 테스트 Mid 설정(Real 전환 시 운영 Mid 설정) , !!실값으로 변경필요!!
$MerchantKey = "nd0So1DPQJEYbLTjyvSAZI8iXf71lL1Kx3klcJZXqmgnVLs3pcpW56D+BItbg2Sxm0vu5nIbP9ShJwqD/5nF4w==";   // 발급받은 테스트 상점키 설정(Real 전환 시 운영 상점키 설정) !!실값으로 변경필요!!
//$Amt = str_replace(',','',$rs['it_price']); // !!실값으로 변경필요!!

$EdiDate = date("YmdHis");
$EncryptData = base64_encode(hash('sha256', $EdiDate.$Mid.$Amt.$MerchantKey, true));
$today = date("YmdHi");		// 현재일자. 캐시방지용으로 사용
$ReturnUrl = 'https://'.$_SERVER[HTTP_HOST]."/pay/payReturnUrl.php";
$Moid = $mbrRefNo;

?>
<!-- PC 연동 시 script. 캐시방지를 위해 ?version=today를 추가 -->
<!-- 운영 전환 시 "https://pay.smartropay.co.kr/asset/js/SmartroPAY-1.0.min.js?version=현재일자" 로 변경 -->
<!--<script src="https://tpay.smartropay.co.kr/asset/js/SmartroPAY-1.0.min.js?version=<?=$today?>"></script>-->
<script src="https://pay.smartropay.co.kr/asset/js/SmartroPAY-1.0.min.js?version=<?=$today?>"></script>

<!-- 모바일 연동 시 script. 캐시방지를 위해 ?version=today를 추가 -->
<!-- 운영 전환 시 "https://mpay.smartropay.co.kr/asset/js/SmartroPAY-1.0.min.js?version=현재일자" 로 변경 -->
<!--<script src="https://tmpay.smartropay.co.kr/asset/js/SmartroPAY-1.0.min.js?version=<?=$today?>"></script>-->
<script src="https://mpay.smartropay.co.kr/asset/js/SmartroPAY-1.0.min.js?version=<?=$today?>"></script>

<!--<form id="tranMgr" name="tranMgr" method="post">-->
	<!-- 각 값들을 가맹점에 맞게 설정해 주세요. -->
	<!-- CARD:신용카드, BANK:계좌이체, VBANK:가상계좌, CELLPHONE:휴대폰결제, NAVER:네이버페이,KAKAO:카카오페이, PAYCO:페이코페이, LPAY:엘페이 -->
	<!--<input type="hidden" name="PayMethod" value="CARD" placeholder=""/>-->
	<!--<input type="hidden" name="GoodsCnt" maxlength="2" value="1" placeholder=""/>-->
	<!--<input type="hidden" name="GoodsName" maxlength="40" value="<?=$rs['it_name']?>" placeholder=""/>-->
	<!--<input type="hidden" name="Amt" maxlength="12" value="<?=$Amt?>" placeholder=""/>-->
	<!--<input type="hidden" name="Moid" maxlength="40" value="<?=$Moid?>" placeholder="특수문자 포함 불가"/>-->
	<!--<input type="hidden" name="Mid" maxlength="10" value="<?=MID?>" placeholder=""/>-->
	<!--<input type="hidden" name="ReturnUrl" size="100" class="input" value="<?=$ReturnUrl?>">-->
	<!--<input type="hidden" name="StopUrl" size="100" class="input" value="<?=$ReturnUrl?>" placeholder="Mobile 연동 시 필수"/>--> 
	<!--<input type="hidden" name="BuyerName" maxlength="30" value="<?=$_POST['pr_name']?>" placeholder=""/>-->
	<!--<input type="hidden" name="BuyerTel" maxlength="30" value="<?=$_POST['pr_ph']?>" placeholder=""/>-->
	<!--<input type="hidden" name="BuyerEmail" maxlength="30" value="<?=$_POST['pr_email']?>" placeholder=""/>-->
	<!--<input type="hidden" name="MallIp" maxlength="20" value="<?=$_SERVER['REMOTE_ADDR']?>" placeholder=""/>-->
	<!--<input type="hidden" name="VbankExpDate" maxlength="8" value="20210824" placeholder="가상계좌 이용 시 필수"/>-->
	<!--<input type="hidden" name="EncryptData" value="<?=$EncryptData?>" placeholder="위/변조방지 HASH 데이터"/>-->
	<!--<input type="hidden" name="GoodsCl" value="0" placeholder="가맹점 설정에 따라 0 또는 1, 핸드폰결제 시 필수"/>-->
	<!--<input type="hidden" name="EdiDate" maxlength="14" value="<?=$EdiDate?>" placeholder=""/>-->
	<!-- MID 기본 세팅시 부가세 직접계산으로 설정됩니다. 
	<input type="hidden" name="TaxAmt" maxlength="12" value="0" placeholder="부가세 직접계산 가맹점 필수,숫자만 가능, 문장부호 제외"/>
	<input type="hidden" name="TaxFreeAmt" maxlength="12" value="0" placeholder="부가세 직접계산 가맹점 필수,숫자만 가능, 문장부호 제외"/>
	<input type="hidden" name="VatAmt" maxlength="12" value="0" placeholder="부가세 직접계산 가맹점 필수,숫자만 가능, 문장부호 제외"/>
	-->
<!--</form>-->
<!-- PC 연동의 경우에만 아래 승인폼이 필요합니다. (Mobile은 제외) -->
<form id="approvalForm" name="approvalForm" method="post">
	<input type="hidden" id="Tid" name="Tid" />
	<input type="hidden" id="TrAuthKey" name="TrAuthKey" />
</form>
	

<script>
        function payPc() {
        	if(isMobile()) {
        		alert("PC에서만 가능합니다.");
        		return;
        	}
        	var form = document.tranMgr;
        	var popupX = (window.screen.width / 2) - (545 / 2);
			var popupY = (window.screen.height /2) - (573 / 2);
						
			var winopts= "width=870,height=800,toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=no,resizable=no,left="+ popupX + ", top="+ popupY + ", screenX="+ popupX + ", screenY= "+ popupY;
			var win =  window.open("", "payDemoPc", winopts);
			
			try{
			    if(win == null || win.closed || typeof win.closed == 'undefined' || win.screenLeft == 0) { 
			    	alert('브라우저 팝업이 차단으로 설정되었습니다.\n 팝업 차단 해제를 설정해 주시기 바랍니다.');
			    	return false;
			    }
			}catch(e){}
		    
			form.target = "payDemoPc";//payWindow  고정
			form.action = "/demo/payPc.do";//payWindow  고정
			form.submit(); 
        }
        
		function payMobile() {
			if(!isMobile()) {
        		alert("모바일에서만 가능합니다.");
        		return;
        	}
			var form = document.tranMgr;
        	/* var popupX = (window.screen.width / 2) - (545 / 2);
			var popupY = (window.screen.height /2) - (573 / 2);
						
			var winopts= "width=500,height=800,toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=no,resizable=no,left="+ popupX + ", top="+ popupY + ", screenX="+ popupX + ", screenY= "+ popupY;
			var win =  window.open("", "payDemoMobile", winopts);
			
			try{
			    if(win == null || win.closed || typeof win.closed == 'undefined' || win.screenLeft == 0) { 
			    	alert('브라우저 팝업이 차단으로 설정되었습니다.\n 팝업 차단 해제를 설정해 주시기 바랍니다.');
			    	return false;
			    }
			}catch(e){}
		    
			form.target = "payDemoMobile";//payWindow  고정 */
			form.action = "/demo/payMobile.do";//payWindow  고정
			form.submit(); 
        }
		
		function isMobile() {
			return /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
		}

		function goPay() {
			// 스마트로페이 초기화
			smartropay.init({
				mode: "REAL"		// STG: 테스트, REAL: 운영
			});
			
			/*if(isMobile()){
				// Mobile 연동시 아래와 같이 smartropay.payment 함수를 구현합니다.
				smartropay.payment({
					FormId : 'tranMgr'				// 폼ID
				});
				return;
			}
			*/

			// 스마트로페이 결제요청
			// PC 연동시 아래와 같이 smartropay.payment 함수를 구현합니다.
			smartropay.payment({
				FormId : 'tranMgr',				// 폼ID
				Callback : function(res) {
					var approvalForm = document.approvalForm;
					approvalForm.Tid.value = res.Tid;
					approvalForm.TrAuthKey.value = res.TrAuthKey;
					approvalForm.action = '<?=$ReturnUrl?>';
					approvalForm.submit();
				}
			});

		}
    </script>
	<iframe name="proc" style="display:none;"></iframe>