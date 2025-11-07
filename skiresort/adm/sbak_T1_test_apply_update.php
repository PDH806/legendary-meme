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

        $p_T_code = is_array($_POST['T_code'] ?? '') ? strip_tags(clean_xss_attributes($_POST['T_code'][$k] ?? '')) : '';
        $p_MEMBER_NAME = is_array($_POST['MEMBER_NAME'] ?? '') ? strip_tags(clean_xss_attributes($_POST['MEMBER_NAME'][$k] ?? '')) : '';
        $p_MEMBER_ID = is_array($_POST['MEMBER_ID'] ?? '') ? strip_tags(clean_xss_attributes($_POST['MEMBER_ID'][$k] ?? '')) : '';
        $p_PHONE = is_array($_POST['PHONE'] ?? '') ? strip_tags(clean_xss_attributes($_POST['PHONE'][$k] ?? '')) : '';
        $p_MEMO = is_array($_POST['MEMO']) ? strip_tags(clean_xss_attributes($_POST['MEMO'][$k])) : '';


        // 만일 검정신청사항을 다른 검정코드로 변경해 올시, 해당 검정코드가 유효한지 검증

        $sql = "select count(*) as CNT  from SBAK_T1_TEST where T_code like '{$p_T_code}'";
        $row = sql_fetch($sql);

        if ($row['CNT'] < 1) {
            alert("입력하신 검정코드가 유효하지 않습니다.", $_SERVER['HTTP_REFERER']);
        }



    //    $sql = "select T_code, T_date, T_status from SBAK_T1_TEST where T_code like '{$p_T_code}'";
   //     $row = sql_fetch($sql);

   //     if ($row['T_status'] == '55' || $row['T_status'] == '88' || $row['T_status'] == '99') {
   //         alert("입력하신 검정코드는 삭제처리된 검정입니다. 다시 확인하세요.", $_SERVER['HTTP_REFERER']);          
   //     }     






        // 요기에...넘어오지 않은 필드에 대한 처리 삽입


        $sql = " update SBAK_T1_TEST_Apply  
                        set T_code = '" . sql_real_escape_string($p_T_code) . "',
                        MEMBER_NAME = '" . sql_real_escape_string($p_MEMBER_NAME) . "',
                        MEMBER_ID = '" . sql_real_escape_string($p_MEMBER_ID) . "',
                        PHONE = '" . sql_real_escape_string($p_PHONE) . "',          
                        MEMO = '" . sql_real_escape_string($p_MEMO) . "' 
                        where UID = '" . sql_real_escape_string($p_UID) . "' ";
        sql_query($sql);
       





    }







}




run_event('admin_ksia_license_list_ski_update', $act_button, ($post_chk ?? ''), $qstr);

if ($_POST['act_button'] == "선택수정") {
   goto_url($_SERVER['HTTP_REFERER']."?". $qstr);
}