<?php
	include '../pc/config.php';
    include '../db_config.html';
		//sms 전송
        $aid='aid9f67f8c0265f400e89bb61a47af1379f830d7';
		$PAY_query	= "SELECT * FROM 7G_Master_Apply where AID = '$aid'";
		$PAY_result	= mysqli_query($link, $PAY_query);
        $PAY		= mysqli_fetch_array($PAY_result);

		
		$msg1 = "발송:(사)한국스키장경영협회.검정시험에 정상신청되었으며 상세내용은 공지사항 참고바람.";
		$member_name = $PAY["MEMBER_NAME"];
		$phone = $PAY["MEMBER_PHONE"];

		echo $PAY_query;
		echo $member_name.'-';
		echo $phone.'-';

		$sms_url = "https://apis.aligo.in/send/"; // 전송요청 URL
		$sms['user_id'] = "podong28"; // SMS 아이디
		$sms['key'] = "cqkqtv257enttzdn95msziftcnj39fxm";//인증키
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
	//  if(!empty($_FILES['image']['tmp_name'])) {
	// 	 $tmp_filetype = mime_content_type($_FILES['image']['tmp_name']); 
	// 	 if($tmp_filetype != 'image/png' && $tmp_filetype != 'image/jpg' && $tmp_filetype != 'image/jpeg') $_POST['image'] = '';
	// 	 else {
	// 		 $_savePath = "./".uniqid(); // PHP의 권한이 허용된 디렉토리를 지정
	// 		 if(move_uploaded_file($_FILES['file']['tmp_name'], $_savePath)) {
	// 			 $_POST['image'] = $_savePath;
	// 		 }
	// 	 }
	//  }
	 
	 // 이미지 전송 설정
	//  if(!empty($_POST['image'])) {
	// 	 if(file_exists($_POST['image'])) {
	// 		 $tmpFile = explode('/',$_POST['image']);
	// 		 $str_filename = $tmpFile[sizeof($tmpFile)-1];
	// 		 $tmp_filetype = mime_content_type($_POST['image']);
	// 		 if ((version_compare(PHP_VERSION, '5.5') >= 0)) { // PHP 5.5버전 이상부터 적용
	// 			 $sms['image'] = new CURLFile($_POST['image'], $tmp_filetype, $str_filename);
	// 			 curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, true);
	// 		 } else {
	// 			 $sms['image'] = '@'.$_POST['image'].';filename='.$str_filename. ';type='.$tmp_filetype;
	// 		 }
	// 	 }
	//  }
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

	 echo "
	 <script>
		 alert('요청하신 결제가 완료되었습니다.');
		 self.close();		
	 </script>";
	
?>