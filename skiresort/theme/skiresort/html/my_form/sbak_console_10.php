<?php

$this_title = "행사신청"; //커스텀페이지의 타이틀을 입력합니다.
$g5['title'] = "각종 신청"; //커스텀페이지의 타이틀을 입력합니다.

include_once('./header_console.php'); //공통 상단을 연결합니다.

$refer = $_SERVER['HTTP_REFERER'] ?? '';


// 어떤 행사인지 받아오기
// 이 부분에, 회원로그인했는지, 자격정보 있는지 확인하는 루틴 삽입

$event_code = $_GET['event_sort'] ?? '';
if (!$event_code) {
  alert("정상적인 경로로 접속하세요!", $refer);
}



$sql_event = "select exists (select * from {$Table_Office_Conf} where Event_code = '{$event_code}' limit 1) as CHK_EXIST";
$row_cnt = sql_fetch($sql_event);

if ($row_cnt['CHK_EXIST'] < 1) {
  alert("정상적인 경로로 접속하세요!", $refer);
}

if ($event_code == 'B02') { // 스키티칭2 일경우 스키티칭1 있는지 체크

  $sql = "select exists (select * from {$Table_Ski_Member} where MEMBER_ID = '{$mb_id}' and K_GRADE = 'T1'  and IS_DEL !='Y' limit 1) as CHK_EXIST";
  $row_cnt = sql_fetch($sql);

  if ($row_cnt['CHK_EXIST'] < 1) {
    alert("스키 티칭1 자격증이 없습니다!", $refer);
  }
}


if ($event_code == 'B05') { // 보드티칭2 일경우 보드티칭1 있는지 체크

  $sql = "select exists (select * from {$Table_Sb_Member} where MEMBER_ID = '{$mb_id}' and K_GRADE = 'T1' and IS_DEL !='Y' limit 1) as CHK_EXIST";
  $row_cnt = sql_fetch($sql);


  if ($row_cnt['CHK_EXIST'] < 1) {
    alert("스노보드 티칭1 자격증이 없습니다!", $refer);
  }
}

if ($event_code == 'B06') { // 보드티칭3 일경우 보드티칭2 있는지 체크

  $sql = "select exists (select * from $Table_Sb_Member where MEMBER_ID = '{$mb_id}' and K_GRADE = 'T2'  and IS_DEL !='Y' limit 1) as CHK_EXIST";
  $row_cnt = sql_fetch($sql);


  if ($row_cnt['CHK_EXIST'] < 1) {
    alert("스노보드 티칭2 자격증이 없습니다!", $refer);
  }
}



if ($event_code == 'C01') { // 기술선수권 일경우 스키티칭2 있는지 체크

  if (isset($_GET['level2_confirm']) && $_GET['level2_confirm'] == 'Y') { // 기선전에 레벨2 보유자에 '예' 눌렀을 경우 통과

    $level = 'L2';


  }else { 

  $sub_sort   = $_GET['sub_sort'] ?? ''; //  스키기술선수권 + 티칭3 구분
  $sql = "select exists (select * from {$Table_Ski_Member} where MEMBER_ID = '{$mb_id}' and K_GRADE = 'T2'  and IS_DEL !='Y' limit 1) as CHK_EXIST";
  $row_cnt = sql_fetch($sql);
  
  if ($sub_sort == 'default') { // 기선전만 이면

  if ($row_cnt['CHK_EXIST'] < 1) {

        echo "<script>
        if (confirm('스키 티칭2 자격증이 없습니다! 레벨2 자격증 보유자입니까?')) {

        location.href = 'sbak_console_10.php?event_sort=C01&sub_sort=default&level2_confirm=Y';

        } else {
            history.back();
        }
    </script>";

  }

}else{ // 기선전 + 티칭3이면

  if ($row_cnt['CHK_EXIST'] < 1) {
    alert("스키 티칭2 자격증이 없습니다!", $refer);
  }

}

  }

}


$arr = array('B02', 'B05', 'B06', 'B07', 'C01');

if (in_array($event_code, $arr)) { //티칭2,3,기선전, 보드 2,3이면 

  if ($event_code == "B02" or $event_code == "C01") {
    $the_license_table = $Table_Ski_Member;
  } elseif ($event_code == "B07") {
    $the_license_table = $Table_Patrol_Member;
  } else {
    $the_license_table = $Table_Sb_Member;
  }


  $sql = "select K_LICENSE,K_GRADE from {$the_license_table} where MEMBER_ID = '{$mb_id}' order by K_GRADE desc";
  $row = sql_fetch($sql);
  $license_no = $row['K_LICENSE'];
  $chk_level = $row['K_GRADE'];
}


// 사무국 설정 함수 로드
get_office_conf($event_code);

    if ($event_status == 'Y') {

     alert("접수금지 상태입니다.", $refer);

    }

    if ($event_control == 'Y') {

     alert("인원마감 상태입니다.", $refer);

    }

$entry_info_2 = ""; // 기선전 , 기선전 + 티칭3 구분

if ($sub_sort == 'T3') { // 기술선수권 + 티칭3 일 경우 B03 에서 가져오기

  $sql2 = "select * from {$Table_Office_Conf} where Event_code = 'B03'";
  $row2 = sql_fetch($sql2);
  $event_entry_fee = $row2['Entry_fee'];  // B03 참가비
  $event_title = $row2['Event_title']; // B03 행사명
  $entry_info_2 = "Y";
}




if ($event_rule == '' or $event_rule < 1) {
  $event_rule = "준비중";
} 


?>


<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-4"><?php echo $event_title; ?> <span class="text-muted fw-light">/ REGISTRATION</span></h4>
  <div class="alert  alert-dark mb-0" role="alert">
    각종 행사에 온라인으로 신청하세요.
  </div> <br>

  <?php
  include "./sbak_console_form_layout.php";
  ?>

</div>


<?php
include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
?>