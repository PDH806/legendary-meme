<!DOCTYPE html>
<html>
<?
	$category 	 		= trim($_POST["category"]);
	$site 				= trim($_POST["site"]);

	include '../db_config.html';

	/*** Category #1, 관리자 & 회사정보 ****/
	
	$admin_name 		= trim($_POST["admin_name"]);
	$admin_mail 		= trim($_POST["admin_mail"]);
	$admin_phone 		= trim($_POST["admin_phone"]);
	
	$admin_name2 		= trim($_POST["admin_name2"]);
	$admin_mail2 		= trim($_POST["admin_mail2"]);
	$admin_phone2 		= trim($_POST["admin_phone2"]);

	$company_name 		= trim($_POST["company_name"]);
	$company_no 		= trim($_POST["company_no"]);
	$company_address 	= trim($_POST["company_address"]);
	$company_phone 		= trim($_POST["company_phone"]);
	$company_fax 		= trim($_POST["company_fax"]);
	$company_email 		= trim($_POST["company_email"]);
	$company_security 	= trim($_POST["company_security"]);
	$copyright 			= trim($_POST["copyright"]);

	
	/*** Category #2, 탑메뉴 정보 ****/
	
	$t_m1_head 			= trim($_POST["t_m1_head"]);
	$t_m1_link 			= trim($_POST["t_m1_link"]);
	$t_m1_name1 		= trim($_POST["t_m1_name1"]);
	$t_m1_link1 		= trim($_POST["t_m1_link1"]);
	$t_m1_name2 		= trim($_POST["t_m1_name2"]);
	$t_m1_link2 		= trim($_POST["t_m1_link2"]);
	$t_m1_name3 		= trim($_POST["t_m1_name3"]);
	$t_m1_link3 		= trim($_POST["t_m1_link3"]);
	$t_m1_name4 		= trim($_POST["t_m1_name4"]);
	$t_m1_link4 		= trim($_POST["t_m1_link4"]);
	$t_m1_name5 		= trim($_POST["t_m1_name5"]);
	$t_m1_link5 		= trim($_POST["t_m1_link5"]);
	$t_m1_name6 		= trim($_POST["t_m1_name6"]);
	$t_m1_link6 		= trim($_POST["t_m1_link6"]);
	$t_m1_name7 		= trim($_POST["t_m1_name7"]);
	$t_m1_link7 		= trim($_POST["t_m1_link7"]);
	$t_m1_name8 		= trim($_POST["t_m1_name8"]);
	$t_m1_link8 		= trim($_POST["t_m1_link8"]);
	$t_m1_name9 		= trim($_POST["t_m1_name9"]);
	$t_m1_link9 		= trim($_POST["t_m1_link9"]);
	$t_m1_name10 		= trim($_POST["t_m1_name10"]);
	$t_m1_link10 		= trim($_POST["t_m1_link10"]);

		
	$t_m2_head 			= trim($_POST["t_m2_head"]);
	$t_m2_link 			= trim($_POST["t_m2_link"]);
	$t_m2_name1 		= trim($_POST["t_m2_name1"]);
	$t_m2_link1 		= trim($_POST["t_m2_link1"]);
	$t_m2_name2 		= trim($_POST["t_m2_name2"]);
	$t_m2_link2 		= trim($_POST["t_m2_link2"]);
	$t_m2_name3 		= trim($_POST["t_m2_name3"]);
	$t_m2_link3 		= trim($_POST["t_m2_link3"]);
	$t_m2_name4 		= trim($_POST["t_m2_name4"]);
	$t_m2_link4 		= trim($_POST["t_m2_link4"]);
	$t_m2_name5 		= trim($_POST["t_m2_name5"]);
	$t_m2_link5 		= trim($_POST["t_m2_link5"]);
	$t_m2_name6 		= trim($_POST["t_m2_name6"]);
	$t_m2_link6 		= trim($_POST["t_m2_link6"]);
	$t_m2_name7 		= trim($_POST["t_m2_name7"]);
	$t_m2_link7 		= trim($_POST["t_m2_link7"]);
	$t_m2_name8 		= trim($_POST["t_m2_name8"]);
	$t_m2_link8 		= trim($_POST["t_m2_link8"]);
	$t_m2_name9 		= trim($_POST["t_m2_name9"]);
	$t_m2_link9 		= trim($_POST["t_m2_link9"]);
	$t_m2_name10 		= trim($_POST["t_m2_name10"]);
	$t_m2_link10 		= trim($_POST["t_m2_link10"]);

	$t_m3_head 			= trim($_POST["t_m3_head"]);
	$t_m3_link 			= trim($_POST["t_m3_link"]);
	$t_m3_name1 		= trim($_POST["t_m3_name1"]);
	$t_m3_link1 		= trim($_POST["t_m3_link1"]);
	$t_m3_name2 		= trim($_POST["t_m3_name2"]);
	$t_m3_link2 		= trim($_POST["t_m3_link2"]);
	$t_m3_name3 		= trim($_POST["t_m3_name3"]);
	$t_m3_link3 		= trim($_POST["t_m3_link3"]);
	$t_m3_name4 		= trim($_POST["t_m3_name4"]);
	$t_m3_link4 		= trim($_POST["t_m3_link4"]);
	$t_m3_name5 		= trim($_POST["t_m3_name5"]);
	$t_m3_link5 		= trim($_POST["t_m3_link5"]);
	$t_m3_name6 		= trim($_POST["t_m3_name6"]);
	$t_m3_link6 		= trim($_POST["t_m3_link6"]);
	$t_m3_name7 		= trim($_POST["t_m3_name7"]);
	$t_m3_link7 		= trim($_POST["t_m3_link7"]);
	$t_m3_name8 		= trim($_POST["t_m3_name8"]);
	$t_m3_link8 		= trim($_POST["t_m3_link8"]);
	$t_m3_name9 		= trim($_POST["t_m3_name9"]);
	$t_m3_link9 		= trim($_POST["t_m3_link9"]);
	$t_m3_name10 		= trim($_POST["t_m3_name10"]);
	$t_m3_link10 		= trim($_POST["t_m3_link10"]);


	$t_m4_head 			= trim($_POST["t_m4_head"]);
	$t_m4_link 			= trim($_POST["t_m4_link"]);
	$t_m4_name1 		= trim($_POST["t_m4_name1"]);
	$t_m4_link1 		= trim($_POST["t_m4_link1"]);
	$t_m4_name2 		= trim($_POST["t_m4_name2"]);
	$t_m4_link2 		= trim($_POST["t_m4_link2"]);
	$t_m4_name3 		= trim($_POST["t_m4_name3"]);
	$t_m4_link3 		= trim($_POST["t_m4_link3"]);
	$t_m4_name4 		= trim($_POST["t_m4_name4"]);
	$t_m4_link4 		= trim($_POST["t_m4_link4"]);
	$t_m4_name5 		= trim($_POST["t_m4_name5"]);
	$t_m4_link5 		= trim($_POST["t_m4_link5"]);
	$t_m4_name6 		= trim($_POST["t_m4_name6"]);
	$t_m4_link6 		= trim($_POST["t_m4_link6"]);
	$t_m4_name7 		= trim($_POST["t_m4_name7"]);
	$t_m4_link7 		= trim($_POST["t_m4_link7"]);
	$t_m4_name8 		= trim($_POST["t_m4_name8"]);
	$t_m4_link8 		= trim($_POST["t_m4_link8"]);
	$t_m4_name9 		= trim($_POST["t_m4_name9"]);
	$t_m4_link9 		= trim($_POST["t_m4_link9"]);
	$t_m4_name10 		= trim($_POST["t_m4_name10"]);
	$t_m4_link10 		= trim($_POST["t_m4_link10"]);

	$t_m5_head 			= trim($_POST["t_m5_head"]);
	$t_m5_link 			= trim($_POST["t_m5_link"]);
	$t_m5_name1 		= trim($_POST["t_m5_name1"]);
	$t_m5_link1 		= trim($_POST["t_m5_link1"]);
	$t_m5_name2 		= trim($_POST["t_m5_name2"]);
	$t_m5_link2 		= trim($_POST["t_m5_link2"]);
	$t_m5_name3 		= trim($_POST["t_m5_name3"]);
	$t_m5_link3 		= trim($_POST["t_m5_link3"]);
	$t_m5_name4 		= trim($_POST["t_m5_name4"]);
	$t_m5_link4 		= trim($_POST["t_m5_link4"]);
	$t_m5_name5 		= trim($_POST["t_m5_name5"]);
	$t_m5_link5 		= trim($_POST["t_m5_link5"]);
	$t_m5_name6 		= trim($_POST["t_m5_name6"]);
	$t_m5_link6 		= trim($_POST["t_m5_link6"]);
	$t_m5_name7 		= trim($_POST["t_m5_name7"]);
	$t_m5_link7 		= trim($_POST["t_m5_link7"]);
	$t_m5_name8 		= trim($_POST["t_m5_name8"]);
	$t_m5_link8 		= trim($_POST["t_m5_link8"]);
	$t_m5_name9 		= trim($_POST["t_m5_name9"]);
	$t_m5_link9 		= trim($_POST["t_m5_link9"]);
	$t_m5_name10 		= trim($_POST["t_m5_name10"]);
	$t_m5_link10 		= trim($_POST["t_m5_link10"]);

	$t_m6_head 			= trim($_POST["t_m6_head"]);
	$t_m6_link 			= trim($_POST["t_m6_link"]);
	$t_m6_name1 		= trim($_POST["t_m6_name1"]);
	$t_m6_link1 		= trim($_POST["t_m6_link1"]);
	$t_m6_name2 		= trim($_POST["t_m6_name2"]);
	$t_m6_link2 		= trim($_POST["t_m6_link2"]);
	$t_m6_name3 		= trim($_POST["t_m6_name3"]);
	$t_m6_link3 		= trim($_POST["t_m6_link3"]);
	$t_m6_name4 		= trim($_POST["t_m6_name4"]);
	$t_m6_link4 		= trim($_POST["t_m6_link4"]);
	$t_m6_name5 		= trim($_POST["t_m6_name5"]);
	$t_m6_link5 		= trim($_POST["t_m6_link5"]);
	$t_m6_name6 		= trim($_POST["t_m6_name6"]);
	$t_m6_link6 		= trim($_POST["t_m6_link6"]);
	$t_m6_name7 		= trim($_POST["t_m6_name7"]);
	$t_m6_link7 		= trim($_POST["t_m6_link7"]);
	$t_m6_name8 		= trim($_POST["t_m6_name8"]);
	$t_m6_link8 		= trim($_POST["t_m6_link8"]);
	$t_m6_name9 		= trim($_POST["t_m6_name9"]);
	$t_m6_link9 		= trim($_POST["t_m6_link9"]);
	$t_m6_name10 		= trim($_POST["t_m6_name10"]);
	$t_m6_link10 		= trim($_POST["t_m6_link10"]);

	$t_m7_head 			= trim($_POST["t_m7_head"]);
	$t_m7_link 			= trim($_POST["t_m7_link"]);
	$t_m7_name1 		= trim($_POST["t_m7_name1"]);
	$t_m7_link1 		= trim($_POST["t_m7_link1"]);
	$t_m7_name2 		= trim($_POST["t_m7_name2"]);
	$t_m7_link2 		= trim($_POST["t_m7_link2"]);
	$t_m7_name3 		= trim($_POST["t_m7_name3"]);
	$t_m7_link3 		= trim($_POST["t_m7_link3"]);
	$t_m7_name4 		= trim($_POST["t_m7_name4"]);
	$t_m7_link4 		= trim($_POST["t_m7_link4"]);
	$t_m7_name5 		= trim($_POST["t_m7_name5"]);
	$t_m7_link5 		= trim($_POST["t_m7_link5"]);
	$t_m7_name6 		= trim($_POST["t_m7_name6"]);
	$t_m7_link6 		= trim($_POST["t_m7_link6"]);
	$t_m7_name7 		= trim($_POST["t_m7_name7"]);
	$t_m7_link7 		= trim($_POST["t_m7_link7"]);
	$t_m7_name8 		= trim($_POST["t_m7_name8"]);
	$t_m7_link8 		= trim($_POST["t_m7_link8"]);
	$t_m7_name9 		= trim($_POST["t_m7_name9"]);
	$t_m7_link9 		= trim($_POST["t_m7_link9"]);
	$t_m7_name10 		= trim($_POST["t_m7_name10"]);
	$t_m7_link10 		= trim($_POST["t_m7_link10"]);

	$t_m8_head 			= trim($_POST["t_m8_head"]);
	$t_m8_link 			= trim($_POST["t_m8_link"]);
	$t_m8_name1 		= trim($_POST["t_m8_name1"]);
	$t_m8_link1 		= trim($_POST["t_m8_link1"]);
	$t_m8_name2 		= trim($_POST["t_m8_name2"]);
	$t_m8_link2 		= trim($_POST["t_m8_link2"]);
	$t_m8_name3 		= trim($_POST["t_m8_name3"]);
	$t_m8_link3 		= trim($_POST["t_m8_link3"]);
	$t_m8_name4 		= trim($_POST["t_m8_name4"]);
	$t_m8_link4 		= trim($_POST["t_m8_link4"]);
	$t_m8_name5 		= trim($_POST["t_m8_name5"]);
	$t_m8_link5 		= trim($_POST["t_m8_link5"]);
	$t_m8_name6 		= trim($_POST["t_m8_name6"]);
	$t_m8_link6 		= trim($_POST["t_m8_link6"]);
	$t_m8_name7 		= trim($_POST["t_m8_name7"]);
	$t_m8_link7 		= trim($_POST["t_m8_link7"]);
	$t_m8_name8 		= trim($_POST["t_m8_name8"]);
	$t_m8_link8 		= trim($_POST["t_m8_link8"]);
	$t_m8_name9 		= trim($_POST["t_m8_name9"]);
	$t_m8_link9 		= trim($_POST["t_m8_link9"]);
	$t_m8_name10 		= trim($_POST["t_m8_name10"]);
	$t_m8_link10 		= trim($_POST["t_m8_link10"]);

	$t_m9_head 			= trim($_POST["t_m9_head"]);
	$t_m9_link 			= trim($_POST["t_m9_link"]);
	$t_m9_name1 		= trim($_POST["t_m9_name1"]);
	$t_m9_link1 		= trim($_POST["t_m9_link1"]);
	$t_m9_name2 		= trim($_POST["t_m9_name2"]);
	$t_m9_link2 		= trim($_POST["t_m9_link2"]);
	$t_m9_name3 		= trim($_POST["t_m9_name3"]);
	$t_m9_link3 		= trim($_POST["t_m9_link3"]);
	$t_m9_name4 		= trim($_POST["t_m9_name4"]);
	$t_m9_link4 		= trim($_POST["t_m9_link4"]);
	$t_m9_name5 		= trim($_POST["t_m9_name5"]);
	$t_m9_link5 		= trim($_POST["t_m9_link5"]);
	$t_m9_name6 		= trim($_POST["t_m9_name6"]);
	$t_m9_link6 		= trim($_POST["t_m9_link6"]);
	$t_m9_name7 		= trim($_POST["t_m9_name7"]);
	$t_m9_link7 		= trim($_POST["t_m9_link7"]);
	$t_m9_name8 		= trim($_POST["t_m9_name8"]);
	$t_m9_link8 		= trim($_POST["t_m9_link8"]);
	$t_m9_name9 		= trim($_POST["t_m9_name9"]);
	$t_m9_link9 		= trim($_POST["t_m9_link9"]);
	$t_m9_name10 		= trim($_POST["t_m9_name10"]);
	$t_m9_link10 		= trim($_POST["t_m9_link10"]);


	$t_m_design			= trim($_POST["t_m_design"]);
	$t_m_bgcolor 		= trim($_POST["t_m_bgcolor"]);
	$t_m_height			= trim($_POST["t_m_height"]);
	$t_m_font_color 	= trim($_POST["t_m_font_color"]);

	/*** Category #3, 메인페이지 슬라이드쇼 ****/
	
	$slide_type 		= trim($_POST["slide_type"]);
	
	$slide_m_title1 	= trim($_POST["slide_m_title1"]);
	$slide_s_title1 	= trim($_POST["slide_s_title1"]);
	
	$slide_btn_name 	= trim($_POST["slide_btn_name"]);
	$slide_btn_link 	= trim($_POST["slide_btn_link"]);
	$slide_btn_color 	= trim($_POST["slide_btn_color"]);
	
	$slide_m_title2 	= trim($_POST["slide_m_title2"]);
	$slide_s_title2 	= trim($_POST["slide_s_title2"]);
	$slide_m_title3 	= trim($_POST["slide_m_title3"]);
	$slide_s_title3 	= trim($_POST["slide_s_title3"]);


	/*** Category #5, 팝업이미지 ****/
	
	$popup_title 		= trim($_POST["Title"]);
	$popup_start 		= trim($_POST["Start_date"]);
	$popup_end 			= trim($_POST["End_date"]);
	$popup_x 			= trim($_POST["X_Position"]);
	$popup_y 			= trim($_POST["Y_Position"]);
	$popup_link			= trim($_POST["Link_url"]);
	$list				= trim($_POST["List"]);
	$popup_no			= trim($_POST["popup_no"]);
	
	/*** Category #6, 오시는 길 지도등록 ****/
	
	$map_main_title 	= trim($_POST["map_main_title"]);
	$map_address 		= trim($_POST["map_address"]);
	$map_phone 			= trim($_POST["map_phone"]);
	$map_source 		= trim($_POST["map_source"]);
	$map_frame_code		= trim($_POST["map_frame_code"]);
	$map_bgcolor 		= trim($_POST["map_bgcolor"]);
	$map_space 			= trim($_POST["map_space"]);


	/*** Category #7, 풋터 메뉴등록 ****/
	
	$f_m1_head 			= trim($_POST["f_m1_head"]);
	$f_m1_name1 		= trim($_POST["f_m1_name1"]);
	$f_m1_link1 		= trim($_POST["f_m1_link1"]);
	$f_m1_name2 		= trim($_POST["f_m1_name2"]);
	$f_m1_link2			= trim($_POST["f_m1_link2"]);
	$f_m1_name3 		= trim($_POST["f_m1_name3"]);
	$f_m1_link3 		= trim($_POST["f_m1_link3"]);

	$f_m2_head 			= trim($_POST["f_m2_head"]);
	$f_m2_name1 		= trim($_POST["f_m2_name1"]);
	$f_m2_link1 		= trim($_POST["f_m2_link1"]);
	$f_m2_name2 		= trim($_POST["f_m2_name2"]);
	$f_m2_link2			= trim($_POST["f_m2_link2"]);
	$f_m2_name3 		= trim($_POST["f_m2_name3"]);
	$f_m2_link3 		= trim($_POST["f_m2_link3"]);


	$connect=mysql_connect("dbserver","skiresort","ll170505");
	mysql_select_db( "skiresort",$connect);

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
			if ($rank <> 9){echo " <script language='javascript'>top.document.location.href = 'member_login.html?case=9'</script>";}
		?>

