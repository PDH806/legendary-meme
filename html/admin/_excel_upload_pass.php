<?
	$servername	= "dbserver"; $username = "skiresort"; $password = "ll170505"; $dbname = "skiresort";
	$connect = mysql_connect($servername, $username, $password); $link = mysqli_connect($servername, $username, $password, $dbname); mysql_select_db($dbname,$connect);

	// include "PHPExcel-1.8/Classes/PHPExcel.php";
	
	// $objPHPExcel = new PHPExcel();

	// require_once "PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";

 	$filename = 'test3.txt';
 	//$filename = iconv("UTF-8", "EUC-KR", $_FILES['excelFile']['test.xls']);

   $fp = fopen($filename, "r") or die("파일열기에 실패하였습니다");
   echo "<table border = 1><tr>
   					<td>BIB</td>
   					<td>성명</td>
   					<td>ID</td>
   					<td>유효점수</td>
   					<td>합격여부</td>
   					<td>SQL</td>
   					</tr>";
   while(!feof($fp)){
      $buffer = fgets($fp);
	  $test = explode(',', $buffer);
	  
	  if ($test[3] >= 960 and $test[4] == 1)
	  { $count = $count + 1;
		if ($count < 10){$count = "00".$count;}
		if ($count >= 10 and $count < 100){$count = "0".$count;}


	  	$sql    = "update 7G_Skiresort_Member set T2_LICENSE = '1', T2_YEAR = '2022', T2_LICENSE_No = 'TⅡ2022$count'  where MEMBER_ID = '$test[2]'";
		$result = mysqli_query($link, $sql);
		
  	    // if ($result === false) { echo mysqli_error($link);}

	}
	
	else { $sql = '';}


	echo "<tr>
			<td>$test[0]</td>
			<td>$test[1]</td>
			<td>$test[2]</td>
			<td>$test[3]</td>
			<td>$test[4]</td>
			<td>$sql</td>
		</tr>";

   }
   
   echo "</table>";   
   fclose($fp);
?>


