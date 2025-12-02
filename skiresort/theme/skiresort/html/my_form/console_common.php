<?php
// 회원이미지 경로
$mb_img_path = G5_DATA_PATH . '/member_image/' . substr($member['mb_id'], 0, 2) . '/' . get_mb_icon_name($member['mb_id']) . '.jpg';
$mb_img_filemtile = (defined('G5_USE_MEMBER_IMAGE_FILETIME') && G5_USE_MEMBER_IMAGE_FILETIME && file_exists($mb_img_path)) ? '?' . filemtime($mb_img_path) : '';
$mb_img_url = G5_DATA_URL . '/member_image/' . substr($member['mb_id'], 0, 2) . '/' . get_mb_icon_name($member['mb_id']) . '.jpg' . $mb_img_filemtile;


//자주 사용되는 테이블명 변수로 정의

$Table_Office_Conf = 'SBAK_OFFICE_CONF';
$Table_T1_Apply = 'SBAK_T1_TEST_Apply';
$Table_T1 = 'SBAK_T1_TEST';
$Table_Skiresort = 'SBAK_SKI_RESORT';
$Table_Service_List = 'SBAK_SERVICE_LIST';
$Table_Master_Apply = 'SBAK_Master_Apply';
$Table_Judge_List = 'SBAK_JUDGE_LIST';
$Table_Mainpay = 'sbak_mainpay';
$Table_Ski_Member = 'SBAK_SKI_MEMBER';
$Table_Sb_Member = 'SBAK_SB_MEMBER';
$Table_Patrol_Member = 'SBAK_PATROL_MEMBER';
$Table_Prn_Log = 'SBAK_prn_log';


$this_year = date("Y");
$this_month = date("m");
$arr = array('11', '12'); //이번 시즌에 포함할 월

if (in_array($this_month, $arr)) {
    $test_season = $this_year + 1;
} else {
    $test_season = $this_year;
}


$this_season = $test_season;


//// 자주 호출하는 코드 함수화
function get_office_conf($event_code)
{
    global $Table_Office_Conf, $event_code, $event_title, $event_title_1;
    global $event_begin_date, $event_begin_time, $event_end_date, $event_end_time, $event_total_limit, $event_extra_limit;
    global $event_date, $event_where, $event_whom, $event_entry_fee, $event_memo;
    global $event_rule, $event_notice, $event_status, $event_control, $event_year, $event_birthdate;
    global $Pay_end_date, $Pay_end_time, $t1_before_days;
    global $refer, $register_err;

    $refer = $_SERVER['HTTP_REFERER'];


    $sql_event = "select * from {$Table_Office_Conf} where Event_code = '{$event_code}'";
    $row_conf = sql_fetch($sql_event);

    $event_title = $row_conf['Event_title'] ?? '';
    $event_title_1 = $row_conf['Event_title_1'] ?? '';

    $event_begin_date = $row_conf['Event_begin_date'];
    $event_begin_time = $row_conf['Event_begin_time'];
    $event_end_date = $row_conf['Event_end_date'];
    $event_end_time = $row_conf['Event_end_time'];
    $event_total_limit = $row_conf['Event_total_limit']; //실운영인원
    $event_extra_cnt = $row_conf['Event_extra_cnt']; //추가모집인원

    $event_extra_limit = $event_total_limit +  $event_extra_cnt; //총 등록가능인원
    /*
    if ($event_total_limit == '' || $event_total_limit == '0') {
        $event_total_limit = "<font style='color:red;'>제한없음</font>";
    } else {
        $event_total_limit = "<span class='text-danger'>" . $event_total_limit . "</span> 명";
    }
        */
    $event_date = $row_conf['Event_date']; // 행사일
    $event_where = $row_conf['Event_where'] ?? ''; // 장소
    $event_whom = $row_conf['Event_whom'] ?? ''; //참가대상
    $event_entry_fee = $row_conf['Entry_fee'] ?? 0; // 참가비
    $event_memo = $row_conf['Event_memo'] ?? '';
    $event_rule = $row_conf['Event_rule'] ?? '';
    $event_notice = $row_conf['Event_notice'] ?? '';

    $event_status = $row_conf['Event_status'] ?? '';
    $event_control = $row_conf['Event_control'] ?? '';


    $event_year = $row_conf['Event_year'] ?? 0;
    $event_birthdate = $row_conf['Event_birthdate'];
    $Pay_end_date = $row_conf['Pay_end_date'];
    $Pay_end_time = $row_conf['Pay_end_time'];
    $t1_before_days = $row_conf['T1_before_days'] ?? 0;

    global $time_begin, $time_end, $time_now;

    $time_begin = $event_begin_date . " " . $event_begin_time;
    $time_begin = strtotime($time_begin);
    $time_end = $event_end_date . " " . $event_end_time;
    $time_end = strtotime($time_end);
    $time_now = strtotime(date("Y-m-d H:i:s"));

    if ($time_now < $time_begin) { //접수기간 전이면
        $register_err = "E1";
    }

    if ($time_now > $time_end) { //접수마감 이후면
        $register_err = "E2";
    }

    if (($register_err != "E1" && $register_err != "E2") && $event_status == "Y") {
        $register_err = "E3";
    }
}



//스키장 관리자인지 가져오기

$sql = "select exists (select MEMBER_ID from {$Table_Judge_List} where MEMBER_ID = '{$mb_id}' and IS_DEL != 'Y' limit 1) as EXIST";
$result = sql_fetch($sql);
$is_resort_manager = $result['EXIST'];
if ($is_resort_manager > 0) {
    $sql = "select RESORT,T_skiresort,SPORTS from {$Table_Judge_List} where MEMBER_ID = '{$mb_id}' and IS_DEL != 'Y'";
    $result = sql_fetch($sql);
    $resort_name = $result['RESORT'] ?? '';
    $resort_no = $result['T_skiresort'] ?? '';
    $resort_judge_gubun = $result['SPORTS'] ?? '';
}