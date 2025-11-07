<!DOCTYPE html>
<html>
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

	$password 			= trim($_POST["password"]);
	$repassword 		= trim($_POST["repassword"]);
	$phone 				= trim($_POST["member_phone"]);
	$id 				= trim($_POST["member_id"]);
	$code 				= trim($_POST["code"]);

	$phone 	= align_tel($phone);
	
    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

	$connect = mysql_connect("dbserver","skiresort","ll170505");
	mysql_select_db( "skiresort",$connect);
	
    $query = "SELECT * FROM 7G_Skiresort_Member WHERE MEMBER_ID = '$id' and PHONE = '$phone' limit 1";
    $result = mysql_query($query,$connect);
    $row	= mysql_fetch_array($result);
 
if ($phone == $row[PHONE])
{
	

//--+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+
// 	CODE 일치여부 확인
//--+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+

if(!empty($code))
	{
  		$query = "SELECT * FROM 7G_Skiresort_Phone_Check WHERE id = '$id' and phone = '$phone' and code = '$code' order by no DESC limit 1";
  		$user_count = $db_handle->numRows($query);

  		if($user_count == 1) 
  		{
  		
  				if($password == $repassword) 
  					{
  						$query="UPDATE 7G_Skiresort_Member SET PASSWORD = '$encrypted_password' where MEMBER_ID = '$id'";
 						$result=mysql_query($query,$connect );
 						
					  	echo "<span class='text-success'>&nbsp;👍&nbsp;&nbsp;비밀번호가 변경되었습니다.<br>
					  	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;변경된 비밀번호로 로그인하세요!!!<br>
					  	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;곧 로그인 화면으로 이동합니다!!!</span>
					  	    
							<script type='text/javascript'>
								setTimeout(location.href='member_login.html',3000);
							</script>
					  	    ";
			  		}
		}



	}

}
else
{
      		echo "<span class='text-danger'>&nbsp;👎&nbsp;&nbsp;입력하신 ID/전화번호/인증번호/패스워드 등이<br>
      		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;상호 일치하지 않습니다.<br></span>";
}

?>