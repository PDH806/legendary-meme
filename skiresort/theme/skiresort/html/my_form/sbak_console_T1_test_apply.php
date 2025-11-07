<?php


$g5['title'] = "티칭1(응시자)"; //커스텀페이지의 타이틀을 입력합니다.


include_once('./header_console.php'); //공통 상단을 연결합니다.

$refer = $_SERVER['HTTP_REFERER'] ?? '';

if (!$refer) {
	alert("비정상적인 접속입니다.", G5_URL);
}

$the_sports = $_GET['sports'] ?? '';
if (empty($_GET['sports'])) {
	alert("비정상적인 접속입니다.", $refer);
}

if ($the_sports == 'ski') {
	$event_code = 'B01';
	$the_type = 1;
} elseif ($the_sports == 'sb') {
	$event_code = 'B04';
	$the_type = 2;
}else {
	$event_code = '';
	$the_type = '';	
}



// 사무국 설정 함수 로드
get_office_conf($event_code);

    if ($event_status == 'Y') {

     alert("접수금지 상태입니다.", $refer);

    }

    if ($event_control == 'Y') {

     alert("인원마감 상태입니다.", $refer);

    }

if ($event_rule == '' or $event_rule < 1) {
	$event_rule = "준비중";
} else {
	$event_rule = "<a href='" . $link_rule . "' target='_blank'><font color=blue> [확인하기]</font></a>"; //변수를 받아 자동으로 링크 나오도록 프로그래밍할것
}

?>


<div class="container-xxl flex-grow-1 container-p-y">
	<h4 class="fw-bold py-3 mb-4"><?php echo $event_title; ?> <span class="text-muted fw-light">/ REGISTRATION</span></h4>
	<div class="alert  alert-dark mb-0" role="alert">
		티칭1 응시 접수는 온라인에서만가능합니다
	</div> <br>
	<?php
	include "./sbak_console_T1_test_apply_form_layout.php";
	?>
</div>


<?php
include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
?>