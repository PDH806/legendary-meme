<?php 
 /*echo json_encode(array("code"=>0));
 exit;
 */
 include_once "../../common.php";
 $_POST = array_map('trim',$_POST);
 
 //T2합격자
 if($_POST['mode']=='skit2'){
  $seq = " in ('GD4488','GD4496', 'GD4491', 'GD4466','GD4505') ";
 }else if($_POST['mode']=='skit1'){
  $seq = " in ('GD4495','GD4470') ";
 }else if($_POST['mode']=='sbt1'){
     $seq = " in ('GD4475') ";
 }else if($_POST['mode']=='sbt2'){
     $seq = " in ('GD4503', 'GD4498') ";
 }
 // 티칭1 합격자인지 체크
 $sql = "select count(*) cnt from t_reserve 
where gd_seq {$seq}  and  rs_buyer_name='{$_POST['BuyerName']}' and 
(rs_buyer_idkey='".str_replace('-','',substr($_POST['birth'],2))."' or rs_buyer_idkey='".str_replace('-','',$_POST['birth'])."') 
and (rs_buyer_tel='{$_POST['hp']}' or rs_buyer_tel='".str_replace('-','',$_POST['hp'])."') and ( license_num <>'' or license_tmp_num <>'' ) ";
//echo $sql;exit;

 if($_SERVER['REMOTE_ADDR']=='125.132.71.189'){
     /*echo json_encode(array("code"=>1));
     exit;*/
 }
 $rchk = sql_fetch($sql);
 if($rchk['cnt']){
   echo json_encode(array("code"=>1));
 }else{
   echo json_encode(array("code"=>0));
 }
?>