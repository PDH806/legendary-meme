<!DOCTYPE html>
<html>

<?
$the_No 		= $_POST["Apply_No"];
$Process 		= $_POST["Process"];
$Score1 		= $_POST["Score1"];
$Score2 		= $_POST["Score2"];
$Score3 		= $_POST["Score3"];
$Total_Score 	= $Score1 + $Score2 + $Score3;
if ($Total_Score >= 210){$Final_result = 1;}else{$Final_result = 0;}
include 'db_config.html';
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<link rel="shortcut icon" href="Myicon.png" type="image/x-icon">
    
		<!-- Custom styles for AUGMENT-SKI -->
			<? include 'link-files.html'; ?>
		<!-- end of Link -->

<script src ="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e){
	$("input").change(function(){
		var total=0;
		$("input[id=score]").each(function(){
			total = total + parseInt($(this).val());
			})
			$("input[id=Total_Score]").val(total);
		});

});
</script>
    
    <title>티칭1 검정결과 등록 | 한국스키장경영협회</title>
    
</head>

<body style = 'background-color:#f2f2f2;'>

		<!-- Navigation for AUGMENT-SKI -->
			<? include 'main-nav.html'; ?>
		<!-- end of Navigation -->

		<br><br><br><br>


<?php

$sql = "UPDATE 7G_T1_Apply SET T1_Score1 = $Score1, T1_Score2 = $Score2, T1_Score3 = $Score3, T1_Total_Score = $Total_Score, Final_result  = '$Final_result', T1_Process  = '7' WHERE Apply_No = $the_No";
if (mysqli_query($link, $sql)){

	if ($the_No){$search = "where 7G_T1_Apply.Apply_No = '$the_No'";}			
 	$query= "select * from 7G_T1_Apply LEFT OUTER JOIN 7G_T1_Schedules ON 7G_T1_Apply.Test_No = 7G_T1_Schedules.No JOIN 7G_Skiresort_Member on 7G_T1_Apply.MEMBER_ID = 7G_Skiresort_Member.MEMBER_ID $search order by 7G_T1_Apply.Apply_date DESC ";
 	$schedule	= mysql_query($query,$connect);
 	$row		= mysql_fetch_array($schedule);

echo "<br>
<section id='contact'>
    <div class='container' style='padding:0px'>

				<br><br>
					<p align = 'center' style = 'align:center;font-size:35px;font-weight:600;'>한국스키장경영협회 티칭1 검정결과 등록 ($row[MEMBER_NAME]님)</p>
        		<br><br><br>";

	$image1 = "SL1.png"; 
    $image2 = "SL2.png";    
	include "slide.html";
	
	if($Final_result == 1){
	$sql2 = "UPDATE 7G_Skiresort_Member SET T1_LICENSE = '1' WHERE MEMBER_ID = '$row[MEMBER_ID]'";
	if (mysqli_query($link, $sql2)) {}
	}
	
	if($Final_result == 0){
	$sql2 = "UPDATE 7G_Skiresort_Member SET T1_LICENSE = '0' WHERE MEMBER_ID = '$row[MEMBER_ID]'";
	if (mysqli_query($link, $sql2)) {}
	}

	
		if ($row[Skiresort] == 1){$Skiresort = '용평리조트';}
		if ($row[Skiresort] == 2){$Skiresort = '양지파인리조트';}
		if ($row[Skiresort] == 3){$Skiresort = '스타힐리조트';}
		if ($row[Skiresort] == 4){$Skiresort = '무주덕유산리조트';}
		if ($row[Skiresort] == 5){$Skiresort = '비발디파크';}
		if ($row[Skiresort] == 6){$Skiresort = '피닉스평창';}
		if ($row[Skiresort] == 7){$Skiresort = '월리힐리파크';}
		if ($row[Skiresort] == 8){$Skiresort = '지산포레스트리조트';}
		if ($row[Skiresort] == 9){$Skiresort = '엘리시안강촌';}
		if ($row[Skiresort] == 10){$Skiresort = '오크밸리';}
		if ($row[Skiresort] == 11){$Skiresort = '하이원리조트';}
		if ($row[Skiresort] == 12){$Skiresort = '곤지암리조트';}
		if ($row[Skiresort] == 13){$Skiresort = '알펜시아';}
		if ($row[Skiresort] == 14){$Skiresort = '베어스타운';}
		if ($row[Skiresort] == 15){$Skiresort = '에덴벨리리조트';}
		if ($row[Skiresort] == 16){$Skiresort = '오투리조트';}

 		if ($row[Status] == 0){$Status = '접수중';}
		if ($row[Status] == 1){$Status = '접수완료';}
		if ($row[Status] == 2){$Status = '검정완료';}
		
		if ($row[Process] == 4){$Process4 = 'selected';}
 		if ($row[Process] == 5){$Process5 = 'selected';}
		if ($row[Process] == 6){$Process6 = 'selected';}
		if ($row[Process] == 7){$Process7 = 'selected';}

		if ($row[Date2] < $today){$Status = '접수완료';} 	
		if ($row[Date1] <= $today){$Status = '검정완료';} 	
		
 		if ($row[Final_result] == '0'){$result0 = 'selected';}
		if ($row[Final_result] == '1'){$result1 = 'selected';}
		
		
		
		
		$Testfee = number_format($row[Testfee]);

	

echo "
	<p><br></p>

	<div class='row' style='padding:0px'>
        <div class='col-lg-12'>
			<form id='contactForm' method='post' action='t1_test_individual_license_update.php' novalidate='novalidate'>
 
            <div class='row' style='padding:0px'>
            
 		       <div class='col-lg-12'>
                
   					<table style = 'height:30px;border-bottom:1px solid #888888;' width = 100%><tr>
						<td width = 220px align = center style = 'background-color:#919191;color:#FFFFFF;font-size:18px;'>티칭1 검정 기본정보</td><td></td></tr></table><br>";

echo "
				<table class = 'table4_9' width = 100% >
					<tr bgcolor= #d6e6ff valign = top height = 40px>

					<td align = left width = 10%>
						•검정번호<br>
						•검정장소<br>
						•응시정원<br>
						•검정요원<br>
					</td>

					<td align = left width = 40%>
						2021 - $row[No]<br>
						$Skiresort<br>
						$row[Participate]명<br>
						$row[Auditor]<br>
					</td>
					
					<td align = left width = 10%>
						•검정일<br>
						•신청마감일<br>
						•검정료<br>
						•검정상태<br>		
					</td>
			
					<td align = left width = 40%>
						$row[Date1] ($row[Time])<br>
						$row[Date2]<br>
						$Testfee 원<br>
						$Status<br>
					</td>
					</td>
					</tr>
					</table><br><br>
					";

echo "
   					<table style = 'height:30px;border-bottom:1px solid #888888;' width = 100%><tr>
						<td width = 220px align = center style = 'background-color:#919191;color:#FFFFFF;font-size:18px;'>티칭1 검정 결과등록</td><td></td></tr></table><br>";




echo "

                <div class='form-group' style='padding-left:10px'>
						<div class='input-group'>
  							<div class='input-group-prepend'>
								<button class='btn btn-info' type='button' style = 'width:120px;'>응시자</button>
  							</div>
  							<input class='form-control'  type='text' name='Apply_No' value = '$row[Apply_No]' hidden>
							<input class='form-control'  type='text' name='Auditor' value = '$row[MEMBER_NAME]' placeholder='응시자' readonly>
						</div>
                </div>
                ";
                
echo "<div class='form-group' style='padding-left:10px'>
						<div class='input-group'>
  							<div class='input-group-prepend'>
								<button class='btn btn-info' type='button' style = 'width:120px;'>검정참석여부</button>
  							</div>
					<select class='form-control' name = 'Process' readonly>
						<option value = '0'>검정참석여부</option>
						<option value = '0'>-----------------------------------</option>
						<option value = '4' $Process4>불참</option>
						<option value = '5' $Process5>참석</option>
						<option value = '6' $Process6>DNF</option>
						<option value = '7' $Process7>경기완료</option>


					</select>
						</div>			
                </div>

                <div class='form-group' style='padding-left:10px'>
						<div class='input-group'>
  							<div class='input-group-prepend'>
								<button class='btn btn-info'  type='button' style = 'width:120px;'>플루그 화렌</button>
  							</div>
								<input class='form-control'  type='text' id = 'score' value = '$Score1' name='Score1' readonly>
						</div>											
                </div>

                <div class='form-group' style='padding-left:10px'>
						<div class='input-group'>
  							<div class='input-group-prepend'>
								<button class='btn btn-info' type='button' style = 'width:120px;'>플루그 보겐</button>
  							</div>
								<input class='form-control'  type='text' id = 'score' value = '$Score2' name='Score2' readonly>
						</div>											
                </div>

                <div class='form-group' style='padding-left:10px'>
						<div class='input-group'>
  							<div class='input-group-prepend'>
								<button class='btn btn-info' type='button' style = 'width:120px;'>슈템턴</button>
  							</div>
								<input class='form-control'  type='text' id = 'score' value = '$Score3' name='Score3'readonly>
						</div>											
                </div>

                <div class='form-group' style='padding-left:10px'>
						<div class='input-group'>
  							<div class='input-group-prepend'>
								<button class='btn btn-info' type='button' style = 'width:120px;'>함계 점수</button>
  							</div>
								<input class='form-control'  type='text' id = 'Total_Score' name='Total_Score' value = '$row[Total_Score]' readonly>
						</div>											
                </div>

                <div class='form-group' 
				<div class='form-group' style='padding-left:10px'>
						<div class='input-group'>
  							<div class='input-group-prepend'>
								<button class='btn btn-info' type='button' style = 'width:120px;'>최종결과</button>
  							</div>
					<select class='form-control' name = 'Final_results' readonly>
						<option value = ''>최종결과(합격/불합격)</option>
						<option value = ''>-----------------------------------</option>
						<option value = '0' $result0>불합격</option>
						<option value = '1' $result1>합격</option>

					</select>
						</div>			
                </div>



				<br><br>
                <div class='form-group text-right'>
                <a href=t1_test_individual_result_input.php?Apply_No=$the_No><button type='button' class='btn-4'>검정점수 재입력</button></a>&nbsp;
                <input class='btn btn-info text-uppercase' type='button' value='$row[MEMBER_NAME]님 검정결과 확정' onclick='submit();'>
                </div>


                </div>
                </div>

</form>
</section>";

} else {echo "업데이트오류 $sql /  $link";}

?>

		<br><br><br><br>


<!-- footer for AUGMENT-SKI -->
	<? include 'footer.html'; ?>
<!-- end of footer -->


</body>

</html>