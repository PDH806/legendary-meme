<?php

// echo $$_SERVER['REMOTE_ADDR'];

// if($_SERVER['REMOTE_ADDR']=='211.238.124.122'){
// 	echo "
// 		<script>
// 			parent.location.href='/';
// 		</script>
// 	";
// }



  // error_reporting( E_ALL );
  // ini_set( "display_errors", 1 );

	// echo $_SERVER['DOCUMENT_ROOT'].'-';
	/*
	$servername	= "dbserver"; $username = "skiresort"; $password = "ll170505"; $dbname = "skiresort";
	$connect = mysql_connect($servername, $username, $password); $link = mysqli_connect($servername, $username, $password, $dbname); mysql_select_db($dbname,$connect);
	*/
	include_once $_SERVER['DOCUMENT_ROOT'].'/db_config.html';


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

	$phone_code     = $_POST['code'];
	$member_name    = $_POST['member_name'];
	$member_id    	= $_POST['member_id'];
	$password   	= $_POST['password'];

	$repassword     = $_POST['repassword'];
	$member_phone   = align_tel($_POST['member_phone']);
	$member_email	= $_POST['member_email'];
	$member_birth	= $_POST['member_birth'];
	$GENDER   	= $_POST['GENDER'];
	$join_date      = date('Ymd');
	$pw_date      	= date('Ymd') + 180;
	$point			= 1000;
	$member_rank	= 0;

	if(!$phone_code or $phone_code == "" or $member_id == "" or !$member_id){echo "<script language='javascript'>alert('잘못된 접근 경로입니다.');top.document.location.href ='index.html';</script>";}

	// 인증코드 일치여부 확인
	$sql 	= "SELECT * FROM 7G_Skiresort_Phone_Check WHERE id = '$member_id' and phone = '$member_phone' and code = '$phone_code' order by no DESC limit 1";

		$result		= mysqli_query($link, $sql);
	$numrow 	= mysqli_num_rows($result);
	if($numrow != 1){echo "<script language='javascript'>alert('인증코드가 불일치합니다..');top.document.location.href ='index.html';</script>";}




    // 기존에 전화번호가 등록되어 있는 경우. 미등록자들 자동등록 루틴
  	$query1 = "SELECT * FROM `7G_Skiresort_Member` WHERE `MEMBER_NAME` = '$member_name' and `PHONE` = '$member_phone'";
	$result1	= mysqli_query($link, $query1);
	$total_record 	= mysqli_num_rows($result1);
	// $result1 = mysql_query($query1,$link);
 	// $row1	= mysql_fetch_array($result1);
	// $total_record = mysql_num_rows($result1);		

	if($total_record == 1){		//비밀번호수정
		if($password == $repassword) 
  			{
    			$encrypted_password = password_hash($password, PASSWORD_DEFAULT);

				/*
				$connect = mysql_connect("dbserver","skiresort","ll170505");
				mysql_select_db( "skiresort",$connect);
				*/

  				$query="UPDATE 7G_Skiresort_Member SET PASSWORD = '$encrypted_password', MEMBER_ID = '$member_id', RANK = '$member_rank', AGREEMENT_DATE = '$join_date' WHERE `MEMBER_NAME` = '$member_name' and `PHONE` = '$member_phone'";
 				// $result=mysql_query($query,$link);
				 if (mysqli_query($link, $query)) {
					setcookie('Login_ID', $member_id, time() + 60*60*24);
					echo "
						<script>
							alert('성공적으로 처리되었습니다.');
							parent.location.href='mypage.html?category=1';
						</script>
					";
					exit;
				}				
		}
	}

	elseif ($total_record == 0)   //회원가입
		{

// 비밀번호 암호화
    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
    setcookie('Login_ID', $member_id, time() + 60*60*24);
    
// $HASH = password_hash($PASSWORD , PASSWORD_DEFAULT);

	//$connect = mysqli_connect("dbserver", "skiresort", "ll170505", "skiresort");

	if (!$link) {
    	die("Connection failed: " . mysqli_connect_error());
	}


//if($_SERVER['REMOTE_ADDR']=='210.97.98.158'){

	// 회원사진 업로드
	// ini_set("upload_max_filesize",1024000*5); 
	// $upload_max_filesize = ini_get('upload_max_filesize');

	// $tmp_file  = $_FILES['file']['tmp_name'];
	// $filesize  = $_FILES['file']['size'];
	// $filename  = $_FILES['file']['name'];
   
	//   if ($filename) {
  //       if ($_FILES['file']['error'] == 1) {
  //           $file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
  //       }
  //       else if ($_FILES['file']['error'] != 0) {
  //           $file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
  //       }
		
  //   }
	//  if (is_uploaded_file($tmp_file)) {
	// 	$timg = @getimagesize($tmp_file);
	// 	$ext = substr($timg['mime'], strpos($timg['mime'],'/')+1 );

	// 	// image type
  //       if ( preg_match("/\.(jpg|png|gif|jpeg)$/i", $filename) ) {
  //           if ($timg['2'] < 1 || $timg['2'] > 16)
  //               $file_upload_msg .= '이미지 파일이 아닙니다.\\n';
  //       }
        
  //     	$dest_file = $_SERVER['DOCUMENT_ROOT'].'/mypage/member_imgs/'.$member_id.'.'.$ext ;
	// 			chmod($_SERVER['DOCUMENT_ROOT'].'/mypage/member_imgs/'.$member_id.'.'.$ext, 0757);
	

	// 	// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
  //   $error_code = move_uploaded_file($tmp_file, $dest_file);
	// 	if(!$error_code) $file_upload_msg .= "파일업로드 오류";
  //   chmod($dest_file, 0757);
  //   }
	// if($file_upload_msg){
	// 	echo "<script>alert(`$file_upload_msg`);</script>";
	// 	exit;
	// }
//}		//ip

$sql = "INSERT INTO 7G_Skiresort_Member (
					MEMBER_NAME,
					MEMBER_ID,
					PASSWORD,
					PHONE,
					EMAIL,
					BIRTH,
					RANK,
					GENDER,
					AGREEMENT_DATE
				
					)

					VALUES (
					'$member_name',
					'$member_id',
					'$encrypted_password',
					'$member_phone',
					'$member_email',
					'$member_birth',
					'$member_rank',
					'$GENDER',
					'$join_date'
				
					 )";
