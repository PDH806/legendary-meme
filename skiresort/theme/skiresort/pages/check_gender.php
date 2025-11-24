<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "회원정보수정";

//본 페이지에 해당되는 css가 있을 경우 아래 css 삽입 코드를 활성화 해주시기 바랍니다.
//add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/page.css?ver='.G5_CSS_VER.'">', 0);
/*
		테마폴더로의 링크가 길어지는 경우 테마폴더 내 pages 폴더를 
		그누보드 adm, data 폴더와 동일한 경로로 복사해 주시면 
		http://도메인/pages/company.php 와 같은 링크로 이용 가능합니다. 

		관리자모드 메뉴관리에서 본 페이지의 주소는 http 또는 https 부터 시작되는 주소로 넣어주시기 바랍니다.
	*/

/* 페이지설정 코드 입력! */
include_once('../head.php');

if ($is_guest || !$is_member) {
    alert('회원만 이용하실 수 있습니다.', G5_URL);
    exit;
}

if ($member['mb_level'] < 2) {
    alert('이용 권한이 없습니다.', G5_URL);
    exit;
}


$go_update = $_POST['gender_update'] ?? '';

if ($go_update == 'yes') {
    $gender = $_POST['gender'] ?? '';

    $sql = "update {$g5['member_table']} set mb_1 = '{$gender}' where mb_id = '{$member['mb_id']}'";

    sql_query($sql);
    alert($gender . '으로 성별이 등록되었습니다. 마이페이지로 이동합니다.', G5_THEME_URL . '/html/my_form/sbak_console_01.php');
}
?>

<script>
    function chk_radio() {
        var genderRadio = document.getElementsByName("gender");
        var selectedGender = null;

        for (var i = 0; i < genderRadio.length; i++) {
            if (genderRadio[i].checked) {
                selectedGender = genderRadio[i].value;
                break;
            }
        }

        if (selectedGender) {

            let form = document.getElementById("go_frm");
            form.method = 'POST';
            form.submit();

        } else {
            alert("성별을 선택하세요");
            return false;
        }

    }
</script>

<h2 class="h2_title">성별을 등록해주세요.</h2>

<p style="font-size:18px;font-weight:500;">'<?php echo $member['mb_name']; ?>' <span style='font-size:14px;font-weight:400;'>회원님</span></p> <br>

<div class="cont_text">
    회원님께서는, 현재 회원정보내에 성별이 등록되어 있지 않습니다.
    각종 행사신청, 민원서비스 조회/신청을 위해서는 반드시 회원정보에 성별이 등록되어 있어야 합니다. 성별을 등록해주세요.
    <br><br>
    한번 등록된 성별 정보는 <span style='color:red;'>추후 변경이 불가능</span>합니다.
</div>
<div class="cont_text_info">

    <form id="go_frm" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="chk_radio()">
        <input type="hidden" name="gender_update" value="yes">
        <input type="radio" name="gender" id="check_m" value="남자"> 남자 &nbsp;&nbsp;&nbsp;
        <input type="radio" name="gender" id="check_f" value="여자"> 여자

        <input type="submit" style='width:60px;margin-left:70px;' name="submit" value="등록">
    </form>


</div>



<?php
include_once('../tail.php');
