<?
    $User_ID_Search 		= trim($_GET["MID"]);
	$User_ID_Search 		= preg_replace("/\s+/", "", $User_ID_Search);
	$special_pattern 		= "/[`~!@#$%^&*|\\\'\";:\/?^=^+_()<>]/";  //특수기호 정규표현식

    setcookie('Login_ID', '', time() + 0, '/');
	setcookie('rank', '', time() + 0, '/');

	include 'db_config.html';

	$guest_ip = $_SERVER["REMOTE_ADDR"];
	if ($guest_ip != "121.137.218.41")
	{
        echo " <script language='javascript'>
        alert(' $guest_ip 비정상적인 접근입니다. !!!');
        top.document.location.href = 'member_login.html'</script>";
	}

	$member_query= "SELECT * FROM $member_table where MEMBER_ID = '$User_ID_Search' limit 1";
	$member_result=mysql_query($member_query,$connect );
	$member=mysql_fetch_array($member_result);
 	$total_member = mysql_num_rows($member_result);

	setcookie('Login_ID', $member[MEMBER_ID], time() + 600, '/');
	setcookie('rank', $member[RANK], time() + 600, '/');
	 
 	if ($total_member == 1) {
 		if ($member[RANK] == 9){echo " <script language='javascript'>top.document.location.href = 'admin/index.html'</script>";}
 		if ($member[RANK] == 8){echo " <script language='javascript'>top.document.location.href = 'admin/index2.html'</script>";}
		if ($member[RANK] == 0){echo " <script language='javascript'>top.document.location.href = '../mypage'</script>";}
    }
    
    else
    
    {
        setcookie('Login_ID', '', time() + 0, '/');
		setcookie('rank', '', time() + 0, '/');

        echo " <script language='javascript'>
        alert('회원 ID 또는 비밀번호가 존재하지 않습니다 !!!');
        top.document.location.href = 'member_login.html'</script>";
	}

?>