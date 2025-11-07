<?php

require_once './_common.php';

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';

$p_EVENT_CODE = $_POST['event_code'];

if (!$post_count_chk) {
    alert($act_button . " 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();


$update_table = 'SBAK_Master_Apply';



if ($_POST['act_button'] == "선택수정") {
    for ($i = 0; $i < count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

        $p_UID = isset($_POST['UID'][$k]) ? (int) $_POST['UID'][$k] : 0;



        $p_THE_GENDER = is_array($_POST['THE_GENDER'] ?? '') ? strip_tags(clean_xss_attributes($_POST['THE_GENDER'][$k] ?? '')) : '';
        $p_MB_LICENSE_NO = is_array($_POST['MB_LICENSE_NO'] ?? '') ? strip_tags(clean_xss_attributes($_POST['MB_LICENSE_NO'][$k] ?? '')) : '';
        $p_THE_BIRTH = is_array($_POST['THE_BIRTH'] ?? '') ? strip_tags(clean_xss_attributes($_POST['THE_BIRTH'][$k] ?? '')) : '';
        $p_THE_TEL = is_array($_POST['THE_TEL'] ?? '') ? strip_tags(clean_xss_attributes($_POST['THE_TEL'][$k] ?? '')) : '';
        $p_THE_PROFILE = is_array($_POST['THE_PROFILE'] ?? '') ? strip_tags(clean_xss_attributes($_POST['THE_PROFILE'][$k] ?? '')) : '';
        $p_THE_MEMO = is_array($_POST['THE_MEMO'] ?? '') ? strip_tags(clean_xss_attributes($_POST['THE_MEMO'][$k] ?? '')) : '';
        $p_THE_PROFILE = is_array($_POST['THE_PROFILE'] ?? '') ? strip_tags(clean_xss_attributes($_POST['THE_PROFILE'][$k] ?? '')) : '';

        $p_ENTRY_INFO_1 = is_array($_POST['ENTRY_INFO_1'] ?? '') ? strip_tags(clean_xss_attributes($_POST['ENTRY_INFO_1'][$k] ?? '')) : '';
        $p_ENTRY_INFO_3 = is_array($_POST['ENTRY_INFO_3'] ?? '') ? strip_tags(clean_xss_attributes($_POST['ENTRY_INFO_3'][$k] ?? '')) : '';
        $p_ENTRY_INFO_4 = is_array($_POST['ENTRY_INFO_4'] ?? '') ? strip_tags(clean_xss_attributes($_POST['ENTRY_INFO_4'][$k] ?? '')) : '';
        $p_ENTRY_INFO_5 = is_array($_POST['ENTRY_INFO_5'] ?? '') ? strip_tags(clean_xss_attributes($_POST['ENTRY_INFO_5'][$k] ?? '')) : '';
        $p_ENTRY_INFO_6 = is_array($_POST['ENTRY_INFO_6'] ?? '') ? strip_tags(clean_xss_attributes($_POST['ENTRY_INFO_6'][$k] ?? '')) : '';

        $p_THE_STATUS = is_array($_POST['THE_STATUS'] ?? '') ? strip_tags(clean_xss_attributes($_POST['THE_STATUS'][$k] ?? '')) : '66';
        $p_ENTRY_BIB = is_array($_POST['ENTRY_BIB'] ?? '') ? strip_tags(clean_xss_attributes($_POST['ENTRY_BIB'][$k] ?? '')) : '';
        $p_BIB_STATUS = is_array($_POST['BIB_STATUS'] ?? '') ? strip_tags(clean_xss_attributes($_POST['BIB_STATUS'][$k] ?? '')) : '';


        //티칭 2 면제자 처리관련 시작
        if ($p_EVENT_CODE == 'B02' || $p_EVENT_CODE == 'B05') {

            $p_MB_NAME = is_array($_POST['MEMBER_NAME'] ?? '') ? strip_tags(clean_xss_attributes($_POST['MEMBER_NAME'][$k] ?? '')) : '';

            $sql = "select exists (select UID from SBAK_EXEMPTION_LIST where SPORTS like '{$p_EVENT_CODE}' and (K_NAME = '{$p_MB_NAME}' and K_BIRTH = '{$p_THE_BIRTH}') limit 1) as EXIST";
            $chk_isexist = sql_fetch($sql);


            if ($chk_isexist['EXIST'] > 0) {
                $row_exist = 'Y';
            } else {
                $row_exist = 'N';
            }
            $p_STATUS_DATE = date("Y-m-d H:i:s");




            if (($p_ENTRY_INFO_3 == "예" && $p_ENTRY_INFO_4 == "지난해 합격") && ($p_ENTRY_INFO_5 == "예" && $p_ENTRY_INFO_6 == "지난해 합격")) {

                if ($row_exist == 'Y') {
                    $sql = "update SBAK_EXEMPTION_LIST set EXEMPT_1 = 'Y', EXEMPT_2 = 'Y', UPDATE_DATE = '{$p_STATUS_DATE}' where SPORTS like '{$p_EVENT_CODE}' and 
                    (K_NAME = '{$p_MB_NAME}' and K_BIRTH = '{$p_THE_BIRTH}')";
                } else {
                    $sql = "insert into SBAK_EXEMPTION_LIST set K_NAME = '{$p_MB_NAME}',K_BIRTH = '{$p_THE_BIRTH}', SPORTS = '{$p_EVENT_CODE}', 
                    EXEMPT_1 = 'Y', EXEMPT_2 = 'Y', INSERT_DATE = '{$p_STATUS_DATE}' ";
                }
                sql_query($sql);
            }

            if (($p_ENTRY_INFO_3 == "예" && $p_ENTRY_INFO_4 == "지난해 합격") && ($p_ENTRY_INFO_5 != "예" || $p_ENTRY_INFO_6 != "지난해 합격")) {

                if ($row_exist == 'Y') {
                    $sql = "update SBAK_EXEMPTION_LIST set EXEMPT_1 = 'Y', EXEMPT_2 = '', UPDATE_DATE = '{$p_STATUS_DATE}' where SPORTS like '{$p_EVENT_CODE}' and 
                    (K_NAME = '{$p_MB_NAME}' and K_BIRTH = '{$p_THE_BIRTH}')";
                } else {
                    $sql = "insert into SBAK_EXEMPTION_LIST set K_NAME = '{$p_MB_NAME}',K_BIRTH = '{$p_THE_BIRTH}', SPORTS = '{$p_EVENT_CODE}', 
                    EXEMPT_1 = 'Y', EXEMPT_2 = '', INSERT_DATE = '{$p_STATUS_DATE}' ";
                }
                sql_query($sql);
            }

            if (($p_ENTRY_INFO_3 != "예" || $p_ENTRY_INFO_4 != "지난해 합격") && ($p_ENTRY_INFO_5 == "예" && $p_ENTRY_INFO_6 == "지난해 합격")) {

                if ($row_exist == 'Y') {
                    $sql = "update SBAK_EXEMPTION_LIST set EXEMPT_1 = '', EXEMPT_2 = 'Y', UPDATE_DATE = '{$p_STATUS_DATE}' where SPORTS like '{$p_EVENT_CODE}' and 
                    (K_NAME = '{$p_MB_NAME}' and K_BIRTH = '{$p_THE_BIRTH}')";
                } else {
                    $sql = "insert into SBAK_EXEMPTION_LIST set K_NAME = '{$p_MB_NAME}', K_BIRTH = '{$p_THE_BIRTH}', SPORTS = '{$p_EVENT_CODE}', 
                    EXEMPT_1 = '', EXEMPT_2 = 'Y', INSERT_DATE = '{$p_STATUS_DATE}' ";
                }
                sql_query($sql);
            }

            if (($p_ENTRY_INFO_3 != "예" || $p_ENTRY_INFO_4 != "지난해 합격") && ($p_ENTRY_INFO_5 != "예" || $p_ENTRY_INFO_6 != "지난해 합격")) {

                if ($row_exist == 'Y') {
                    $sql = "delete from SBAK_EXEMPTION_LIST  where SPORTS like '{$p_EVENT_CODE}' and 
                    (K_NAME = '{$p_MB_NAME}' and K_BIRTH = '{$p_THE_BIRTH}') ";
                }
                sql_query($sql);
            }
        }




        //티칭 2 면제자 종료



        // 요기에...넘어오지 않은 필드에 대한 처리 삽입
        $p_STATUS_DATE = date("Y-m-d H:i:s");

        $sql = " update {$update_table}  
                        set THE_GENDER = '" . sql_real_escape_string($p_THE_GENDER) . "',
                        MB_LICENSE_NO = '" . sql_real_escape_string($p_MB_LICENSE_NO) . "',
                        THE_BIRTH = '" . sql_real_escape_string($p_THE_BIRTH) . "',
                        THE_TEL = '" . sql_real_escape_string($p_THE_TEL) . "',
                        THE_PROFILE = '" . sql_real_escape_string($p_THE_PROFILE) . "',

                        THE_MEMO = '" . sql_real_escape_string($p_THE_MEMO) . "',

                        ENTRY_INFO_1 = '" . sql_real_escape_string($p_ENTRY_INFO_1) . "',
                        ENTRY_INFO_3 = '" . sql_real_escape_string($p_ENTRY_INFO_3) . "',
                        ENTRY_INFO_4 = '" . sql_real_escape_string($p_ENTRY_INFO_4) . "',
                        ENTRY_INFO_5 = '" . sql_real_escape_string($p_ENTRY_INFO_5) . "',
                        ENTRY_INFO_6 = '" . sql_real_escape_string($p_ENTRY_INFO_6) . "',
                        THE_STATUS = '" . sql_real_escape_string($p_THE_STATUS) . "',
                        STATUS_DATE = '" . sql_real_escape_string($p_STATUS_DATE) . "',
                        ENTRY_BIB = '" . sql_real_escape_string($p_ENTRY_BIB) . "',
                        BIB_STATUS = '" . sql_real_escape_string($p_BIB_STATUS) . "'
                        where UID = '" . sql_real_escape_string($p_UID) . "' ";

        sql_query($sql);
    }
} elseif ($_POST['act_button'] == "문자발송") {

    if (empty($_POST['sms_msg'])) {
        alert("문자 발송 내용을 작성해주세요.", $_SERVER['HTTP_REFERER']);
    }

    $sms_msg = $_POST['sms_msg'];

    //여기서 부터 문자서비스를 위한 아이코드 모듈 인클루드 및 함수선언
    include_once(G5_LIB_PATH . '/icode.lms.lib.php');  //LMS모듈

    function lmsSend($sHp, $rHp, $msg)
    {
        global $g5, $config;
        $rtn = "";
        try {
            $send_hp = str_replace("-", "", $sHp); // - 제거 
            $recv_hp = str_replace("-", "", $rHp); // - 제거 
            $strDest = array();
            $strDest[0] = $recv_hp;
            $SMS = new LMS; // SMS 연결 
            $SMS->SMS_con(
                $config['cf_icode_server_ip'],
                $config['cf_icode_id'],
                $config['cf_icode_pw'],
                '1'
            );
            $SMS->Add(
                $strDest,
                $send_hp,
                $config['cf_icode_id'],
                "",
                "",
                iconv("utf-8", "euc-kr", $msg),
                "",
                "1"
            );
            //                            iconv("utf-8", "euc-kr", stripslashes($msg)), 
            // 메세지에서 특수문자를 제거하여 발송하려면 stripslashes를 추가하세요
            $SMS->Send();
            $rtn = true;
        } catch (Exception $e) {
            alert("처리중 문제가 발생했습니다." . $e->getMessage());
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
        $p_THE_TEL = is_array($_POST['THE_TEL']) ? strip_tags(clean_xss_attributes($_POST['THE_TEL'][$k])) : '';

        $sql_1 = "update SBAK_MASTER_Apply set SMS_TIME = '{$set_time}', SMS_MSG = '{$sms_msg}'  where UID = '{$p_UID}'";
        $rHp = $p_THE_TEL;


        //  lmsSend($sHp,$rHp,$msg); //문자발송
        if (lmsSend($sHp, $rHp, $msg)) {
            sql_query($sql_1);
        }
    }


    alert('문자를 발송했습니다.');
} elseif ($_POST['act_button'] == "선택삭제") {


    alert('삭제기능은 데이터 보호를 위해 당분간 지원하지 않습니다. 데이터에 삭제체크표시기능을 이용해주세요.');
}


run_event('admin_sbak_license_list_ski_update', $act_button, ($post_chk ?? ''), $qstr);


if ($_POST['act_button'] == "선택수정" || $_POST['act_button'] == "문자발송") {


    if ($p_EVENT_CODE == 'B01') {
        $to_go_url = './sbak_event_list_B01.php?';
    }
    if ($p_EVENT_CODE == 'B02') {
        $to_go_url = './sbak_event_list_B02.php?';
    }
    if ($p_EVENT_CODE == 'B06') {
        $to_go_url = './sbak_event_list_B06.php?';
    }
    if ($p_EVENT_CODE == 'B05') {
        $to_go_url = './sbak_event_list_B05.php?';
    }
    if ($p_EVENT_CODE == 'B04') {
        $to_go_url = './sbak_event_list_B04.php?';
    }
    if ($p_EVENT_CODE == 'B03') {
        $to_go_url = './sbak_event_list_B03.php?';
    }
    if ($p_EVENT_CODE == 'B07') {
        $to_go_url = './sbak_event_list_B07.php?';
    }
    if ($p_EVENT_CODE == 'C01') {
        $to_go_url = './sbak_event_list_C01.php?';
    }


    goto_url($to_go_url . $qstr);
}
