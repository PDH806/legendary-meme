<?php

	include '../db_config.html';
	$MID     = $Login_User_ID;
	
	if($_FILES["file"]["name"] != '')
	{
		$test 	= explode('.', $_FILES["file"]["name"]);
		$ext 	= end($test);
		$name 	= $MID . '.' . $ext;
 		$location = '../files/2223_patrol/' . $name;				//22-23 T2 파일

 		move_uploaded_file($_FILES["file"]["tmp_name"], $location);
		echo '업로드 완료';
	}
	else{
		echo '업로드 에러';
	}
?>

