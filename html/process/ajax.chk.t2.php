<?php 
header('Content-Type: text/html; charset=UTF-8');
 include_once "../../common.php";
 $_POST = array_map('trim',$_POST);
 
 // 필기실기 합격여부 체크
 $sql = "select * from t_reserve where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}' 
and rs_buyer_name='{$_POST['name']}' and rs_buyer_idkey='{$_POST['birth']}' and (rs_buyer_tel='{$_POST['tel']}' or rs_buyer_tel='".str_replace('-','',$_POST['tel'])."') and (rs_inspect_yn='y' or rs_inspect_yn='Y') limit 1";

 
 $rs = sql_query($sql);
 $r = sql_fetch($sql);
 if(sql_num_rows($rs)){
   echo json_encode(array("code"=>1,"rs_seq"=>$r['rs_seq']));
 }else{
   echo json_encode(array("code"=>0));
 }
?>