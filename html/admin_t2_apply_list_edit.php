<?
// 관리자여부 체크
$Login_User_ID 		= $_COOKIE['Login_ID'];
$rank 				= $_COOKIE['Member_Rank'];

// 관리자가 아니면 member_login.html 페이지로 이동
if ($Login_User_ID or $rank != 9 or !$rank){
echo " <script>
alert('잘못된 접근입니다.');
top.document.location.href = 'member_login.html?MEMBER_ID=$User_ID_Search&Case=9';
</script>";
}

include 'db_config.html';
$update_No			= $_POST["apply_no"];
$member_id			= $_POST["member_id"];
$member_email		= $_POST["member_email"];
$zipcode			= $_POST["zip"];
$Address1			= $_POST["Address1"];
$Address2			= $_POST["Address2"];
$Address3			= $_POST["Address3"];

$Memo1				= $_POST["Memo1"];
$Memo2				= $_POST["Memo2"];
$Memo3				= $_POST["Memo3"];
$Memo4				= $_POST["Memo4"];

$Payment_Method		= $_POST["Payment_Method"];
$Payment			= $_POST["Payment"];
$ski_Brand			= $_POST["ski_Brand"];

$sql = "UPDATE 7G_T2_Apply SET 
Payment			= '$Payment',
Payment_Method	= '$Payment_Method',
ZIPCODE			= '$zipcode',
ADDR1			= '$Address1',
ADDR2			= '$Address2',
ADDR3			= '$Adress3',
T2_MEMO1		= '$Memo1',
T2_MEMO2		= '$Memo2',
T2_MEMO3		= '$Memo3',
T2_MEMO4		= '$Memo4',
Ski_Brand		= '$ski_Brand'
WHERE Apply_No 	= '$update_No'";

if ($link->query($sql) === TRUE) {} else {}

if ($member_email != ''){
$sql2="Update 7G_Skiresort_Member set
EMAIL = '$member_email' where MEMBER_ID = '$member_id'";
if ($link->query($sql2) === TRUE) {} else {}
}

$link->close();

echo "<script>location.href='admin_t2_apply_list_edit.html?No=$update_No';</script>";
?>