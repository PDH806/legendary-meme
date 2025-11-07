<?
$the_No 		= $_POST["Apply_No"];
$Process 		= $_POST["Process"];
$Score1 		= $_POST["Score1"];
$Score2 		= $_POST["Score2"];
$Score3 		= $_POST["Score3"];
$Total_Score 	= $Score1 + $Score2 + $Score3;

if ($Total_Score >= 210){$Final_result = 1;}else{$Final_result = 0;}
$style_header = 'width:140px;font-size:13pt';

include '../db_config.html';
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Acara - Ticketing Bootstrap Admin Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
	<link href="./vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
	<style>.form-control{border-radius: $radius; background: $white; border: 1px solid $border; font-size:13pt; color: #f54242; height: 56px; @include respond('laptop') { height: 41px; } &:hover,&:focus,&.active{ box-shadow: none; background: $white; color: $dark; } }</style>

	<script src ="https://code.jquery.com/jquery-1.11.2.min.js"></script>
	<script type="text/javascript">
        function sum(){  //input 5개 자동더해서 total에 입력
            var num1 = $('[name=Score1]').val();
            var num2 = $('[name=Score2]').val();
            var num3 = $('[name=Score3]').val();
            totalnum = Number(num1)+Number(num2)+Number(num3);
            $('[name=Total_Score]').val(totalnum);
        }

        function onlyNumber(obj) {  //숫자만 입력
            $(obj).keyup(function(){
                 $(this).val($(this).val().replace(/[^0-9]/g,''));
            });
        }
	</script>

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="../index.html" class="brand-logo">
                <img src="../images/sb_logo.png" width = 90%>
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

		<?
		// 챗팅박스 + 헤드네비 불러오기
		include '_chat_box.html';
		include '_head_bar.html';

		// 좌측 네비게이션
	    if ($rank == 9){include '_admin_menu.html';}
	    if ($rank == 8){include '_admin_menu2.html';}
	    ?>


        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- container starts -->
            <div class="container-fluid">
                <!-- row -->

<?php

	$sql = "UPDATE 7G_Master_Apply SET T_Score1 = $Score1, T_Score2 = $Score2, T_Score3 = $Score3, T_Total_Score = $Total_Score, Final_result  = '$Final_result', TRAN_STATUS  = '7' WHERE Apply_No = $the_No";
	if (mysqli_query($link, $sql)){

	if ($the_No){$search = "where 7G_Master_Apply.Apply_No = '$the_No'";}
 	$query= "select * from 7G_Master_Apply LEFT OUTER JOIN 7G_T1_Schedules ON 7G_Master_Apply.Test_No = 7G_T1_Schedules.No JOIN 7G_Skiresort_Member on 7G_Master_Apply.MEMBER_ID = 7G_Skiresort_Member.MEMBER_ID $search order by 7G_Master_Apply.Apply_date DESC ";
 	$schedule	= mysqli_query($link, $query);
 	$row		= mysqli_fetch_array($schedule);

echo "<br>
<section id='contact'>
    <div class='container' style='padding:0px'>

				<br><br>
					<p align = 'center' style = 'align:center;font-size:35px;font-weight:600;'>스노보드 티칭1 검정결과 등록 ($row[MEMBER_NAME]님)</p>
        		<br><br><br>";

	if($Final_result == 1){
	$sql2 = "UPDATE 7G_Skiresort_Member SET SBT1_LICENSE = '1' WHERE MEMBER_ID = '$row[MEMBER_ID]'";
	if (mysqli_query($link, $sql2)) {}
	}

	if($Final_result == 0){
	$sql2 = "UPDATE 7G_Skiresort_Member SET SBT1_LICENSE = '0' WHERE MEMBER_ID = '$row[MEMBER_ID]'";
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

 		if ($row[TRAN_STATUS] == 0){$Status = '접수중';}
		if ($row[TRAN_STATUS] == 1){$Status = '접수완료';}
		if ($row[TRAN_STATUS] == 2){$Status = '검정완료';}

		if ($row[TRAN_STATUS] == 4){$Process4 = 'selected';}
 		if ($row[TRAN_STATUS] == 5){$Process5 = 'selected';}
		if ($row[TRAN_STATUS] == 6){$Process6 = 'selected';}
		if ($row[TRAN_STATUS] == 7){$Process7 = 'selected';}

		if ($row[Date2] < $today){$Status = '접수완료';}
		if ($row[Date1] <= $today){$Status = '검정완료';}

 		if ($row[Final_result] == '0'){$result0 = 'selected';}
		if ($row[Final_result] == '1'){$result1 = 'selected';}




		$Testfee = number_format($row[Testfee]);



echo "
	<p><br></p>

	<div class='row' style='padding:0px'>
        <div class='col-lg-12'>
			<form id='contactForm' method='post' action='sbt1_test_individual_license_update.php' novalidate='novalidate'>

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
						2022 - $row[Test_No]<br>
						$Skiresort<br>
						$row[Participate]명<br>
						$row[Auditor]<br>
					</td>

					<td align = left width = 10%>
						•시험일<br>
						•신청마감일<br>
						•응시료<br>
						•시험상태<br>
					</td>

					<td align = left width = 40%>
						$row[Test_Date] ($row[Time])<br>
						$row[Expired_Date]<br>
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
                <input class='form-control'  type='text' name='MEMBER_ID' value = '$row[MEMBER_ID]' hidden>
                <input class='form-control'  type='text' name='TEST_ID' value = '$row[TEST_ID]' hidden>
                <input class='form-control'  type='text' name='Test_No' value = '$row[Test_No]' hidden>
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
            <option value = '9' $Process9>결과확정</option>


					</select>
						</div>
                </div>

                <div class='form-group' style='padding-left:10px'>
						<div class='input-group'>
  							<div class='input-group-prepend'>
								<button class='btn btn-info'  type='button' style = 'width:120px;'>종목1</button>
  							</div>
								<input class='form-control'  type='text' id = 'score' value = '$Score1' name='Score1' readonly>
						</div>
                </div>

                <div class='form-group' style='padding-left:10px'>
						<div class='input-group'>
  							<div class='input-group-prepend'>
								<button class='btn btn-info' type='button' style = 'width:120px;'>종목2</button>
  							</div>
								<input class='form-control'  type='text' id = 'score' value = '$Score2' name='Score2' readonly>
						</div>
                </div>

                <div class='form-group' style='padding-left:10px'>
						<div class='input-group'>
  							<div class='input-group-prepend'>
								<button class='btn btn-info' type='button' style = 'width:120px;'>종목3</button>
  							</div>
								<input class='form-control'  type='text' id = 'score' value = '$Score3' name='Score3'readonly>
						</div>
                </div>

                <div class='form-group' style='padding-left:10px'>
						<div class='input-group'>
  							<div class='input-group-prepend'>
								<button class='btn btn-info' type='button' style = 'width:120px;'>함계 점수</button>
  							</div>
								<input class='form-control'  type='text' id = 'Total_Score' name='Total_Score' value = '$row[T_Total_Score]' readonly>
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
                <div class='form-group text-right'>";

                if ($row[Status] != 9){
                    echo "
                    <a href=t1_test_individual_result_input.php?Apply_No=$the_No><button type='button' class='btn-primary'>검정점수 재입력</button></a>&nbsp;
                    <input class='btn btn-info text-uppercase' type='button' value='$row[MEMBER_NAME]님 검정결과 확정' onclick='submit();'>";
                }
                else {
                  echo "
                  <input class='btn btn-info text-uppercase' type='button' value='$row[MEMBER_NAME]님 결과확정(수정불가)'>";
                }

                echo "
                </div>


                </div>
                </div>

</form>
</section>";

} else {echo "업데이트오류 $sql /  $link";}

?>


                <!-- Row ends -->
            </div>
            <!-- container ends -->
        </div>
        <!--**********************************
                Content body end
            ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>© Designed &amp; Developed by <a href="https://7gate.kr/" target="_blank">podong28.com</a> 2019</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
	<script src="./vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="./js/custom.min.js"></script>
	<script src="./js/deznav-init.js"></script>


</body>

</html>
