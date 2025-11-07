<?php

include_once('./header_console.php'); //공통 상단을 연결합니다.

if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가





$refer = $_SERVER['HTTP_REFERER'] ?? '';

if (!$refer) {
    alert("정상적으로 접속하세요.!", G5_URL);
}




$the_insert_table = $Table_T1;


if (empty($_POST['sports'])) {
    alert("정상적으로 접속하세요.!", $refer);
}



if (isset($_POST['is_del']) and $_POST['is_del'] == "yes") {

    $uid = $_POST['uid'] ?? 0;

    $sql = "update $the_insert_table set T_status = '99' where UID = {$uid}";
    sql_query($sql);

    $togo_url = "sbak_console_T1_test_open_list.php?sports=" . $_POST['sports'];

    alert("해당 개최건이 삭제되었습니다.", $togo_url);
} elseif ($_POST['w'] == "yes") {


    if (empty($_POST['event_code'])) {
        alert("비정상적인 접속입니다.!", G5_URL);
    }

    $event_code = $_POST['event_code'];


    // 사무국 설정 함수 로드
    get_office_conf($event_code);


    if ($event_status == 'Y') {
        alert("해당 행사는 요강미확정으로 현재 접수제한중입니다.", $refer);
    }



    // 기간 체크 시작

    if ($time_now < $time_begin) { //접수기간 전이면
        alert("아직 접수기간 전입니다. 기간내에 이용하세요.!", $refer);
    }

    if ($time_now > $time_end) { //접수마감 이후면
        alert("접수기간이 만료되었습니다. 접수기한을 확인하세요.!", $refer);
    }




    //기간체크 끝



} else {

    alert("비정상적인 접속입니다!", G5_URL);
}
