<?php
  include_once $_SERVER['DOCUMENT_ROOT'].'/common.php';
  echo "<script src='/ski/js/jquery-1.11.1.min.js' type='text/javascript'></script>\n";
   
  
 if(is_mobile()) 
  echo "<meta charset='utf-8'>";
 else 
  echo "<meta charset='euc-kr'>";
 
 $_POST = array_map('trim',$_POST);


 
 if(!is_mobile()){
     if(preg_match('/Chrome/i',$_SERVER['HTTP_USER_AGENT']) or preg_match('/Safari/i',$_SERVER['HTTP_USER_AGENT']) )
         ;
     else
         ;//$_POST = array_map('iconv_utf8',$_POST);
 }
 // 스키구조요원 신청 결제 프로세스
 if(is_mobile()){
  echo "<form name='frm3' method='post' accept-charset='utf-8'>"; 
 }else{
  echo "<form name='frm3' method='post' accept-charset='euc-kr'>";  
 }
 
 
 
 if(is_mobile()){
     $DEV_PAY_ACTION_URL = "https://tspay.smilepay.co.kr/pay/interfaceURL";	//개발
     $PRD_PAY_ACTION_URL = "https://smpay.smilepay.co.kr/pay/interfaceURL";	//운영
     $stopUrl = G5_URL."/pg/mobile/stopUrl.php"; // 결제중지 URL
 }else{
     $DEV_PAY_ACTION_URL = "https://tpay.smilepay.co.kr/interfaceURL.jsp";	//개발
     $PRD_PAY_ACTION_URL = "https://pay.smilepay.co.kr/interfaceURL.jsp";	//운영
 }
 
  
 if(preg_match("/patrol_reissue.1.html/i",$p_url)){ // 스키구조요원 재발급( 19기 이후 )
  
  
  if($_POST['tpay']=='free'){ // 무료신청인 경우
   echo "<script>
          parent.document.frm1.action='/ski/process/process.2.php';
          parent.document.frm1.target='_self';
          parent.document.frm1.submit();      
        </script>";       
   exit;
         
  }
  $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
  $Moid = $_POST['seq'].date("YmdHis"); // 스키구조요원
  $GoodsName = $_POST['GoodsName']; // 상품명
  $Amt = $goodsAmt = $_POST['tpay']=='free' ? '0' : explode('||',$_POST['re_issue'])[2];// 상품금액
  $BuyerName = $_POST['BuyerName'];
    
 } else if(preg_match("/teach_reissue.t1.html/i",$p_url)){ // 스키지도 티칭1 재발급
     
     if($_POST['tpay']=='free'){ // 무료신청인 경우
      echo "<script>
          parent.document.frm1.action='/ski/process/process.ski.t1.certi.php';
          parent.document.frm1.target='_self';
          parent.document.frm1.submit();
        </script>";
      exit;
     }
     $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
     $Moid = $_POST['seq'].date("YmdHis"); // 스키구조요원
     $GoodsName = $r['gd_name']; // 상품명
     $Amt = $goodsAmt = $_POST['tpay']=='free' ? '0' : explode('||',$_POST['re_issue'])[2];// 상품금액
     $BuyerName = $_POST['BuyerName'];
     
         
 }else if(preg_match("/teach_reissue.t2.html/i",$p_url)){ // 스키지도 티칭2 재발급
     
     if($_POST['tpay']=='free'){ // 무료신청인 경우
         echo "<script>
          parent.document.frm1.action='/ski/process/process.ski.t2.certi.php';
          parent.document.frm1.target='_self';
          parent.document.frm1.submit();
        </script>";
         exit;
     }
     $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
     $Moid = $_POST['seq'].date("YmdHis"); // 스키지도티칭2
     $GoodsName = $r['gd_name']; // 상품명
     $Amt = $goodsAmt = $_POST['tpay']=='free' ? '0' : explode('||',$_POST['re_issue'])[2];// 상품금액
     $BuyerName = $_POST['BuyerName'] ? $_POST['BuyerName'] : $_POST['names'];
     //echo '$GoodsName : ' . $GoodsName;exit;
     
 }else if(preg_match("/teach_reissue.t3.html/i",$p_url)){ // 스키지도 티칭3 재발급
     
     if($_POST['tpay']=='free'){ // 무료신청인 경우
         echo "<script>
          parent.document.frm1.action='/ski/process/process.ski.t3.certi.php';
          parent.document.frm1.target='_self';
          parent.document.frm1.submit();
        </script>";
         exit;
     }
     $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
     $Moid = $_POST['seq'].date("YmdHis"); // 스키지도티칭3
     $GoodsName = $r['gd_name']; // 상품명
     $Amt = $goodsAmt = $_POST['tpay']=='free' ? '0' : explode('||',$_POST['re_issue'])[2];// 상품금액
     $BuyerName = $_POST['BuyerName'];
     //echo '$GoodsName : ' . $GoodsName;exit;
     
 }else if(preg_match("/snow_reissue.t1.html/i",$p_url)){ // 보드지도 티칭1 재발급
     
     if($_POST['tpay']=='free'){ // 무료신청인 경우
         echo "<script>
          parent.document.frm1.action='/ski/process/process.sbt1.php';
          parent.document.frm1.target='_self';
          parent.document.frm1.submit();
        </script>";
         exit;
     }
     $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
     $Moid = $_POST['seq'].date("YmdHis"); // 보드지도 티칭1 재발급
     $GoodsName = $r['gd_name']; // 상품명
     $Amt = $goodsAmt = $_POST['tpay']=='free' ? '0' : explode('||',$_POST['re_issue'])[2];// 상품금액
     $BuyerName = $_POST['BuyerName'];
     //echo '$GoodsName : ' . $GoodsName;exit;
     
 }else if(preg_match("/snow_reissue.t2.html/i",$p_url)){ // 보드지도 티칭2 재발급
     
     if($_POST['tpay']=='free'){ // 무료신청인 경우
         echo "<script>
          parent.document.frm1.action='/ski/process/process.sbt2.php';
          parent.document.frm1.target='_self';
          parent.document.frm1.submit();
        </script>";
         exit;
     }
     $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
     $Moid = $_POST['seq'].date("YmdHis"); // 보드지도 티칭2 재발급
     $GoodsName = $r['gd_name']; // 상품명
     $Amt = $goodsAmt = $_POST['tpay']=='free' ? '0' : explode('||',$_POST['re_issue'])[2];// 상품금액
     $BuyerName = $_POST['BuyerName'];
     //echo '$GoodsName : ' . $GoodsName;exit;
     
 }else if(preg_match("/snow_reissue.t3.html/i",$p_url)){ // 보드지도 티칭3 재발급
     
     if($_POST['tpay']=='free'){ // 무료신청인 경우
         echo "<script>
          parent.document.frm1.action='/ski/process/process.sbt2.php';
          parent.document.frm1.target='_self';
          parent.document.frm1.submit();
        </script>";
         exit;
     }
     $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
     $Moid = $_POST['seq'].date("YmdHis"); // 보드지도 티칭3 재발급
     $GoodsName = $r['gd_name']; // 상품명
     $Amt = $goodsAmt = $_POST['tpay']=='free' ? '0' : explode('||',$_POST['re_issue'])[2];// 상품금액
     $BuyerName = $_POST['BuyerName'];
     //echo '$GoodsName : ' . $GoodsName;exit;
     
 }else if(preg_match("/patrol_accept.html/i",$p_url)){ // 스키구조요원 접수
    
     $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
     $Moid = $_POST['seq'].date("YmdHis"); // 스키구조요원 주문번호
     $GoodsName = $r['gd_name']; // 상품명
     $Amt = $goodsAmt = $_POST['amount'];// 상품금액
     $BuyerName = $_POST['BuyerName'];
     //echo '$GoodsName : ' . $GoodsName;exit;
     
 }else if(preg_match("/teach_accept_t2.html/i",$p_url)){ // 스키지도T2 접수
     
     $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
     $Moid = $_POST['seq'].date("YmdHis"); // 스키지도T2 주문번호
     $GoodsName = $r['gd_name']; // 상품명
     $Amt = $goodsAmt = $_POST['amount'];// 상품금액
     $BuyerName = $_POST['BuyerName'];
     //echo '$GoodsName : ' . $GoodsName;exit;
     
 }else if(preg_match("/teach_accept_t3.html/i",$p_url)){ // 스키지도T3 접수
     
     $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
     $Moid = $_POST['seq'].date("YmdHis"); // 스키지도T3 주문번호
     $GoodsName = $r['gd_name']; // 상품명
     $Amt = $goodsAmt = $_POST['amount'];// 상품금액
     $BuyerName = $_POST['BuyerName'];
     //echo '$GoodsName : ' . $GoodsName;exit;
     
 }else if(preg_match("/snow_accept_t2.html/i",$p_url)){ // 스노보드지도T2 접수
     
     $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
     $Moid = $_POST['seq'].date("YmdHis"); // 스노보드T2 주문번호
     $GoodsName = $r['gd_name']; // 상품명
     $Amt = $goodsAmt = $_POST['amount'];// 상품금액
     $BuyerName = $_POST['BuyerName'];
     //echo '$GoodsName : ' . $GoodsName;exit;
     
 }else if(preg_match("/snow_accept_t3.html/i",$p_url)){ // 스노보드지도T3 접수
     
     $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
     $Moid = $_POST['seq'].date("YmdHis"); // 스노보드T3 주문번호
     $GoodsName = $r['gd_name']; // 상품명
     $Amt = $goodsAmt = $_POST['amount'];// 상품금액
     $BuyerName = $_POST['BuyerName'];
     //echo '$GoodsName : ' . $GoodsName;exit;
     
 }else if(preg_match("/champion_accept.html/i",$p_url)){ // 기술선수권 접수
     
     $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
     $Moid = $_POST['seq'].date("YmdHis"); // 기술선수권 주문번호
     $GoodsName = $r['gd_name']; // 상품명
     $Amt = $goodsAmt = $_POST['amount'];// 상품금액
     $BuyerName = $_POST['BuyerName'];
     //echo '$GoodsName : ' . $GoodsName;exit;
     
 }else{
  //   echo "select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'";
  //   exit;

  $r = sql_fetch("select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'");
  $Moid = $_POST['seq'].date("YmdHis"); // 스키지도1 재발급
  $GoodsName = $r['gd_name']; // 상품명
  $Amt = $goodsAmt = $_POST['amount'];		// 상품금액
  $BuyerName = $_POST['BuyerName'];

 }
 
 // PG사 결제내역과 확인을 위해
 $pg_sql="insert into pg_check set oid='$Moid', buyer_name='$BuyerName', buyer_tel='{$_POST['hp1']}-{$_POST['hp2']}-{$_POST['hp3']}', insert_dt='".G5_TIME_YMDHIS."' ";
 sql_query($pg_sql);
 
 
 
 
 $day = '+';
 $server_ip = $_SERVER['SERVER_ADDR']; // $_SERVER['SERVER_ADDR'];	// 서버 IP 가져오기
 $VbankExpDate = date("Ymd", strtotime($day."1 day"));
 $ediDate = date("YmdHis"); // 전문생성일시
 // 상점서명키 - 실결제(꼭 해당 상점키로 바꿔주세요)
 $merchantKey = "nd0So1DPQJEYbLTjyvSAZI8iXf71lL1Kx3klcJZXqmgnVLs3pcpW56D+BItbg2Sxm0vu5nIbP9ShJwqD/5nF4w==";
 $MID = "know00001m";		// MID
 
 
 
 
 if($_SERVER['REMOTE_ADDR']=='125.132.71.189'):
  //$goodsAmt = $Amt = $_POST['amount'] = 501;
  /*echo 'p_url:'.basename($p_url);
  echo '<br>';
  echo "select gd_name from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'";
  */
 endif;
 
  
  
  $encryptData = base64_encode(md5($ediDate.$MID.$goodsAmt.$merchantKey));
 
  if(is_mobile()){
     //$returnUrl = G5_URL.'/pg/mobile/returnMobilePay.php'; // 결제결과를 수신할 가맹점 returnURL 설정
     //$returnUrl = G5_URL.'/pg/pc/returnPay.php'; // 결제결과를 수신할 가맹점 returnURL 설정
     $returnUrl = G5_URL.'/ski/process/blank.html';
     $retryUrl = G5_URL.'/pg/mobile//nformMobile.php'; // 가맹점 retryURL 설정
     
     $retryUrl = $returnUrl;
     
     $stopUrl = G5_URL.'/pg/mobile/stopUrl.php'; // 결제중지 URL
 }else{
     $returnUrl = "http://".$_SERVER['HTTP_HOST']."/pg/pc/returnPay.php"; // 결제결과를 수신할 가맹점 returnURL 설정
     //$retryUrl = "http://".$_SERVER['HTTP_HOST']."/pg/pc/inform.php"; // 가맹점 retryURL 설정
     $retryUrl = $returnUrl;
     //$retryUrl = "https://tpay.smilepay.co.kr/inform.jsp"; // 가맹점 retryURL 설정
 }
 
 $returnUrl = "http://".$_SERVER['HTTP_HOST']."/pg/pc/returnPay.php"; // 결제결과를 수신할 가맹점 returnURL 설정
 $retryUrl = $returnUrl;
 
 
 $DivideInfo = "{'DivideInfo':[{'Amt':'502','MID':'SMTSUB002m','GoodsName':'상품1'},{'Amt':'502','MID':'SMTSUB003m','GoodsName':'상품2'}]}";
 
 $EncryptData = base64_encode(md5($ediDate.$MID.$Amt.$merchantKey));
 //$actionUrl = $DEV_PAY_ACTION_URL; // 개발 서버 URL
 $actionUrl = $PRD_PAY_ACTION_URL; // 실서버 URL
 
 
 //echo '$returnUrl :'.$returnUrl;exit;
 
 
