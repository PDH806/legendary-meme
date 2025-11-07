<?php
/**************** 문자전송하기 예제 필독항목 ******************/
/* 동일내용의 문자내용을 다수에게 동시 전송하실 수 있습니다
 * 대량전송시에는 반드시 컴마분기하여 1천건씩 설정 후 이용하시기 바랍니다. (1건씩 반복하여 전송하시면 초당 10~20건정도 발송되며 컨텍팅이 지연될 수 있습니다.)
 * 전화번호별 내용이 각각 다른 문자를 다수에게 보내실 경우에는 send 가 아닌 send_mass(예제:curl_send_mass.html)를 이용하시기 바랍니다
 */
/****************** 인증정보 시작 ******************/

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

 	$verify_code 	= rand(100000, 999999);
 	$code 			= $verify_code;
 	$log 			= time();
	$phone			= trim($_POST["no"]);
 	$phone			= align_tel($phone);
 	$id				= trim($_POST["id"]);
 	$case 			= trim($_POST["kind"]);
 	$name 			= trim($_POST["name"]);
 
 	// $link			= mysqli_connect(localhost, skiresort, ll170505, skiresort);
  $link			= mysqli_connect("localhost", "skiresort", "wints!", "skiresort");
 
 	$query = "SELECT * FROM 7G_Skiresort_Member WHERE MEMBER_ID = '$id' and PHONE = '$phone' limit 1";
 	$result = mysqli_query($link, $query);
 	$row	= mysqli_fetch_array($result);
 
 	if ($phone == $row[PHONE] and $case != '1')
 		{
 			echo "<span class='text-success'>&nbsp;👍&nbsp;&nbsp; $phone 본인 전화번호가 확인되었습니다. 비밀번호 변경이 가능합니다. $phone // $row[PHONE]<br></span>";  		
  		}
 
  		elseif ($phone != $row[PHONE] and $case != '1')
  		
  		{
      		echo "<span class='text-danger'>&nbsp;👎&nbsp;&nbsp; $phone 등록하신 전화번호가 불일치합니다. 비밀번호 변경이 불가능합니다. $phone // $row[PHONE]<br></span>";
  		}
 
  	$query1 = "SELECT * FROM `7G_Skiresort_Member` WHERE `MEMBER_NAME` = '$name' and `PHONE` = '$phone'";
 	$result1 = mysqli_query($link, $query1);
 	$row1	= mysqli_fetch_array($result1);
	$total_record = mysqli_num_rows($result1);		

	if($case == 1 and $total_record == 1){
	
		echo "<span class='text-danger'>&nbsp;👎&nbsp;&nbsp;기존 자격증을 보유하신 회원님입니다. <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;인증번호 6자리 검증후 비밀번호 등록하시면 회원등록이 완료됩니다.<br></span>";
	
	}

  	$query2 = "SELECT * FROM 7G_Skiresort_Member WHERE PHONE = '$phone'";
 	$result2 = mysqli_query($link, $query2);
 	$row2	= mysqli_fetch_array($result2);
	$total_record2 = mysqli_num_rows($result2);		

	//if($case == 1 and $total_record2 > 1){echo "<span class='text-danger'>&nbsp;👎&nbsp;&nbsp;입력하신 전화번호가 이미 회원가입에 사용된 전화번호입니다!!!<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;본인 전화이거나 문제해결이 필요하시면 협회로 연락주세요 !!!<br></span>";}
	// else if($case == 1 and $total_record2 == 0){echo "<span class='text-danger'>&nbsp;👎&nbsp;&nbsp;인증번호 6자리를 보내드렸습니다. <br></span>";}

 	if ($case == '1')
 	{
	 	$phone			= trim($_POST["phone"]);
 		$phone			= align_tel($phone);
		$insert 		= "INSERT INTO 7G_Skiresort_Phone_Check ( name, id, phone, code, log ) VALUES ( '$name', '$id', '$phone', '$code', '$log' )";

		mysqli_query($link, $insert);

		$msg1	= "$name"."님($id) 한국스키장경영협회 회원가입 인증번호 [$code]"; 	
 	}
 
  	if ($phone == $row[PHONE] and $case <> 1){
	 	$name	= $row[MEMBER_NAME];
		$insert = "INSERT INTO 7G_Skiresort_Phone_Check ( name, id, phone, code, log ) VALUES ( '$name', '$id', '$phone', '$code', '$log' )";

		mysqli_query($link, $insert);

		$msg1	= "$name"."님($id) 한국스키장경영협회 비밀번호 변경 인증번호 [$code]"; }


 $sms_url = "https://apis.aligo.in/send/"; // 전송요청 URL
 $sms['user_id'] = "wints"; // SMS 아이디
 $sms['key'] = "tfcoquci8ovaem2zzflk488qpseio40i";//인증키
