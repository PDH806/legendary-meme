<?php

    //upload.php
	include '../db_config.html';

	if($_FILES["file"]["name"] != '')
	{
 		$test 	= explode('.', $_FILES["file"]["name"]);
 		$ext 	= end($test);
 		$name 	= $Login_User_ID . '.' . $ext;
 		$location = '../member_imgs/' . $name;
 		
 		unlink("../member_imgs/$Login_User_ID".".jpg");
 		unlink("../member_imgs/$Login_User_ID".".jpeg");
 		unlink("../member_imgs/$Login_User_ID".".png");
 		unlink("../member_imgs/$Login_User_ID".".gif");
 		
 		move_uploaded_file($_FILES["file"]["tmp_name"], $location);
 		echo '<img src="'.$location.'"  width="400" class="img-thumbnail" />';
	}
?>
