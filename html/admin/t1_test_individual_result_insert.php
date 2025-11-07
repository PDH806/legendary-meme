<?
    extract($_REQUEST);
	$The_No 	= $_GET['No'];
	$The_No2 	= $_GET['Test_No'];

	include '../db_config.html';

	// 관리자가 아니면 member_login.html 페이지로 이동
	if ($rank < 7){
	echo " <script>
	alert('잘못된 접근입니다.');
	top.document.location.href = '../member_login.html?MEMBER_ID=$User_ID_Search&Case=9';
	</script>";
	}


	// 응시자의 시험정보 불러오기
	$test_query		= "SELECT * FROM 7G_Master_Apply where Apply_No = '$The_No'";
	$test_result	= mysqli_query($link, $test_query);
	$test_info		= mysqli_fetch_array($test_result);
	$TEST_ID		= $test_info[TEST_ID];
	

	// 라이센스번호 연번 구하기
	$query= "select * from 7G_Master_Apply where TEST_ID = '$test_info[TEST_ID]' and Final_result = 1";
	$result	= mysqli_query($link, $query);
	$count  = mysqli_num_rows($result);
	$count = $count + 1;
	$License_No_Count = strlen("$count");

	if ($License_No_Count == 1) {$add_zero = "000";}
	if ($License_No_Count == 2) {$add_zero = "00";}
	if ($License_No_Count == 3) {$add_zero = "0";}
	if ($License_No_Count == 4) {$add_zero = "";}
	$License_No = "$TEST_ID"."2022".$add_zero.$count;

	$Pay_Update = "update 7G_Master_Apply set TRAN_STATUS = 9, Final_result = 1, License_No = '$License_No', TRAN_DATE = '$today' where Apply_No = '$The_No'";
	$result		= mysqli_query($link, $Pay_Update);
	
      if ($TEST_ID == 'T1')
       {
          // 티칭1 라이센스 번호 발급
          $sql3 = "UPDATE 7G_Skiresort_Member SET T1_LICENSE  = '1', T1_YEAR  = '2022', T1_LICENSE_No = '$License_No' WHERE MEMBER_ID = '$test_info[MEMBER_ID]'";

          if (mysqli_query($link, $sql3))
           {echo "<script>top.document.location.href = 'admin_master_apply_list.html?ID=$TEST_ID&No=$test_info[Test_No]&page=$page'</script>";}
          else {echo "Error: " . $sql3 . "<br>" . mysqli_error($link);}
       }


       if ($TEST_ID == 'SBT1')
       {
         $sql4 = "UPDATE 7G_Skiresort_Member SET SBT1_LICENSE  = '1', SBT1_YEAR  = '2022', SBT1_LICENSE_No = '$License_No' WHERE MEMBER_ID = '$test_info[MEMBER_ID]'";
         if (mysqli_query($link, $sql4))
          {echo "<script>top.document.location.href = 'admin_master_apply_list.html?ID=$TEST_ID&No=$test_info[Test_No]&page=$page'</script>";}
         else {echo "Error: " . $sql4 . "<br>" . mysqli_error($link);}
      }

?>
