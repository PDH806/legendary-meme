<?php
 header('Content-Type: text/html; charset=utf-8');
 include_once "../../common.php";
 $_POST = array_map('trim',$_POST);
 /* 해당회 연도
 $sql = "select gd_seq  from t_goods where idkey='{$_POST['key']}' and gd_sale_enddt < (select gd_sale_enddt from t_goods 
where gd_seq='{$_POST['seq']}') and gd_name like '%티칭2%' and gd_name not like '%재발급%' 
order by gd_sale_enddt desc limit 1 ";
 */
 
 $birth = explode('-',$_POST['birth']);
 if(strlen($birth[0])>2) $bt = substr($birth[0],2,2);
 else $bt = $birth[0];
 $bt .= sprintf('%02d',$birth[1]).sprintf('%02d',$birth[2]);
 
 $_POST['name'] =  $_POST['name'] ? $_POST['name'] : $_POST['hname'];    
 
 if($_POST['mode']=='sbt1'){
  $sql = "select (select ADD_EXEMPT_TYPE from t_reserve_add_info where rs_seq=a.RS_SEQ) add_exempt_type 
          from t_reserve a where GD_SEQ='{$_POST['seq']}' and  rs_buyer_name='{$_POST['name']}' and rs_buyer_idkey='{$bt}' and rs_buyer_tel='{$_POST['hp']}' 
           and bib_num like 'Bib2019%' 
          order by rs_date desc limit 1";
 // echo $sql;exit;
  $find = sql_fetch($sql);
  if(!$find['add_exempt_type'] || $find['add_exempt_type']=='NONE'){
      echo json_encode(array("code"=>1,"msg"=>"필기/실기 면제자가 아닙니다.","val"=>"NONE"));
  }else if($find['add_exempt_type']=='BOTH'){
      echo json_encode(array("code"=>1,"msg"=>"실기/필기 면제대상자 입니다.","val"=>"BOTH"));
  }else if($find['add_exempt_type']=='NOTES'){
      echo json_encode(array("code"=>1,"msg"=>"필기 면제대상자 입니다.", "val"=>"NOTES"));
  }else if($find['add_exempt_type']=='PRACTICE'){
      echo json_encode(array("code"=>1,"msg"=>"실기 면제대상자 입니다.", "val"=>"PRACTICE"));
  }
  exit;
 }
 
 else{
  $sql = "select * from t_reserve where  rs_buyer_name='{$_POST['name']}' and rs_buyer_idkey='{$bt}' and (rs_seq like 'BibT22018%' or rs_seq like 'BibS22018%'  ) order by rs_date desc limit 1";
  $rchk = sql_query($sql);
 }
 //echo $sql;exit;
 
 
 if(!sql_num_rows($rchk)){
     echo json_encode(array("code"=>1,"msg"=>"대상여부를 조회할 수 없습니다.\n관리자에게 문의해 주세요.","val"=>"NOT"));
     exit;
 }

 $r = sql_fetch($sql);
  
 $find = sql_fetch("select add_exempt_type from t_reserve_add_info where idkey='{$r['IDKEY']}' and gd_seq='{$r['GD_SEQ']}' and add_name_kor='{$_POST['name']}' and rs_seq='{$r['RS_SEQ']}'  order by regist_date desc limit 1");
 
 /*echo "select add_exempt_type from t_reserve_add_info where idkey='{$r['IDKEY']}' and gd_seq='{$r['GD_SEQ']}' and add_name_kor='{$_POST['name']}' and rs_seq='{$r['RS_SEQ']}'  order by regist_date desc limit 1";
 exit;
 */
 
 if(!$find['add_exempt_type'] || $find['add_exempt_type']=='NONE'){
   echo json_encode(array("code"=>1,"msg"=>"필기/실기 면제자가 아닙니다.","val"=>"NONE"));
 }else if($find['add_exempt_type']=='BOTH'){
     echo json_encode(array("code"=>1,"msg"=>"실기/필기 면제대상자 입니다.","val"=>"BOTH"));
 }else if($find['add_exempt_type']=='NOTES'){
     echo json_encode(array("code"=>1,"msg"=>"필기 면제대상자 입니다.", "val"=>"NOTES"));
 }else if($find['add_exempt_type']=='PRACTICE'){
     echo json_encode(array("code"=>1,"msg"=>"실기 면제대상자 입니다.", "val"=>"PRACTICE"));
 }
?>