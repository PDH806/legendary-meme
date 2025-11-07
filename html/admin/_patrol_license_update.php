<?

	include '../db_config.html';
 	$filename = 'PATROL.txt';
 	//$filename = iconv("UTF-8", "EUC-KR", $_FILES['excelFile']['test.xls']);

   $fp = fopen($filename, "r") or die("파일열기에 실패하였습니다");
   echo "<table border = 1><tr>
   					<td>ID</td>
   					<td>성명</td>
   					<td>자격번호</td>
   					</tr>";
   while(!feof($fp)){
      $buffer = fgets($fp);
	  $test = explode(',', $buffer);

	  $sql    = "UPDATE 7G_Skiresort_Member SET PATROL_LICENSE  = '1', PATROL_YEAR  = '2022', PATROL_LICENSE_No = '$test[0]' WHERE MEMBER_ID = '$test[1]'";
	  $result = mysqli_query($link, $sql);
	  // if ($result === false) { echo mysqli_error($link);}

	echo "<tr>
			<td>$test[1]</td>
			<td>$test[2]</td>
			<td>$test[0]</td>
			<td>$sql</td>
		</tr>";

   }
   
   echo "</table>";   
   fclose($fp);
?>
