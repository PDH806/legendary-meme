<?
$Apply_No 		    = $_POST["Apply_No"];
$Final_results 		= $_POST["Final_results"];
$MEMBER_ID 		    = $_POST["MEMBER_ID"];
$TEST_ID 		    = $_POST["TEST_ID"];
$Test_No 		    = $_POST["Test_No"];

include '../db_config.html';

$query= "select * from 7G_Master_Apply where TEST_ID = '$TEST_ID' and Test_No = '$Test_No' and Final_result = '1'";
$result	= mysqli_query($link, $query);
$count  = mysqli_num_rows($result);
//$count = $count + 1;
$License_No_Count = strlen("$count");


if ($License_No_Count == 1) {$add_zero = "000";}
if ($License_No_Count == 2) {$add_zero = "00";}
if ($License_No_Count == 3) {$add_zero = "0";}
if ($License_No_Count == 4) {$add_zero = "";}
$License_No = "$TEST_ID"."2022".$add_zero.$count;

// 합격자 처리
if ( $Final_results == 1)
   {
     // 응시자 상태코드 변경 (최종완료)
      $sql2 = "UPDATE 7G_Master_Apply SET TRAN_STATUS  = '9', License_No = '$License_No' WHERE Apply_No = '$Apply_No'";
      $result = mysqli_query($link, $sql2);

       if ($TEST_ID == 'SBT1')
       {
         $sql4 = "UPDATE 7G_Skiresort_Member SET SBT1_LICENSE  = '1', SBT1_YEAR  = '2022', SBT1_LICENSE_No = '$License_No' WHERE MEMBER_ID = '$MEMBER_ID'";
         if (mysqli_query($link, $sql4))
          {echo "<script>top.document.location.href = 'admin_master_apply_list.html?ID=$TEST_ID&No=$Test_No'</script>";}
         else {echo "Error: " . $sql4 . "<br>" . mysqli_error($link);}
      }
   }



if ($Final_results == 0)
   {
      $sql2 = "UPDATE 7G_Master_Apply SET TRAN_STATUS  = '9', License_No = '불합격' WHERE Apply_No = '$Apply_No'";
      if (mysqli_query($link, $sql4))
      {echo "<script>top.document.location.href = 'admin_master_apply_list.html?ID=$TEST_ID&No=$Test_No'</script>";}
      else {echo "Error: " . $sql4 . "<br>" . mysqli_error($link);}
   }

?>
