<?php
 $connect=mysql_connect("localhost", "skiresort", "wints!");
 $link=mysqli_connect("localhost", "skiresort", "wints!", "skiresort");
 mysql_select_db("skiresort",$connect);

 $insert = "INSERT INTO 7G_Skiresort_Phone_Check ( name, id, phone, code, log ) VALUES ( 'qkreogus', 'qkreogus00', '01025986417', '111111', '123456' )";

 mysqli_query($link, $insert);

 ?>