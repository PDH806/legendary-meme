<?php
 header('Content-Type: text/html; charset=utf-8');
 include_once "../../common.php";
 $_POST = array_map('trim',$_POST);
 
 $encData = base64_encode(md5($ediDate.$MID.$goodsAmt.$mk));
 if($encData){
     echo json_encode(array("code"=>1,"encData"=>$encData));
     exit;
 }else{
     echo json_encode(array("code"=>1,"msg"=>"귀하는 티칭2 합격자입니다."));
     exit;
 }
 
?>