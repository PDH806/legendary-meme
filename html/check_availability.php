<?php
include 'db_config.html';

if(!empty($_POST["username"])) {
  $sql 			= "SELECT * FROM 7G_Skiresort_Member WHERE MEMBER_ID = '" . $_POST["username"] . "'";
  $result		= mysqli_query($link, $sql);
  $numrow 		= mysqli_num_rows($result);
  
  if($numrow > 0 or empty($_POST["username"])) {
      echo "<span class='text-danger'>&nbsp;👎&nbsp;&nbsp;다른 회원이 사용중인 ID입니다. 다른 ID를 사용하여 주세요.<br></span>";
  }else{
      echo "<span class='text-success'>&nbsp;👍&nbsp;&nbsp;선택하신 ID는 사용가능합니다.<br></span>";
  }
}
?>