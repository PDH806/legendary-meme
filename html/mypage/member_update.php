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

	include '../db_config.html';

    if (!$Login_User_ID) {echo " <script language='javascript'>top.document.location.href = '../member_login.html'</script>";}
	
	
		


	/**** 1. 멤버 일반정보/프로필 사진 업데이트 ****/

	if($category == 1)
	{
		
	// 회원사진 업로드
	ini_set("upload_max_filesize",$upload_max_filesize); 
	$upload_max_filesize = ini_get('upload_max_filesize');

	$tmp_file  = $_FILES['file']['tmp_name'];
    $filesize  = $_FILES['file']['size'];
    $filename  = $_FILES['file']['name'];
   
	 // 서버에 설정된 값보다 큰파일을 업로드 한다면
    if ($filename) {
        if ($_FILES['file']['error'] == 1) {
            $file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
        }
        else if ($_FILES['file']['error'] != 0) {
            $file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
        }
		
    }
	 if (is_uploaded_file($tmp_file)) {
		$timg = @getimagesize($tmp_file);
		$ext = substr($timg['mime'], strpos($timg['mime'],'/')+1 );

		// image type
        if ( preg_match("/\.(jpg|png|gif|jpeg)$/i", $filename) ) {
            if ($timg['2'] < 1 || $timg['2'] > 16)
                $file_upload_msg .= '이미지 파일이 아닙니다.\\n';
        }
        
      	// $dest_file = $_SERVER['DOCUMENT_ROOT'].'/mypage/member_imgs/'.$Login_User_ID.'.'.$ext ;
        $dest_file = '../member_imgs/'.$Login_User_ID.'.'.$ext ;
		chmod('../member_imgs/'.$Login_User_ID.'.'.$ext, 0757);
		
		//echo 'dest_file :'.$dest_file;exit;

        // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
        $error_code = move_uploaded_file($tmp_file, $dest_file);
		if(!$error_code) $file_upload_msg .= "파일업로드 오류";
        // 올라간 파일의 퍼미션을 변경합니다.
        chmod($dest_file, 0757);
    }
	if($file_upload_msg){
		echo "<script>alert(`$file_upload_msg`);</script>";
		exit;
	}

	$member_phone = align_tel($member_phone);
 	
	$query="UPDATE 7G_Skiresort_Member SET GENDER = '$GENDER', EMAIL = '$EMAIL', PHONE = '$member_phone', BIRTH = '$BIRTH' where MEMBER_ID = '$Login_User_ID'";
	$result=mysqli_query($link, $query);	

	}

 	if($category == 99)
	{
 	$query="INSERT into 7G_TECH_PROFILE (MEMBER_ID, PROFILE) values ('$Login_User_ID', '$profile')";
 	$result=mysqli_query($link, $query);
 	
 	echo "
    	<script language='javascript'>
    		alert('기선전 프로필 등록이 완료되었습니다.');
    	</script>";
 	
 	
 	
 	
	}
 
 
 	if($category == 2)
	{
 	$query="UPDATE 7G_Skiresort_Member SET ZIP = '$ZIP', ADDRESS1 = '$ADDRESS1',  ADDRESS2 = '$ADDRESS2', ADDRESS3 = '$ADDRESS3' where MEMBER_ID = '$Login_User_ID'";
 	$result=mysqli_query($link, $query);
	}


 	if($category == 3)
	{
 	$query="UPDATE 7G_Skiresort_Member SET Ski1_Brand = '$Ski1_Brand', Ski2_Brand = '$Ski2_Brand',  Ski3_Brand = '$Ski3_Brand', Ski4_Brand = '$Ski4_Brand', Boots_Brand = '$Boots_Brand', 
 			Helmet_Brand = '$Helmet_Brand', Goggle_Brand = '$Goggle_Brand', Pole_Brand = '$Pole_Brand' where MEMBER_ID = '$Login_User_ID'";
 	$result=mysqli_query($link,$query);
	}

 	if($category == 4)
	{
 	$query="UPDATE 7G_Skiresort_Member SET Main_Base = $Main_Base, Sub_Base = $Sub_Base,  Club1 = '$Club1', Club2 = '$Club2' where MEMBER_ID = '$Login_User_ID'";
 	$result=mysqli_query($link, $query);
	}


 	if($category == 9)
	{
	
		$member_query= "SELECT * FROM 7G_Skiresort_Member where MEMBER_ID = '$MEMBER_ID'";
		$member_result=mysqli_query($link, $member_query);
		$member=mysqli_fetch_array($member_result);
 		$total_member = mysqli_num_rows($member_result);

 		if (password_verify($password0, $member[PASSWORD])) { 
 		 		
			if($password1 == $password2){
    			$encrypted_password = password_hash($password1, PASSWORD_DEFAULT);
  				$query="UPDATE 7G_Skiresort_Member SET PASSWORD = '$encrypted_password' WHERE MEMBER_ID = '$MEMBER_ID'";
 				$result=mysqli_query($link, $query);
				}
 		}
		
		$category = '1';	
	 	echo "<script>alert('새로운 비밀번호를 등록하였습니다..');</script>";
	}

 	echo "<script>location.href='/mypage/index.html?category=$category';</script>";


?>

	<!-- footer for AUGMENT-SKI -->
		<? include 'footer.html'; ?>
	<!-- end of footer -->
	
</body>

</html>