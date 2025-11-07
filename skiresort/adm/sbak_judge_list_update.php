<?php

$sub_menu = '600100';

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
        // $p_PHONE = is_array($_POST['PHONE'] ?? '') ? strip_tags(clean_xss_attributes($_POST['PHONE'][$k] ?? '')) : '';  
        // $p_EMAIL = is_array($_POST['EMAIL'] ?? '') ? strip_tags(clean_xss_attributes($_POST['EMAIL'][$k] ?? '')) : '';
        $p_IS_DEL = is_array($_POST['IS_DEL'] ?? '') ? strip_tags(clean_xss_attributes($_POST['IS_DEL'][$k] ?? '')) : '';
        $p_MEMO = is_array($_POST['MEMO'] ?? '') ? strip_tags(clean_xss_attributes($_POST['MEMO'][$k] ?? '')) : '';
   


        $sql = " update SBAK_JUDGE_LIST  
                        set 
                        IS_DEL = '" . sql_real_escape_string($p_IS_DEL) . "',               
                        MEMO = '" . sql_real_escape_string($p_MEMO) . "'
                        where UID = " . $p_UID . " ";
       sql_query($sql);
   



    }


} elseif ($_POST['act_button'] == "선택삭제") {




    alert('삭제기능은 데이터 보호를 위해 당분간 지원하지 않습니다. 데이터에 삭제체크표시기능을 이용해주세요.');


}




run_event('admin_ksia_license_list_ski_update', $act_button, ($post_chk ?? ''), $qstr);

if ($_POST['act_button'] == "선택수정") {
  goto_url('./sbak_judge_list.php?' . $qstr);
}