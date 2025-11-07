<?
include 'db_config.html';

if ($rank != 9 and $rank != 8){echo " <script language='javascript'>top.document.location.href = 'member_login.html?MEMBER_ID=$User_ID_Search&Case=9'</script>";}


$No 			= $_POST['S_No'];
$ID				= $_POST['ID'];
$Skiresort   	= $_POST['Skiresort'];
$Participate   	= $_POST['Participate'];
$Date1			= $_POST['Date1'];
$Date2			= $_POST['Date2'];

$Time1			= $_POST['Time1'];
$Time2			= $_POST['Time2'];
$Time 			= "$Time1~$Time2";
$Testfee		= $_POST['Testfee'];
$Status			= $_POST['Status'];

if ($rank == 8){$return_page = "../admin/admin_t1_schedule_list.html?ID=$ID";}
if ($rank == 9){$return_page = "../admin/admin_t1_schedule_list.html?ID=$ID";}
//echo "<script>if(confirm('정말 변경하시겠습니까 ?')){}else{top.document.location.href = 'admin_t1_schedule_edit.html?No=$No'}</script>";
//echo "<script>if (!confirm('스키지도요원 티칭1 일정을 변경하시겠습니까 ?')){location.href='admin_t1_schedule_edit.html?No=$No';}</script>";

if (!$link) {die("Connection failed: " . mysqli_connect_error());}

$sql = "update 7G_Master_Schedules set
Skiresort 		= '$Skiresort',
Test_id					= '$ID',
Participate	= '$Participate',
Test_Date			= '$Date1',
Expired_Date = '$Date2',
Time								= '$Time',
Testfee					= '$Testfee',
Manager_ID		= '$Login_User_ID',
Status						= '$Status'
where S_No 	= '$No'
";

if (mysqli_query($link, $sql)){echo "<script language='javascript'>alert('요청하신 시험정보가 수정 되었습니다.');top.document.location.href = '$return_page'</script>";}
else {echo "Error: " . $sql . "<br>" . mysqli_error($link);}

echo $sql;

mysqli_close($link);

?>
