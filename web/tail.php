<?php
/* copyright(c) WEBsiting.co.kr */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$admin = get_admin("super");

if (G5_IS_MOBILE) {
	include_once(G5_THEME_MOBILE_PATH . '/tail.php');
	return;
}

?>

<?php if (!defined("_INDEX_")) {  //인덱스에서 사용하지 않음
?>
	</div><!-- // #container 닫음 -->
<?php }  //인덱스에서 사용하지 않음
?>

<button id="snbOpen">
	<b><i></i><i></i><i></i></b>
	<span class="sound_only">사이드메뉴 열기 닫기</span>
</button>
<aside id="sideBar">
	<h2 class="sound_only">사이트 전체메뉴</h2>

	<!-- SNB // -->
	<?php include_once(G5_THEME_PATH . "/sideBar.php"); /* 사이드메뉴 PC or 모바일*/ ?>

	<!-- // SNB -->

	<!-- 서브메뉴바 하단 정보// -->
	<dl class="snbCS">
		<dt>CONTACT US</dt>
		<dd>
			<strong><i class="fa fa-phone-square"></i> <?php if ($admin['mb_tel']) {
															echo '<span> Tel. ' . $admin['mb_tel'] . '</span>';
														} else echo '<span>관리자 전화번호</span>'; ?> </strong>
			<b><?php if ($admin['mb_email']) {
					echo  '<span> E-mail. '; ?><a href='mailto:<?php echo $admin['mb_email'] ?>'><?php echo $admin['mb_email'] ?></a></span><?php } else echo '<span>관리자이메일</span>'; ?> </b>
			<b><?php if ($admin['mb_1'] == '내용없음') echo '';
				else if ($admin['mb_1']) {
					echo  '<span> Fax. '; ?><?php echo $admin['mb_1'] ?></span><?php } else echo '<span>관리자정보여분필드1(팩스번호)</span>'; ?> </b>

			<br>
			<?php if ($admin['mb_2']) {
				echo  '<span>'; ?><?php echo $admin['mb_2'] ?></span><?php } else echo '<span>관리자정보여분필드2</span>'; ?>
		</dd>
	</dl>
	<div id="snbMvAr">
		<a href="<?php echo G5_URL; ?>" id="btnHome">HOME</a>
		<div class="snbMvArBtn">
			<?php if ($is_member) {  ?>
				<a href="<?php echo G5_BBS_URL ?>/logout.php">LOGOUT</a>
				<a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a>
			<?php } else {  ?>
				<a href="<?php echo G5_BBS_URL ?>/login.php"><b>LOGIN</b></a>
				<a href="<?php echo G5_BBS_URL ?>/register.php">JOIN</a>
			<?php }  ?>
		</div>
	</div>
	<?php if ($is_admin) {  ?>
		<div id="snbMvArBottom">
			<a href="<?php echo G5_ADMIN_URL ?>"><b><i class="fa fa-user-circle" aria-hidden="true"></i> 관리자</b></a>
		</div>
	<?php }  ?>
	<!-- //서브메뉴바 하단 정보 -->
</aside>

</section><!-- // #ctWrap 닫음 -->
<!-- } 콘텐츠 끝 -->

<hr>

<!-- 하단 커스텀배너 시작 { -->
<aside class="customBan">
	<a href="#"><img src="<?php echo G5_THEME_IMG_URL ?>/bottomAbg.jpg" alt=""> <span class="customBanTit">커스텀배너 <u></u></span></a>
	<a href="#"><img src="<?php echo G5_THEME_IMG_URL ?>/bottomAbg02.jpg" alt=""> <span class="customBanTit">for HTML <u></u></span></a>
</aside>
<!-- } 하단 커스텀배너 끝 -->

<hr>

<!-- 하단 시작 { -->
<footer id="footer">
	<dl>
		<dt><img src="<?php echo G5_THEME_IMG_URL; ?>/footerLogo.png" alt="<?php echo $config['cf_title'] ?>"></dt>
		<dd>
			<a href="#" data-featherlight="<?php echo G5_THEME_URL ?>/pop.privacy.php .term_area" data-featherlight-type="ajax">개인정보처리방침</a>
			<a href="#" data-featherlight="<?php echo G5_THEME_URL ?>/pop.term.php .term_area" data-featherlight-type="ajax">이용약관</a>
			<a href="#" data-featherlight="<?php echo G5_THEME_URL ?>/pop.noEmail.php .term_area" data-featherlight-type="ajax">이메일주소 무단수집거부</a>
		</dd>
	</dl>
	<address>
		<?php if ($admin['mb_addr1']) {
			echo '<span>' . $admin['mb_addr1'];
			echo $admin['mb_addr2'] . '</span>';
		} else echo '<span>관리자모드에서 관리자정보의 주소를 입력해 주시기 바랍니다.</span>'; ?>
		<?php if ($admin['mb_tel']) {
			echo ' <em>|</em><span> Tel. ' . $admin['mb_tel'] . '</span>';
		} else echo '<span>관리자정보 전화번호 입력</span>'; ?>
		<?php echo '<em>|</em><span> 대표자명. 임 충 희</span>'; ?>
		<?php if ($admin['mb_email']) {
			echo  ' <em>|</em><span> E-mail. '; ?><a href='mailto:<?php echo $admin['mb_email'] ?>'><?php echo $admin['mb_email'] ?></a></span><?php } else echo '<span>관리자정보 이메일 입력</span>'; ?>
		<?php if ($admin['mb_3'] == '내용없음') echo '';
		else if ($admin['mb_3']) {
			echo  '<br><span>'; ?><?php echo $admin['mb_3'] ?></span><?php } else echo '<br><span>관리자정보여분필드3 내용이 없을 경우 내용없음 이라고 입력해 주세요.</span>'; ?>
	</address>
	<p><span>Copyright</span> &copy; <b>SBAK</b> <span>All rights reserved.</span></p>
</footer>

<button type="button" id="top_btn" class="fa fa-angle-up" aria-hidden="true"><span class="sound_only">페이지 상단으로 이동</span></button>

<?php
if ($config['cf_analytics']) {
	echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->
<?php
include_once(G5_THEME_PATH . "/tail.sub.php");
