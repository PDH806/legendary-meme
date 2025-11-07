<?
	include '../db_config.html';
	// include "PHPExcel-1.8/Classes/PHPExcel.php";
	
	// $objPHPExcel = new PHPExcel();

	// require_once "PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";

 	$filename = 'test2.txt';
 	//$filename = iconv("UTF-8", "EUC-KR", $_FILES['excelFile']['test.xls']);

   $fp = fopen($filename, "r") or die("파일열기에 실패하였습니다");
   echo "<table border = 1><tr>
   					<td>BIB</td>
   					<td>ID</td>
   					<td>성명</td>
   					<td>성별</td>
   					
   					</tr>";
   while(!feof($fp)){
      $buffer = fgets($fp)."<br>";
	  $test = explode(',', $buffer);

	  // $sql = "insert into 7G_MASTER_LICENSE (NO, LICENSE_NO, NAME, BIRTH, PHONE, YEAR, ZIP, ADDR1, ADDR2, ADDR3) VALUES ( $test[0],'$test[1]','$test[2]','$birth','$test[4]','$test[5]','$zip','$test[7]','$test[8]','$test[9]' )";
	  // $result=mysqli_query($link, $sql);
	  
	echo "<tr>
			<td>$test[0]</td>
			<td>$test[1]</td>
			<td>$test[2]</td>
			<td>$test[3]</td>
		</tr>";

   }
   
   echo "</table>";   
   fclose($fp);
?>


