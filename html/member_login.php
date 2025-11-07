<?
    $User_ID_Search 		= trim($_POST["MEMBER_ID"]);
		// $User_ID_Search = 'admin01';
    $PIN_No_Search 			= trim($_POST["PASSWORD"]);
		// $PIN_No_Search = 'sbak34731277';
    $case 					= trim($_GET["case"]);
    $return_page 			= trim($_GET["return_page"]);
    $type 					= trim($_POST["type"]);
	
	$User_ID_Search = preg_replace("/\s+/", "", $User_ID_Search);

	$special_pattern = "/[`~!@#$%^&*|\\\'\";:\/?^=^+_()<>]/";  //특수기호 정규표현식

	// if( preg_match($special_pattern, $User_ID_Search) ){  //받은 아이디에 특수기호가있으면

		// setcookie('Login_ID', '', 0, '/');
		// setcookie('rank', 0, 0, '/');

        // echo " <script language='javascript'>
        // alert('회원ID에 특수문자를 입력하실 수 없습니다.');
        // top.document.location.href = 'member_login.html'</script>";
	// }

	include 'db_config.html';

	$member_query= "SELECT * FROM $member_table where MEMBER_ID = '$User_ID_Search'";
	// echo $member_query;
	$member_result=mysql_query($member_query,$connect );
	$member=mysql_fetch_array($member_result);
 	$total_member = mysql_num_rows($member_result);

	setcookie('Login_ID', $member[MEMBER_ID], time() + 60*60, '/');
	setcookie('rank', $member[RANK], time() + 600, '/');
	
	if (!$User_ID_Search) {
        echo " <meta charset='utf-8'><script language='javascript'>
        		alert('회원아이디(ID)를 입력해 주세요 !!!')
					top.document.location.href = 'member_login.html?MEMBER_ID=$User_ID_Search&Case=1'
					</script>";
    }

	if (!$PIN_No_Search) {
		 echo " <meta charset='utf-8'><script language='javascript'>
        		alert('비밀번호(Password)를 입력해 주세요 !!!')
					top.document.location.href = 'member_login.html?MEMBER_ID=$User_ID_Search&Case=3'
					</script>";
    }
	

	if($_SERVER['REMOTE_ADDR']=='210.97.98.158'){

		/*echo password_hash($PIN_No_Search, PASSWORD_DEFAULT);
		echo '<br>'.$member['PASSWORD'];
		exit;
		*/
		
	}
	

	//if($User_ID_Search != 'newin0162'){ //PASSWORD_BCRYPT
		// $hash = password_hash('1111', PASSWORD_DEFAULT);
		// echo password_verify('1111', $hash)."<br>";
    // if (password_verify('1111', $hash)) {
    //     echo "성공";
    // } else {
    //     echo "실패";
    // }

// echo $PIN_No_Search.'<br>-'.password_hash($PIN_No_Search,PASSWORD_DEFAULT).'<br>-'.$member[PASSWORD];
 	if (password_verify($PIN_No_Search, $member[PASSWORD]) /* || $User_ID_Search=='cline24' */) {
		// echo "ok";
		if ($type == 'm1'){echo " <script language='javascript'>top.document.location.href = '../mypage/'</script>";}
 		if ($type == 'm4'){echo " <script language='javascript'>top.document.location.href = '../mypage/index.html?category=4'</script>";}
 		if ($return_page){echo "<script language='javascript'>top.document.location.href = '".$return_page."'</script>";}
 		if ($member[RANK] == 9){echo " <script language='javascript'>top.document.location.href = 'admin/index.html'</script>";}
 		if ($member[RANK] == 8 or $member[RANK] == 7){echo " <script language='javascript'>top.document.location.href = 'admin/index2.html'</script>";}
		if ($member[RANK] == 0){echo " <script language='javascript'>top.document.location.href = '../mypage'</script>";}
    }
    
    else
    // echo "no";
    {
    	setcookie('Login_ID', '', time() + 0, '/');
			setcookie('rank', '', time() + 0, '/');

        echo " <meta charset='utf-8'><script language='javascript'>
		        alert('회원 ID 또는 비밀번호가 존재하지 않습니다 !!!');
				    top.document.location.href = 'member_login.html';
				</script>";
	}
	//}

?>