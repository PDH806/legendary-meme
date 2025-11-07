<?php

include_once('./header_console.php'); //공통 상단을 연결합니다.

if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가


$refer = $_SERVER['HTTP_REFERER'] ?? '';

if (!$refer) {
    alert("정상적으로 접속하세요.!", G5_URL);
}


$test_year = $_POST['test_year'] ?? '';
$the_sports = $_POST['sports'] ?? '';
$is_regis = $_POST['w'] ?? '';
$is_del = $_POST['is_del'] ?? '';
$is_update = $_POST['is_update'] ?? '';
$event_code = $_POST['event_code'] ?? '';


$the_insert_table = $Table_T1;
$goto_url = "sbak_console_T1_test_open_list.php?sports=" . $the_sports;




if ($is_del == "yes") {

    //검정코드를 갖고와서, 해당 검정코드에 신청자가 있는 지 확인하고 없을 경우에만 삭제 프로세스로 가자
    $the_test_code = $_POST['chk_test_code'] ?? '';
    if (empty($the_test_code)) {
        alert("비정상적인 접속입니다!", $refer);
    }

    $sql = "select exists (select * from {$Table_T1_Apply} where T_code like and T_status = '77') as CHK_EXIST";
    $row = sql_fetch($sql);

    if ($row['CHK_EXIST'] > 0) {
        alert("본 시험에 이미 신청자가 있어서, 삭제할 수 없습니다!", $refer);
    }

    // 삭제 가능하게

    $uid = $_POST['uid'] ?? '';

    if (empty($uid)) {
        alert("비정상적인 접속입니다.!", $refer);
    } else {
        $sql = "update $the_insert_table set T_status = '99' where UID = {$uid}";
        sql_query($sql);

        alert("해당 행사 신청건이 삭제되었습니다!", $goto_url);
    }
} elseif ($is_update == "yes") {
    $uid = $_POST['uid'] ?? '';
    $Application_Day = $_POST['apply_start'] ?? '';
    $Expired_Day = $_POST['apply_end'] ?? '';
    $T_meeting = $_POST['t_meeting']  ?? '';
    $T_date = $_POST['t_date']  ?? '';
    $T_tel = $_POST['t_tel']  ?? '';
    $T_status_date = date("Y-m-d H:i:s");
    $is_private = $_POST['is_private'] ?? ''; //개별검정인지
    $target_id_list = $_POST['target_id_list'] ?? ''; //개별검정 대상자 아이디값

    if (empty($uid)) {
        alert("비정상적인 접속입니다!", $refer);
    }
    if (empty($Application_Day) || empty($Expired_Day) || empty($Application_Day) || empty($T_meeting) || empty($T_tel)) {
        alert("빈 항목이 있습니다. 입력칸을 다시 확인하시고, 빠짐없이 기재하세요!", $refer);
    }
    if ($is_private == "Y" && empty($target_id_list)) {
        alert("비공개 검정의 경우, 대상자 ID를 1개 이상 입력해야 합니다!", $refer);
    }

    if ($Application_Day > $Expired_Day) {
        alert("접수 시작일과 마감일을 확인해주세요!", $refer);
    }

    if (($Application_Day > $T_date) || ($Expired_Day > $T_date)) {
        alert("접수시작일과 마감일은, 행사일 이전이어야 합니다!", $refer);
    }



    $sql = "update $the_insert_table set Application_Day = '{$Application_Day}', 
        Expired_Day = '{$Expired_Day}',
        T_meeting = '{$T_meeting}',
        T_tel = '{$T_tel}',
        T_status_date = '{$T_status_date}',
        Is_private = '{$is_private}',
        Subject_lists = '{$target_id_list}'
        where UID = {$uid}";
    sql_query($sql);


    alert("해당 행사 신청건이 수정되었습니다.", $refer);
} elseif ($is_regis == "yes") {


    if (empty($the_sports) or empty($event_code) or empty($test_year)) {
        alert("비정상적인 접속입니다!", $refer);
    }


    if ($is_resort_manager < 1) { //스키장관리자가 아니면
        alert('본 서비스의 이용권한이 없습니다. 관리자만 이용가능합니다!', $refer);
    }

    //사무국에서 접수제한 설정한지 체크

    $sql_event = "select * from {$Table_Office_Conf} where Event_code = '{$event_code}'";
    $row = sql_fetch($sql_event);

    if ($row['Event_status'] == 'Y') {
        alert("해당 행사는 현재 접수제한중입니다. 사무국에 문의하세요.", $refer);
    }



    if (!$is_admin) {

        // 기간 체크 시작

        if ($time_now < $time_begin) { //접수기간 전이면
            alert("아직 접수기간 전입니다. 기간내에 이용하세요!", $refer);
        }

        if ($time_now > $time_end) { //접수마감 이후면
            alert("접수기간이 만료되었습니다. 접수기한을 확인하세요!", $refer);
        }


        //기간체크 끝


    }



    //동일한 검정일과 시간, 스키장을 비교하여 만일 같은 날, 같은 시간, 같은 스키장이면 에러처리
    $T_date = $_POST['t_date'] ?? '';
    $T_time = $_POST['t_time'] ?? '';
    $T_skiresort = $_POST['t_where'] ?? '';


    $query = "select exists (select T_date from {$Table_T1} where T_mb_id = '{$mb_id}' and T_date = '{$T_date}' and T_time = '{$T_time}' and T_skiresort = {$T_skiresort} 
         and (T_status != '88' and T_status != '99') limit 1 )  as CHK_EXIST";
    $row_chk1 = sql_fetch($query);

    if ($row_chk1['CHK_EXIST'] > 0) {
        alert("동일 날짜, 동일 시간에 이미 생성된 검정이 존재합니다!", $refer);
    }



    //끝



    $TEST_YEAR = $test_year;
    $Application_Day = $_POST['apply_start'] ?? '';
    $Expired_Day = $_POST['apply_end'] ?? '';
    $T_regis_date = date("Y-m-d");
    $resort_num = $T_skiresort;
    $resort_name = $_POST['resort_name'] ?? '';
    $T_meeting = $_POST['t_meeting']  ?? '';
    $T_tel = $_POST['t_tel']  ?? '';
    $T_memo = $_POST['on_memo'] ?? '';
    $T_status_date = date("Y-m-d H:i:s");
    $is_private = $_POST['is_private'] ?? ''; //개별검정인지
    $target_id_list = $_POST['target_id_list'] ?? ''; //개별검정 대상자 아이디값

    if ($the_sports == 'ski') {
        $TYPE = 1;
    } elseif ($the_sports == 'sb') {
        $TYPE = 2;
    } else {
        $TYPE = '';
    }

    $limit_member = $_POST['limit_member'] ?? '1'; //이미 이전 페이지 자바스크립트에서 3명 이상으로 제한됨


    // --> 검정코드 만들기 시작

    $query = "select CODE from {$Table_Skiresort} where NO = {$resort_num}";
    $row = sql_fetch($query);
    $resort_code = $row['CODE'] ?? '';

    $query = "select exists (select T_code from {$Table_T1} where TEST_YEAR = {$TEST_YEAR}) as CHK_EXIST";
    $row = sql_fetch($query);


    if ($row['CHK_EXIST'] < 1) {
        $code_start_num = 1;
        $code_start_num = sprintf('%04d', $code_start_num); // '0001' 형태로 숫자 자리수를 표시

    } else {
        $query = "select max(right(T_code,4)) as HI_NUM from {$Table_T1} where TEST_YEAR = {$TEST_YEAR}";
        $row_hi = sql_fetch($query);
        $code_start_num = ($row_hi['HI_NUM'] + 1);
        $code_start_num = sprintf('%04d', $code_start_num); // '0001' 형태로 숫자 자리수를 표시

    }

    $T_code = $resort_code . $TEST_YEAR . "-" . $code_start_num;

    //--> 검정코드 만들기 끝


    $sql = " insert into {$the_insert_table}
            set 
                                   
                T_code        = '{$T_code}',
                T_date           = '{$T_date}',                   
                T_mb_id      = '{$mb_id}',
                T_name      = '{$mb_name}',
                T_regis_date     = '{$T_regis_date}',  
                T_skiresort   = {$resort_num}, 
                T_where      = '{$resort_name}',                
                T_time            = '{$T_time}',
                T_tel           = '{$T_tel}', 
                T_meeting  = '{$T_meeting}', 
                T_status = '77',
                T_status_date = '{$T_status_date}',
                Is_private = '{$is_private}',
                Subject_lists = '{$target_id_list}',                
                T_memo           = '{$T_memo}',  
                TEST_YEAR          = '{$TEST_YEAR}',  
                TYPE          = '{$TYPE}',  
                Application_Day          = '{$Application_Day}', 
                Expired_Day          = '{$Expired_Day}',  
                limit_member           = '{$limit_member}'";


    sql_query($sql);

    alert("티칭1 시험이 등록되었습니다!", $goto_url);
} else {

    alert("비정상적인 접속입니다!", G5_URL);
}
