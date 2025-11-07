<?
	include 'db_config.html';
	// 관리자가 아니면 member_login.html 페이지로 이동
	if ($Login_User_ID or $rank != 9 or $rank !=8  or !$rank){
	echo " <script>
	alert('잘못된 접근입니다.');
	top.document.location.href = 'member_login.html?MEMBER_ID=$User_ID_Search&Case=9';
	</script>";
	}
?>

<!DOCTYPE html>
<html>

<?
$link 	= 	mysqli_connect("dbserver","skiresort","ll170505","skiresort");
include 'db_config.html';
?>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<link rel="shortcut icon" href="Myicon.png" type="image/x-icon">
    
    <title>티칭1 검정일정 등록 | 한국스키장경영협회</title>
    
		<!-- Custom styles for AUGMENT-SKI -->
			<? include 'link-files.html'; ?>
		<!-- end of Link -->
</head>

<body>

		<!-- Navigation for AUGMENT-SKI -->
			<? include 'main-nav.html'; ?>
		<!-- end of Navigation -->

		<br><br><br><br>


<?
		
$date2 			= date('Ymd');
$member_id 		= $Login_User_ID;

$Auditor  		= $_POST['Auditor'];
$Skiresort   	= $_POST['Skiresort'];
$Participate   	= $_POST['Participate'];
$Date1			= $_POST['Date1'];
$Date2			= $_POST['Date2'];

$Time1					= $_POST['Time1'];
$Time2					= $_POST['Time2'];
$Time 					= "$Time1~$Time2";
$Testfee				= $_POST['Testfee'];

$connect = mysqli_connect("dbserver","skiresort","ll170505","skiresort");

if (!$connect) {
      die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO 7G_T1_Schedules (
Auditor,
Skiresort,
Participate,
Date1,
Date2,
Time,
Testfee,
Manager_ID
		) 
					
VALUES (
'$Auditor',
'$Skiresort',
'$Participate',
'$Date1',
'$Date2',
'$Time',
'$Testfee',
'$Login_User_ID'
)";
	


if (mysqli_query($connect, $sql)) 
{
		if ($Skiresort == 1){$Skiresort = '용평리조트';}
		if ($eventhall == 2){$Skiresort = '양지파인리조트';}
		if ($eventhall == 3){$Skiresort = '스타힐리조트';}
		if ($Skiresort == 4){$Skiresort = '무주덕유산리조트';}
		if ($eventhall == 5){$Skiresort = '비발디파크';}
		if ($eventhall == 6){$Skiresort = '피닉스평창';}
		if ($Skiresort == 7){$Skiresort = '월리힐리파크';}
		if ($eventhall == 8){$Skiresort = '지산포레스트리조트';}
		if ($eventhall == 9){$Skiresort = '엘리시안강촌';}
		if ($Skiresort == 10){$Skiresort = '오크밸리';}
		if ($eventhall == 11){$Skiresort = '하이원리조트';}
		if ($eventhall == 12){$Skiresort = '곤지암리조트';}
		if ($Skiresort == 13){$Skiresort = '알펜시아';}
		if ($eventhall == 14){$Skiresort = '베어스타운';}
		if ($eventhall == 15){$Skiresort = '에덴벨리리조트';}
		if ($eventhall == 16){$Skiresort = '오투리조트';}

echo "
<section id='contact'>
    <div class='container'>
      <div class='row'>
        <div class='col-lg-12 text-center'>
          <h2 class='section-heading text-uppercase'>한국스키장경영협회 티칭1 검정일정 등록</h2>
          <p class='text-success'>검정일정 등록내용을 확인바랍니다.</p>
        </div>
      </div>
		<br><br>
    <div class='container'>
      <div class='row'>
        <div class='col-lg-12 text-center'>
        	<table style='border-top:1px solid #d6d6d6;' width = 100%>
  				    <tr style='border-bottom:1px solid #d6d6d6;height:50px'><td width = 50%>관리자ID</td><td class='text-success'>$Login_User_ID</td></tr>
  				    <tr style='border-bottom:1px solid #d6d6d6;height:50px'><td>검정요원</td><td class='text-success'>$Auditor</td></tr>
  				    <tr style='border-bottom:1px solid #d6d6d6;height:50px'><td>검정장소</td><td class='text-success'>$Skiresort</td></tr>
  				    <tr style='border-bottom:1px solid #d6d6d6;height:50px'><td>검정일자</td><td class='text-success'>$Date1</td></tr>
  				    <tr style='border-bottom:1px solid #d6d6d6;height:50px'><td>검정시간</td><td class='text-success'>$Time</td></tr>
					<tr style='border-bottom:1px solid #d6d6d6;height:50px'><td>검정인원</td><td class='text-success'>$Participate</td></tr>
  				    <tr style='border-bottom:1px solid #d6d6d6;height:50px'><td>신청마감일</td><td class='text-success'>$Date2</td></tr>
  				    <tr style='border-bottom:1px solid #d6d6d6;height:50px'><td>검정료</td><td class='text-success'>$Testfee</td></tr>
         		</table>
         		<br>
			<div class = 'text-right'>         		
         	<a href = 'mypage.html' class='btn btn-success btn-sm text-uppercase'>확인</a>
			</div>
        </div>
      </div>
</section>
<br><br><br><br>
";

?>

<!-- footer for AUGMENT-SKI -->
	<? include 'footer.html'; ?>
<!-- end of footer -->

<?
echo "
</body>

</html>
";

} else {
      echo "Error: " . $sql . "<br>" . mysqli_error($connect);
}
mysqli_close($connect);

?>