/****************** 인증정보 끝 ********************/

/****************** 전송정보 설정시작 ****************/
$_POST['msg'] = $msg1; // 가능한 문자열만 사용하실 수 있습니다. (이모지 사용불가능)
$_POST['receiver'] = $phone; // 수신번호
$_POST['destination'] = ''; // 수신인 %고객명% 치환
$_POST['sender'] =''; // 발신번호
$_POST['rdate'] = ''; // 예약일자 - 20161004 : 2016-10-04일기준
$_POST['rtime'] = ''; // 예약시간 - 1930 : 오후 7시30분
$_POST['testmode_yn'] = ''; // Y 인경우 실제문자 전송X , 자동취소(환불) 처리
$_POST['subject'] = ''; //  LMS, MMS 제목 (미입력시 본문중 44Byte 또는 엔터 구분자 첫라인)
// $_POST['image'] = '/tmp/pic_57f358af08cf7_sms_.jpg'; // MMS 이미지 파일 위치 (저장된 경로)
$_POST['msg_type'] = 'SMS'; //  SMS, LMS, MMS등 메세지 타입을 지정
// ※ msg_type 미지정시 글자수/그림유무가 판단되어 자동변환됩니다. 단, 개행문자/특수문자등이 2Byte로 처리되어 SMS 가 LMS로 처리될 가능성이 존재하므로 반드시 msg_type을 지정하여 사용하시기 바랍니다.
/****************** 전송정보 설정끝 ***************/

$sms['msg'] 		= stripslashes($_POST['msg']);
$sms['receiver'] 	= $_POST['receiver'];
$sms['destination'] = $_POST['destination'];
$sms['sender'] 		= $_POST['sender'];
$sms['rdate'] 		= $_POST['rdate'];
$sms['rtime'] 		= $_POST['rtime'];
$sms['testmode_yn'] = empty($_POST['testmode_yn']) ? '' : $_POST['testmode_yn'];
$sms['title'] 		= $_POST['subject'];
$sms['msg_type'] 	= $_POST['msg_type'];

// 만일 $_FILES 로 직접 Request POST된 파일을 사용하시는 경우 move_uploaded_file 로 저장 후 저장된 경로를 사용하셔야 합니다.
if(!empty($_FILES['image']['tmp_name'])) {
	$tmp_filetype = mime_content_type($_FILES['image']['tmp_name']); 
	if($tmp_filetype != 'image/png' && $tmp_filetype != 'image/jpg' && $tmp_filetype != 'image/jpeg') $_POST['image'] = '';
	else {
		$_savePath = "./".uniqid(); // PHP의 권한이 허용된 디렉토리를 지정
		if(move_uploaded_file($_FILES['file']['tmp_name'], $_savePath)) {
			$_POST['image'] = $_savePath;
		}
	}
}

// 이미지 전송 설정
if(!empty($_POST['image'])) {
	if(file_exists($_POST['image'])) {
		$tmpFile = explode('/',$_POST['image']);
		$str_filename = $tmpFile[sizeof($tmpFile)-1];
		$tmp_filetype = mime_content_type($_POST['image']);
		if ((version_compare(PHP_VERSION, '5.5') >= 0)) { // PHP 5.5버전 이상부터 적용
			$sms['image'] = new CURLFile($_POST['image'], $tmp_filetype, $str_filename);
			curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, true);
		} else {
			$sms['image'] = '@'.$_POST['image'].';filename='.$str_filename. ';type='.$tmp_filetype;
		}
	}
}
/*****/
$host_info = explode("/", $sms_url);
$port = $host_info[0] == 'https:' ? 443 : 80;

$oCurl = curl_init();
curl_setopt($oCurl, CURLOPT_PORT, $port);
curl_setopt($oCurl, CURLOPT_URL, $sms_url);
curl_setopt($oCurl, CURLOPT_POST, 1);
curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($oCurl, CURLOPT_POSTFIELDS, $sms);
curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
$ret = curl_exec($oCurl);
curl_close($oCurl);

// echo $ret;
// $retArr = json_decode($ret); // 결과배열
?>