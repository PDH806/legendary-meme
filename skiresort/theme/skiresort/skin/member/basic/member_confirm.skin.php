<?php
/* copyright(c) WEBsiting.co.kr */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
include_once(G5_THEME_PATH.'/head.php');
?>

<!-- 회원 비밀번호 확인 시작 { -->
<div id="mb_confirm" class="mbskin">
    <h1>Member confirm</h1>

    <p>
        <strong>비밀번호를 한번 더 입력해주세요.</strong>
        <?php if ($url == 'member_leave.php') { ?>
        비밀번호를 입력하시면 회원탈퇴가 완료됩니다.
        <?php }else{ ?>
        회원님의 정보를 안전하게 보호하기 위해 <span><br></span>비밀번호를 한번 더 확인합니다.
        <?php }  ?>
    </p>

    <form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
    <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
    <input type="hidden" name="w" value="u">

    <fieldset>       

		
		<div class="loginForm">
			<label> <i class="fa fa-info-circle"></i> <strong class="sound_only">회원아이디 필수</strong></label>
			<input type="text"  readonly required value="<?php echo $member['mb_id'] ?>" class="frm_input frm_inputId required" size="20" maxLength="20" placeholder="아이디">
		</div>
		<div class="loginForm">
			<label for="login_pw"> <i class="fa fa-unlock-alt"></i> <strong class="sound_only">비밀번호 필수</strong></label>
			<input type="password" name="mb_password" id="confirm_mb_password" required class="required frm_input" size="15" maxLength="20" placeholder="비밀번호">
		</div>
        <input type="submit" value="확인" id="btn_submit" class="btn_submit">
    </fieldset>

    </form>

</div>

<script>
function fmemberconfirm_submit(f)
{
    document.getElementById("btn_submit").disabled = true;

    return true;
}
</script>
<!-- } 회원 비밀번호 확인 끝 -->
<?php 
include_once(G5_THEME_PATH.'/tail.php');
?>