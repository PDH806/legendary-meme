<? 
	include 'db_config.html';
	if (!$Login_User_ID){echo " <script language='javascript'>top.document.location.href = 'member_login.html?case=9'</script>";}

	extract($_REQUEST);
	$filename = $_FILES[image][tmp_name];
	$handle = fopen($filename,"rb");
	$size = GetImageSize($_FILES[image][tmp_name]);
	$width = $size[0];
	$height = $size[1];
	$imageblob = addslashes(fread($handle, filesize($filename)));
	$filesize = $filename;
	fclose($handle);

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

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<link rel="shortcut icon" href="Myicon.png" type="image/x-icon">
    
    <title><? echo "$main_title"; ?></title>
		<? include 'link-files.html'; ?>
		
</head>

<body>

	<?  include 'main-nav.html'; 
	
 		if ($imageblob)
 			{
				$query="UPDATE 7G_Skiresort_Member SET image = '$imageblob', width = '$width', height = '$height', filesize = '$filesize', EMAIL = '$EMAIL', ZIP = '$ZIP' , ADDRESS1 = '$ADDRESS1', ADDRESS2 = '$ADDRESS2', ADDRESS3 = '$ADDRESS3', Process = '1' where MEMBER_ID = '$Login_User_ID'";
 				$result=mysql_query($query,$connect );
			}

			else
			{  	
				$query="UPDATE 7G_Skiresort_Member set EMAIL = '$EMAIL', ZIP = '$ZIP' , ADDRESS1 = '$ADDRESS1', ADDRESS2 = '$ADDRESS2', ADDRESS3 = '$ADDRESS3', Process = '1' where MEMBER_ID = '$Login_User_ID'";
				$result=mysql_query($query,$connect);
		
			}


	echo "	
	
<form name='mobileweb' method='post' accept-charset='euc-kr'> 
	<input type='text' name='P_NEXT_URL' value='$return_page' hidden> 
	<input type='text' name='P_INI_PAYMENT' value='$PayMethod' hidden> 
	<input type='text' name='P_RESERVED' value='twotrs_isp=Y&block_isp=Y&twotrs_isp_noti=N' hidden> 
	<input type='text' name='P_MID' value='INIpayTest' hidden> 
	<input type='text' name='P_OID' value='test_oid_123456' hidden>  
	<input type='text' name='P_GOODS' value='$P_GOODS' hidden> 
	<input type='text' name='P_AMT' value='$P_AMT' hidden> 
	<input type='text' name='P_UNAME' value='$MEMBER_NAME' hidden> 
	<input type='text' name='P_NOTI_URL' value='' hidden>  
	<input type='text' name='P_HPP_METHOD' value='1' hidden>  
</form>";

 echo "<script> myform = document.mobileweb; 
 myform.action = 'https://mobile.inicis.com/smart/payment/';
 myform.target = '_self';
 myform.submit(); 
</script>";

?>

	<!-- footer for AUGMENT-SKI -->
		<? include 'footer.html'; ?>
	<!-- end of footer -->
	
</body>

</html>