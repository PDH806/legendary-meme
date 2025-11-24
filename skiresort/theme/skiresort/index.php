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
$sliderHeight = "1080"; /* 메인 슬라이더늬 높이를 지정해 주세요 // 영상배경이 있는 경우 1080을 넘지 않도록 해주세요*/

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



<!--section class="mainBasicCont01">

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
	
<?php
/* 박스형 갤러리 게시판 최신글 메인 박스형 갤러리 최신글은 6의 배수로 설정해 주세요 ex) 6 , 12 , 18 , 24 ... */
// 사용방법 : latest('theme/gallery_box', '게시판아이디', 출력라인, 글자수);
echo latest('theme/gallery_box', 'gallery_box', 12, 24);
?>
</section>



<hr-->



<section class="mainContentsW100 background-dark">
    <h2 class="sound_only"><?php echo $config['cf_title'] ?></h2>
    <div class="mainContents">
        <ul class="main_figure_list">
            <li>
                <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_01.php">
                    <i class="fa fa-desktop"></i>
                    <strong>Mypage</strong>
                    <span>자격조회 및 신청, 발급</span>
                </a>
            </li>
            <li>
                <a href="<?php echo G5_THEME_URL; ?>/pages/patrol_01.php">
                    <i class="fa fa-plus-square"></i>
                    <strong>스키구조요원</strong>
                    <span>소개, 시험정보</span>
                </a>
            </li>
            <li>
                <a href="<?php echo G5_THEME_URL; ?>/pages/ski_div_01.php">
                    <i class="fa fa-sort-amount-desc"></i>
                    <strong>스키지도요원</strong>
                    <span>소개, 시험정보</span>
                </a>
            </li>
            <li>
                <a href="<?php echo G5_THEME_URL; ?>/pages/sb_div_01.php">
                    <i class="fa fa-users"></i>
                    <strong>스노보드지도요원</strong>
                    <span>소개, 시험정보</span>
                </a>
            </li>
        </ul>
    </div>
</section>



<hr>



<!--section class="mainContents">
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
</section-->



<hr>

<style>
    #mBot>.inner {
        padding-top: 113px;
        padding-bottom: 173px
    }

    #mBot {
        background: url('<?php echo G5_THEME_URL; ?>/img/index_bg1.jpg') center center no-repeat;
        background-size: cover;
    }

    #mBot>.inner {
        display: flex;
        justify-content: space-between;
        gap: 30px
    }

    #mBot .r {
        width: 770px
    }

    #mBot .l {
        width: 530px;
        display: flex;
        flex-flow: column;
        gap: 30px;
        justify-content: space-between
    }

    #mBot .l .txt {
        font-size: 36px;
        font-weight: 900;
        margin-bottom: 20px;
        line-height: 1.15;
        letter-spacing: 0;
    }

    #mBot .l .logo img {
        filter: brightness(0) invert(1);
        width: 230px;
        padding-bottom: 30px;
    }

    #mBot .l .btns {
        font-size: 1.25rem;
        font-weight: 700;

    }

    #mBot .l .btns a {
        display: flex;
        max-width: 216px;
        height: 55px;
        border-radius: 100px;
        border: 1px solid #fff;
        padding: 0 25px;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        text-align: left;
        line-height: 1.18;
        color: #fff;
    }




    #mBot .l .btns a:after {
        width: 31px;
        height: 24px;
        background: url('<?php echo G5_THEME_URL; ?>/img/next.png') center center no-repeat;
        content: '';
        display: block;
        margin-right: -5px;
    }

    #mBot .l .btns a:not(:first-child) {
        margin-top: 10px;
    }

    #mBot .r .box {
        border-radius: 10px;
        position: relative;
    }

    #mBot .r .box a {
        color: #fff;
    }

    #mBot .r .box:before {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        content: '';
        border-radius: 10px;
        background: #0F1F70;
        filter: opacity(.7);
        backdrop-filter: blur(5px);
    }

    #mBot .r {
        display: flex;
        gap: 10px;
        font-size: 1.25rem;
        flex-wrap: wrap
    }

    #mBot .r>* {
        width: calc(38.333% - 20px/3)
    }

    #mBot .r>.box {
        padding: 35px 10px 35px 35px;
        min-height: 384px
    }

    #mBot .r .col {
        display: flex;
        flex-flow: column;
        gap: 12px;
        width: calc(23.333% - 20px/3)
    }

    #mBot .r .col .box {
        flex: 1;
        background: none
    }

    #mBot .r .col .box:before {
        background: #0F1F70;
        backdrop-filter: blur(5px);
    }

    #mBot .r .t {
        font-size: 1.5rem;
        display: block;
        margin-bottom: 25px;
        line-height: 1;
        font-weight: 700;
        position: relative;
        color: #fff;
        z-index: 1;
    }

    #mBot .r .depth {
        line-height: 1.15;
        letter-spacing: -0.04em;

    }

    #mBot .r .depth>li {
        position: relative;
        padding-left: 13px;

    }

    #mBot .r .depth>li a {
        color: #fff;


    }

    #mBot .r .depth>li:before {
        content: '';
        position: absolute;
        left: 0;
        top: .5em;
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #fff;
        display: block;

    }

    #mBot .r .depth>li:not(:first-child) {
        margin-top: 20px;
    }

    #mBot .r .depth a:hover,
    #mBot .r .depth a:focus {
        text-decoration: underline;
    }

    #mBot .r .col .box img {
        width: 45px;
    }

    #mBot .r .col a {
        display: flex;
        flex-flow: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        gap: 5px;
        position: relative;
        z-index: 1
    }
