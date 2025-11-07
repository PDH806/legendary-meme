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
?>
<h2 class="sound_only"><?php echo $g5['title'] ?> <?php echo $config['cf_title'] ?></h2>

<?php /* 메인페이지 비쥬얼 슬라이더///////// */ ?>
<?php
	/* 
		메인 슬라이더의 가로세로 크기를 지정해 주시면 지정한 비율로 자동으로 맞춰집니다.
	*/
	$sliderWidth ="1920"; /* 메인 슬라이더늬 넓이를 지정해 주세요 */
	$sliderHeight ="900"; /* 메인 슬라이더늬 높이를 지정해 주세요 // 영상배경이 있는 경우 1080을 넘지 않도록 해주세요*/

	$sliderSpacer ='<img src="'.G5_THEME_URL.'/plugin/websiting/imageSpacer.php?w='.$sliderWidth.'&h='.$sliderHeight.'" alt="슬라이드 영역">';
?>

<section class="mainVisualImage">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?> 메인 슬라이드</h2>
	<div class="mvSlider">
		<ul>
			<li class="txtCenter" >
				<?php echo $sliderSpacer ?>

				<div class="youtubeBackgroundBG mvMwAlign">
					<i class="fa fa-spin fa-circle-o-notch"></i>
					<?php /* 유튜브 영상의 경우 videoURL:'u3vOaYm7CuI'  부분에 유튜브 주소창의 영상 아이디값을 입력해 주세요 */ ?>
					<div class="youtubePlayer" data-property="{videoURL:'u3vOaYm7CuI'}"></div>
				</div>
				<div class="WCMSScontS">
					<dl>
						<dt><i class="fa fa-youtube-square"></i> WITH YOUTUBE</dt>
						<dd>
							YOUTUBE background section
							<br>
							<a href="#" class="themeBgColor">view more +</a>
						</dd>
					</dl>
				</div>
			</li>
			<li class="txtLeft" >
				<?php echo $sliderSpacer ?>

				<div class="youtubeBackgroundBG mvMwAlign">
					<i class="fa fa-spin fa-circle-o-notch"></i>
					<?php /* 유튜브 영상의 경우 videoURL:'iYqsuvvg7vY'  부분에 유튜브 주소창의 영상 아이디값을 입력해 주세요 */ ?>
					<div class="youtubePlayer" data-property="{videoURL:'iYqsuvvg7vY'}"></div>
				</div>
				<div class="WCMSScontS">
					<dl>
						<dt><i class="fa fa-youtube-square"></i> WITH YOUTUBE</dt>
						<dd>
							YOUTUBE background section
							<br>
							<a href="#" class="themeBgColor">view more +</a>
						</dd>
					</dl>
				</div>
			</li>
			<li class="txtRight" >
				<?php echo $sliderSpacer ?>

				<div class="youtubeBackgroundBG mvMwAlign">
					<i class="fa fa-spin fa-circle-o-notch"></i>
					<?php /* 유튜브 영상의 경우 videoURL:'N4mCIq4lnTs'  부분에 유튜브 주소창의 영상 아이디값을 입력해 주세요 */ ?>
					<div class="youtubePlayer" data-property="{videoURL:'N4mCIq4lnTs'}"></div>
				</div>
				<div class="WCMSScontS">
					<dl>
						<dt><i class="fa fa-youtube-square"></i> WITH YOUTUBE</dt>
						<dd>
							YOUTUBE background section
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

<section class="sound_only">
	<!-- 
		main.css 참조 
		검색엔진 노출을 위하여 메인페이지의 본 영역에 홈페이지에 대한 간략한 소개, 기본 정보 등 을 기재해 주시면 좋습니다.
	-->
	<h2>퓨어화이트(PURE WHITE)</h2>
	<h3>그누보드5 기반의 반응형 홈페이지 테마!</h3>

	<p class="centerBar"></p>

	<p class="MBC01txt">
		<strong>퓨어화이트(PURE WHITE) 테마는   <span class="pc_br"></span>그누보드5 5버전 기반의 반응형 웹사이트 테마입니다.</strong><br><br>
		퓨어화이트 테마는 기본적인 트랜디한 레이아웃에 어떤 컨셉이든 잘 어울리는  <span class="pc_br"></span>심플한 구조로 제작되어 있어 퓨어화이트 테마로 만들 수 있는 웹사이트의 종류는 정말 다양합니다.<br>
		어떤 업종! 어떤 종류의 홈페이지도 뚝딱 만들어 낼 수 있는 퓨어화이트 테마로 홈페이지 제작에 도전해 보세요!
	</p>
</section>

<hr>

<section class="mainContents">

	<?php
	/* 제품소개 게시판 최신글 */
	// 사용방법 : latest('theme/product', '게시판아이디', 출력라인, 글자수);
	echo latest('theme/product', 'product_gallery', 10, 24);
	?>
</section>

<hr>



<?php
if(defined('_INDEX_')) { /* index에서만 실행 */
	include G5_BBS_PATH.'/newwin.inc.php'; /* 팝업레이어 */
}
?>


<?php
include_once(G5_THEME_PATH.'/tail.php');