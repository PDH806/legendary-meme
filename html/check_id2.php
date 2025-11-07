<!DOCTYPE html>
<Html>
<head>
<meta charset='utf-8'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

  <!-- Bootstrap core CSS -->
  <link href="http://www.crocsports.kr/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
</head>

<title>ID 중복체크</title>

<?php

	$uid = $_GET["userid"];
	$connect = mysqli_connect("dbserver","skiresort","ll170505","skiresort");
	$sql="SELECT * FROM 7G_Skiresort_Member WHERE MEMBER_ID = '$uid'";
	$result=mysqli_query($connect,$sql);
    $member = mysqli_num_rows($result);     

	if($member == 0)
		{
		echo "
		<div class='alert alert-success' role='alert'>
		<p>$uid 는 사용가능한 아이디입니다. !!!</p>
		<button class='btn btn-success btn-sm text-uppercase' type='button' onclick='window.close()'>닫기</button>
		</div>
		";
		}
		  		
	if($member >= 1)
		{
		echo "
		<div class='alert alert-danger' role='alert'>
		<p>$uid 는 사용이 불가능한 아이디입니다. !!!</p>
		<button class='btn btn-danger btn-sm text-uppercase' type='button' onclick='window.close()'>닫기</button>
		</div>
		";
		}
	

?>