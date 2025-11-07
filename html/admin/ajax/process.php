<script
  src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
  integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
  crossorigin="anonymous"></script>
<?php
	echo "<meta charset='utf-8' />";
	include_once "../../db_config.html";
	$mode = $_POST['mode'];
	if($mode=='mUserInfo'){ 
		$q = "SELECT MEMBER_ID, MEMBER_NAME , TRAN_DATE, TRAN_TIME, LICENSE_NO, ZIPCODE, ADDR1, ADDR2, ADDR3, PRODUCT_CODE, 
		( select PHOTO3 from 7G_Skiresort_Member WHERE MEMBER_ID=at.MEMBER_ID) PHOTO3 ,
		( select PHONE from 7G_Skiresort_Member WHERE MEMBER_ID=at.MEMBER_ID) PHONE
		FROM 7G_License_Renew at where NO=$_POST[NO]";
		//echo $q;
		$rs = mysqli_query($link, $q);
		$row = mysqli_fetch_array($rs);
		
		// $member_imgs_jpg = "../../mypage/member_imgs/$row[MEMBER_ID]".".jpg";
		// $member_imgs_jpeg = "../../mypage/member_imgs/$row[MEMBER_ID]".".jpeg";
		// $member_imgs_png = "../../mypage/member_imgs/$row[MEMBER_ID]".".png";
		// $member_imgs_gif = "../../mypage/member_imgs/$row[MEMBER_ID]".".gif";

		// if ($row[PHOTO3]){$img_url = "/data/".$row[PHOTO3];}else{$img_url = '/data/no_image.jpg';}
		// if ($row[image]){$img_url = "../../mypage/view3.html?id=".$row[MEMBER_ID];}

		// if (is_file($member_imgs_jpg)){$img_url ="/mypage/member_imgs/{$row[MEMBER_ID]}.jpg";}
		// if (is_file($member_imgs_jpeg)){$img_url ="/mypage/member_imgs/{$row[MEMBER_ID]}.jpeg";}
		// if (is_file($member_imgs_png)){$img_url ="/mypage/member_imgs/{$row[MEMBER_ID]}.png";}
		// if (is_file($member_imgs_gif)){$img_url ="/mypage/member_imgs/{$row[MEMBER_ID]}.gif";}
	

		// 회원이미지 불러오기--------------
		$member_imgs_jpg 	= "../../member_imgs/$row[MEMBER_ID]".".jpg";
		$member_imgs_jpeg = "../../member_imgs/$row[MEMBER_ID]".".jpeg";
		$member_imgs_png 	= "../../member_imgs/$row[MEMBER_ID]".".png";
		$member_imgs_gif 	= "../../member_imgs/$row[MEMBER_ID]".".gif";

		//if ($row[PHOTO3]){$img_url = "../data/".$row[PHOTO3];}else{$img_url='../data/no_image.jpg';}
		if ($row[image]){$img_url = "/mypage/view3.html?id=".$row[MEMBER_ID];}

		if (is_file($member_imgs_jpg)){$img_url ="$member_imgs_jpg";}
		if (is_file($member_imgs_jpeg)){$img_url ="$member_imgs_jpeg";}
		if (is_file($member_imgs_png)){$img_url ="$member_imgs_png";}
		if (is_file($member_imgs_gif)){$img_url ="$member_imgs_gif";}
		// 회원이미지 불러오기--------------

		$img = "<img class='card-img-top' src = '$img_url' style=''>";
		
		$row[TRAN_TIME] = substr($row[TRAN_TIME],0,2).":".substr($row[TRAN_TIME],2,2).";".substr($row[TRAN_TIME],4,2);
		
		if($row['PRODUCT_CODE']==7000) $appliedItem = "자격증(A4)";
		else if($row['PRODUCT_CODE']==16000) $appliedItem = "ID카드";
		else if($row['PRODUCT_CODE']==20000) $appliedItem = "자격증 + ID카드";

		$returnHtml = "
			<table class='table card-table display dataTablesCard'>
				<thead>
					<tr style = 'font-size:14pt;color:black;'>
						<td colspan='2' style='text-align:right;font-weight:bold;font-size:2em;padding:0px;cursor:pointer;' onclick='$(\"#popLayer\").hide()'>X</td>
					</tr>
					<tr style = 'font-size:14pt;color:black;'>
						<td>사진</td>
						<td>$img</td>
					</tr>
					<tr style = 'font-size:14pt;color:black;'>
						<td>회원성명 / ID</td>
						<td>{$row['MEMBER_NAME']} / {$row['MEMBER_ID']}</td>
					</tr>
					<tr style = 'font-size:14pt;color:black;'>
						<td>신청일시</td>
						<td>$row[TRAN_DATE] $row[TRAN_TIME]</td>
					</tr>
					<tr style = 'font-size:14pt;color:black;'>
						<td>License</td>
						<td>$row[LICENSE_NO]</td>
					</tr>
					<tr style = 'font-size:14pt;color:black;'>
						<td>핸드폰</td>
						<td>$row[PHONE]
						</td>
					</tr>
					<tr style = 'font-size:14pt;color:black;'>
						<td>신청항목</td>
						<td>$appliedItem</td>
					</tr>
				</thead>
				<tbody>	
					
		";
		echo "
			<script>
				$('#popLayer', parent.document).empty().append(`$returnHtml`);
				parent.adjustPopup();
			</script>
		";
	}
?>