?>

 <!--<input type='hidden' name='PayMethod' value='' /> [필수]CARD, BANK, VBANK -->
 <input type='hidden' name='GoodsCnt' value='1' /><!-- [필수] 상품개수 -->
 <input type='hidden' name='GoodsName' value='<?php echo $GoodsName?>' /><!--[필수]  상품이름 -->
 <input type='hidden' name='PayMethod' value='<?php echo $PayMethod?>'/><!--[필수]  지불수단 -->
 <input type='hidden' name='Amt' value='<?php echo $goodsAmt?>' /><!--  [필수]상품금액 -->
 <input type='hidden' name='Moid' value='<?php echo $Moid?>' /><!-- [필수] 상품주문번호 -->
 <input type='hidden' name='MID' value='<?php echo $MID?>' /><!-- [필수] 상점아이디 -->
 <input type='hidden' name='ReturnURL' value='<?php echo $returnUrl?>' /><!-- [필수] 결제결과전송URL-->
 <input type='hidden' name='RetryURL' value='<?php echo $retryUrl?>' /><!-- [선택] 결제결과RetrURL-->
 <input type='hidden' name='mallUserID' value='' /><!-- [선택] 회원사고객ID-->
 <input type='hidden' name='BuyerName' value='<?php echo $BuyerName?>' /> <!-- [필수] 구매자명12-->
 <input type='hidden' name='BuyerTel' value='<?php echo $_POST['hp1'].'-'.$_POST['hp2'].'-'.$_POST['hp3']?>' /><!-- [필수] 구매자연락처-->
 <input type='hidden' name='BuyerEmail' value='<?php echo $_POST['BuyerEmail']?>' /><!-- [필수] 구매자메일주소-->
 <input type='hidden' name='MallIP' value='49.247.205.58' /><!-- [필수] 상점서버IP-->
 <input type='hidden' name='VbankExpDate' value='<?php echo $VbankExpDate ?>' /><!-- [선택] 가상계좌입금만료일-->
 <input type='hidden' name='EncryptData' value='<?php echo $encryptData ?>' /><!-- [필수] 암호화데이타-->
 <input type='hidden' name='FORWARD' value='Y' /><!-- [필수] 화면처리방식-->
 <input type='hidden' name='TransType' value='0' /><!-- [필수] 결제타입-->
 <input type='hidden' name='EncodingType' value='utf8' /><!-- [선택] 결제결과인코딩-->
 <input type='hidden' name='fn_cd' value='' /><!-- [선택] 카드사코드-->
 <input type='hidden' name='ediDate' value='<?php echo $ediDate ?>' /><!-- [필수] 전문생성일시-->
 <?php if(is_mobile()){?>
<input type='hidden' name='StopURL' value='<?php echo $stopUrl?>' /><!-- [필수] 결제중지 URL-->
<input type='hidden' name='UserIP' value='<?php echo $_SERVER['REMOTE_ADDR']?>' /><!-- [필수] 고객IP-->
<?php  
       }
 //추가 파라미터
