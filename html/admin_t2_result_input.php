<?
include 'db_config.html';
$update_No		= $_GET["No"];
$Final_result	= $_GET["result"];

// 관리자가 아니면 member_login.html 페이지로 이동
if ($Login_User_ID or $rank != 9 or !$rank){
echo " <script>
alert('잘못된 접근입니다.');
top.document.location.href = 'member_login.html?MEMBER_ID=$User_ID_Search&Case=9';
</script>";
}
	

$sql="UPDATE 7G_T2_Apply SET Final_result = '$Final_result' where Apply_No = '$update_No'";

if ($link->query($sql) === TRUE) {} else {}
$link->close();
echo "<script>location.href='admin_t2_result_input.html';</script>";
?>



