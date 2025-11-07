<?
	include '../db_config.html';

	// include "PHPExcel-1.8/Classes/PHPExcel.php";
	
	// $objPHPExcel = new PHPExcel();

	// require_once "PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";

 	$filename = 'SBT2.txt';
 	//$filename = iconv("UTF-8", "EUC-KR", $_FILES['excelFile']['test.xls']);

   $fp = fopen($filename, "r") or die("파일열기에 실패하였습니다");
   echo "<table border = 1><tr>
   					<td>성명</td>
   					<td>생일</td>
   					<td>전화번호</td>
   					<td>자격번호</td>
   					</tr>";
   while(!feof($fp)){
      $buffer = fgets($fp);
	  $test = explode(',', $buffer);

      $query2	= "SELECT * FROM 7G_Skiresort_Member where MEMBER_NAME like '%$test[1]%' and BIRTH = '$test[2]' limit 1";
	  // $query2 = "SELECT * FROM g5_member where MEMBER_ID like '%friday1968%' limit 1";
      $result2	= mysqli_query($link, $query2);
      $member	= mysqli_fetch_array($result2);
	  $member_Count	= mysqli_num_rows($result2);


	  $sql    = "UPDATE 7G_Skiresort_Member SET SBT2_LICENSE  = '1', SBT2_YEAR  = '2022', SBT2_LICENSE_No = '$test[0]' WHERE MEMBER_ID = '$member[MEMBER_ID]'";
	  $result = mysqli_query($link, $sql);
	  // if ($result === false) { echo mysqli_error($link);}

	echo "<tr>
			<td>$test[1] // $member[MEMBER_ID] // $member_Count</td>
			<td>$test[2]</td>
			<td>$test[3]</td>
			<td>$test[0]</td>
			<td>$query2<br>$sql</td>
		</tr>";

   }
   
   echo "</table>";   
   fclose($fp);
?>





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
