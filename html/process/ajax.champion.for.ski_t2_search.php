<?php
 header('Content-Type: text/html; charset=utf-8');
 include_once "../../common.php";
 $_POST = array_map('trim',$_POST);

 $birth = explode('-',$_POST['birth']);
 if(strlen($birth[0])>2) $bt = substr($birth[0],2,2);
 else $bt = $birth[0];
 $bt .= sprintf('%02d',$birth[1]).sprintf('%02d',$birth[2]);
 
 $sql = "select count(*) cnt  from t_reserve where gd_seq in ('GD4466','GD4488','GD4491','GD4496', 'GD4505') and 
 (license_tmp_num like 'T2%' or license_num  like 'T2%' or   license_num  like 'TⅡ%') and rs_buyer_name='{$_POST['name']}' 
and (rs_buyer_idkey='{$bt}' or rs_buyer_idkey='".str_replace('-','',$_POST['birth'])."')
";
 $rchk = sql_fetch($sql);

 //echo $sql;exit;
 
 
 
 if(!$rchk['cnt']){
     echo json_encode(array("code"=>0,"msg"=>"대상여부를 조회할 수 없습니다.\n관리자에게 문의해 주세요."));
     exit;
 }else{
     echo json_encode(array("code"=>1,"msg"=>"귀하는 티칭2 합격자입니다."));
     exit;
 }
 

 
 
 $find = sql_fetch("select add_exempt_type from t_reserve_add_info where gd_seq='{$rchk['gd_seq']}' and add_name_kor='{$_POST['name']}' and add_birth='{$bt}' ");
 /*echo "select add_exempt_type from t_reserve_add_info where gd_seq='{$rchk['gd_seq']}' and add_name_kor='{$_POST['name']}' and add_birth='{$bt}'";
 exit;
 */
 
 if(!$find['add_exempt_type'] || $find['add_exempt_type']=='NONE'){
   echo json_encode(array("code"=>1,"msg"=>"대상여부가 조회되지 않습니다."));
 }else if($find['add_exempt_type']=='BOTH'){
   echo json_encode(array("code"=>1,"msg"=>"실기/필기 면제대상자 입니다."));
 }else if($find['add_exempt_type']=='NOTES'){
   echo json_encode(array("code"=>1,"msg"=>"필기 면제대상자 입니다."));
 }else if($find['add_exempt_type']=='PRACTICE'){
   echo json_encode(array("code"=>1,"msg"=>"실기 면제대상자 입니다."));
 }
?>