if($_POST['seq']=='GD4494') $_POST['seq']='GD4497';

$_POST['GoodsName'] = $_POST['GoodsName'] ? $_POST['GoodsName'] : $GoodsName;
$sql = "select  GD_SALE_ENDDT from t_goods where gd_seq = '{$_POST['seq']}' ";
$sd_date = sql_fetch($sql);

$sd_date = substr($sd_date['GD_SALE_ENDDT'],0,8);
$rs_buyer_idkey = $_POST['birth1'].$_POST['birth2'].$_POST['birth3'];


$tel = $BuyerTel = $_POST['BuyerTel'] ? $_POST['BuyerTel'] : $_POST['hp1'].'-'.$_POST['hp2'].'-'.$_POST['hp3'];
$tel1 = $_POST['tel1'].'-'.$_POST['tel2'].'-'.$_POST['tel3'];

$_POST['amount'] = $_POST['amount'] ? $_POST['amount'] : $Amt;
$rs_status = $_POST['PayMethod']=='CARD' || $_POST['PayMethod']=='BANK' || $_POST['tpay']=='free' ? "C" : "V"; // C -> 신청완료, V -> 입금대기, tpay => pay(유료), free(무료)
$birth = $_POST['birth1'].'-'.sprintf("%02d",$_POST['birth2']).'-'.sprintf("%02d",$_POST['birth3']);

