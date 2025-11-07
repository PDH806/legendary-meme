<?php



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

        $p_T_tel = is_array($_POST['T_tel'] ?? '') ? strip_tags(clean_xss_attributes($_POST['T_tel'][$k] ?? '')) : '';
        $p_T_date = is_array($_POST['T_date'] ?? '') ? strip_tags(clean_xss_attributes($_POST['T_date'][$k] ?? '')) : '';
        $p_T_time = is_array($_POST['T_time'] ?? '') ? strip_tags(clean_xss_attributes($_POST['T_time'][$k] ?? '')) : '';
        $p_Expired_Day = is_array($_POST['Expired_Day'] ?? '') ? strip_tags(clean_xss_attributes($_POST['Expired_Day'][$k] ?? '')) : '';
        $p_T_skiresort = is_array($_POST['T_skiresort'] ?? '') ? strip_tags(clean_xss_attributes($_POST['T_skiresort'][$k] ?? '')) : '';
        $p_T_meeting = is_array($_POST['T_meeting'] ?? '') ? strip_tags(clean_xss_attributes($_POST['T_meeting'][$k] ?? '')) : '';
        $p_limit_member = is_array($_POST['limit_member'] ?? '') ? strip_tags(clean_xss_attributes($_POST['limit_member'][$k] ?? '')) : '';
        $p_PAYMENT_AMOUNT = is_array($_POST['PAYMENT_AMOUNT'] ?? '') ? strip_tags(clean_xss_attributes($_POST['PAYMENT_AMOUNT'][$k] ?? '')) : '';
        $p_T_status = is_array($_POST['T_status'] ?? '') ? strip_tags(clean_xss_attributes($_POST['T_status'][$k] ?? '')) : '';
        $p_T_memo = is_array($_POST['T_memo'] ?? '') ? strip_tags(clean_xss_attributes($_POST['T_memo'][$k] ?? '')) : '';

         $T_status_date = date("Y-m-d")." ".date("H:i:s");

         if (empty($p_PAYMENT_DATE)) {
            $p_PAYMENT_DATE = '0000-00-00';
         }



        // 요기에...넘어오지 않은 필드에 대한 처리 삽입


        $sql = " update SBAK_T1_TEST  
                        set T_tel = '" . sql_real_escape_string($p_T_tel) . "',
                        T_date = '" . sql_real_escape_string($p_T_date) . "',
                        T_time = '" . sql_real_escape_string($p_T_time) . "',
                        Expired_Day = '" . sql_real_escape_string($p_Expired_Day) . "',
                        T_skiresort = '" . sql_real_escape_string($p_T_skiresort) . "',
                        T_meeting = '" . sql_real_escape_string($p_T_meeting) . "',
                        limit_member = '" . sql_real_escape_string($p_limit_member) . "',
                        PAYMENT_AMOUNT = '" . sql_real_escape_string($p_PAYMENT_AMOUNT) . "',                 
                        T_status_date = '" . sql_real_escape_string($T_status_date) . "',
                        T_status = '" . sql_real_escape_string($p_T_status) . "',
                        T_MEMO = '" . sql_real_escape_string($p_T_memo) . "' 
                        where UID = '" . sql_real_escape_string($p_UID) . "' ";
        sql_query($sql);





    }







}




run_event('admin_ksia_license_list_ski_update', $act_button, ($post_chk ?? ''), $qstr);

if ($_POST['act_button'] == "선택수정") {
   // goto_url('./ksia_L1_test_list.php?' . $qstr);
    goto_url($_SERVER['HTTP_REFERER']."?". $qstr);
}