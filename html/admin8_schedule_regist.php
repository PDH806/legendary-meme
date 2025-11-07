<?
	include 'db_config.html';
	
	if (!$Login_User_ID and $rank != 9 and $rank != 8){echo "<script language='javascript'>top.document.location.href = 'member_login.html?MEMBER_ID=$User_ID_Search&Case=9'</script>";}

	$category       = $_POST['category'];
	$date2 			= date('Ymd');
	$Auditor  		= $_POST['Auditor'];
	$Test_Year		= $_POST['Test_Year'];	
	$Skiresort   	= $_POST['Skiresort'];	
	$Participate   	= $_POST['Participate'];
	$Test_Date		= $_POST['Date1'];
	$Expired_Date	= $_POST['Date2'];

	$Time1			= $_POST['Time1'];
	$Time2			= $_POST['Time2'];
	$Time 			= "$Time1~$Time2";
	$Testfee		= $_POST['Testfee'];

	if (!$link) {die("Connection failed: " . mysqli_connect_error());}

	if ($category == 'T1' or $category == 'SBT1'){
	$sql = "INSERT INTO 7G_".$category."_Schedules 
	(Auditor, Test_Year, Skiresort, Participate, Test_Date, Expired_Date, Time, Testfee, Manager_ID) 
	VALUES ('$Auditor','$Test_Year','$Skiresort','$Participate','$Test_Date','$Expired_Date','$Time','$Testfee','$Login_User_ID')";
	}
	else
	{
	$sql = "INSERT INTO 7G_".$category."_Schedules 
	(Test_Year, Skiresort, Participate, Test_Date, Expired_Date, Time, Testfee, Manager_ID) 
	VALUES ('$Test_Year','$Skiresort','$Participate','$Test_Date','$Expired_Date','$Time','$Testfee','$Login_User_ID')";
	}
	
	if ($category == 'T1'){$return_page = 'admin_t1_schedule_list.html';}
	if ($category == 'T1' and $rank == 8){$return_page = 'admin8_t1_schedule_list.html';}

	if ($category == 'T2'){$return_page = 'admin_t2_schedule_list.html';}
	if ($category == 'T3'){$return_page = 'admin_t3_schedule_list.html';}

	if ($category == 'SBT1'){$return_page = 'admin_sbt1_schedule_list.html';}
	if ($category == 'SBT1' and $rank == 8){$return_page = 'admin8_sbt1_schedule_list.html';}

	if ($category == 'SBT2'){$return_page = 'admin_sbt2_schedule_list.html';}
	if ($category == 'SBT3'){$return_page = 'admin_sbt3_schedule_list.html';}
	if ($category == 'Patrol'){$return_page = 'admin_patrol_schedule_list.html';}

	if (mysqli_query($link, $sql)) {echo "<script language='javascript'>
	alert('검정일정 신규등록이 완료되었습니다.');
	top.document.location.href = '$return_page'</script>";} else {echo "Error: " . $sql . "<br>" . mysqli_error($link);}

	mysqli_close($link);

?>