<?php 
 exit;
 include_once "../common.php";
 
 // 스노보드티칭2
 $sql = "select a.rs_seq , b.add_sex
from t_reserve a, t_reserve_add_info b
where  a.rs_seq=b.rs_seq and b.add_bike='알파인' and a.idkey='500051' and a.gd_seq='gd4503' and a.rs_status='C' and a.insert_dt like '2020-02%'
order by a.rs_date";
 $rs = sql_query($sql);
 
 $tmp = array();
 while($r = sql_fetch_array($rs)):
 $tmp['F'][] = $r['rs_seq'];
 endwhile;
 shuffle($tmp['F']);
 
 $sql = "select a.rs_seq , b.add_sex
from t_reserve a, t_reserve_add_info b
where  a.rs_seq=b.rs_seq and b.add_bike='프리스타일' and a.idkey='500051' and a.gd_seq='gd4503' and a.rs_status='C' and a.insert_dt like '2020-02%'
order by b.add_sex, a.rs_date";
 $rs = sql_query($sql);
 while($r = sql_fetch_array($rs)):
 $tmp['M'][] = $r['rs_seq'];
 endwhile;
 shuffle($tmp['M']);
 
 $seq=1;
 $num=1;
 
 foreach($tmp['F'] as $v){
     $bib_num = "Bib2020".sprintf("%04d",$seq++);
     $sql = "update t_reserve set bib_num='{$bib_num}' where rs_seq='{$v}' ";
     //echo $num++.'->'.$sql.'<br>';
     sql_query($sql,true);
     
 }
 
 foreach($tmp['M'] as $v){
     $bib_num = "Bib2020".sprintf("%04d",$seq++);
     $sql = "update t_reserve set bib_num='{$bib_num}' where rs_seq='{$v}' ";
     //echo $num++.'->'.$sql.'<br>';
     sql_query($sql,true);
 }
 exit;
 
 // 스파이더배 기술선수권대회
 /*
 $sql = "select a.rs_seq , b.add_sex
from t_reserve a, t_reserve_add_info b  
where  a.rs_seq=b.rs_seq and b.add_sex='F' and a.idkey='500050' and a.gd_seq='gd4502' and a.rs_status='C' and a.insert_dt like '2020%'
order by b.add_sex, a.rs_date";
 $rs = sql_query($sql);
 
 $tmp = array();
 while($r = sql_fetch_array($rs)):
  $tmp['F'][] = $r['rs_seq'];
 endwhile;
 shuffle($tmp['F']);
 
 $sql = "select a.rs_seq , b.add_sex
from t_reserve a, t_reserve_add_info b
where  a.rs_seq=b.rs_seq and b.add_sex='M' and a.idkey='500050' and a.gd_seq='gd4502' and a.rs_status='C' and a.insert_dt like '2020%'
order by b.add_sex, a.rs_date";
 $rs = sql_query($sql);
 while($r = sql_fetch_array($rs)):
 $tmp['M'][] = $r['rs_seq'];
 endwhile;
 shuffle($tmp['M']);

 $seq=1;
 $num=1;
 foreach($tmp['F'] as $v){
     $bib_num = "Bib2020".sprintf("%04d",$seq++);
     $sql = "update t_reserve set bib_num='{$bib_num}' where rs_seq='{$v}' ";
     //echo $num++.'->'.$sql.'<br>';
     sql_query($sql,true);
      
 }
 
 foreach($tmp['M'] as $v){
     $bib_num = "Bib2020".sprintf("%04d",$seq++);
     $sql = "update t_reserve set bib_num='{$bib_num}' where rs_seq='{$v}' ";
     //echo $num++.'->'.$sql.'<br>';
     sql_query($sql,true);
 }
 */
 
 
 
 /*
 // 제7기 스키지도요원(티칭2)
 $sql = "select a.rs_seq 
from t_reserve a
where  a.idkey='500053' and a.gd_seq='gd4505' and a.rs_status='C' and insert_dt like '2020%'
order by a.rs_date";
 */
 /* 제22기 스키구조요원
 $sql = "select a.rs_seq
from t_reserve a
where  a.idkey='500044' and a.gd_seq='gd4493' and a.rs_status='C' and bib_num >= 'Bib20190005'
order by a.rs_date";
 */
 
 
 $rs = sql_query($sql);
 
 $tmp = array();
 while($r = sql_fetch_array($rs)):
 $tmp[] = $r['rs_seq'];
 endwhile;
 shuffle($tmp);
 
 $seq=1;
 foreach($tmp as $v){
     $bib_num = "Bib2020".sprintf("%04d",$seq++);
     $sql = "update t_reserve set bib_num='{$bib_num}' where rs_seq='{$v}' and idkey='500053' and gd_seq='gd4505' ";
     echo $sql.'<br>';
     //sql_query($sql,true);
 }
 
?>