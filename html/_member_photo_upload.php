<?php
	include '../db_config.html';

	$MID     = $_GET['MID'];

	if($_FILES["file"]["name"] != '')
	{
 		$test 	= explode('.', $_FILES["file"]["name"]);
 		$ext 	= end($test);
 		// $name 	= $Login_User_ID . '.' . $ext;
		 $name 	= $MID . '.' . $ext;
 		$location = 'member_imgs/' . $name;
				// $location = $name;
 		
 		unlink("./member_imgs/$MID".".jpg");
 		unlink("./member_imgs/$MID".".jpeg");
 		unlink("./member_imgs/$MID".".png");
 		unlink("./member_imgs/$MID".".gif");
 		
 		move_uploaded_file($_FILES["file"]["tmp_name"], $location);
 		// if(move_uploaded_file($_FILES["file"]["tmp_name"], $location)){
		// 	echo 'ok';
		// }
		// else{
		// 	echo 'fail';
		// }
		echo '<img src="'.$location.'"  width="400" class="img-thumbnail" />';
	}
?>
