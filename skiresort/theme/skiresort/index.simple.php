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
	//add_stylesheet('<style>#topSpacer{display:block !important;}</style>', 10);

?>
<h2 class="sound_only"><?php echo $g5['title'] ?> <?php echo $config['cf_title'] ?></h2>

<?php /* 메인페이지 비쥬얼 슬라이더///////// */ ?>
<?php
	/* 
		메인 슬라이더의 가로세로 크기를 지정해 주시면 지정한 비율로 자동으로 맞춰집니다.
	*/
	$sliderWidth ="1920"; /* 메인 슬라이더늬 넓이를 지정해 주세요 */
	$sliderHeight ="800"; /* 메인 슬라이더늬 높이를 지정해 주세요 // 영상배경이 있는 경우 1080을 넘지 않도록 해주세요*/

	$sliderSpacer ='<img src="'.G5_THEME_URL.'/plugin/websiting/imageSpacer.php?w='.$sliderWidth.'&h='.$sliderHeight.'" alt="슬라이드 영역">';
?>

<section class="mainVisualImage">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?> 메인 슬라이드</h2>
	<div class="mvSlider">
		<ul>
			<li class="txtCenter"  style="background-image:URL('<?php echo G5_THEME_IMG_URL ?>/mainImg01.jpg')">
				<?php echo $sliderSpacer ?>

				<div class="WCMSScontS">
					<dl>
						<dt>그누보드5 기반</dt>
						<dd>
							퓨어화이트 반응형 홈페이지 테마
							<br>
							<a href="#" class="themeBgColor">view more +</a>
						</dd>
					</dl>
				</div>
			</li>
			<li class="txtLeft" style="background-image:URL('<?php echo G5_THEME_IMG_URL ?>/mainImg02.jpg')">
				<?php echo $sliderSpacer ?>

				<div class="WCMSScontS">
					<dl>
						<dt>PURE WHITE</dt>
						<dd>
							그누보드5 반응형 홈페이지 테마
							<br>
							<a href="#" class="themeBgColor">view more +</a>
						</dd>
					</dl>
				</div>
			</li>
			<li class="txtRight" style="background-image:URL('<?php echo G5_THEME_IMG_URL ?>/mainImg03.jpg')">
				<?php echo $sliderSpacer ?>

				<div class="WCMSScontS">
					<dl>
						<dt>GNUBOARD5 BASE</dt>
						<dd>
							퓨어화이트 반응형 홈페이지 테마
							<br>
							<a href="#" class="themeBgColor">view more +</a>
						</dd>
					</dl>
				</div>
			</li>
		</ul>
	</div>
	<?php echo '<aside id="sliderSpace">'.$sliderSpacer.'</aside>'; ?>

</section>
<?php /* /////////메인페이지 비쥬얼 슬라이더 */ ?>



<hr>



<section class="mainContentsW100">
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
				/* 일반형 게시판 최신글 */
				// 사용방법 : latest('theme/basic', '게시판아이디', 출력라인, 글자수);
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





<?php
include_once(G5_THEME_PATH.'/tail.php');