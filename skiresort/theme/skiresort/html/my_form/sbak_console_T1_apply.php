<?php


$g5['title'] = "티칭1(관리자)"; //커스텀페이지의 타이틀을 입력합니다.

include_once('./header_console.php'); //공통 상단을 연결합니다.

$refer = $_SERVER['HTTP_REFERER'] ?? '';

if (!$refer) {
	alert("올바르지 않은 경로입니다.", G5_URL);
}




$the_sports = $_GET['sports'] ?? '';
if (empty($_GET['sports'])) {
	alert("비정상적인 접속입니다.", $refer);
}

if ($the_sports == 'ski') {
	$event_code = 'B01';
	$cap_sports =  'SKI';
} elseif ($the_sports == 'sb') {
	$event_code = 'B04';
	$cap_sports =  'SB';
}


//스키장관리자인지

if (empty($resort_no) || empty($resort_name)) {
	alert("스키장 관리자가 아닙니다.", $refer);
}


// 행사 설정 가져오기


// 사무국 설정 함수 로드
get_office_conf($event_code);


?>


<div class="container-xxl flex-grow-1 container-p-y">

	<h4 class="fw-bold py-3 mb-4"><?php echo $event_title; ?> <span class="text-muted fw-light">/ <?php echo $resort_name; ?></span></h4>
	<div class="alert  alert-dark mb-0" role="alert">
		각 스키장 관리자만 신청 가능합니다.

	</div> <br>

	<?php
	include "./sbak_console_T1_apply_form_layout.php";
	?>

</div>


<?php
include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
?>