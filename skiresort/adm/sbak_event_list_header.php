<?php

include_once('./_common.php');
add_stylesheet('<link rel="stylesheet" href="' . G5_URL . '/adm/css/sbak_css.css">', 0);



$_GET['get_payment'] = $_GET['get_payment'] ?? '';



if ($event_code == 'B03'){
$sql_event = "select * from SBAK_OFFICE_CONF where Event_code = 'C01'";
}else{
$sql_event = "select * from SBAK_OFFICE_CONF where Event_code = '{$event_code}'";
}
$row_conf = sql_fetch($sql_event);

$event_title = $row_conf['Event_title'];
$event_title_1 = $row_conf['Event_title_1'];
if ($event_code == 'B03'){
    $event_title_1 .= ' + 티칭3';
}
$event_year = $row_conf['Event_year'];

$event_begin_date = $row_conf['Event_begin_date'];
$event_begin_time = $row_conf['Event_begin_time'];
$event_end_date = $row_conf['Event_end_date'];
$event_end_time = $row_conf['Event_end_time'];
$event_total_limit = $row_conf['Event_total_limit']; //실운영인원
$event_extra_cnt = $row_conf['Event_extra_cnt']; //추가모집인원


$event_extra_limit = $event_total_limit +  $event_extra_cnt; //총 등록가능인원

$default_year = $event_year;

$this_year = date("Y");
$this_month = date("m");
$arr = array('11', '12'); //이번 시즌에 포함할 월

if (in_array($this_month, $arr)) {
    $test_season = $this_year + 1;
} else {
    $test_season = $this_year;
}

switch ($event_code) {


    case ('B02'):
        $sub_menu = '590100';
        $g5['title'] = '스키티칭2 검정';
        break;
    case ('B03'):
        $sub_menu = '590700';
        $g5['title'] = '스키 기술선수권 + 티칭3';
        break;
    case ('B05'):
        $sub_menu = '590300';
        $g5['title'] = '스노보드티칭2 검정';
        break;
    case ('B06'):
        $sub_menu = '590400';
        $g5['title'] = '스노보드티칭3 검정';
        break;
    case ('B07'):
        $sub_menu = '590500';
        $g5['title'] = '스키구조요원';
        break;
    case ('C01'):
        $sub_menu = '590600';
        $g5['title'] = '스키 기술선수권';
        break;

    default:
        break;
}


$g5['title'] = $event_title_1;

auth_check_menu($auth, $sub_menu, 'r');

include_once('./admin.head.php');


$colspan = 13;
$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '">처음</a>'; //페이지 처음으로 (초기화용도)



$sql_search = '';
$sql_common = " from SBAK_Master_Apply ";


//조회년도가 없으면 기본년도로 지정
if (!$sst) {
    $sst = $default_year;
}

if ($_GET['get_payment'] == 'YC') {

    if ($event_code == "B03") { // 기선전 + 티칭3은 C01(기선전) 에서 통합관리중

        $sql_search = " where (EVENT_CODE like 'C01' and EVENT_YEAR = {$sst} and ENTRY_INFO_2 = 'Y' and PAYMENT_STATUS IN ('Y', 'C')) ";
    } elseif ($event_code == "C01") {

        $sql_search = " where (EVENT_CODE like '{$event_code}' and EVENT_YEAR = {$sst} and ENTRY_INFO_2 != 'Y' and PAYMENT_STATUS IN ('Y', 'C')) ";
    } else {

        $sql_search = " where (EVENT_CODE like '{$event_code}' and EVENT_YEAR = {$sst} and PAYMENT_STATUS IN ('Y', 'C')) ";
    }
} else {

    if ($event_code == "B03") { // 기선전 + 티칭3은 C01(기선전) 에서 통합관리중

        $sql_search = " where (EVENT_CODE like 'C01' and EVENT_YEAR = {$sst} and ENTRY_INFO_2 = 'Y' and PAYMENT_STATUS ='Y') ";
    } elseif ($event_code == "C01") {

        $sql_search = " where (EVENT_CODE like '{$event_code}' and EVENT_YEAR = {$sst} and ENTRY_INFO_2 != 'Y' and PAYMENT_STATUS ='Y') ";
    } else {

        $sql_search = " where (EVENT_CODE like '{$event_code}' and EVENT_YEAR = {$sst} and PAYMENT_STATUS ='Y') ";
    }
}


$event_year = $sst;

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'PAYMENT_STATUS':
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'TRAN_STATUS':
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'MEMBER_ID':
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        case 'THE_STATUS':
            $sql_search .= " ({$sfl} >= 88) ";
            break;
        case 'ENTRY_INFO_3':
            $sql_search .= " ({$sfl} >= 'Y') ";
            break;
        case 'ENTRY_INFO_5':
            $sql_search .= " ({$sfl} >= 'Y') ";
            break;

        default:
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}



$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1)
    $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            order by UID desc
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

?>