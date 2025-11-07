<?php
require_once("DBController.php");
$db_handle = new DBController();

if(!empty($_POST["username"])) {

		$connect=mysql_connect("dbserver", skiresort, ll170505);
		$link=mysqli_connect("dbserver", skiresort, ll170505, skiresort);
		mysql_select_db(skiresort,$connect);

  		$query = "SELECT * FROM 7G_Skiresort_Member WHERE MEMBER_ID = '" . $_POST["username"] . "'";

		$result = mysql_query($query,$connect);
		$row2	= mysql_fetch_array($result);

		$name	= $row2[MEMBER_NAME];
		$name   = iconv_substr($name, 0, 2, "utf-8");

		$user_count = $db_handle->numRows($query);
		
  		if($user_count>0) {
  		
      		echo "<span class='text-success'>&nbsp;👍&nbsp;&nbsp;입력하신 ID는 $name*님의 ID입니다.<br>
      		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;본인 ID가 맞으시면 전화번호를 입력해 주세요 !!!<br></span>";
  			}else{
      		echo "<span class='text-danger'>&nbsp;👎&nbsp;&nbsp;존재하지 않는 ID입니다. 다른 ID를 입력하여 주십시요.<br></span>";
  		}
}
?>






