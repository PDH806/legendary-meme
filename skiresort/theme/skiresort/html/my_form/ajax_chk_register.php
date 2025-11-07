<?php
include "../../../../common.php";

header('Content-Type: text/html; charset=utf-8');

$event_code = $_POST['event_code'] ?? '';
$event_year = $_POST['event_year'] ?? '';

if (empty($event_code) || empty($event_year)) {
    $register_err = "E100";
}


$register_err = "E200"; //에러통과
include "console_common.php";
get_office_conf($event_code);


$sql = "SELECT exists (select MB_ID from {$the_insert_table} where (EVENT_CODE = '{$event_code}' and MB_ID = '{$mb_id}') and
            (EVENT_YEAR = '{$event_year}' and PAYMENT_STATUS = 'Y') limit 1) as CHK_EXIST";

$get_result = sql_fetch($sql);

if ($get_result['CHK_EXIST'] > 0) {
    $register_err = "E4";
}

$sql = "select count(*) as CNT from {$the_insert_table} where EVENT_CODE = '{$event_code}' and (EVENT_YEAR = '{$event_year}' and PAYMENT_STATUS = 'Y')";
$limit_result = sql_fetch($sql);


if ($limit_result['CNT'] >= $event_total_limit) {
    $register_err = "E5";
}


// E1 접수기간 이전  E2 접수기간 이후 E3 사무국 폐쇄  E4 이미 등록  E5 인원초과
echo $register_err;
