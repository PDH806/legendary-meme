<?php
include_once('./_common.php');// index.php 파일로 변경 시 이 줄을 제거해주세요
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/main.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 5);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/plugin/bxslider/jquery.bxslider.min.css">', 0);
add_javascript('
<script src="'.G5_THEME_URL.'/plugin/bxslider/jquery.bxslider.min.js?v7"></script>
<script src="'.G5_THEME_URL.'/plugin/youtubeloop/jquery.mb.YTPlayer.min.js?v7"></script>', 99);
add_javascript('<script src="'.G5_THEME_URL.'/js/WEBsiting.main.js?v7'.date("H:i:s").'"></script>', 100);
include_once(G5_THEME_PATH.'/head.php');

	/* 
	상단 메뉴바가 컨텐와 겹치는 경우 아래 코드를 사용하시면 상단 메뉴 부분 만큼 내려옵니다.
	메인 슬라이더를 사용하지 않는 경우 아래 스타일 코드의 주석을 해제해 주세요
	*/ 
	add_stylesheet('<style>#topSpacer{display:block !important;}</style>', 10);

?>
<h2 class="sound_only"><?php echo $g5['title'] ?> <?php echo $config['cf_title'] ?></h2>

<!-- 메인 박스형 갤러리 최신글 -->
<section class="mainContentsW100 btnMoreNone latTitNone">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>
	<!-- 타이틀 없는 100% 꽉차는 박스형 갤러리 -->
	<?php
	/* 박스형 갤러리 게시판 최신글 메인 박스형 갤러리 최신글은 6의 배수로 설정해 주세요 ex) 6 , 12 , 18 , 24 ... */
	// 사용방법 : latest('theme/gallery_box', '게시판아이디', 출력라인, 글자수);
	echo latest('theme/gallery_box', 'gallery_box', 12, 24);
	?>
</section>


<section class="mainContentsW100 btnMoreNone latTitNone">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>
	<!-- 타이틀 없는 100% 꽉차는 박스형 갤러리 -->
	<?php
	/* 박스형 갤러리 게시판 최신글 메인 박스형 갤러리 최신글은 6의 배수로 설정해 주세요 ex) 6 , 12 , 18 , 24 ... */
	// 사용방법 : latest('theme/gallery_box', '게시판아이디', 출력라인, 글자수);
	echo latest('theme/gallery_box', 'gallery', 12, 24);
	?>
</section>



<hr>



<section class="mainBasicCont01 background-light">
	<!-- 
		main.css 참조 
		검색엔진 노출을 위하여 메인페이지의 본 영역에 홈페이지에 대한 간략한 소개, 기본 정보 등 을 기재해 주시면 좋습니다.
	-->
	<h2>Main page latest system</h2>
	<h3>메인페이지에서 사용가능한 최근 게시물 예제입니다.</h3>

	<p class="centerBar"></p>

	<p class="MBC01txt">
		이 페이지를 참고하시어 메인페이지에 최근 게시글 코드에 활용해 주시기 바랍니다.<br>
		최근게시글 코드만으로도 다양한 홈페이지 연출이 가능합니다. <br><br>
		갤러리 최신글 theme/gallery , theme/gallery_box , theme/product 의 이미지 사이즈는 <br>
		해당 게시판의 이미지 높이, 이미지 넓이 설정에 따른 비율로 썸네일이 생성 됩니다.
	</p>
</section>



<hr>






<hr>



<section class="mainContents">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>

	<div class="mainTwoLatArea">
		<div class="MTLA01">
			<?php
			/* 일반형 게시판 최신글 */
			// 사용방법 : latest('theme/basic', '게시판아이디', 출력라인, 글자수);
			echo latest('theme/basic', 'basic', 5, 24);
			?>
		</div>
		<div class="MTLA02">
			<?php
			/* 웹진형 게시판 최신글 */
			// 사용방법 : latest('theme/webzine', '게시판아이디', 출력라인, 글자수);
			echo latest('theme/webzine', 'webzine', 2, 24);
			?>
		</div>
	
	</div>
</section>


<hr>



<section class="mainContentsW100 background-light">
	<div class="mainContents">
		<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>

		<div class="mainTwoLatArea">
			<div class="MTLA01">
				<?php
				/* 3단갤러리 게시판 최신글 */
				// 사용방법 : latest('theme/zMain_gallery', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/zMain_gallery', 'gallery_box', 6, 24);
				?>
			</div>
			<div class="MTLA02">
				<?php
				/* 웹진형 게시판 최신글 */
				// 사용방법 : latest('theme/webzine', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/webzine', 'webzine', 2, 24);
				?>
			</div>
		
		</div>
	</div>
</section>



<hr>


<!-- 커스텀배너 시작 { -->
<aside class="customBan">
	<a href="#"><img src="<?php echo G5_THEME_IMG_URL ?>/mainImg01.jpg" alt=""> <span class="customBanTit">커스텀배너 <u></u></span></a>
	<a href="#"><img src="<?php echo G5_THEME_IMG_URL ?>/mainImg03.jpg" alt=""> <span class="customBanTit">for HTML <u></u></span></a>
</aside>
<!-- } 커스텀배너 끝 -->


<section class="mainContents">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>
	<?php
	/* 제품소개, 롤링게시글 최신글 */
	// 사용방법 : latest('theme/product', '게시판아이디', 출력라인, 글자수);
	echo latest('theme/product', 'product_gallery', 10, 24);
	?>
</section>



<hr>



<section class="mainContentsW100 background-light">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>
	<div class="mainContents">

		<div class="mainThreeLatArea">
			<div class="MTLA01">
				<?php
				/* 일반형 게시판 최신글 */
				// 사용방법 : latest('theme/basic', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/basic', 'basic', 5, 24);
				?>
			</div>
			<div class="MTLA02">
				<?php
				/* faw 게시판 최신글 */
				// 사용방법 : latest('theme/faq', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/faq', 'faq', 5, 24);
				?>
			</div>
			<div class="MTLA03">
				<?php
				/* 질문답변 게시판 최신글 */
				// 사용방법 : latest('theme/qna', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/qna', 'qna', 5, 24);
				?>
			</div>
		
		</div>

	</div>
</section>



<hr>



<section class="mainContentsW100">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>
	<div class="mainContents">

		<div class="mainThreeLatArea">
			<div class="MTLA01">
				<?php
				/* 3단갤러리 게시판 최신글 */
				// 사용방법 : latest('theme/zMain_gallery', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/zMain_gallery', 'gallery2', 6, 24);
				?>
			</div>
			<div class="MTLA02">
				<?php
				/* 웹진형 게시판 최신글 */
				// 사용방법 : latest('theme/webzine', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/webzine', 'basic', 2, 24);
				?>
			</div>
			<div class="MTLA03">
				<?php
				/* 연혁 게시판 최신글 */
				// 사용방법 : latest('theme/history', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/history', 'history', 3, 24);
				?>
			</div>
		
		</div>

	</div>
</section>



<hr>



<section class="mainContentsW100">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>
	<div class="mainContents">

		<div class="mainThreeLatArea">
			<div class="MTLA01">
				<?php
				/* 3단갤러리 게시판 최신글 */
				// 사용방법 : latest('theme/zMain_gallery', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/zMain_gallery', 'gallery', 6, 24);
				?>
			</div>
			<div class="MTLA02">
				<?php
				/* 웹진형 게시판 최신글 */
				// 사용방법 : latest('theme/webzine', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/webzine', 'webzine', 2, 24);
				?>
			</div>
			<div class="MTLA03">
				<?php
				/* 폼메일 게시판 최신글 */
				// 사용방법 : latest('theme/form', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/form', 'form', 5, 24);
				?>
			</div>
		
		</div>

	</div>
</section>



<hr>



<section class="mainContentsW100 background-light">
	<div class="mainContents">
		<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>
		<?php
		/* 제품소개 롤링게시글 최신글 */
		// 사용방법 : latest('theme/product', '게시판아이디', 출력라인, 글자수);
		echo latest('theme/product', 'gallery2', 10, 24);
		?>
	</div>
</section>


<hr>



<section class="mainContentsW100">
	<div class="mainContents">
		<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>

		<div class="mainTwoLatArea">
			<div class="MTLA01">
				<?php
				/* 박스형 갤러리 게시판 최신글 */
				// 사용방법 : latest('theme/gallery_box', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/gallery_box', 'gallery_box', 6, 24);
				?>
			</div>
			<div class="MTLA02">
				<?php
				/* 박스형 갤러리 게시판 최신글 */
				// 사용방법 : latest('theme/gallery_box', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/gallery_box', 'gallery_box', 6, 24);
				?>
			</div>
		
		</div>
	</div>
</section>


<hr>



<section class="mainContentsW100 background-light">
	<div class="mainContents">
		<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>

		<div class="mainTwoLatArea">
			<div class="MTLA01">
				<?php
				/* 갤러리 게시판 최신글 */
				// 사용방법 : latest('theme/webzine', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/gallery', 'gallery', 6, 24);
				?>
			</div>
			<div class="MTLA02">
				<?php
				/* 갤러리 게시판 최신글 */
				// 사용방법 : latest('theme/webzine', '게시판아이디', 출력라인, 글자수);
				echo latest('theme/gallery', 'gallery', 6, 24);
				?>
			</div>
		
		</div>
	</div>
</section>


<hr>



<!-- 메인 박스형 갤러리 최신글 -->
<section class="mainContentsW100 btnMoreNone latTitNone">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>
	<!-- 타이틀 없는 100% 꽉차는 박스형 갤러리 -->
	<?php
	/* 박스형 갤러리 게시판 최신글 메인 박스형 갤러리 최신글은 6의 배수로 설정해 주세요 ex) 6 , 12 , 18 , 24 ... */
	// 사용방법 : latest('theme/gallery_box', '게시판아이디', 출력라인, 글자수);
	echo latest('theme/gallery_box', 'gallery_box2', 6, 24);
	?>
</section>


<?php
if(defined('_INDEX_')) { /* index에서만 실행 */
	include G5_BBS_PATH.'/newwin.inc.php'; /* 팝업레이어 */
}
?>

<?php
include_once(G5_THEME_PATH.'/tail.php');