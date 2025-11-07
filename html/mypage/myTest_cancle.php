<?php

	include '../db_config.html';
    if (!$Login_User_ID) {echo " <script language='javascript'>top.document.location.href = '../member_login.html'</script>";}
	
	extract($_REQUEST);

	$today = date("Ymd H:i:m");

	if($MID){		// MID 해당 거래번호
		$query="UPDATE 7G_Master_Apply SET TRAN_STATUS = 2, CANCLE_DATE = '$today' where Apply_No = $MID";
   	 	$result=mysqli_query($link, $query);
	}



		//sms 전송
		$PAY_query	= "SELECT * FROM 7G_Master_Apply where Apply_No = '$MID'";
		$PAY_result	= mysqli_query($link, $PAY_query);
    $PAY		= mysqli_fetch_array($PAY_result);

		
		$msg1 = "발송:신청이 취소되었습니다. 환불 대상인 경우 2주 정도가 소요됩니다.";
		$member_name = $PAY["MEMBER_NAME"];
		$phone = $PAY["MEMBER_PHONE"];

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
			alert('선택하신 참가신청이 취소되었습니다. 감사합니다.');
			top.document.location.href = 'admin_master_apply_list.html'
		</script>
	";

?>