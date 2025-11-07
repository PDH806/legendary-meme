
<?php

include_once('./admin.head.php');


$css_file = str_replace(G5_ADMIN_PATH, G5_ADMIN_URL, './css/sbak_css.css');
add_stylesheet('<link rel="stylesheet" href="' . $css_file . '">', 1);

$event_code = "B01";

$sql_1 = " select Event_year from SBAK_OFFICE_CONF where Event_code like '{$event_code}' ";
$row_1 = sql_fetch($sql_1);
$default_year = $row_1['Event_year']; //환경설정의 기본년도를 가져온다.



$colspan = 8;
$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '">처음</a>'; //페이지 처음으로 (초기화용도)

$sql_common = " from SBAK_T1_TEST ";

//조회년도가 없으면 기본년도로 지정
if (!$sst) {
    $sst = $default_year;
  }    

  $set_today = date("Y-m-d");
  $event_year = $sst;  


?>

