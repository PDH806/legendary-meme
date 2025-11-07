<?
	include '../db_config.html';
	// include "PHPExcel-1.8/Classes/PHPExcel.php";
	
	// $objPHPExcel = new PHPExcel();

	// require_once "PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";

 	$filename = 'test.txt';
 	//$filename = iconv("UTF-8", "EUC-KR", $_FILES['excelFile']['test.xls']);

   $fp = fopen($filename, "r") or die("파일열기에 실패하였습니다");
   echo "<table border = 1><tr>
   					<td>번호</td>
   					<td>자격증번호</td>
   					<td>성명</td>
   					<td>생년월일</td>
   					<td>전화번호</td>
   					<td>등록일</td>
   					<td>우편번호</td>
   					<td>주소1</td>
   					<td>주소2</td>
   					<td>주소3</td>
   					
   					</tr>";
   while(!feof($fp)){
      $buffer = fgets($fp)."<br>";
	  $test = explode(',', $buffer);

	  $birth	  = $test[3]; 	
	  $birth_year = substr($birth,0,4);
	  $birth_month = substr($birth,4,2);
	  $birth_day = substr($birth,6,2);
	  $birth = "$birth_year"."-"."$birth_month"."-"."$birth_day";
	  
	  $zip = $test[6];
	  $zip = str_replace("'","", $zip);
	  $sql = "insert into 7G_MASTER_LICENSE (NO, LICENSE_NO, NAME, BIRTH, PHONE, YEAR, ZIP, ADDR1, ADDR2, ADDR3) VALUES ( $test[0],'$test[1]','$test[2]','$birth','$test[4]','$test[5]','$zip','$test[7]','$test[8]','$test[9]' )";
	  $result=mysqli_query($link, $sql);
	  
	echo "<tr>
			<td>$test[0]</td>
			<td>$test[1]</td>
			<td>$test[2]</td>
			<td>$birth</td>
			<td>$test[4]</td>
			<td>$test[5]</td>
			<td>$zip</td>
			<td>$test[7]</td>
			<td>$test[8]</td>
			<td>$test[9]</td>
		</tr>";

   }
   
   echo "</table>";   
   fclose($fp);
?>


