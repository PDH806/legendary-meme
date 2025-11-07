<?php
include 'db_config.html';

if(!empty($_POST["phone1"])) {
  $sql 			= "SELECT * FROM 7G_Skiresort_Member WHERE phone = '" . $_POST["phone1"] . "'";
  $result		= mysqli_query($link, $sql);
  $numrow 		= mysqli_num_rows($result);
  
  if($numrow > 0 or empty($_POST["phone1"])) {
      echo "<span class='text-danger'>&nbsp;👎&nbsp;&nbsp;다른 회원이 사용중인 전화번호입니다. 다른 번호를 입력해주세요.<br></span>";
  }else{
      echo "<span class='text-success'>&nbsp;👍&nbsp;&nbsp;선택하신 번호는 사용가능합니다.<br></span>";
  }
}
?>