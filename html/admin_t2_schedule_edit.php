<? 
include 'db_config.html'; 

// 관리자가 아니면 member_login.html 페이지로 이동
if ($Login_User_ID or $rank != 9 or !$rank){
echo " <script>
alert('잘못된 접근입니다.');
top.document.location.href = 'member_login.html?MEMBER_ID=$User_ID_Search&Case=9';
</script>";
}
		
$No 			= $_POST['No'];
$Test_Year		= $_POST['Test_Year'];
$Auditor  		= $_POST['Auditor'];
$Skiresort   	= $_POST['Skiresort'];
$Participate   	= $_POST['Participate'];
$Date1			= $_POST['Date1'];
$Date2			= $_POST['Date2'];

$Time1			= $_POST['Time1'];
$Time2			= $_POST['Time2'];
$Time 			= "$Time1~$Time2";
$Testfee		= $_POST['Testfee'];
$Status			= $_POST['Status'];

if (!$link) {die("Connection failed: " . mysqli_connect_error());}

$sql = "update 7G_T2_Schedules set
Test_Year	= '$Test_Year',
Skiresort 	= '$Skiresort',
Participate	= '$Participate',
Test_Date	= '$Date1',	
Expired_Date = '$Date2',
Time		= '$Time',
Testfee		= '$Testfee',
Manager_ID	= '$Login_User_ID',
Status		= '$Status'
where No = '$No'
";
	
if (mysqli_query($link, $sql)){echo "<script language='javascript'>alert('요청하신 일정변경이 완료되었습니다.');top.document.location.href = 'admin_t2_schedule_edit.html?No=$No'</script>";} 
else {echo "Error: " . $sql . "<br>" . mysqli_error($link);}

mysqli_close($link);


?>