if($_POST['PayMethod'] == 'CARD') $pm_method = "CARD";
else if($_POST['PayMethod'] == 'BANK') $pm_method = "BANK";
else if($_POST['PayMethod'] == 'DIRECTBANK') $pm_method = "DIRECTBANK";

   
$_POST['OID'] = $_POST['OID'] ? $_POST['OID'] : $Moid;
$passwd = $_POST['passwd'];

//$RS_BUYER_PHOTO="/member/".date('Y')."/".date('m')."/".date('d')."/{$_POST['uploadPhoto']}";
if(preg_match("/^\/data\/member/i", $_POST['uploadPhoto']))
 $RS_BUYER_PHOTO = $_POST['uploadPhoto'];
else
 $RS_BUYER_PHOTO="/data/member/".date('Y')."/".date('m')."/".date('d')."/{$_POST['uploadPhoto']}";

$re_issue = $_POST['re_issue'];
$branch = $_POST['branch'];
$except = $_POST['except'];
$part = $_POST['part'];
$isChk1 = $_POST['isChk1']; // 필기/실기 체크여부



if(is_mobile()){
 $pc_mobile = 'm';
}else{
 $pc_mobile = 'p';
}
// 필기면제 첨부자료 ( bf_file )
if (isset($_FILES)) {
    $upload_max_filesize = ini_get('upload_max_filesize');
    $tmp_file  = $_FILES['bf_file']['tmp_name'];
    $filesize  = $_FILES['bf_file']['size'];
    $filename  = $_FILES['bf_file']['name'];
    $filename  = get_safe_filename($filename);
    // 서버에 설정된 값보다 큰파일을 업로드 한다면
    if ($filename) {
        if ($_FILES['bf_file']['error'] == 1) {
            $file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
        }
        else if ($_FILES['bf_file']['error'][$i] != 0) {
            $file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
        }
    }
    if($file_upload_msg){
        echo "<form name='frm1' action='' method='post'>";
        foreach($_POST as $k=>$v){
            echo "<input type='hidden' name='{$k}' value='{$v}' />";
        }
        echo "</form>";
        echo "<script>frm1.submit();</script>";
        exit;
    }
    
    if (is_uploaded_file($tmp_file)) {
        
        // 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
        mkdir(G5_DATA_PATH.'/file/'.$_POST['key'].'/'.$_POST['seq'], G5_DIR_PERMISSION,true);
        chmod(G5_DATA_PATH.'/file/'.$_POST['key'].'/'.$_POST['seq'], G5_DIR_PERMISSION);
        //echo "path : " . G5_DATA_PATH.'/file/'.$_POST['key'].'/'.$_POST['seq'] ;exit;
        
        $chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
        // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
        $filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);
        shuffle($chars_array);
        $shuffle = implode('', $chars_array);
        
        // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
        $upfile = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);
        
        $dest_file = G5_DATA_PATH.'/file/'.$_POST['key'].'/'.$_POST['seq'].'/'.$upfile;
        // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
        $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file']['error'][$i]);
        // 올라간 파일의 퍼미션을 변경합니다.
        chmod($dest_file, G5_FILE_PERMISSION);
        $db_ins_file = '/data/file/'.$_POST['key'].'/'.$_POST['seq'].'/'.$upfile;
        $db_ins_file1 = $_FILES['bf_file']['name'];
    }
    
}

 
 
