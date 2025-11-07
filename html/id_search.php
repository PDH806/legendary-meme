<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<?
	require_once("DBController.php");
	$db_handle = new DBController();

	include 'db_config.html';
	
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

	$email 			= trim($_POST["EMAIL"]);
	$phone 		= trim($_POST["PHONE"]);

	if(!$email){
		echo "<script>alert('회원 이메일 [필수] 입력입니다.')</script>";
		exit;
	}
	if(!$phone){
		echo "<script>alert('전화번호 [필수] 입력입니다.')</script>";
		exit;
	}

	 $phone 	= align_tel($phone);

	/*
	$connect = mysql_connect("dbserver","skiresort","ll170505");
	mysql_select_db( "skiresort",$connect);
	*/

	define('ESCAPE_PATTERN',  '/(and|or).*(union|select|insert|update|delete|from|where|limit|create|drop).*/i');
	define('ESCAPE_REPLACE',  '');
	function sql_escape_string($str){
		if(defined('ESCAPE_PATTERN') && defined('ESCAPE_REPLACE')) {
			$pattern = ESCAPE_PATTERN;
			$replace = ESCAPE_REPLACE;

			if($pattern)
				$str = preg_replace($pattern, $replace, $str);
		}

		$str = call_user_func('addslashes', $str);

		return $str;
	}
    $query = "SELECT MEMBER_ID  FROM 7G_Skiresort_Member WHERE EMAIL = '".sql_escape_string($email)."' and PHONE = '".sql_escape_string($phone)."' ";
    $result = mysql_query($query,$connect);
    $row	= mysql_fetch_array($result);
	
	 if(mysql_num_rows($result)){
		echo "
			<script>
			$('.input-group.searchedID', parent.document).empty().append(`<div style='margin-bottom:15px;padding:0px 10px ; line-height:2.5;height: calc(1.5em + 0.75rem + 2px);font-size:1.3em;border: 1px solid #ced4da;'>귀하의 아이디는 : <span style='font-weight:bold;color:#008095'>{$row['MEMBER_ID']}</span>입니다.</div>`);
			</script>
		";
	 } else {
		echo "<script>alert('등록된 회원이 없습니다.\\n관리자에게 문의하시기 바랍니다.')</script>";
		exit;
	 }
	



?>