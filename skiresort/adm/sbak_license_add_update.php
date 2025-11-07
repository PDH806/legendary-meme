<?php

if ($_POST['sports'] == 'ski') {

    $sub_menu = '800100';
    $table = "SBAK_SKI_MEMBER";
    $sports = "ski";
} elseif ($_POST['sports'] == 'sb') {

    $sub_menu = '800200';
    $table = "SBAK_SB_MEMBER";
    $sports = "sb";
} elseif ($_POST['sports'] == 'ptl') {

    $sub_menu = '800300';
    $table = "SBAK_PATROL_MEMBER";
    $sports = "ptl";

}
else {

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
        $p_MEMBER_ID = is_array($_POST['MEMBER_ID']) ? strip_tags(clean_xss_attributes($_POST['MEMBER_ID'][$k])) : '';
        $p_K_LICENSE = is_array($_POST['K_LICENSE']) ? strip_tags(clean_xss_attributes($_POST['K_LICENSE'][$k])) : '';
        $p_K_GRADE = is_array($_POST['K_GRADE']) ? strip_tags(clean_xss_attributes($_POST['K_GRADE'][$k])) : '';
        $p_K_MEMO = is_array($_POST['K_MEMO']) ? strip_tags(clean_xss_attributes($_POST['K_MEMO'][$k])) : '';
        $p_K_BIRTH = is_array($_POST['K_BIRTH']) ? strip_tags(clean_xss_attributes($_POST['K_BIRTH'][$k])) : '';
        $p_GUBUN = is_array($_POST['GUBUN']) ? strip_tags(clean_xss_attributes($_POST['GUBUN'][$k])) : '';
        $p_IS_DEL = is_array($_POST['IS_DEL']) ? strip_tags(clean_xss_attributes($_POST['IS_DEL'][$k])) : '';

        // 요기에...넘어오지 않은 필드에 대한 처리 삽입

        if ($p_MEMBER_ID == '') {
            alert("자료값의 ID에 빈항목이 있습니다. 확인하세요!", $_SERVER['REFERER']);
            exit;
        }
        if ($p_K_NAME == '') {
            alert("자료값의 이름에 빈항목이 있습니다. 확인하세요!", $_SERVER['REFERER']);
            exit;
        }
        if ($p_K_LICENSE == '') {
            alert("자료값의 자격번호에 빈항목이 있습니다. 확인하세요!", $_SERVER['REFERER']);
            exit;
        }
        if ($p_K_GRADE == '') {
            alert("자료값의 자격등급에 빈항목이 있습니다. 확인하세요!", $_SERVER['REFERER']);
            exit;
        }
        if ($p_K_BIRTH == '') {
            alert("자료값의 생년월일에 빈항목이 있습니다. 확인하세요!", $_SERVER['REFERER']);
            exit;
        }
        if ($p_GUBUN == '') {
            alert("자료값의 구분(년도)에 빈항목이 있습니다. 확인하세요!", $_SERVER['REFERER']);
            exit;
        }





        $sql = " insert into $table
                        set MEMBER_ID = '" . sql_real_escape_string($p_MEMBER_ID) . "',
                            GUBUN = '" . sql_real_escape_string($p_GUBUN) . "',
                            K_NAME = '" . sql_real_escape_string($p_K_NAME) . "',
                            K_BIRTH = '" . sql_real_escape_string($p_K_BIRTH) . "',
                            K_LICENSE = '" . sql_real_escape_string($p_K_LICENSE) . "',
                            K_GRADE = '" . sql_real_escape_string($p_K_GRADE) . "',
                            INSERT_DATE = '" . date("Y-m-d H:i:s") . "',
                            K_MEMO = '" . sql_real_escape_string($p_K_MEMO) . "' ";
        sql_query($sql);




    }

}



run_event('admin_sbak_license_list_ski_update', $act_button, $post_chk, $qstr);

if ($_POST['sports'] == 'ski') {
    goto_url('./sbak_license_list_ski.php?' . $qstr);
} elseif ($_POST['sports'] == 'sb') {
    goto_url('./sbak_license_list_sb.php?' . $qstr);
}else {
    goto_url('./sbak_license_list_ptl.php?' . $qstr);
}