<?

	/**** 1. 관리자 & 회사정보 업데이트 ****/

	if($category == 1)
	{
	
  		extract($_REQUEST);
 		$filename = $_FILES[company_logo][tmp_name];
 		$handle = fopen($filename,"rb");
 		$size = GetImageSize($_FILES[company_logo][tmp_name]);
 		$width = $size[0];
 		$height = $size[1];
 		$imageblob = addslashes(fread($handle, filesize($filename)));
 		$filesize = $filename;
 		fclose($handle);
 		//메모리 오류 방지

	
 		if ($delete_logo)
 			{
   				$query="UPDATE site_config SET company_logo = '' , logo_width = '', logo_height = '', logo_filesize = '' where site = '$site'";
 				$result=mysql_query($query,$connect );
 			}
	
 		if ($imageblob)
 			{
				$query="UPDATE site_config SET company_logo = '$imageblob' , logo_width = '$width', logo_height = '$height', logo_filesize = '$filesize' where site = '$site'";
 				$result=mysql_query($query,$connect );
			}

	
 		$query="UPDATE site_config SET 	admin_name='$admin_name', admin_mail='$admin_mail', admin_phone='$admin_phone', 
 									admin_name2='$admin_name2', admin_mail2='$admin_mail2', admin_phone2='$admin_phone2',
 									company_name = '$company_name', company_no='$company_no', company_address='$company_address', company_phone='$company_phone', 
 									company_fax='$company_fax', company_email='$company_email', company_security='$company_security', copyright='$copyright'
 				where site = '$site'";

 		$result=mysql_query($query,$connect );
	}

 	/**** 2. 탑 메뉴 설정 ****/
	
 	if($category == 2)
	{
 	$query="UPDATE site_config SET 	t_m1_head='$t_m1_head', 	t_m1_link='$t_m1_link', 	t_m1_name1='$t_m1_name1', 	t_m1_link1='$t_m1_link1', 
 									t_m1_name2='$t_m1_name2', 	t_m1_link2='$t_m1_link2', 	t_m1_name3='$t_m1_name3', 	t_m1_link3='$t_m1_link3', 
 									t_m1_name4='$t_m1_name4', 	t_m1_link4='$t_m1_link4', 	t_m1_name5='$t_m1_name5', 	t_m1_link5='$t_m1_link5',
 									t_m1_name6='$t_m1_name6', 	t_m1_link6='$t_m1_link6', 	t_m1_name7='$t_m1_name7', 	t_m1_link7='$t_m1_link7',
 									t_m1_name8='$t_m1_name8', 	t_m1_link8='$t_m1_link8',	t_m1_name9='$t_m1_name9', 	t_m1_link9='$t_m1_link9',
 									t_m1_name10='$t_m1_name10', t_m1_link10='$t_m1_link10',


									t_m2_head='$t_m2_head', 	t_m2_link='$t_m2_link', 	t_m2_name1='$t_m2_name1', 	t_m2_link1='$t_m2_link1', 
 									t_m2_name2='$t_m2_name2', 	t_m2_link2='$t_m2_link2', 	t_m2_name3='$t_m2_name3', 	t_m2_link3='$t_m2_link3', 
 									t_m2_name4='$t_m2_name4', 	t_m2_link4='$t_m2_link4', 	t_m2_name5='$t_m2_name5', 	t_m2_link5='$t_m2_link5',
 									t_m2_name6='$t_m2_name6', 	t_m2_link6='$t_m2_link6', 	t_m2_name7='$t_m2_name7', 	t_m2_link7='$t_m2_link7',
 									t_m2_name8='$t_m2_name8', 	t_m2_link8='$t_m2_link8',	t_m2_name9='$t_m2_name9', 	t_m2_link9='$t_m2_link9',
 									t_m2_name10='$t_m2_name10', t_m2_link10='$t_m2_link10',

									t_m3_head='$t_m3_head', 	t_m3_link='$t_m3_link', 	t_m3_name1='$t_m3_name1', 	t_m3_link1='$t_m3_link1', 
 									t_m3_name2='$t_m3_name2', 	t_m3_link2='$t_m3_link2', 	t_m3_name3='$t_m3_name3', 	t_m3_link3='$t_m3_link3', 
 									t_m3_name4='$t_m3_name4', 	t_m3_link4='$t_m3_link4', 	t_m3_name5='$t_m3_name5', 	t_m3_link5='$t_m3_link5',
 									t_m3_name6='$t_m3_name6', 	t_m3_link6='$t_m3_link6', 	t_m3_name7='$t_m3_name7', 	t_m3_link7='$t_m3_link7',
 									t_m3_name8='$t_m3_name8', 	t_m3_link8='$t_m3_link8',	t_m3_name9='$t_m3_name9', 	t_m3_link9='$t_m3_link9',
 									t_m3_name10='$t_m3_name10', t_m3_link10='$t_m3_link10',

									t_m4_head='$t_m4_head', 	t_m4_link='$t_m4_link', 	t_m4_name1='$t_m4_name1', 	t_m4_link1='$t_m4_link1', 
 									t_m4_name2='$t_m4_name2', 	t_m4_link2='$t_m4_link2', 	t_m4_name3='$t_m4_name3', 	t_m4_link3='$t_m4_link3', 
 									t_m4_name4='$t_m4_name4', 	t_m4_link4='$t_m4_link4', 	t_m4_name5='$t_m4_name5', 	t_m4_link5='$t_m4_link5',
 									t_m4_name6='$t_m4_name6', 	t_m4_link6='$t_m4_link6', 	t_m4_name7='$t_m4_name7', 	t_m4_link7='$t_m4_link7',
 									t_m4_name8='$t_m4_name8', 	t_m4_link8='$t_m4_link8',	t_m4_name9='$t_m4_name9', 	t_m4_link9='$t_m4_link9',
 									t_m4_name10='$t_m4_name10', t_m4_link10='$t_m4_link10',

									t_m5_head='$t_m5_head', 	t_m5_link='$t_m5_link', 	t_m5_name1='$t_m5_name1', 	t_m5_link1='$t_m5_link1', 
 									t_m5_name2='$t_m5_name2', 	t_m5_link2='$t_m5_link2', 	t_m5_name3='$t_m5_name3', 	t_m5_link3='$t_m5_link3', 
 									t_m5_name4='$t_m5_name4', 	t_m5_link4='$t_m5_link4', 	t_m5_name5='$t_m5_name5', 	t_m5_link5='$t_m5_link5',
 									t_m5_name6='$t_m5_name6', 	t_m5_link6='$t_m5_link6', 	t_m5_name7='$t_m5_name7', 	t_m5_link7='$t_m5_link7',
 									t_m5_name8='$t_m5_name8', 	t_m5_link8='$t_m5_link8',	t_m5_name9='$t_m5_name9', 	t_m5_link9='$t_m5_link9',
 									t_m5_name10='$t_m5_name10', t_m5_link10='$t_m5_link10',

									t_m6_head='$t_m6_head', 	t_m6_link='$t_m6_link', 	t_m6_name1='$t_m6_name1', 	t_m6_link1='$t_m6_link1', 
 									t_m6_name2='$t_m6_name2', 	t_m6_link2='$t_m6_link2', 	t_m6_name3='$t_m6_name3', 	t_m6_link3='$t_m6_link3', 
 									t_m6_name4='$t_m6_name4', 	t_m6_link4='$t_m6_link4', 	t_m6_name5='$t_m6_name5', 	t_m6_link5='$t_m6_link5',
 									t_m6_name6='$t_m6_name6', 	t_m6_link6='$t_m6_link6', 	t_m6_name7='$t_m6_name7', 	t_m6_link7='$t_m6_link7',
 									t_m6_name8='$t_m6_name8', 	t_m6_link8='$t_m6_link8',	t_m6_name9='$t_m6_name9', 	t_m6_link9='$t_m6_link9',
 									t_m6_name10='$t_m6_name10', t_m6_link10='$t_m6_link10',


									t_m7_head='$t_m7_head', 	t_m7_link='$t_m7_link', 	t_m7_name1='$t_m7_name1', 	t_m7_link1='$t_m7_link1', 
 									t_m7_name2='$t_m7_name2', 	t_m7_link2='$t_m7_link2', 	t_m7_name3='$t_m7_name3', 	t_m7_link3='$t_m7_link3', 
 									t_m7_name4='$t_m7_name4', 	t_m7_link4='$t_m7_link4', 	t_m7_name5='$t_m7_name5', 	t_m7_link5='$t_m7_link5',
 									t_m7_name6='$t_m7_name6', 	t_m7_link6='$t_m7_link6', 	t_m7_name7='$t_m7_name7', 	t_m7_link7='$t_m7_link7',
 									t_m7_name8='$t_m7_name8', 	t_m7_link8='$t_m7_link8',	t_m7_name9='$t_m7_name9', 	t_m7_link9='$t_m7_link9',
 									t_m7_name10='$t_m7_name10', t_m7_link10='$t_m7_link10',

									t_m8_head='$t_m8_head', 	t_m8_link='$t_m8_link', 	t_m8_name1='$t_m8_name1', 	t_m8_link1='$t_m8_link1', 
 									t_m8_name2='$t_m8_name2', 	t_m8_link2='$t_m8_link2', 	t_m8_name3='$t_m8_name3', 	t_m8_link3='$t_m8_link3', 
 									t_m8_name4='$t_m8_name4', 	t_m8_link4='$t_m8_link4', 	t_m8_name5='$t_m8_name5', 	t_m8_link5='$t_m8_link5',
 									t_m8_name6='$t_m8_name6', 	t_m8_link6='$t_m8_link6', 	t_m8_name7='$t_m8_name7', 	t_m8_link7='$t_m8_link7',
 									t_m8_name8='$t_m8_name8', 	t_m8_link8='$t_m8_link8',	t_m8_name9='$t_m8_name9', 	t_m8_link9='$t_m8_link9',
 									t_m8_name10='$t_m8_name10', t_m8_link10='$t_m8_link10',

									t_m9_head='$t_m9_head', 	t_m9_link='$t_m9_link', 	t_m9_name1='$t_m9_name1', 	t_m9_link1='$t_m9_link1', 
 									t_m9_name2='$t_m9_name2', 	t_m9_link2='$t_m9_link2', 	t_m9_name3='$t_m9_name3', 	t_m9_link3='$t_m9_link3', 
 									t_m9_name4='$t_m9_name4', 	t_m9_link4='$t_m9_link4', 	t_m9_name5='$t_m9_name5', 	t_m9_link5='$t_m9_link5',
 									t_m9_name6='$t_m9_name6', 	t_m9_link6='$t_m9_link6', 	t_m9_name7='$t_m9_name7', 	t_m9_link7='$t_m9_link7',
 									t_m9_name8='$t_m9_name8', 	t_m9_link8='$t_m9_link8',	t_m9_name9='$t_m9_name9', 	t_m9_link9='$t_m9_link9',
 									t_m9_name10='$t_m9_name10', t_m9_link10='$t_m9_link10',


 									t_m_design='$t_m_design',	t_m_bgcolor='$t_m_bgcolor', t_m_font_color='$t_m_font_color', t_m_height='$t_m_height'

 									where site = '$site'";
 	$result=mysql_query($query,$connect );
	}



 
	/**** 3.메인페이지 슬라이드 설정 ****/

	if($category == 3)
	{

  		extract($_REQUEST);
 		$filename1 = $_FILES[image1][tmp_name];
 		$handle1 = fopen($filename1,"rb");
 		$size1 = GetImageSize($_FILES[image1][tmp_name]);
 		$width1 = $size1[0];
 		$height1 = $size1[1];
 		$imageblob1 = addslashes(fread($handle1, filesize($filename1)));
 		$filesize1 = $filename1;
 		fclose($handle1);
 		//메모리 오류 방지


 		ini_set("memory_limit" , -1);

 		extract($_REQUEST);
 		$filename2 = $_FILES[image2][tmp_name];
 		$handle2 = fopen($filename2,"rb");
 		$size2 = GetImageSize($_FILES[image2][tmp_name]);
 		$width2 = $size2[0];
 		$height2 = $size2[1];
 		$imageblob2 = addslashes(fread($handle2, filesize($filename2)));
 		$filesize2 = $filename;
 		fclose($handle2);
 		//메모리 오류 방지
 
  		ini_set("memory_limit" , -1);

 		extract($_REQUEST);
 		$filename3 = $_FILES[image3][tmp_name];
 		$handle3 = fopen($filename3,"rb");
 		$size3 = GetImageSize($_FILES[image3][tmp_name]);
 		$width3 = $size3[0];
 		$height3 = $size3[1];
 		$imageblob3 = addslashes(fread($handle3, filesize($filename3)));
 		$filesize3 = $filename3;
 		fclose($handle);
 		//메모리 오류 방지
 		
 		  if ($delete_image1)
 			{
   				$query="UPDATE site_config SET image1 = '' , width1 = '', height1 = '', filesize1 = '' where site = '$site'";
 				$result=mysql_query($query,$connect );
 			}

 		  if ($delete_image2)
 			{
   				$query="UPDATE site_config SET image2 = '' , width2 = '', height2 = '', filesize2 = '' where site = '$site'";
 				$result=mysql_query($query,$connect );
 			}

 		  if ($delete_image3)
 			{
   				$query="UPDATE site_config SET image3 = '' , width3 = '', height3 = '', filesize3 = '' where site = '$site'";
 				$result=mysql_query($query,$connect );
 			}
 		

 		  if ($imageblob1)
 			{
				$query="UPDATE site_config SET image1 = '$imageblob1' , width1 = '$width1', height1 = '$height1', filesize1 = '$filesize1' where site = '$site'";
 				$result=mysql_query($query,$connect );
			}

 		  if ($imageblob2)
 			{
				$query="UPDATE site_config SET image2 = '$imageblob2' , width2 = '$width2', height1 = '$height2', filesize2 = '$filesize2' where site = '$site'";
 				$result=mysql_query($query,$connect );
			}

 		  if ($imageblob3)
 			{
				$query="UPDATE site_config SET image3 = '$imageblob3' , width3 = '$width3', height3 = '$height3', filesize3 = '$filesize3' where site = '$site'";
 				$result=mysql_query($query,$connect );
			}


 		$query="UPDATE site_config SET 	slide_type='$slide_type', slide_m_title1='$slide_m_title1', slide_s_title1='$slide_s_title1', slide_btn_name='$slide_btn_name', 
 										slide_btn_link='$slide_btn_link', slide_btn_color='$slide_btn_color', slide_m_title2='$slide_m_title2', slide_s_title2='$slide_s_title2',
										slide_m_title3='$slide_m_title3', slide_s_title3='$slide_s_title3'
 										where site = '$site'";
 		$result=mysql_query($query,$connect );
	}
 
 
 	/**** 4. 메인화면 Notice 설정 ****/

	if($category == 4)
	{

  		extract($_REQUEST);
 		$filename1 = $_FILES[notice1_image][tmp_name];
 		$handle1 = fopen($filename1,"rb");
 		$size1 = GetImageSize($_FILES[notice1_image][tmp_name]);
 		$width1 = $size1[0];
 		$height1 = $size1[1];
 		$imageblob1 = addslashes(fread($handle1, filesize($filename1)));
 		$filesize1 = $filename1;
 		fclose($handle1);
 		//메모리 오류 방지

 		ini_set("memory_limit" , -1);

 		extract($_REQUEST);
 		$filename2 = $_FILES[notice2_image][tmp_name];
 		$handle2 = fopen($filename2,"rb");
 		$size2 = GetImageSize($_FILES[notice2_image][tmp_name]);
 		$width2 = $size2[0];
 		$height2 = $size2[1];
 		$imageblob2 = addslashes(fread($handle2, filesize($filename2)));
 		$filesize2 = $filename;
 		fclose($handle2);
 		//메모리 오류 방지
 
  		ini_set("memory_limit" , -1);

 		
 		  if ($delete_image4)
 			{
   				$query="UPDATE site_config SET notice1_image = '' , notice1_width = '', notice1_height = '', notice1_filesize = '' where site = '$site'";
 				$result=mysql_query($query,$connect );
 			}

 		  if ($delete_image5)
 			{
   				$query="UPDATE site_config SET notice2_image = '' , notice2_width = '', notice2_height = '', notice2_filesize = '' where site = '$site'";
 				$result=mysql_query($query,$connect );
 			}
 		
 		  if ($imageblob1)
 			{
				$query="UPDATE site_config SET notice1_image = '$imageblob1' , notice1_width = '$width1', notice1_height = '$height1', notice1_filesize = '$filesize1' where site = '$site'";
 				$result=mysql_query($query,$connect );
			}

 		  if ($imageblob2)
 			{
				$query="UPDATE site_config SET notice2_image = '$imageblob2' , notice2_width = '$width2', notice2_height = '$height2', notice2_filesize = '$filesize2' where site = '$site'";
 				$result=mysql_query($query,$connect );
			}


 		$result=mysql_query($query,$connect );
	}
 
 
 
	/**** 5. 팝업이미지 관리 ****/
	
 	if($category == 5)
 	{
 	  extract($_REQUEST);
 		$filename1 = $_FILES[popup_image][tmp_name];
 		$handle1 = fopen($filename1,"rb");
 		$size1 = GetImageSize($_FILES[popup_image][tmp_name]);
 		$width1 = $size1[0];
 		$height1 = $size1[1];
 		$imageblob1 = addslashes(fread($handle1, filesize($filename1)));
 		$filesize1 = filesize($filename1);
 		fclose($handle1);
 		//메모리 오류 방지


		if (!$list)
		{
		$sql="Insert 7G_Skiresort_popup (Title, Start_date, End_date, X_Position, Y_Position, image, width, height, filesize, Link_url)
		VALUES ('$popup_title', '$popup_start', '$popup_end', '$popup_x', '$popup_y','$imageblob1', '$width1', '$height1', '$filesize1', '$popup_link')";

		if (mysqli_query($link, $sql)) { } else {echo "Error: " . $sql . "<br>" . mysqli_error($link);}
		mysqli_close($link);
		}

		if ($list == 3)
		{
				
 		  if ($imageblob1)
 			{
				$query="UPDATE 7G_Skiresort_popup SET Title = '$popup_title', Start_date = '$popup_start', End_date = '$popup_end', 
													  X_Position = '$popup_x', Y_Position = '$popup_y',  
													  image = '$imageblob1', width = '$width1', height = '$height1', filesize = '$filesize1', Link_url = '$popup_link'
						 where No = '$popup_no'";
 				$result=mysql_query($query,$connect );
			}
		
		  if (!$imageblob1)
 			{
				$query="UPDATE 7G_Skiresort_popup SET Title = '$popup_title', Start_date = '$popup_start', End_date = '$popup_end', 
													  X_Position = '$popup_x', Y_Position = '$popup_y', Link_url = '$popup_link'
						 where No = '$popup_no'";
 				$result=mysql_query($query,$connect );
			}
			
			
 			$result=mysql_query($query,$connect );
 				
		}

 		echo "<script>location.href='index.html?category=$category';</script>";
	
	
	}

 	/**** 6. 찾아오시는길 정보 업데이트 ****/
	
 	if($category == 6)
	{
 	$query="UPDATE site_config SET 	map_main_title='$map_main_title', map_address='$map_address', map_phone='$map_phone', map_source='$map_source', 
 									map_frame_code='$map_frame_code', map_bgcolor='$map_bgcolor', map_space='$map_space'
 									where site = '$site'";
 	$result=mysql_query($query,$connect );
	}

 	/**** 7. 풋터 정보 업데이트 ****/
	
 	if($category == 7)
	{
  		extract($_REQUEST);
 		$filename = $_FILES[company_logo][tmp_name];
 		$handle = fopen($filename,"rb");
 		$size = GetImageSize($_FILES[company_logo][tmp_name]);
 		$width = $size[0];
 		$height = $size[1];
 		$imageblob = addslashes(fread($handle, filesize($filename)));
 		$filesize = $filename;
 		fclose($handle);
 		//메모리 오류 방지

	
 		if ($delete_logo)
 			{
   				$query="UPDATE site_config SET company_logo = '' , logo_width = '', logo_height = '', logo_filesize = '' where site = '$site'";
 				$result=mysql_query($query,$connect );
 			}
	
 		if ($imageblob)
 			{
				$query="UPDATE site_config SET company_logo = '$imageblob' , logo_width = '$width', logo_height = '$height', logo_filesize = '$filesize' where site = '$site'";
 				$result=mysql_query($query,$connect );
			}

	
	
	
 		$query="UPDATE site_config SET 	f_m1_head='$f_m1_head', f_m1_name1='$f_m1_name1', f_m1_link1='$f_m1_link1', 
 										f_m1_name2='$f_m1_name2', f_m1_link2='$f_m1_link2', f_m1_name3='$f_m1_name3', f_m1_link3='$f_m1_link3',
 									
										f_m2_head='$f_m2_head', f_m2_name1='$f_m2_name1', f_m2_link1='$f_m2_link1', 
 									f_m2_name2='$f_m2_name2', f_m2_link2='$f_m2_link2', f_m2_name3='$f_m2_name3', f_m2_link3='$f_m2_link3', 								
 									
 									company_name = '$company_name', company_no='$company_no', company_address='$company_address', company_phone='$company_phone', 
 									company_fax='$company_fax', company_email='$company_email', company_security='$company_security', copyright='$copyright'
 				where site = '$site'";
 		$result=mysql_query($query,$connect );
	}

 	if($category == 31)
	{
	extract($_REQUEST);
 	$query="UPDATE Access_Deny SET url='$deny_url', country='$deny_country', ip='$deny_ip' where site = '$site'";
 	
 	$result=mysql_query($query,$connect );
	}


 	echo "<script>location.href='index.html?category=$category';</script>";

?>

	<!-- footer for AUGMENT-SKI -->
		<? include 'footer.html'; ?>
	<!-- end of footer -->
	
</body>

</html>