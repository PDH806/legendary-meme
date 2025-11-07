<?
	include '../db_config.html';
	
	extract($_REQUEST);
 	$filename1 = $_FILES[image1][tmp_name];
 	$handle1 = fopen($filename1,"rb");
 	$size1 = GetImageSize($_FILES[image1][tmp_name]);
 	$width1 = $size1[0];
 	$height1 = $size1[1];
 	$imageblob1 = addslashes(fread($handle1, filesize($filename1)));
 	$filesize1 = $filename1;
 	fclose($handle1);

	if ($BIRTH == '0000-00-00' or $BIRTH == ''){$BIRTH = "1901-01-01";}

	$query="UPDATE 7G_Skiresort_Member SET MEMBER_NAME2 = '$MEMBER_NAME2', GENDER = '$GENDER', PHONE = '$PHONE', BIRTH = '$BIRTH', RANK = '$RANK', EMAIL = '$EMAIL',
										   ZIP = '$ZIP', ADDRESS1 = '$ADDRESS1', ADDRESS2 = '$ADDRESS2', ADDRESS3 = '$ADDRESS3',
										   
										   T1_LICENSE = '$T1_LICENSE', T1_YEAR = '$T1_YEAR', T1_LICENSE_No = '$T1_LICENSE_No',
										   T2_LICENSE = '$T2_LICENSE', T2_YEAR = '$T2_YEAR', T2_LICENSE_No = '$T2_LICENSE_No',
										   T3_LICENSE = '$T3_LICENSE', T3_YEAR = '$T3_YEAR', T3_LICENSE_No = '$T3_LICENSE_No',
										   
										   SBT1_LICENSE = '$SBT1_LICENSE', SBT1_YEAR = '$SBT1_YEAR', SBT1_LICENSE_No = '$SBT1_LICENSE_No',
										   SBT2_LICENSE = '$SBT2_LICENSE', SBT2_YEAR = '$SBT2_YEAR', SBT2_LICENSE_No = '$SBT2_LICENSE_No',
										   SBT3_LICENSE = '$SBT3_LICENSE', SBT3_YEAR = '$SBT3_YEAR', SBT3_LICENSE_No = '$SBT3_LICENSE_No',
										   PATROL_LICENSE = '$PATROL_LICENSE', PATROL_YEAR = '$PATROL_YEAR', PATROL_LICENSE_No = '$PATROL_LICENSE_No',
										   
										   Main_Base = '$Main_Base', Sub_Base = '$Sub_Base',
										   Club1 = '$Club1', Club2 = '$Club2',
										   
										   Ski1_Brand = '$Ski1_Brand', Ski2_Brand = '$Ski2_Brand', Ski3_Brand = '$Ski3_Brand', Ski4_Brand = '$Ski4_Brand',
										   Boots_Brand = '$Boots_Brand', Helmet_Brand = '$Helmet_Brand', Goggle_Brand = '$Goggle_Brand', Pole_Brand = '$Pole_Brand'
										   
										   where NO = '$NO'";
										   

	$result=mysqli_query($link, $query);

	echo "<script>
	alert('회원정보 수정이 완료되었습니다.');
	location.href='admin_member_edit.html?No=$NO';</script>";

	?>
	
	
