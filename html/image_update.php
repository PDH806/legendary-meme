<!DOCTYPE html>
<html>

<head>

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
			<? include 'main-nav.html'; ?>
		<!-- end of Navigation -->

<?

	
  		extract($_REQUEST);
 		$filename = $_FILES[image1][tmp_name];
 		$handle = fopen($filename,"rb");
 		$size = GetImageSize($_FILES[image1][tmp_name]);
 		$width = $size[0];
 		$height = $size[1];
 		$imageblob = addslashes(fread($handle, filesize($filename)));
 		$filesize = $filename;
 		fclose($handle);
 		//메모리 오류 방지

	
	
 		if ($imageblob)
 			{
				$query="UPDATE image_rolling SET image1 = '$imageblob' where No = '1'";
 				$result=mysql_query($query,$connect );
			}

	
 		$result=mysql_query($query,$connect );


 	echo "<script>location.href='image_update.html';</script>";

?>

	<!-- footer for AUGMENT-SKI -->
		<? include 'footer.html'; ?>
	<!-- end of footer -->
	
</body>

</html>