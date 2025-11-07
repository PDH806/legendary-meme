<?php 
header('Content-Type: text/html; charset=UTF-8');
 include_once "../../common.php";
 $_POST = array_map('trim',$_POST);
 //$_POST = array_map('iconv_utf8', $_POST); 
 
 //print_r($_POST);exit;

 $username = $_POST['name'];
 
 // 자격증 신청기간인지 확인
 $sql = "select  gd_name, gd_sale_startdt, gd_sale_enddt  from t_goods where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}'"; 
 
 $rs = sql_query($sql);
 $r = sql_fetch($sql);
 
 $now = strtotime("now");
 $st_dt = strtotime(substr($r['gd_sale_startdt'],0,4)."-".substr($r['gd_sale_startdt'],4,2)."-".substr($r['gd_sale_startdt'],6,2));
 $end_dt = strtotime(substr($r['gd_sale_enddt'],0,4)."-".substr($r['gd_sale_enddt'],4,2)."-".substr($r['gd_sale_enddt'],6,2));
 
 /*echo substr($r['gd_sale_startdt'],0,4)."-".substr($r['gd_sale_startdt'],4,2)."-".substr($r['gd_sale_startdt'],6,2);
 echo "\n";
 echo substr($r['gd_sale_enddt'],0,4)."-".substr($r['gd_sale_enddt'],4,2)."-".substr($r['gd_sale_enddt'],6,2);
 exit;
 
 
 echo "$now";
 echo "<br>$st_dt";
 echo "<br>$end_dt";
 exit;
 */
 if($now >= $st_dt && $now <= $end_dt){
     echo json_encode(array("code"=>1,"msg"=>$r['gd_name']));
 }else{
     echo json_encode(array("code"=>0, "msg"=>"{$r['gd_name']} 신청기간이 아닙니다."));
 }
 
?>