$base64encode = "key={$_POST['key']}&seq={$_POST['seq']}&amount={$_POST['amount']}&GoodsName={$GoodsName}&tpay={$_POST['tpay']}";
$base64encode .= "&birth={$birth}&hname={$_POST['hname']}&ename={$_POST['ename']}";
$base64encode .= "&tel={$tel}&tel1={$tel1}&part={$_POST['part']}&zip={$_POST['zip']}&addr1={$_POST['addr1']}&addr2={$_POST['addr2']}";
$base64encode .= "&names={$_POST['names']}&births={$_POST['births']}&hps={$_POST['hps']}&license_num={$_POST['license_num']}&BuyerName={$_POST['BuyerName']}";
$base64encode .= "&BuyerTel={$BuyerTel}&BuyerEmail={$_POST['BuyerEmail']}&PayMethod={$_POST['PayMethod']}&sd_date={$sd_date}&rs_buyer_idkey={$rs_buyer_idkey}&tel={$tel}&passwd={$passwd}";
$base64encode .= "&rs_status={$rs_status}&RS_BUYER_PHOTO={$RS_BUYER_PHOTO}&re_issue={$re_issue}&branch={$branch}&except={$except}&pm_method={$pm_method}&pc_mobile={$pc_mobile}&bf_file={$db_ins_file}";
$base64encode .= "&bf_file1={$db_ins_file1}&isChk1={$isChk1}&ADD_BIKE={$_POST['ADD_BIKE']}&skill={$_POST['skill']}";
//기술선수권대회
$base64encode .= "&apt_gender={$_POST['apt_gender']}&nickname={$_POST['nickname']}&ability={$_POST['ability']}&hobby={$_POST['hobby']}&introduction={$_POST['introduction']}";


