<?php

$sub_menu = '600200';

require_once './_common.php';

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';


if (!$post_count_chk) {
    alert($act_button . " 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();

if (empty($_POST['T_code'])) {
    alert("정상적으로 이용하세요", $_SERVER['HTTP_REFERER']);
}

$T_code = $_POST['T_code'];


if ($_POST['act_button'] == "선택수정") {
    for ($i = 0; $i < count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

        $p_UID = isset($_POST['UID'][$k]) ? (int) $_POST['UID'][$k] : 0;


        $p_T_status = is_array($_POST['T_status']) ? strip_tags(clean_xss_attributes($_POST['T_status'][$k])) : '';

        if (empty($p_T_status)) {
            $p_T_status = '77';
        }




        // 만일 검정신청사항을 다른 검정코드로 변경해 올시, 해당 검정코드가 유효한지 검증

        $sql = "select count(*) as CNT  from SBAK_T1_TEST where T_code like '{$T_code}'";
        $row = sql_fetch($sql);

        if ($row['CNT'] < 1) {
            alert("입력하신 검정코드가 유효하지 않습니다.", $_SERVER['HTTP_REFERER']);
        }



        $sql = "select T_code, T_date, T_status from SBAK_T1_TEST where T_code like '{$T_code}'";
        $row = sql_fetch($sql);

        if ($row['T_status'] == '55' || $row['T_status'] == '88' || $row['T_status'] == '99') {
            alert("입력하신 검정코드는 삭제처리된 검정입니다. 다시 확인하세요.", $_SERVER['HTTP_REFERER']);          
        }     






        // 요기에...넘어오지 않은 필드에 대한 처리 삽입


        $sql = " update SBAK_T1_TEST_Apply  
                        set 
                        T_status = '" . sql_real_escape_string($p_T_status) . "'

                        where UID = '" . sql_real_escape_string($p_UID) . "' ";
        sql_query($sql);
 //echo $sql."<br>";




    }







}




run_event('admin_ksia_license_list_ski_update', $act_button, $post_chk, $qstr);

if ($_POST['act_button'] == "선택수정") {
    goto_url('./sbak_T1_test_detail_info.php?t_code='.$T_code."&" . $qstr);
}