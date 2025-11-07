<!DOCTYPE html>
<html>

<head>

<?
include 'db_config.html';
?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<link rel="shortcut icon" href="Myicon.png" type="image/x-icon">
    
    <title>
    	<?
    	echo "$main_title";    	
    	?>    
    </title>
    
		<!-- Custom styles for AUGMENT-SKI -->
			<? include 'link-files.html'; ?>
		<!-- end of Link -->
		
</head>

<body>

		<!-- Navigation for AUGMENT-SKI -->
			<? include './main-nav.html'; ?>
		<!-- end of Navigation -->

<br><br><br>

<?php

echo "쿠키 테스트 메뉴 <br>";
echo "==================================<br><br>";
echo "<a href = cookie_set.php>관리자_쿠키입력</a><br>";
echo "<a href = cookie_set_tester.html>일반회원_쿠키입력</a><br>";
echo "<a href = cookie_check.php>쿠키_체크</a><br>";
echo "<a href = cookie_delete.php>쿠키_삭제</a><br>";
?>

<br><br><br>

</body>

		<!-- Custom styles for AUGMENT-SKI -->
			<? include '../footer.html'; ?>
		<!-- end of Link -->
