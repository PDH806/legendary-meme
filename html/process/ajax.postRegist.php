<?php 
if(!$_POST['seq'] && !$_POST['BuyerName'] && !$_POST['hp'] ) exit;

include_once "../../common.php";
 $_POST = array_map('trim',$_POST);
 
 

 if($_POST['seq']=='GD4502' or $_POST['seq']=='GD4503' ){
   // 기술선수권(GD4502) 300명 응시제한
   // 스노보드 T2(GD4503) 250명 응시제한
   $sql = "select count(*) cnt from t_reserve where gd_seq='{$_POST['seq']}' and (license_num is null or license_num = '') ";
   $cnt = sql_fetch($sql);
   if($_POST['seq']=='GD4503') $limit = '250';
   else if($_POST['seq']=='GD4502') $limit = '300';
 
   if($cnt['cnt']>$limit){
    echo json_encode(array("code"=>2,"msg"=>"응시제한인원({$limit}명)을 초과하였습니다."));
    exit;
   }
  }
 // 기 등록된 자인지 체크
 $sql = "select count(*) cnt from t_reserve where gd_seq='{$_POST['seq']}' and  rs_buyer_name='{$_POST['BuyerName']}' and rs_buyer_tel='{$_POST['hp']}' 
and (rs_status='C' or rs_status='V') and INSERT_DT like '".G5_TIME_Y."%' order by INSERT_DT desc limit 1";
 //echo $sql;exit;
 
 $rchk = sql_fetch($sql);
 if($rchk['cnt']){
   echo json_encode(array("code"=>1));
 }else{
   echo json_encode(array("code"=>0));
 }
?>