// echo $sql;
// if($total_record==1){
// 	echo "
// 		<script>
// 			alert('성공적으로 비밀번호가 수정되었습니다.');
// 			parent.location.href='member_login.html';
// 		</script>
// 	";	
// }

if (mysqli_query($link, $sql)) {
	echo "
		<script>
			alert('성공적으로 회원가입이 되었습니다.');
			parent.location.href='mypage.html?category=1';
		</script>
	";
	exit;
    echo "
<section id='contact'>
    <div class='container'>
      <div class='row'>
        <div class='col-lg-12 text-center'>
          <p class='text-success'>회원 등록</p>
        </div>
      </div>

    <div class='container'>
      <div class='row'>
        <div class='col-lg-12 text-center'>
        	<table class = 'table table-striped table-sm' width = 80%>
  				<thead class='thead-dark'>

            		<tr>
            			<th>성명</th><td class='text-success'>$member_name</td>
            		</tr>
            		
					<tr>
            			<th>전화번호</th><td class='text-success'>$member_id</td>
            		</tr>

					<tr>
            			<th>전화번호</th><td class='text-success'>$member_phone</td>
            		</tr>

					<tr>
            			<th>이메일</th><td class='text-success'>$member_email</td>
            		</tr>

					<tr>
            			<th>생년월일</th><td class='text-success'>$member_birth</td>
            		</tr>

					<tr>
            			<th>가입일</th><td class='text-success'>$join_date</td>
            		</tr>

					<tr>
            			<th>신규 포인트</th><td class='text-success'>$point</td>
            		</tr>

         		</table>

         	<a href = 'index.html'>
			<button class='btn btn-success btn-sm text-uppercase' type='button'>확인</button></a>

        </div>
      </div>

</section>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
}

}
mysqli_close($link);

?>