</style>

<section id="mBot">
    <div style="width:1300px;display:flex;margin: 0 auto;padding-top:110px;padding-bottom:180px;">
        <div class="l">
            <div class="inner">
                <div class="top">
                    <div class="txt" style="font-size: 36px;font-weight: 900;margin-bottom: 20px;line-height: 1.15;letter-spacing: 0;">한국 스키산업의 성장을 주도하는</div>
                    <div class="logo"><img src="<?php echo G5_THEME_URL; ?>/img/index_mLogo.png" alt="한국스키장경영협회"></div>
                </div>

                <div class="btns">
                    <a href="<?php echo G5_THEME_URL; ?>/pages/greeting.php" title="페이지 이동">회장 인사말</a>
                    <a href="<?php echo G5_URL; ?>/bbs/content.php?co_id=contacts" title="페이지 이동">오시는 길</a>
                </div>
            </div>

        </div>


        <ul class="r">
            <li class="box">
                <strong class="t">협회 소개</strong>
                <ul class="depth">
                    <li><a href="<?php echo G5_THEME_URL; ?>/pages/company.php" title="페이지 이동">협회정보</a></li>
                    <li><a href="<?php echo G5_THEME_URL; ?>/pages/tasks.php" title="새 창 열림">협회업무</a></li>
                    <li><a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=history" title="페이지 이동">협회연혁</a></li>
                    <li><a href="<?php echo G5_THEME_URL; ?>/pages/organization.php" title="페이지 이동">조직도</a></li>
                    <li><a href="<?php echo G5_THEME_URL; ?>/pages/presidents.php" title="페이지 이동">역대회장</a></li>
                    <li><a href="<?php echo G5_THEME_URL; ?>/pages//join.php" title="페이지 이동">협회가입안내</a></li>
                </ul>
            </li>
            <li class="box">
                <strong class="t">회원사 소개</strong>
                <ul class="depth">
                    <li><a href="<?php echo G5_THEME_URL; ?>/pages/members_ceo.php" title="페이지 이동">회원사 대표자 소개</a></li>
                    <li><a href="<?php echo G5_THEME_URL; ?>/pages/skiarea.php" title="페이지 이동">지역별 스키장 현황</a></li>
                    <li><a href="<?php echo G5_THEME_URL; ?>/pages/members_resort.php" title="페이지 이동">회원사 소개</a></li>


                </ul>
            </li>
            <li class="col">
                <div class="box">
                    <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=notice" title="페이지 이동">
                        <img src="https://www.sports.or.kr/static/sports/svg/ico-i2.svg" alt="">
                        공지사항
                    </a>
                </div>
                <div class="box">
                    <a href="<?php echo G5_THEME_URL; ?>/pages/safety_rules.php" title="페이지 이동">
                        <img src="https://www.sports.or.kr/static/sports/svg/ico-i2.svg" alt="">
                        안전수칙
                    </a>
                </div>

            </li>
        </ul>

        <!--/div-->

    </div>
</section>

<hr>

<!--section class="mainContentsW100 background-light">
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
</section-->

<style>
    #mPartner {
        padding: 80px 0
    }

    #mPartner .tit {
        font-size: 1.875rem;
        font-weight: 700;
        color: #5f5f5f;
        display: flex;
        justify-content: space-between;
        align-items: end;
        margin-bottom: 30px;
        line-height: 1.15;
    }

    #mPartner .green:after {
        background: linear-gradient(90deg, #068081 0%, transparent 100%)
    }

    #mPartner .green2:after {
        background: linear-gradient(90deg, #3E9E5F 0%, transparent 100%)
    }

    #mPartner .black:after {
        background: linear-gradient(90deg, var(--black3) 0%, transparent 100%)
    }

    #mPartner .group:not(:first-child) {
        margin-top: 80px;
    }

    #mPartner .div {
        display: flex;
        flex-wrap: wrap;
        margin: 0 0 -12px -12px
    }

    #mPartner .div>li {
        border: 1px solid #5f5f5f;
        border-radius: 5px;
        width: calc(20% - 12px);
        margin: 0 0 12px 12px;
        transition: .3s;
    }

    #mPartner .div>li:hover {
        border-color: #3D3D3D;
    }

    #mPartner .div a {
        padding-bottom: 30%;
        position: relative;
        display: block;
    }

    #mPartner .div img {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        max-width: 80%;
        max-height: 80%
    }

    @media (max-width:767px) {
        #mPartner .div>li {
            width: calc(33.333% - 12px)
        }

        #mPartner {
            padding-top: 50px;
        }

        #mPartner .group:not(:first-child) {
            margin-top: 50px;
        }

        #mPartner .div a {
            padding-bottom: 40%;
        }
    }
