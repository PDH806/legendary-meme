<?php
	$connect=mysql_connect("dbserver","skiresort","ll170505");
	mysql_select_db("skiresort",$connect);

    $query= "select * from 7G_T_Reserve_New where MEMBER_TYPE = 't1b'" ;
 	$result=mysql_query($query,$connect );
 	$row=mysql_fetch_array($result);
	$i = 0;
	while ($row) {
		// $file = file_get_contents("$row[RS_BUYER_PHOTO]");

		
		$i = $i+1;		
	


		if (substr($row[RS_BUYER_PHOTO],0,5) == '/data')
		{
			$row[RS_BUYER_PHOTO] = "http://skiresort.or.kr".$row[RS_BUYER_PHOTO];
		}
		
		if ($row[RS_BUYER_PHOTO])
		{
				$target = $row[RS_BUYER_PHOTO];
				$targer2 = "/data/"."$row[NO]".".jpg";
				$size = getimagesize($target);
				$width = $size[0];
				$height = $size[1];
				$type = $size[2];
				$attr = $size[3];
		
				echo $i." ".$row[RS_BUYER_PHOTO]." // $width // $height // $type // $attr // "."<br>";
				echo "<img src = '$row[RS_BUYER_PHOTO]'><br>";
		
				if($width>200) {
					$new_width = 200;
					$new_height = $height * (200/$width);

					$image_p = imagecreatetruecolor($new_width, $new_height);
					$image = imagecreatefromjpeg($target);
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					imagejpeg($image_p, "$target2", 100);
					imagedestroy($image);
					imagedestroy($image_p);

					} else {
					$new_width = $width;
					$new_height = $height;

					$image_p = imagecreatetruecolor($new_width, $new_height);
					$image = imagecreatefromjpeg($target);
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					imagejpeg($image_p, "$target2", 100);
					imagedestroy($image);
					imagedestroy($image_p);
				}

		
				$size = getimagesize($target2);
				$width = $size[0];
				$height = $size[1];

				$imageblob = addslashes(fread(fopen($target2, "r"), filesize($target2))); 
				$filesize = filesize($target2) ; 
		
		
		



		// $file = fopen($row[RS_BUYER_PHOTO], "rb");
 		// $imageblob = addslashes(fread($file, filesize($row[RS_BUYER_PHOTO])));
			
		$sql = "update 7G_T_Reserve_New set image = '$imageblob' where NO = '$row[NO]'";
 		$result2 = mysql_query($sql,$connect);
		}
		
		$row=mysql_fetch_array($result);
	
		
		}

?>