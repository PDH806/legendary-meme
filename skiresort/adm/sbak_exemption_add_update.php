<?php

if ($_POST['exempt'] == 'Y') {

    $sub_menu = '590800';
    $table = "SBAK_EXEMPTION_LIST";

} else {

    alert("비정상적인 접근입니다.", G5_URL);

}


require_once './_common.php';

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';


if (!$post_count_chk) {
    alert($act_button . " 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();


if ($_POST['act_button'] == "선택등록") {
    for ($i = 0; $i < count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;




        $p_K_NAME = is_array($_POST['K_NAME']) ? strip_tags(clean_xss_attributes($_POST['K_NAME'][$k])) : '';
        $p_K_BIRTH = is_array($_POST['K_BIRTH']) ? strip_tags(clean_xss_attributes($_POST['K_BIRTH'][$k])) : '';
        $p_SPORTS = is_array($_POST['SPORTS']) ? strip_tags(clean_xss_attributes($_POST['SPORTS'][$k])) : '';
        $p_EXEMPT_1 = is_array($_POST['EXEMPT_1']) ? strip_tags(clean_xss_attributes($_POST['EXEMPT_1'][$k])) : '';
        $p_EXEMPT_2 = is_array($_POST['EXEMPT_2']) ? strip_tags(clean_xss_attributes($_POST['EXEMPT_2'][$k])) : '';

        $p_IS_DEL = is_array($_POST['IS_DEL']) ? strip_tags(clean_xss_attributes($_POST['IS_DEL'][$k])) : '';

        // 요기에...넘어오지 않은 필드에 대한 처리 삽입


        if ($p_K_NAME == '') {
            alert("자료값의 이름에 빈항목이 있습니다. 확인하세요!", $_SERVER['REFERER']);
            exit;
        }
        if ($p_K_BIRTH == '') {
            alert("자료값의 생년월일에 빈항목이 있습니다. 확인하세요!", $_SERVER['REFERER']);
            exit;
        }
        if ($p_SPORTS == '') {
            alert("자료값의 구분(종목)에 빈항목이 있습니다. 확인하세요!", $_SERVER['REFERER']);
            exit;
        }





        $sql = " insert into $table
                        set K_NAME = '" . sql_real_escape_string($p_K_NAME) . "',
                        K_BIRTH = '" . sql_real_escape_string($p_K_BIRTH) . "',
                        SPORTS = '" . sql_real_escape_string($p_SPORTS) . "',
                        EXEMPT_1 = '" . sql_real_escape_string($p_EXEMPT_1) . "',
                        EXEMPT_2 = '" . sql_real_escape_string($p_EXEMPT_2) . "',
                        IS_DEL = 'N',
                        INSERT_DATE = '" . date("Y-m-d H:i:s") . "' ";
        sql_query($sql);




    }

}



run_event('admin_sbak_license_list_ski_update', $act_button, $post_chk, $qstr);


    goto_url('./sbak_event_exemption.php');