</style>


<section class="mainContents">
    <section id="mPartner">
        <ul class="inner">
            <li class="group">
                <div class="tit">회원사</div>

                <ul class="div">
                    <li>
                        <a href="https://www.yongpyong.co.kr/" target="_blank" title="모나용평">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_1.jpg" alt="모나용평">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mdysresort.com/" target="_blank" title="무주리조트">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_4.jpg" alt="무주리조트">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.sonohotelsresorts.com/complex_vp" target="_blank" title="비발디파크">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_5.jpg" alt="비발디파크">
                        </a>
                    </li>
                    <li>
                        <a href="https://phoenixhnr.co.kr/" target="_blank" title="휘닉스평창">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_6.jpg" alt="휘닉스평창">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.wellihillipark.com/" target="_blank" title="웰리힐리파크">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_7.jpg" alt="웰리힐리파크">
                        </a>
                    </li>

                    <li>
                        <a href="https://www.jisanresort.co.kr/" target="_blank" title="지산">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_8.jpg" alt="지산포레스트">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.elysian.co.kr/home" target="_blank" title="강촌">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_9.jpg" alt="엘리시안강촌">
                        </a>
                    </li>
                    <li>
                        <a href="https://oakvalley.co.kr/" target="_blank" title="오크밸리">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_10.jpg" alt="오크밸리">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.high1.com/" target="_blank" title="하이원">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_11.jpg" alt="하이원리조트">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.konjiamresort.co.kr/" target="_blank" title="곤지암">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_12.jpg" alt="곤지암리조트">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.alpensia.com/" target="_blank" title="알펜시아">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_13.jpg" alt="알펜시아리조트">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.o2resort.com/" target="_blank" title="오투">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_16v1.jpg" alt="오투리조트">
                        </a>
                    </li>
                    </ui>
            </li>

        </ul>


        <ul class="inner" style="margin-top:40px;">
            <li class="group">
                <div class="tit">관련기관</div>

                <ul class="div">
                    <li>
                        <a href="https://www.mcst.go.kr/site/main.jsp" target="_blank" title="문화체육관광부">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_19.jpg" alt="문화체육관광부">
                        </a>
                    </li>
                    <li>
                        <a href="https://state.gwd.go.kr/portal" target="_blank" title="강원도">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_20.jpg" alt="강원도">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.gg.go.kr/" target="_blank" title="경기도">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_21.jpg" alt="경기도">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.jeonbuk.go.kr/index.jeonbuk" target="_blank" title="전라북도">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_22.jpg" alt="전라북도">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.gyeongnam.go.kr/index.gyeong" target="_blank" title="경상남도">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_23.jpg" alt="경상남도">
                        </a>
                    </li>

                    <li>
                        <a href="https://korean.visitkorea.or.kr/main/main.do" target="_blank" title="한국관광공사">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_24.jpg" alt="한국관광공사">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.kspo.or.kr/kspo/main/main.do" target="_blank" title="국민체육진흥공단">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_25.jpg" alt="국민체육진흥공단">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.sportsafety.or.kr/front/main.do" target="_blank" title="스포츠안전재단">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_26.jpg" alt="스포츠안전재단">
                        </a>
                    </li>

                    </ui>
            </li>

        </ul>



        <ul class="inner" style="margin-top:40px;">
            <li class="group">
                <div class="tit">후원사</div>

                <ul class="div">
                    <li>
                        <a href="https://www.carvekorea.com" target="_blank" title="카브">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_151.jpg" alt="카브스포츠">
                        </a>
                    </li>
                    <li>
                        <a href="https://skitzo.co.kr" target="_blank" title="SKITZO">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_162.jpg" alt="SKITZO">
                        </a>
                    </li>
                    <li>
                        <a href="https://smartstore.naver.com/medoutdoor" target="_blank" title="POC">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_poc.png" alt="POC">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.leki.kr/" target="_blank" title="LEKI">
                            <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_leki.png" alt="LEKI">
                        </a>
                    </li>

                    </ui>
            </li>




        </ul>

    </section>
</section>



<hr>


<?php
if (defined('_INDEX_')) { /* index에서만 실행 */
    include G5_BBS_PATH . '/newwin.inc.php'; /* 팝업레이어 */
}
?>

<?php
include_once(G5_THEME_PATH . '/tail.php');
