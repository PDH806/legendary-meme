<?php
 include_once $_SERVER['DOCUMENT_ROOT'].'/common.php';
 $_POST = array_map('trim',$_POST);
 
 //IDKEY 구하기
 $sql = "select idkey from t_goods where gd_seq='{$_POST['seq']}' ";
 $tidkey = sql_fetch($sql);
 $_POST['key'] = $tidkey['idkey'];
 
 
 if($_POST['w']==''){
 
 if(strlen($_POST['birth1'])==4){
     $birth = substr($_POST['birth1'],2,2);
     $tbirth = substr($_POST['birth1'],2,2);
 }
 else if(strlen($_POST['birth1'])==2){
     $birth = $_POST['birth1'];
     $tbirth = $_POST['birth1'];
 }
 
 $tbirth .= '-'.sprintf("%02d",$_POST['birth2']).'-'.sprintf("%02d",$_POST['birth3']);
 $birth .= sprintf("%02d",$_POST['birth2']).sprintf("%02d",$_POST['birth3']);
 
 $tel = $_POST['tel1'].'-'.$_POST['tel2'].'-'.$_POST['tel3'];
     
 $sql = "SELECT idkey, gd_seq, rs_seq FROM t_reserve where IDKEY='{$_POST['key']}' AND  GD_SEQ='{$_POST['seq']}' 
                AND rs_buyer_name='{$_POST['hname']}' and rs_buyer_idkey='$birth' limit 1";
 //echo $sql;exit;
 $chk = sql_query($sql);
 $r = sql_fetch_array($chk);
 
 //print_r($r);exit;
 
 // 업로드한 파일 DB 입력
 if($_POST['uploadPhoto']){
    /* echo "update t_reserve set rs_buyer_photo='{$_POST['uploadPhoto']}' where IDKEY='{$_POST['key']}' AND  GD_SEQ='{$_POST['seq']}'
                AND rs_buyer_name='{$_POST['hname']}' and rs_buyer_idkey='$birth'";
     exit;
    */
 sql_query("update t_reserve set rs_buyer_photo='{$_POST['uploadPhoto']}' where IDKEY='{$_POST['key']}' AND  GD_SEQ='{$_POST['seq']}' 
                AND rs_buyer_name='{$_POST['hname']}' and rs_buyer_idkey='$birth'");
 }

 
 if(sql_num_rows($chk)){
  $sql = "INSERT INTO  t_reserve_add_info SET
            IDKEY='{$_POST['key']}', GD_SEQ='{$_POST['seq']}', RS_SEQ='{$r['rs_seq']}',
            ADD_NAME_KOR='{$_POST['hname']}', ADD_NAME_ENG='{$_POST['ename']}', ADD_BIRTH='{$tbirth}', ADD_TEL='{$tel}',
            ADD_ADDR_TYPE='{$_POST['part']}', ADD_ZIPCODE='{$_POST['zip']}',
            ADD_ADDR1 = '{$_POST['addr1']}' ,  ADD_ADDR2='{$_POST['addr2']}' , REGIST_DATE = '".G5_TIME_YMDHIS."'
  ";
 }
 //echo $sql;exit;
 $rs = sql_query($sql);

 }else if($_POST['w']=='u'){ // 수정일때
   $tel = $_POST['tel1'].'-'.$_POST['tel2'].'-'.$_POST['tel3'];
   if(strlen($_POST['birth1'])==4){
       $birth = substr($_POST['birth1'],2,2);
       $tbirth = substr($_POST['birth1'],2,2);
   }
   else if(strlen($_POST['birth1'])==2){
       $birth = $_POST['birth1'];
       $tbirth = $_POST['birth1'];
   }
   $birth .= sprintf("%02d",$_POST['birth2']).sprintf("%02d",$_POST['birth3']);
   // 업로드한 파일 DB 입력
   if($_POST['uploadPhoto']){
       sql_query("update t_reserve set rs_buyer_photo='{$_POST['uploadPhoto']}' where IDKEY='{$_POST['key']}' AND  GD_SEQ='{$_POST['seq']}'
                AND rs_buyer_name='{$_POST['hname']}' and rs_buyer_idkey='$birth'");
   }
   $sql = "UPDATE  t_reserve_add_info SET
            ADD_NAME_ENG='{$_POST['ename']}', ADD_TEL='{$tel}',  ADD_ADDR_TYPE='{$_POST['part']}', ADD_ZIPCODE='{$_POST['zip']}',
            ADD_ADDR1 = '{$_POST['addr1']}' ,  ADD_ADDR2='{$_POST['addr2']}' , UPDATE_DATE = '".G5_TIME_YMDHIS."'
           WHERE IDKEY='{$_POST['key']}' and GD_SEQ='{$_POST['seq']}' and  RS_SEQ='{$_POST['seq1']}'

  ";
   //echo $sql;exit;
   $rs = sql_query($sql);
     
 }
?>
<?php if($rs){?>
<form name='f1' action='/ski/teach_my_info.t2.html' method='post'>
<?php 
 foreach($_POST as $k=>$v){
  if($k=='chk1') $v='1';
?>
 <input type='hidden' name='<?php echo $k?>' value='<?php echo $v?>' />
<?php }?>
</form>
<script>
 alert("등록되었습니다.");
 f1.submit();
</script>
<?php }?>


