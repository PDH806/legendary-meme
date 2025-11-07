<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="' . G5_THEME_CSS_URL . '/main.css">', 5);
add_stylesheet('<link rel="stylesheet" href="' . G5_THEME_URL . '/plugin/bxslider/jquery.bxslider.min.css">', 0);
add_javascript('
<script src="' . G5_THEME_URL . '/plugin/bxslider/jquery.bxslider.min.js?v7"></script>
<script src="' . G5_THEME_URL . '/plugin/youtubeloop/jquery.mb.YTPlayer.min.js?v7"></script>', 99);
add_javascript('<script src="' . G5_THEME_URL . '/js/WEBsiting.main.js?v7"></script>', 100);
include_once(G5_THEME_PATH . '/head.php');

/* 
	상단 메뉴바가 컨텐츠와 겹치는 경우 아래 코드를 사용하시면 상단 메뉴 부분 만큼 내려옵니다.
	메인 슬라이더를 사용하지 않는 경우 아래 스타일 코드의 주석을 해제해 주세요
	*/
//add_stylesheet('<style>#topSpacer{display:block !important;}</style>', 10);

?>
<h2 class="sound_only"><?php echo $g5['title'] ?> <?php echo $config['cf_title'] ?></h2>

<?php /* 메인페이지 비쥬얼 슬라이더///////// */ ?>
<?php
/* 
		메인 슬라이더의 가로세로 크기를 지정해 주시면 지정한 비율로 자동으로 맞춰집니다.
		모바일에서는 지정 사이즈의 좌우 30% 씩 제거되어 세로높이를 조금 더 확보합니다.

		글자 정렬 안내
		슬라이더의 li 에 txtCenter , txtLeft , txtRight 클래스로 정렬 가능합니다.

		이미지는 아래 지정된 사이즈와 동일하거나 또는 같은 비율로 제작하여 테마의 이미지 경로에 넣어주세요
		이미지 경로 style="background-image:URL('이미지경로')"

	*/
$sliderWidth = "1920"; /* 메인 슬라이더늬 넓이를 지정해 주세요 */
$sliderHeight = "900"; /* 메인 슬라이더늬 높이를 지정해 주세요 // 영상배경이 있는 경우 1080을 넘지 않도록 해주세요*/

$sliderSpacer = '<img src="' . G5_THEME_URL . '/plugin/websiting/imageSpacer.php?w=' . $sliderWidth . '&h=' . $sliderHeight . '" alt="Slider Space">';
?>

<section class="mainVisualImage">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?> 메인 슬라이드</h2>
	<div class="mvSlider">
		<ul>
			<li class="txtCenter">
				<?php echo $sliderSpacer ?>

				<?php /* 유튜브 배경세트 ////// */ ?><div class="youtubeBackgroundBG mvMwAlign"><i class="fa fa-spin fa-circle-o-notch"></i>
					<?php /* 유튜브 영상의 경우 videoURL:'N4mCIq4lnTs'  부분에 유튜브 주소창의 영상 아이디값을 입력해 주세요 */ ?>
					<div class="youtubePlayer" data-property="{videoURL:'vz91QpgUjFc'}"></div>
				</div><?php /*  ////// 유튜브 배경세트 */ ?>


				<div class="WCMSScontS">
					<dl>
						<dt><!--i class="fa fa-youtube-square"></i--> 한국스키장경영협회</dt>
						<dd>
							Ski Resort Association of Korea
							<br>
							한국 스키 산업의 지속적 발전에 앞장섭니다.
							<!--a href="#" class="themeBgColor">view more +</a-->
						</dd>
					</dl>
				</div>
			</li>
			<li class="txtCenter" style="background-image:URL('<?php echo G5_THEME_IMG_URL ?>/mainImg01.jpg')">
				<?php echo $sliderSpacer ?>

				<div class="WCMSScontS">
					<dl>
						<dt>스키장 사업의 지속적 발전</dt>
						<dd>
							동계 스포츠의 활성화 방안 강구 및 스키장 시설의 확충
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
						<dt>스키관련(패트롤, 지도자) 자격 검정</dt>
						<dd>
							스키장의 안전을 지키는 패트롤과 스키 입문자들의 기술 향상을 도와줄 스키강사들의 자격검정 시행
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
						<dt>회원사의 결속과 의사소통의 체계화</dt>
						<dd>
							회원간 활발한 자료교환 및 의견수렴을 통한 상호 이익 도모
							<br>
							<a href="#" class="themeBgColor">view more +</a>
						</dd>
					</dl>
				</div>
			</li>
		</ul>
	</div>
	<?php echo '<aside id="sliderSpace">' . $sliderSpacer . '</aside>'; ?>

</section>
<?php /* /////////메인페이지 비쥬얼 슬라이더 */ ?>


<hr>



<section class="mainBasicCont01">
	<!-- 
		main.css 참조 
		검색엔진 노출을 위하여 메인페이지의 본 영역에 홈페이지에 대한 간략한 소개, 기본 정보 등 을 기재해 주시면 좋습니다.
	-->
	<h2>퓨어화이트(PURE WHITE)</h2>
	<h3>그누보드 기반의 반응형 홈페이지 테마!</h3>

	<p class="centerBar"></p>

	<p class="MBC01txt">
		<strong>퓨어화이트(PURE WHITE) 테마는 <span class="pc_br"></span>그누보드 5버전 기반의 반응형 웹사이트 테마입니다.</strong><br><br>
		퓨어화이트 테마는 기본적인 트랜디한 레이아웃에 어떤 컨셉이든 잘 어울리는 <span class="pc_br"></span>심플한 구조로 제작되어 있어 퓨어화이트 테마로 만들 수 있는 웹사이트의 종류는 정말 다양합니다.<br>
		어떤 업종! 어떤 종류의 홈페이지도 뚝딱 만들어 낼 수 있는 퓨어화이트 테마로 홈페이지 제작에 도전해 보세요!
	</p>
</section>



<hr>



<section class="mainContentsW100 btnMoreNone latTitNone">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>
	<!-- 타이틀 없는 100% 꽉차는 박스형 갤러리 -->
	<?php
	/* 박스형 갤러리 게시판 최신글 메인 박스형 갤러리 최신글은 6의 배수로 설정해 주세요 ex) 6 , 12 , 18 , 24 ... */
	// 사용방법 : latest('theme/gallery_box', '게시판아이디', 출력라인, 글자수);
	echo latest('theme/gallery_box', 'gallery_box', 12, 24);
	?>
</section>



<hr>



<section class="mainContentsW100 background-dark">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>
	<div class="mainContents">
		<ul class="main_figure_list">
			<li>
				<a href="#">
					<i class="fa fa-desktop"></i>
					<strong>WEBSITE</strong>
					<span>웹사이트 제작 및 관리</span>
				</a>
			</li>
			<li>
				<i class="fa fa-code"></i>
				<strong>MOBILE</strong>
				<span>모바일 웹사이트 제작 및 관리</span>
			</li>
			<li>
				<i class="fa fa-shopping-cart"></i>
				<strong>E-commerce</strong>
				<span>쇼핑몰 제작 및 운영대행</span>
			</li>
			<li>
				<i class="fa fa-android"></i>
				<strong>Application</strong>
				<span>웹 어플리케이션 개발 및 운영</span>
			</li>
		</ul>
	</div>
</section>



<hr>



<section class="mainContents">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>

	<div class="mainTwoLatArea">
		<div class="MTLA01">
			<?php
			/* 웹진형 게시판 최신글 */
			// 사용방법 : latest('theme/webzine', '게시판아이디', 출력라인, 글자수);
			echo latest('theme/webzine', 'basic', 2, 24);
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



<hr>



<section class="mainContents">
	<h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>
	<?php
	/* 제품소개 게시판 최신글 */
	// 사용방법 : latest('theme/product', '게시판아이디', 출력라인, 글자수);
	echo latest('theme/product', 'product_gallery', 10, 24);
	?>
</section>



<hr>


<?php
if (defined('_INDEX_')) { /* index에서만 실행 */
	include G5_BBS_PATH . '/newwin.inc.php'; /* 팝업레이어 */
}
?>

<?php
include_once(G5_THEME_PATH . '/tail.php');
