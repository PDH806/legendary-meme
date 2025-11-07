<?php


$g5['title'] = "티칭1(응시자)"; //커스텀페이지의 타이틀을 입력합니다.


include_once('./header_console.php'); //공통 상단을 연결합니다.


$refer = $_SERVER['HTTP_REFERER'] ?? '';

if (!$refer) {
	alert("비정상적인 접속입니다.", G5_URL);
}

$t_code = $_GET['t_code'] ?? '';
$event_code = $_GET['event_code'] ?? '';
$sports = $_GET['sports'] ?? '';
$the_sports = $sports;

if (empty($_GET['t_code']) || empty($_GET['event_code']) || empty($_GET['sports'])) {
	alert("비정상적인 접속입니다.", $refer);
}


$sql = "select exists (select T_code from {$Table_T1} where T_code like '{$t_code}') as CHK_EXIST";
$result = sql_fetch($sql);

if ($result['CHK_EXIST'] < 1) {
	alert("없는 검정코드입니다.", $refer);
}

$sql = "select exists (select * from {$Table_Office_Conf} where Event_code = '{$event_code}') as CHK_EXIST";
$result = sql_fetch($sql);

if ($result['CHK_EXIST'] < 1) {
	alert("접근권한이 없는 행사입니다.", $refer);
}

if ($sports !== 'ski' && $sports !== 'sb') {
	alert("스키, 스노보드만 가능합니다.", $refer);
}

//만일 이미 결제완료한 검정이면 에러처리
$sql = "select exists (select T_code from {$Table_T1_Apply} where T_code like '{$t_code}' and MEMBER_ID = '{$mb_id}' and PAYMENT_STATUS = 'Y') as CHK_EXIST";
$result = sql_fetch($sql);


if ($result['CHK_EXIST'] > 0) {
	alert("이미 신청/결제완료한 검정입니다. 중복신청 할수없습니다.", $refer);
	exit;
}


//접수기간 검증 시작

$to_date = date("Y-m-d");
$sql = "select Application_Day, Expired_Day from {$Table_T1} where T_code like '{$t_code}'";
$row = sql_fetch($sql);

if (($row['Application_Day'] > $to_date) || ($row['Expired_Day'] < $to_date)) {
	alert("해당 시험은 접수가능기간이 아닙니다.", $refer);
}
//접수기간 검증 종료



// 비공개 검정에 대한 권한 시작
$sql = "select Is_private,Subject_lists from {$Table_T1} where T_code like '{$t_code}'";
$result = sql_fetch($sql);

if ($result['Is_private'] == 'Y') {
	$arr = explode(',', $result['Subject_lists'], 100); //등록된 대상자를 콤마단위로 최대 100개까지만 가져오자
	$arr = array_map('trim', $arr);

	if (in_array($mb_id, $arr) == false) {
		alert("해당 행사에는 응시권한이 없습니다.", $refer);
	}
}
// 비공개 검정에 대한 권한 종료



// 행사 설정 가져오기

$sql_event = "select * from {$Table_Office_Conf} where Event_code = '{$event_code}'";
$result = sql_query($sql_event);


for ($i = 0; $row = sql_fetch_array($result); $i++) {


	$event_title = $row['Event_title'] ?? '';
	$event_begin_date = $row['Event_begin_date'] ?? '';
	$event_begin_time = $row['Event_begin_time'] ?? '';
	$event_end_date = $row['Event_end_date'] ?? '';
	$event_end_time = $row['Event_end_time'] ?? '';
	$event_title = $row['Event_title'] ?? '';
	$event_birthdate = $row['Event_birthdate'] ?? '';

	$event_title_1 = $row['Event_title_1'] ?? '';

	$event_entry_fee = $row['Entry_fee'] ?? '';
	$event_bank_account = $row['Bank_account'] ?? '';
	$event_memo = $row['Event_memo'] ?? '';
	$event_rule = $row['Event_rule'] ?? '';
	$event_notice = $row['Event_notice'] ?? '';
	$event_status = $row['Event_status'] ?? '';
	$event_year = $row['Event_year'] ?? '';
	$T1_before_days = $row['T1_before_days'] ?? '';

	if ($event_rule == '' or $event_rule < 1) {
		$event_rule = "준비중";
	}
}


?>


<div class="container-xxl flex-grow-1 container-p-y">

	<h4 class="fw-bold py-3 mb-4"><?php echo $event_title; ?> <span class="text-muted fw-light">/ REGISTRATION</span></h4>
	<div class="alert  alert-dark mb-0" role="alert">
		티칭1 접수는 온라인에서만가능합니다.
	</div> <br>

	<?php
	include "./sbak_console_T1_test_apply_2_form_layout.php";
	?>

</div>


<?php
include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
?>