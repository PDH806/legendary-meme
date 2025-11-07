<?php
include_once('./header_console.php'); //공통 상단을 연결합니다.

$this_title = "자격증 연동";


if ($is_guest || !$is_member) {
    alert('회원만 이용하실 수 있습니다.', G5_URL);
    exit;
}

if ($member['mb_level'] < 2) {
    alert('이용 권한이 없습니다.', G5_URL);
    exit;
}

$mb_id = $member['mb_id'] ?? '';
$mb_name = $member['mb_name'] ?? '';
$mb_birth = $member['mb_2'] ?? '';


$the_sports = $_POST['the_sports'] ?? '';
$the_level = $_POST['the_level'] ?? '';

if (empty($the_sports) || empty($the_level)) {
    alert('이용 권한이 없습니다.', $_SERVER['HTTP_REFERER']);
    exit;
}




if ($the_sports == "ski") {
    $the_table = $Table_Ski_Member;
    $the_license_type = "스키지도요원";
} elseif ($the_sports == "sb") {
    $the_table = $Table_Sb_Member;
    $the_license_type = "스노보드지도요원";
} else {
    $the_table = $Table_Patrol_Member;
    $the_license_type = "스키구조요원";
}

$from_url = G5_THEME_URL . "/html/my_form/sbak_console_02.php";
//update일떄 처리 시작

$go_update = $_POST['go_update'] ?? '';


if ($go_update == "yes") {

    $UID = $_POST['UID'] ?? '';

    $sql = "update {$the_table} set MEMBER_ID = trim('{$mb_id}') where UID = {$UID}";
    sql_query($sql);


    alert("자격정보가 업데이트 되었습니다.!", $from_url);
    exit;
    //update 끝

} else {


    if ($_SERVER['HTTP_REFERER'] !== $from_url) {
        alert("비정상적인 접속입니다.!", $_SERVER['HTTP_REFERER']);
        exit;
    }



    //기존에 아이디가 매칭되어 있더라도 신규 아이디로 변경할 수 있게 쿼리 조정
    $sql = "select exists (select * from {$the_table} where K_NAME like '{$mb_name}' and K_BIRTH = '{$mb_birth}' 
    and K_GRADE = '{$the_level}' and IS_DEL != 'Y' limit 1) as CHK_EXIST";
    $row = sql_fetch($sql);

    if ($row['CHK_EXIST'] < 1) {

        alert("회원님의 이름과 생년월일로 자격정보가 조회되지 않습니다!", $_SERVER['HTTP_REFERER']);
        exit;
    } else {


        $sql = "select UID, MEMBER_ID, GUBUN, K_LICENSE from {$the_table} where K_NAME = trim('{$mb_name}') and K_BIRTH = '{$mb_birth}' and K_GRADE = '{$the_level}'";
        $row = sql_fetch($sql);

?>



        <div class="container-xxl flex-grow-1 container-p-y">

            <h4 class="fw-bold py-3 mb-4"><?php echo $this_title; ?><span class="text-muted fw-light"> / INSTRUCTOR'S PAGE</span></h4>
            <div class="alert  alert-dark mb-0">


                <div>

                    <p>
                    <h2><span style="font-size:2rem;font-weight:600;border:1px solid #000;border-radius:5px;background-color:#fff;padding:5px;">
                            <?php echo $the_license_type; ?></span>
                    </h2>
                    <hr>
                    <h3>+ 자격번호 : <span style="font-size:2rem;font-weight:600;"><?php echo $row['K_LICENSE']; ?></span>
                    </h3>
                    <h3>+ 취득년도 : <span style="font-size:2rem;font-weight:600;"><?php echo $row['GUBUN']; ?></span>
                    </h3>

                    </p><br>
                    <p><span style="font-size:1.2rem;font-weight:600;color:#000"><?php echo $mb_name; ?></span>
                        회원님의 이름과 생년월일로 위의 자격정보가 검색되었습니다. <br>본인 자격이 맞으시면 연동확인 버튼을 눌러주세요. </p>
                    <br>
                    <p style="font-weight:600;color:red"> <i class='bx bx-error me-1'></i>이 자격번호는 이미 '<?php echo $row['MEMBER_ID']; ?>' 아이디와 연동되어 있습니다. 다시 연동하기를 할 경우, 기존 아이디로 기록된 모든 서비스는 사용해제됩니다.
                        기존 사용 기록을 유지하시려면, 기존 아이디로 다시 로그인하세요. <br><br>

                    </p>


                    <form name="update_license" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                        <input type="hidden" name="go_update" value="yes">
                        <input type="hidden" name="UID" value="<?php echo $row['UID']; ?>">
                        <input type="hidden" name="the_sports" value="<?php echo $the_sports; ?>">
                        <input type="hidden" name="the_level" value="<?php echo $the_level; ?>">


                        <div class="online_bt">
                            <input type="submit" class="btn btn-primary" id="btn_submit" value="연동하기">
                            &nbsp;&nbsp;<a href="javascript:history.back()" class="btn btn-outline-primary">취소</a>
                        </div>

                    </form>

                </div>




            </div>


        </div>

<?php


        include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
    }
}
?>