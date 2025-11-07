<?php
$sub_menu = '600200';
include_once('./_common.php');


auth_check_menu($auth, $sub_menu, 'r');

if (empty($_POST['T_status'])) {
 alert("적합한 값이 넘어오지 않았습니다.", $_SERVER['HTTP_REFERER']);
}


//여기서 부터 문자서비스를 위한 아이코드 모듈 인클루드 및 함수선언
include_once(G5_LIB_PATH.'/icode.lms.lib.php');  //LMS모듈

function lmsSend($sHp, $rHp, $msg) {
    global $g5, $config;
    $rtn = "";
    try {
        $send_hp = str_replace("-","",$sHp); // - 제거 
        $recv_hp = str_replace("-","",$rHp); // - 제거 
        $strDest = array(); 
        $strDest[0] = $recv_hp; 
        $SMS = new LMS; // SMS 연결 
        $SMS->SMS_con($config['cf_icode_server_ip'], 
                                    $config['cf_icode_id'], 
                                    $config['cf_icode_pw'], 
                                    '1'); 
        $SMS->Add($strDest, 
                            $send_hp, 
                            $config['cf_icode_id'],
                            "",
                            "", 
                            iconv("utf-8", "euc-kr", $msg), 
                            "",
                            "1"); 
//                            iconv("utf-8", "euc-kr", stripslashes($msg)), 
// 메세지에서 특수문자를 제거하여 발송하려면 stripslashes를 추가하세요
        $SMS->Send(); 
        $rtn = true;
    }
    catch(Exception $e) {
        alert("처리중 문제가 발생했습니다.".$e->getMessage());
        $rtn = false;
    }
    return $rtn;
}
 // 문자보내기 끝 


 $set_time = date("Y-m-d H:i:s");


if ($_POST['T_status'] == '77') {  //확정문자라면

    $ready_msg = $_POST['T_date'] . "일 " . $_POST['$the_sports'] . " 티칭1 검정 확정안내. \r\n [심사위원] " . $_POST['T_name'];
    $ready_msg = $ready_msg . " (" . $_POST['T_tel'] . ")". " \r\n [스키장] ". $_POST['T_where'] ."\r\n [미팅시간] ";
    $ready_msg = $ready_msg . $_POST['T_time'] . "\r\n [장소] " . $_POST['T_meeting'] . "\r\n\r\n 안전하고, 보람있는 검정시간이 되길 바랍니다.";
    $ready_msg = $ready_msg . "\r\n\r\n -한국스키장경영협회-";
   
    $sql_1 = "update SBAK_T1_TEST set SMS_TIME = '{$set_time}', SMS_MSG = '{$ready_msg}'  where T_code = '{$_POST['T_code']}' and T_status = '77'";
    $sql_2 = "update SBAK_T1_TEST_Apply set SMS_TIME = '{$set_time}', SMS_MSG = '{$ready_msg}'  where T_code = '{$_POST['T_code']}' and PAYMENT_STATUS < 3 and T_status = '77'";

    


} else { // 취소문자라면

    $ready_msg = $_POST['T_date'] . "일 " . $_POST['$the_sports'] . " 티칭1 검정 취소안내. \r\n [심사위원] " . $_POST['T_name'];
    $ready_msg = $ready_msg . " \r\n [검정코드] ". $_POST['T_code'] . " \r\n [스키장] ". $_POST['T_where'];
    $ready_msg = $ready_msg . "\r\n\r\n 본 검정은 응시자미달로 취소되었습니다. 입금한 응시자의 경우 환불게시판에 환불신청바랍니다.";
    $ready_msg = $ready_msg . "\r\n\r\n -한국스키장경영협회-";
   
    $sql_1 = "update SBAK_T1_TEST set SMS_TIME = '{$set_time}', SMS_MSG = '{$ready_msg}'  where T_code = '{$_POST['T_code']}' and T_status != '77'";
    $sql_2 = "update SBAK_T1_TEST_Apply set SMS_TIME = '{$set_time}', SMS_MSG = '{$ready_msg}'  where T_code = '{$_POST['T_code']}' and PAYMENT_STATUS < 3";
    $sql_3 = "update SBAK_T1_TEST_Apply set T_status = '88'  where T_code = '{$_POST['T_code']}' and T_status != '99'";    
    $sql_4 = "update SBAK_T1_TEST set T_status = '88'  where T_code = '{$_POST['T_code']}' and T_status != '99'";  
}



//전화번호를 갖고와서 배열로 구분
$tel_list = $_POST['T_tel_list'];


$tel_list = explode("|",$tel_list);


$sHp = "02-488-6711"; // 발송번호

$msg = $ready_msg;   //발송내용



   // 응시자문자 보낸다
for ($i=0; $i < count($tel_list); $i++) {

 
   $rHp = $tel_list[$i]; // 수신번호
   sql_query($sql_1);
   sql_query($sql_2);
   if ($_POST['T_status'] != '77') {  //취소문자라면
    sql_query($sql_3);
    sql_query($sql_4);   
   }

   lmsSend($sHp,$rHp,$msg); //문자발송
}
 

//if (lmsSend($sHp,$rHp,$msg)) 
   alert('발송완료',$_SERVER['HTTP_REFERER']);
//else
//   alert('발송오류');


?>





