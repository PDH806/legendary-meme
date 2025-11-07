<?php
 include_once $_SERVER['DOCUMENT_ROOT'].'/common.php';
 $_POST = array_map('trim',$_POST);
?>
<style type="text/css">
 #img_container {
     position:absolute;
     width:100%;
     height:100%;
 }
 
 #img_container img {
    display:block;
    margin-left:auto;
    margin-right:auto;
 }
 #img_container div{
    text-align:center;
 }
 </style>
<div id="img_container">
  <img src="/img/gif-load.gif" >
  <div>결제가 진행중입니다.</div>
</div>

<?php if(G5_IS_MOBILE){?>
<form name='frm3' method='post' accept-charset='utf-8'>
<?php }else{?>
<form name='frm3' method='post' accept-charset='euc-kr'>
<?php }?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/pg/pc/frm.1.php';?>
</form>

<form name='frm1' method='post' accept-charset='utf-8' action='../reissue_fin.html'>
 <input type='hidden' name='key' value='<?php echo $_POST['key']?>' />
 <input type='hidden' name='seq' value='<?php echo $_POST['seq']?>' />
 <input type='hidden' name='amount' value='<?php echo $_POST['amount']?>' />
 <input type='hidden' name='GoodsName' value='<?php echo $_POST['GoodsName']?>' />
 <input type='hidden' name='OID' value='<?php echo $Moid?>' />
 <input type='hidden' name='TID' value='<?php echo $_POST['TID']?>' />
 <input type='hidden' name='BankCode' value='<?php echo $_POST['BankCode']?>' />
 <input type='hidden' name='BankName' value='<?php echo $_POST['BankName']?>' />
 <input type='hidden' name='VbankExpDate' value='<?php echo $_POST['VbankExpDate']?>' />
 <input type='hidden' name='AuthDate' value='<?php echo $_POST['AuthDate']?>' />
 <input type='hidden' name='BuyerName' value='<?php echo $_POST['BuyerName']?>' />
 <input type='hidden' name='BuyerEmail' value='<?php echo $_POST['BuyerEmail']?>' />
 <input type='hidden' name='BuyerTel' value='<?php echo $_POST['BuyerTel']?>' />
 <input type='hidden' name='re_issue' value='<?php echo $_POST['re_issue']?>' />
 <input type='hidden' name='PayMethod' value='<?php echo $_POST['PayMethod']?>' />
 <input type='hidden' name='tpay' value='<?php echo $_POST['tpay']?>' /><!-- 자격증신청 유/무료 -->
 <input type='hidden' name='birth1' value='<?php echo $_POST['birth1']?>' />
 <input type='hidden' name='birth2' value='<?php echo $_POST['birth2']?>' />
 <input type='hidden' name='birth3' value='<?php echo $_POST['birth3']?>' />
 
 <input type='hidden' name='hname' value='<?php echo $_POST[hname]?>' />
 <input type='hidden' name='ename' value='<?php echo $_POST[ename]?>' />
 
 <input type='hidden' name='tel1' value='<?php echo $_POST[tel1]?>' />
 <input type='hidden' name='tel2' value='<?php echo $_POST[tel2]?>' />
 <input type='hidden' name='tel3' value='<?php echo $_POST[tel3]?>' />
 
 <input type='hidden' name='part' value='<?php echo $_POST[part]?>' />
 
 <input type='hidden' name='zip' value='<?php echo $_POST[zip]?>' />
 <input type='hidden' name='addr1' value='<?php echo $_POST[addr1]?>' />
 <input type='hidden' name='addr2' value='<?php echo $_POST[addr2]?>' />
 
 <!-- 이전 페이지에서 넘어온 값 -->
<input type='hidden' name='names' value='<?=$_POST['names']?>'  />
<input type='hidden' name='births' value='<?=$_POST['births']?>'  />
<input type='hidden' name='hps' value='<?=$_POST['hps']?>'  />
<input type='hidden' name='license_num' value='<?=$_POST['license_num']?>'  />
<?php if(G5_IS_MOBILE){?>
<input type='hidden' name='pc_mobile' value='m' />
<?php }?>

</form>
<script>
<?php 
		// 무료신청인 경우
		if($_POST['tpay']=='free'){
		 echo "frm1.submit();</script>";
		 exit;
		}
?>
 
 var encodingType = "EUC-KR";//EUC-KR
 function setAcceptCharset(form) 
	{
		var browser = getVersionOfIE();
	    if(browser != 'N/A')
	    	document.charset = encodingType;//ie
	    else
	    	form.charset = encodingType;//else
	}

	function getVersionOfIE() 
	{ 
		 var word; 
		 var version = "N/A"; 

		 var agent = navigator.userAgent.toLowerCase(); 
		 var name = navigator.appName; 

		 // IE old version ( IE 10 or Lower ) 
		 if ( name == "Microsoft Internet Explorer" ) 
		 {
			 word = "msie "; 
		 }
		 else 
		 { 
			 // IE 11 
			 if ( agent.search("trident") > -1 ) word = "trident/.*rv:"; 

			 // IE 12  ( Microsoft Edge ) 
			 else if ( agent.search("edge/") > -1 ) word = "edge/"; 
		 } 

		 var reg = new RegExp( word + "([0-9]{1,})(\\.{0,}[0-9]{0,1})" ); 

		 if ( reg.exec( agent ) != null  ) 
			 version = RegExp.$1 + RegExp.$2; 

		 return version; 
	}
 
 function goPG(){
		
		 var f = document.frm3;
		 var f1 = document.frm1;
		//PG호출
		/*
		setAcceptCharset(f);
		setAcceptCharset(f1);
		*/
		
		 
		
		 try{setAcceptCharset(f);}catch(err){/*alert(err);*/};
		 
		 f.EncryptData.value = '<?php echo base64_encode(md5($ediDate.$MID.$goodsAmt.$merchantKey)) ?>';
		
		  f.action = '<?php echo $actionUrl ?>';

		  <?php if(G5_IS_MOBILE){?>
		  	f.target='payFrame';
			f.submit();
		  <?php }else{ ?>

		  
		  if(f.FORWARD.value == 'Y') // 화면처리방식 Y(권장):상점페이지 팝업호출
			{
				var popupX = (window.screen.width / 2) - (545 / 2);
				var popupY = (window.screen.height /2) - (573 / 2);
							
				var winopts= "width=545,height=573,toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=no,resizable=no,left="+ popupX + ", top="+ popupY + ", screenX="+ popupX + ", screenY= "+ popupY;
				var win =  window.open("", "payWindow", winopts);
				
				try{
				    if(win == null || win.closed || typeof win.closed == 'undefined' || win.screenLeft == 0) { 
				    	alert('브라우저 팝업이 차단으로 설정되었습니다.\n 팝업 차단 해제를 설정해 주시기 바랍니다.');
				    	return false;
				    }
				}catch(e){}
			    
				f.target = "payWindow";//payWindow  고정
				f.submit();
			}
			else // 화면처리방식 N:결제모듈내부 팝업호출
			{
				f.target = "payFrame";//payFrame  고정
				f.submit();
			}
		    
		    <?php } ?>
			return false;
		
	 }

 <?php 
 if(G5_IS_MOBILE){ 
  //include_once "./returnPay_1.php";  
  echo "goPG();";
 }else{
 ?>
 if(!frm1.amount.value){
  goPG();
 }
 <?php 
 }
 ?>
 </script>
<?php if(G5_IS_MOBILE){ ?>
<iframe src="./blank.html" name="payFrame" frameborder="no" width="0" height="0" scrolling="yes" align="center"></iframe>	
<?php }?>