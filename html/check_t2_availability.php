<?php
include 'db_config.html';


if(!empty($_POST["username"])) {
  $sql 			= "SELECT * FROM 7G_T2_Apply WHERE MEMBER_ID = '" . $_POST["username"] . "'";
  $result		= mysqli_query($link, $sql);
  $numrow 		= mysqli_num_rows($result);
  
  if($numrow > 0 or empty($_POST["username"])) {
      echo "<span class='text-danger'>&nbsp;👎&nbsp;&nbsp;이미 티칭2 검정을 신청하셨습니다.<br></span>";
  }else{
      echo "<span class='text-success'>&nbsp;👍&nbsp;&nbsp;티칭2 검정 응시가 가능합니다.<br></span>";
  }
}
?>