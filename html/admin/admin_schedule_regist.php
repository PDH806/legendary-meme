<?
	include '../db_config.html';
	// include '../check_rank.php';

	$category       = $_POST['ID'];
	$date2 			= date('Ymd');
	$Auditor  		= $_POST['Auditor'];
	$Test_Year		= $_POST['Test_Year'];	
	$Skiresort   	= $_POST['Skiresort'];		//장소
	$Participate   	= $_POST['Participate'];
	$Test_Date		= $_POST['Date1'];
	$Expired_Date	= $_POST['Date2'];
	$return_page	= $_POST['return_page'];
	$ID				= $_POST['ID'];			//검정종목

	$Time1			= $_POST['Time1'];
	$Time2			= $_POST['Time2'];
	$Time 			= "$Time1~$Time2";
	$Testfee		= $_POST['Testfee'];
	$Test_Year 		= "2025";				//매년 변경 등록


	if (!$link) {die("Connection failed: " . mysqli_connect_error());}
	
	//$query		= "SELECT max(Test_No) FROM 7G_Master_Schedules where Test_id = '$category' and Test_Year = '$Test_Year' ";
	$query		= "SELECT max(Test_No) maxNo FROM 7G_Master_Schedules";
	$result		= mysqli_query($link, $query);
	$count		= mysqli_fetch_array($result);
	if($count['maxNo'] != NULL){
		$TEST_NO = $count['maxNo']+1;
	}
	else{
		$TEST_NO = 1;
	}

	$sql = "INSERT INTO 7G_Master_Schedules 
	(Test_Year, Skiresort, Test_id, TEST_NO, Participate, Test_Date, Expired_Date, Time, Testfee, Manager_ID, Status) 
	VALUES ('$Test_Year', '$Skiresort', '$ID', '$TEST_NO','$Participate','$Test_Date','$Expired_Date','$Time','$Testfee','$Login_User_ID', 0)";
	

	if (mysqli_query($link, $sql)) {
		echo "
		<script language='javascript'>
			alert('검정일정 신규등록이 완료되었습니다.');
			//top.document.location.href = 'admin_schedule_list2.html?ID=$ID';
			top.document.location.href = 'admin_t1_schedule_list.html??ID=$ID';
			
		</script>";
	} 
		else {echo "Error: " . $sql . "<br>" . mysqli_error($link);}

	mysqli_close($link);

?>