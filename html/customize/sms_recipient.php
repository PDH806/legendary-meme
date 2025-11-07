<?php 
include_once "../common.php";
 // 스파이더배 기술선수권대회
 
header( "Content-type: application/vnd.ms-excel" );
header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = 스파이더배 기술선수권대회.xls" );
header( "Content-Description: PHP4 Generated Data" );
echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"excel\"> ";

 /*$sql = "select a.rs_buyer_tel, a.rs_buyer_name, a.bib_num
from t_reserve a
where  a.idkey='500050' and a.gd_seq='gd4502' and a.rs_status='C' 
order by a.bib_num";
//스노보드지도요원(티칭2)
 $sql = "select a.rs_buyer_tel, a.rs_buyer_name, a.bib_num
from t_reserve a
where  a.idkey='500051' and a.gd_seq='gd4503' and a.rs_status='C' and insert_dt like '2020-02%'
order by a.bib_num";
 
  
*/
 
 
 
 

// 기술선수권대회
$sql = "select a.rs_buyer_tel, a.rs_buyer_name, a.bib_num
from t_reserve a
where  a.idkey='500050' and a.gd_seq='gd4502' and a.rs_status='C' and insert_dt like '2020-02%'
order by a.bib_num";


/*
// 제7기 스키지도요원(티칭2)
$sql = "select a.rs_buyer_tel, a.rs_buyer_name, bib_num 
from t_reserve a
where  a.idkey='500053' and a.gd_seq='gd4505' and a.rs_status='C' and insert_dt like '2020%'
order by a.bib_num";
 
/*
// 제22기 스키구조요원
$sql = "select a.rs_buyer_tel, a.rs_buyer_name, a.bib_num
from t_reserve a
where  a.idkey='500044' and a.gd_seq='GD4493' and a.rs_status='C'
order by a.bib_num";
 */
 
 
 $rs = sql_query($sql);
 
 ?>
 
 <table>
  <tr><td>연락처</td><td>이름</td><td>BIB_NUM</td></tr>
 <?php 
 while($r = sql_fetch_array($rs)){
     echo "<tr><td>{$r['rs_buyer_tel']}</td><td>{$r['rs_buyer_name']}</td><td>{$r['bib_num']}</td></tr>";
     
 }
 ?> 
  
 </table>
 <?php 
 
 
 
 
 
 
 
 
 // 제1기 스노보드지도요원(티칭2)
 /*
 $sql = "select a.rs_seq
from t_reserve a
where  a.idkey='500051' and a.gd_seq='gd4503' and a.rs_status='C'
order by a.rs_date";
 $rs = sql_query($sql);
 */
?>