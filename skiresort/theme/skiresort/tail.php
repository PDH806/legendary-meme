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
			<strong><i class="fa fa-phone-square"></i> <span> Tel. 02-3473-1275,1277</span> </strong>
			<b> <span> E-mail. ski@resort.or.kr</span></b>
			<br><span> 업무시간 : 평일 9:00 ~ 18:00</span>



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
	<a href="http://carvekorea.com" target="_blank"><img src="<?php echo G5_THEME_URL ?>/sbak_imgs/sponsor_carve.jpg" alt=""> <span class="customBanTit">CARVE SPORTS<u></u></span></a>
	<a href="https://www.high1.com" target="_blank"><img src="<?php echo G5_THEME_URL ?>/sbak_imgs/sponsor_high1.jpg" alt=""> <span class="customBanTit">HIGH1 Resort <u></u></span></a>
</aside>
<!-- } 하단 커스텀배너 끝 -->

<hr>






<!-- 하단 시작 { -->
<footer id="footer">

	<dl>
		<dt>
			| <a href="#" data-featherlight="<?php echo G5_THEME_URL ?>/pop.privacy.php .term_area" data-featherlight-type="ajax">개인정보처리방침</a> |
			<a href="#" data-featherlight="<?php echo G5_THEME_URL ?>/pop.term.php .term_area" data-featherlight-type="ajax">이용약관</a> |
			<a href="#" data-featherlight="<?php echo G5_THEME_URL ?>/pop.noEmail.php .term_area" data-featherlight-type="ajax">이메일주소 무단수집거부</a> |
		</dt>
		<dd>


			<img src="<?php echo G5_THEME_IMG_URL; ?>/footerLogo.png" alt="<?php echo $config['cf_title'] ?>">
		</dd>
	</dl>

	<address>
		<span>서울 송파구 오금로 58 아이스페이스 1201호</span>
		<em>|</em><span> Tel. 02-3473-1275, 1277</span>
		<em>|</em><span> 대표자명. 임 충 희</span>
		<em>|</em><span> E-mail. ski@skiresort.or.kr</span>
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
