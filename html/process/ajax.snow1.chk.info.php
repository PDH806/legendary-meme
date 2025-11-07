<?php 
header('Content-Type: text/html; charset=UTF-8');
 include_once "../../common.php";
 $_POST = array_map('trim',$_POST);
 //$_POST = array_map('iconv_utf8', $_POST); 
 
 //print_r($_POST);exit;
 $t1 = explode(',',$_POST['seq']);
 $seq = implode('\',\'', $t1);
 
 $username = $_POST['name'];
 
 // 기 등록된 자인지 체크
 $sql = "select idkey,gd_seq,rs_seq, license_num, license_tmp_num   from t_reserve where  gd_seq in ('{$seq}')  
and rs_buyer_name='{$username}' and rs_buyer_idkey='{$_POST['birth']}' and ( rs_buyer_tel='{$_POST['tel']}' or rs_buyer_tel='{$_POST['tel1']}') 
/*and (rs_inspect_yn='y' or rs_inspect_yn='Y')*/ order by insert_dt desc
limit 1";
 
 if($_SERVER['REMOTE_ADDR']=='210.97.98.158'){
  /*echo $sql;
  exit;
  */
 }
 $rs = sql_query($sql);
 $r = sql_fetch($sql);
 if(sql_num_rows($rs) && ( $r['license_num'] || $r['license_tmp_num'] ) ){
     echo json_encode(array("code"=>1,"rs_seq"=>$r['rs_seq'],"gd_seq"=>$r['gd_seq'],"key"=>$r['idkey'] , 'license_num'=>$r['license_num']?$r['license_num']:$r['license_tmp_num']));
 }else{
   echo json_encode(array("code"=>0));
 }
?>