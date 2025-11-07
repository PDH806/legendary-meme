<?php



$tmenu_ = "각종 민원"; // theme.menu.php 에서 세팅한 이 페이지의 대메뉴명을 입력합니다.
$g5['title'] = "SBAK 행정종합"; //커스텀페이지의 타이틀을 입력합니다.


include_once('header_console.php');


// 어떤 민원인지 받아오기
// 이 부분에, 회원로그인했는지, 자격정보 있는지 확인하는 루틴 삽입


$event_code = $_GET['category_sort'] ?? '';

if (empty($event_code)) {
	alert('비정상적인 접근입니다. 정상적인 경로로 이용하세요.', $_SERVER['HTTP_REFERER']);
}

$prevPage = $_SERVER['HTTP_REFERER'] ?? '';
$fromPage = G5_THEME_URL . "/html/my_form/sbak_console_02.php";



//카테고리 필드명 : PRODUCT_CODE
// A01: 자격증(A4), A02:자격증(ID), A03: 자격증(A4+ID)  

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
} 

$arr = array('A01', 'A02', 'A03');

if (in_array($event_code, $arr)) { //product_code가 유효하다면

	if ($prevPage == $fromPage) { // 만일 이전페이지가 sbak_console_02.php라면

		if (empty($_GET['license'])) { //sbak_license에서 넘어오는데 자격번호가 안넘어오면
			alert('비정상적인 접근입니다. 정상적인 경로로 이용하세요.', $_SERVER['HTTP_REFERER']);
		}

		$the_license_no = $_GET['license'] ?? '';

		if (substr($the_license_no, 0, 1) == 'T') {
			$the_license_table = $Table_Ski_Member;
			$the_sports = "스키";
			$sbak_sports = "ski";
		} elseif (substr($the_license_no, 0, 2) == 'SB') {
			$the_license_table = $Table_Sb_Member;
			$the_sports = "스노보드";
			$sbak_sports = "sb";
		} else {
			$the_license_table = $Table_Patrol_Member;
			$the_sports = "스키구조요원";
			$sbak_sports = "ptl";
		}


		$sql = "select K_GRADE from {$the_license_table} where K_LICENSE = '{$the_license_no}'";
		$result = sql_fetch($sql);

		$the_license_level = $result['K_GRADE'];



		if (file_exists($mb_img_path) == '0') {
			alert("자격증을 신청하시려면, 먼저 회원사진을 등록하고 이용해주세요", $_SERVER['HTTP_REFERER']);
		}



		$sql = "select exists (select * from {$the_license_table} where K_LICENSE = '{$the_license_no}' and K_NAME = trim('{$mb_name}') limit 1) as CHK_EXIST ";
		/*데이터 조회의 정확성을 위해서는, 회원테이블의 생년월일과 자격증 테이블의 생년월일도 검색조건에 두는 게 적합하나, 임시적으로 이름과 자격번호로만 조회하자.
		$sql = "select exists (select * from {$the_license_table} where K_LICENSE = '{$the_license_no}' and K_NAME = trim('{$mb_name}' and and K_BIRTH = '{$mb_birth}') limit 1) as CHK_EXIST ";
		*/
		$row = sql_fetch($sql);



		if ($row['CHK_EXIST'] > 0) {
			$sql = "select K_GRADE, K_BIRTH from {$the_license_table} where K_LICENSE = '{$the_license_no}' ";
			$row = sql_fetch($sql);
			$the_level = $row['K_GRADE'] ?? '';
			$the_birth = $row['K_BIRTH'] ?? '';
		} else {

			alert('자격번호와 회원명으로 자격정보가 검색되지 않습니다. 로그인한 본인 자격으로만 신청할 수 있습니다.', $_SERVER['HTTP_REFERER']);
		}
	}
} else {
	alert('비정상적인 접속입니다. 정상적인 경로로 이용하세요!', $_SERVER['HTTP_REFERER']);
}



?>




<div class="container-xxl flex-grow-1 container-p-y">

	<h4 class="fw-bold py-3 mb-4"><?php echo $event_title; ?> 신청 <span class="text-muted fw-light">/ SERVICE</span></h4>
	<div class="alert  alert-dark mb-0" role="alert">
		신청정보를 작성하고, 결제까지 마쳐야 등록됩니다.
	</div> <br>

	<?php
	include "./sbak_console_service_form_layout.php";
	?>

</div>

<?php


include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.

?>