<?php
// 기존 event_cgi/L1_test_update.php


include_once('./header_console.php'); //공통 상단을 연결합니다.

if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가



$refer = $_SERVER['HTTP_REFERER'] ?? '';

if (!$refer) {
    alert("정상적으로 접속하세요.!", G5_URL);
}


$the_insert_table = $Table_T1_Apply;


$togo_url = "sbak_console_T1_test.php?sports=" . $_POST['sports'];


if (isset($_POST['is_del']) and $_POST['is_del'] == "yes") {

    $uid = $_POST['uid'] ?? 0;

    $sql = "update {$the_insert_table} set T_status = '99' where UID = {$uid}";
    sql_query($sql);

    alert("해당 행사 신청건이 삭제되었습니다.", $togo_url);
} elseif ($_POST['w'] == "yes") {

    if (empty($_POST['event_code'])) {
        alert("비정상적인 접속입니다.!", G5_URL);
    }
} else {

    alert("비정상적인 접속입니다!", G5_URL);
}
