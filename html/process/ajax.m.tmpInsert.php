<?php 
header('Content-Type: text/html; charset=UTF-8');
 include_once "../../common.php";
 $_POST = array_map('trim',$_POST);
 //$_POST = array_map('iconv_utf8', $_POST); 
 
 //print_r($_POST);exit;
 
 // 기 등록된 자인지 체크
 
 $sql = "insert into tmp_reserve set oid='{$_POST['oid']}', idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}', 
            birth='{$_POST['birth']}', hname='{$_POST['hname']}' , ename='{$_POST['ename']}',
            hp='{$_POST['hp']}', part='{$_POST['part']}' , zip='{$_POST['zip']}',
            addr1='{$_POST['addr1']}', addr2='{$_POST['addr2']}' , names='{$_POST['names']}',
            births='{$_POST['births']}', hps='{$_POST['hps']}' "; 

 //echo $sql;
 $rs = sql_query($sql);
 
 if($rs){
   echo json_encode(array("code"=>1));
 }else{
   echo json_encode(array("code"=>0));
 }
?>