<?php

$sub_menu = '700100';

require_once './_common.php';

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';


if (!$post_count_chk) {
    alert($act_button . " 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();


if ($_POST['act_button'] == "선택수정") {
    for ($i = 0; $i < count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;





        $p_UID = isset($_POST['UID'][$k]) ? (int) $_POST['UID'][$k] : 0;

        $p_MEMBER_PHONE = is_array($_POST['MEMBER_PHONE'] ?? '') ? strip_tags(clean_xss_attributes($_POST['MEMBER_PHONE'][$k] ?? '')) : '';
        $p_MEMBER_EMAIL = is_array($_POST['MEMBER_EMAIL'] ?? '') ? strip_tags(clean_xss_attributes($_POST['MEMBER_EMAIL'][$k] ?? '')) : '';
        $p_ZIP = is_array($_POST['ZIP'] ?? '') ? strip_tags(clean_xss_attributes($_POST['ZIP'][$k] ?? '')) : '';
        $p_ADDR1 = is_array($_POST['ADDR1'] ?? '') ? strip_tags(clean_xss_attributes($_POST['ADDR1'][$k] ?? '')) : '';
        $p_ADDR2 = is_array($_POST['ADDR2'] ?? '') ? strip_tags(clean_xss_attributes($_POST['ADDR2'][$k] ?? '')) : '';
        $p_ADDR3 = is_array($_POST['ADDR3'] ?? '') ? strip_tags(clean_xss_attributes($_POST['ADDR3'][$k] ?? '')) : '';
        // $p_LICENSE_NO = is_array($_POST['LICENSE_NO'] ?? '') ? strip_tags(clean_xss_attributes($_POST['LICENSE_NO'][$k] ?? '')) : '';
        $p_AMOUNT = is_array($_POST['AMOUNT'] ?? '') ? strip_tags(clean_xss_attributes($_POST['AMOUNT'][$k] ?? '')) : '';
        $p_DELIVERY_AGENCY = is_array($_POST['DELIVERY_AGENCY'] ?? '') ? strip_tags(clean_xss_attributes($_POST['DELIVERY_AGENCY'][$k] ?? '')) : '';
        $p_TRACKING_NO = is_array($_POST['TRACKING_NO'] ?? '') ? strip_tags(clean_xss_attributes($_POST['TRACKING_NO'][$k] ?? '')) : '';
        $p_DELIVERY_DATE = is_array($_POST['DELIVERY_DATE'] ?? '') ? strip_tags(clean_xss_attributes($_POST['DELIVERY_DATE'][$k] ?? '')) : '';
        $p_MEMO1 = is_array($_POST['MEMO1'] ?? '') ? strip_tags(clean_xss_attributes($_POST['MEMO1'][$k] ?? '')) : '';
        $p_TRAN_STATUS = is_array($_POST['TRAN_STATUS'] ?? '') ? strip_tags(clean_xss_attributes($_POST['TRAN_STATUS'][$k] ?? '')) : '';
        // $p_IS_DEL = is_array($_POST['IS_DEL'] ?? '') ? strip_tags(clean_xss_attributes($_POST['IS_DEL'][$k] ?? '')) : '';

        // 요기에...넘어오지 않은 필드에 대한 처리 삽입


        $sql = " update SBAK_SERVICE_LIST  
                        set MEMBER_PHONE = '" . sql_real_escape_string($p_MEMBER_PHONE) . "',
                        MEMBER_EMAIL = '" . sql_real_escape_string($p_MEMBER_EMAIL) . "',
                        ZIP = '" . sql_real_escape_string($p_ZIP) . "',
                        ADDR1 = '" . sql_real_escape_string($p_ADDR1) . "',
                        ADDR2 = '" . sql_real_escape_string($p_ADDR2) . "',
                        ADDR3 = '" . sql_real_escape_string($p_ADDR3) . "',

                        AMOUNT = '" . sql_real_escape_string($p_AMOUNT) . "',
                        DELIVERY_AGENCY = '" . sql_real_escape_string($p_DELIVERY_AGENCY) . "',
                        TRACKING_NO = '" . sql_real_escape_string($p_TRACKING_NO) . "',
                        DELIVERY_DATE = '" . sql_real_escape_string($p_DELIVERY_DATE) . "',
                        MEMO1 = '" . sql_real_escape_string($p_MEMO1) . "',
                        TRAN_STATUS = '" . sql_real_escape_string($p_TRAN_STATUS) . "'
                      

                        where UID = '" . sql_real_escape_string($p_UID) . "' ";
                       
                         sql_query($sql);





    }



} elseif ($_POST['act_button'] == "문자발송") {



      if(empty($_POST['sms_msg'])) {
        alert("문자 발송 내용을 작성해주세요.", $_SERVER['HTTP_REFERER']);
      }

      $sms_msg = $_POST['sms_msg'];

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
        $msg = $sms_msg;
        
         $sHp = "02-488-6711"; // 발송번호
        for ($i = 0; $i < count($_POST['chk']); $i++) {
            // 실제 번호를 넘김
            $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
            $p_UID = isset($_POST['UID'][$k]) ? (int) $_POST['UID'][$k] : 0;
            $p_MEMBER_PHONE = is_array($_POST['MEMBER_PHONE']) ? strip_tags(clean_xss_attributes($_POST['MEMBER_PHONE'][$k])) : '';

            $sql_1 = "update SBAK_SERVICE_LIST set SMS_TIME = '{$set_time}', SMS_MSG = '{$sms_msg}'  where UID = '{$p_UID}'";
            $rHp = $p_MEMBER_PHONE;


          //  lmsSend($sHp,$rHp,$msg); //문자발송
            if (lmsSend($sHp,$rHp,$msg)) {
              sql_query($sql_1);
            }  
    
        }  


        alert('문자를 발송했습니다.');



} elseif ($_POST['act_button'] == "선택삭제") {




    alert('삭제기능은 데이터 보호를 위해 당분간 지원하지 않습니다. 데이터에 삭제체크표시기능을 이용해주세요.');


}




run_event('admin_ksia_license_list_ski_update', $act_button, ($post_chk ?? ''), $qstr);

if ($_POST['act_button'] == "선택수정") {
   goto_url('./sbak_service_list.php?' . $qstr);
}