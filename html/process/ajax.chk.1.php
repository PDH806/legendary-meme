<?php 
header('Content-Type: text/html; charset=UTF-8');
 include_once "../../common.php";
 $_POST = array_map('trim',$_POST);
 //$_POST = array_map('iconv_utf8', $_POST); 
 
 //print_r($_POST);exit;

 $username = $_POST['name'];
 $t_gd_seq = explode(',',$_POST['seq']);
 $tmp1 = implode('\',\'',$t_gd_seq);
 
 $t_gd_seq = explode(',',$_POST['key']);
 $tmp2 = implode('\',\'',$t_gd_seq);
 
 // 기 등록된 자인지 체크
 /*$sql = "select idkey,gd_seq,rs_seq , license_num, license_tmp_num  from t_reserve where idkey='{$_POST['key']}' and gd_seq in ('{$tmp1}') 
and rs_buyer_name='{$username}' and rs_buyer_idkey='{$_POST['birth']}' and (rs_buyer_tel='{$_POST['tel']}' or rs_buyer_tel='".str_replace('-','',$_POST['tel'])."') 
and (rs_inspect_yn='y' or rs_inspect_yn='Y') limit 1";
*/
$sql = "select rs_date, idkey,gd_seq,rs_seq , license_num, license_tmp_num  from t_reserve where idkey in ('{$tmp2}') and gd_seq in ('{$tmp1}') 
and rs_buyer_name='{$username}' and rs_buyer_idkey='{$_POST['birth']}' and (rs_buyer_tel='{$_POST['tel']}' or rs_buyer_tel='".str_replace('-','',$_POST['tel'])."') 
/*and (rs_inspect_yn='y' or rs_inspect_yn='Y')*/ order by rs_date desc limit 1";

//echo $sql;exit;

 $rs = sql_query($sql);
 $r = sql_fetch($sql);
 if(sql_num_rows($rs) && ( $r['license_num'] || $r['license_tmp_num'] ) ){
     echo json_encode(array("code"=>1,"seq"=>$r['gd_seq'], "seq1"=>$r['rs_seq'], 'license_num'=>$r['license_num']?$r['license_num']:$r['license_tmp_num']));
 }else{
   echo json_encode(array("code"=>0));
 }
?>