if($_SERVER['REMOTE_ADDR']=='125.132.71.189'){
 /*echo "<br>base64encode : ".$base64encode;
 exit;
 */
}

$encodeStr = $base64encode;
$base64encode = base64_encode($base64encode);

 /*print_r($_POST);
 print_r($_FILES);
 */
 // 결제세팅
 ?>
 <input type='hidden' name='MallReserved' value='<?php echo $base64encode ?>' /><!-- [선택] 몰전용 데이터-->

 </form>
 
 <script type='text/javascript'>



 
  var encodingType = 'EUC-KR';
 

 
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
	 
	// 기 등록된 자인지 체크 
	
	 var chk1 = false;
	 $.ajax({
	  url : '/ski/process/ajax.postRegist.php',
	  type : 'post',
	  async : false,
	  dataType :'json',
	  data : {
	   seq : '<?=$_POST['seq']?>',
	   BuyerName : '<?php echo $_POST['BuyerName']?>',
	   hp : '<?php echo $BuyerTel?>' 
	  },
	  success : function(data){
	   if(data.code=='1'){
		alert('이미 등록하셨습니다.\n감사합니다.');
		chk1 = true;
	    return false;
	   }
	  }
	 });
	if(chk1) return false;

	//return false;	 
	 
	 
	 
	 var f3 = document.frm3;
	 var f1 = document.frm1;
	//PG호출
	/*
	setAcceptCharset(f);
	setAcceptCharset(f1);
	*/
	setAcceptCharset(f3);
	  
	  f3.action = '<?php echo $actionUrl ?>';
	  
	  <?php if(is_mobile()){?>
	   var winopts= "width=100%,height=100%,toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no";
	   var win =  window.open("", "payWindow", winopts);
	   f3.target='payWindow';
	   
	   //alert('aa');
	   //alert('f.target : ' + f3.target);
	   
	   f3.submit();
	 
	   
	  <?php }else{ ?>
	  
	  if(f3.FORWARD.value == 'Y') // 화면처리방식 Y(권장):상점페이지 팝업호출
		{
			var popupX = (window.screen.width / 2) - (545 / 2);
			var popupY = (window.screen.height /2) - (573 / 2);
						
			var winopts= "width=545,height=573,toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=no,resizable=no,left="+ popupX + ", top="+ popupY + ", screenX="+ popupX + ", screenY= "+ popupY;
			var win =  window.open("", "payWindow", winopts);
			
			try{
			    if(win == null || win.closed || typeof win.closed == 'undefined' || win.screenLeft == 0) { 
			    	alert('브라우저 팝업이 차단으로 설정되었습니다.\\n 팝업 차단 해제를 설정해 주시기 바랍니다.');
			    	return false;
			    }
			}catch(e){}
		    
			f3.target = "payWindow";//payWindow  fixed
			f3.submit();
		}
		else // 화면처리방식 N:결제모듈내부 팝업호출
		{
			f3.target = "payFrame";//payFrame  고정
			f3.submit();
		}
	    <?php } ?>
		return false;
	
 }
 <?php  if(isset($_POST) && !empty($_POST['key'])):?>
  goPG();
 <?php  endif;?>
</script>