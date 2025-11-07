<?php 
 exit;
 include_once "../common.php";
 $sql = "select idkey, gd_seq, sd_seq, rs_seq, rs_buyer_photo, rs_buyer_doc from t_reserve where 1=1";
 $rs = sql_query($sql);
 while($r = sql_fetch_array($rs)):
 echo $r['rs_buyer_doc'].'<br>';
  if(preg_match("/buyer_attach/i",$r['rs_buyer_photo'])){
    //echo $r['rs_buyer_photo'].'<br>';  
  }else{
   //echo $r['rs_buyer_photo'].'<br>';
    $photo = str_replace("http://smartixcamping.cafe24.com/upload/koreaski","/data/member",$r['rs_buyer_photo']);
    //echo $photo.'<br>';
    $update = "update t_reserve set rs_buyer_photo='{$photo}' where idkey='$r[idkey]' and gd_seq='$r[gd_seq]' and sd_seq='$r[sd_seq]' and rs_seq='$r[rs_seq]' ";
    //echo $update.'<br>';
    //sql_query($update);
  }
 endwhile;
?>