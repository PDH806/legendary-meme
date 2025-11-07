<!DOCTYPE html>
<html>

<?php
	extract($_REQUEST);

    function align_tel($telNo)
    {
        $telNo = preg_replace('/[^\d\n]+/', '', $telNo);
        if (substr($telNo, 0, 1)!="0" && strlen($telNo)>8) {
            $telNo = "0".$telNo;
        }
        $Pn3 = substr($telNo, -4);
        if (substr($telNo, 0, 2)=="01") {
            $Pn1 =  substr($telNo, 0, 3);
        } elseif (substr($telNo, 0, 2)=="02") {
            $Pn1 =  substr($telNo, 0, 2);
        } elseif (substr($telNo, 0, 1)=="0") {
            $Pn1 =  substr($telNo, 0, 3);
        }
        $Pn2 = substr($telNo, strlen($Pn1), -4);
        if (!$Pn1) {
            return $Pn2."-".$Pn3;
        } else {
            return $Pn1."-".$Pn2."-".$Pn3;
        }
    }

    function replace_string($content, $type="TEXT")
    { // $type를 대문자로전환 $type = strtoupper($type);
        if ($type=="TEXT") {
            $content = stripslashes($content);
            $content = htmlspecialchars($content);
            $content = preg_replace("\r\n", "\n", $content);
            $content = preg_replace("\n", "<br>", $content);
            $content = $this->autoLink($content);
        } elseif ($type=="HTML") {
            $content = stripslashes($content);
            $content = preg_replace("\"", "", $content);
            $content = preg_replace("'", "", $content);
            $content = preg_replace("<\?", "&lt;?", $content);
            $content = preg_replace("\?>", "?&gt;", $content);
            $content = preg_replace("<\%", "&lt;%", $content);
            $content = preg_replace("\%>", "%&gt;", $content);
            $content = preg_replace("<(SCRIPT)(^>]*)>", "&lt;\\1\\2&gt;", $content);
            $content = preg_replace("<\(SCRIPT)>", "&lt;/\\1&gt;", $content);
            $content = preg_replace("<(XMP)(^>]*)>", "&lt;\\1\\2&gt;", $content);
            $content = preg_replace("</(XMP)>", "&lt;/\\1&gt;", $content);
        } elseif ($type=="HTML+TEXT") {
            $content = stripslashes($content);
            $content = preg_replace("\r\n", "\n", $content);
            $content = preg_replace("\n", "<br>", $content);
            $content = preg_replace("\"", "", $content);
            $content = preg_replace("'", "", $content);
            $content = preg_replace("<\?", "&lt;?", $content);
            $content = preg_replace("\?>", "?&gt;", $content);
            $content = preg_replace("<\%", "&lt;%", $content);
            $content = preg_replace("\%>", "%&gt;", $content);
        }

        return $content;
    }


	$category 	 	= trim($_POST["category"]);
	$MEMBER_ID 		= trim($_POST["MEMBER_ID"]);

	include 'db_config.html';


?>

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

		<?  /* 관리자가 아니면 로그인 화면으로 이동 (에러코드 - 9) */
			// if ($rank <> 9){echo " <script language='javascript'>top.document.location.href = 'member_login.html?case=9'</script>";}
		?>

<?

	/**** 1. 멤버 일반정보/프로필 사진 업데이트 ****/

	if($category == 1)
	{
	$filename = $_FILES[image][tmp_name];
	$handle = fopen($filename,"rb");
	$size = GetImageSize($_FILES[image][tmp_name]);
	$width = $size[0];
	$height = $size[1];
	$imageblob = addslashes(fread($handle, filesize($filename)));
	$filesize = $filename;
	fclose($handle);
 		//메모리 오류 방지

		
 		//메모리 오류 방지

 		if ($delete_image)
 			{
   				$query="UPDATE 7G_Skiresort_Member SET image = '', width = '', height = '', filesize = '' where MEMBER_ID = '$Login_User_ID'";
 				$result=mysql_query($query,$connect );
 			}
	
 		if ($imageblob)
 			{
 				$query="UPDATE 7G_Skiresort_Member SET image = '$imageblob', GENDER = '$GENDER', EMAIL = '$EMAIL', BIRTH = '$BIRTH' where MEMBER_ID = '$Login_User_ID'";
 				$result=mysql_query($query,$connect );
			}

			else

			{
 				$query="UPDATE 7G_Skiresort_Member SET GENDER = '$GENDER', EMAIL = '$EMAIL', BIRTH = '$BIRTH' where MEMBER_ID = '$Login_User_ID'";
 				$result=mysql_query($query,$connect );
			}

	}


 	if($category == 2)
	{
	extract($_REQUEST);
 	$query="UPDATE 7G_Skiresort_Member SET ZIP = '$ZIP', ADDRESS1 = '$ADDRESS1',  ADDRESS2 = '$ADDRESS2', ADDRESS3 = '$ADDRESS3' where MEMBER_ID = '$Login_User_ID'";
 	$result=mysql_query($query,$connect );
	}


	if ($category == 3 or $category == 4  or $category == 5) 
	{echo "<script>location.href='mypage.html?category=$category';</script>";}

 	echo "<script>location.href='mypage.html?category=$category';</script>";

?>

	<!-- footer for AUGMENT-SKI -->
		<? include 'footer.html'; ?>
	<!-- end of footer -->
	
</body>

</html>