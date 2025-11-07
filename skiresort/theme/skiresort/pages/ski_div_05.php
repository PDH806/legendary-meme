<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "데몬스트레이터";

//본 페이지에 해당되는 css가 있을 경우 아래 css 삽입 코드를 활성화 해주시기 바랍니다.
add_stylesheet('<link rel="stylesheet" href="' . G5_THEME_CSS_URL . '/page.css?ver=' . G5_CSS_VER . '">', 0);
/*
		테마폴더로의 링크가 길어지는 경우 테마폴더 내 pages 폴더를 
		그누보드 adm, data 폴더와 동일한 경로로 복사해 주시면 
		http://도메인/pages/company.php 와 같은 링크로 이용 가능합니다. 

		관리자모드 메뉴관리에서 본 페이지의 주소는 http 또는 https 부터 시작되는 주소로 넣어주시기 바랍니다.
	*/

/* 페이지설정 코드 입력! */
include_once('../head.php');
?>

<style>
    /*협회 가입안내*/
    .box_div_content {
        margin: 40px 0px 0 0px;
    }




    /*tab css*/
    .tab {
        float: left;
        width: 100%;
        height: 100%;
        padding-top: 50px;
    }

    .tabnav {
        font-size: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    .tabnav li {
        display: inline-block;
        height: 46px;
        text-align: center;
        border-right: 1px solid #ddd;
    }

    .tabnav li a:before {
        content: "";
        position: absolute;
        left: 0;
        top: 0px;
        width: 100%;
        height: 3px;
    }

    .tabnav li a.active:before {
        background: #7ea21e;
    }

    .tabnav li a.active {
        border-bottom: 1px solid #fff;
    }

    .tabnav li a {
        position: relative;
        display: block;
        background: #f8f8f8;
        color: #000;
        padding: 0 30px;
        line-height: 46px;
        text-decoration: none;
        font-size: 16px;
    }

    .tabnav li a:hover,
    .tabnav li a.active {
        background: #fff;
        color: #7ea21e;
    }

    .tabcontent {
        padding: 20px;
        height: 100%;
        border: 1px solid #ddd;
        border-top: none;
    }




    .tc_set_1 div {
        float: left;
        width: 25%;
        text-align: center;
        padding-bottom: 10px;
    }

    .tc_set_1 img {
        border-radius: 5px;
        padding-bottom: 10px;
    }

    .tc_set_1 span {
        font-weight: 500;
        border-radius: 5px;
        background-color: #efefef;
        padding: 3px 30px 3px 30px;
        border: 1px solid #666;

    }



    @media screen and (max-width:576px) {
        .tc_set_1 div {
            float: left;
            width: 50%;
            text-align: center;
            padding-bottom: 10px;
        }

    }
</style>
<script>
    $(function() {
        $('.tabcontent > div').hide();
        $('.tabnav a').click(function() {
            $('.tabcontent > div').hide().filter(this.hash).fadeIn();
            $('.tabnav a').removeClass('active');
            $(this).addClass('active');
            return false;
        }).filter(':eq(0)').click();
    });
</script>

<div id="page-content">


    <div class="tab">
        <ul class="tabnav">
            <li><a href="#tab01">1기</a></li>
            <li><a href="#tab02">2기</a></li>
            <li><a href="#tab03">3기</a></li>
            <li><a href="#tab04">4기</a></li>
        </ul>
        <div class="tabcontent">

            <div id="tab01">



                <div class="tc_set_1">
                    <p class="sb_title">데몬 1기</p> <br>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon1.jpg"><br><span>노은진</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon2.jpg"><br><span>민지나</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon3.jpg"><br><span>김정훈</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon4.jpg"><br><span>변기덕</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon5.jpg"><br><span>김창연</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon6.jpg"><br><span>안영택</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon7.jpg"><br><span>김경래</span></div>
                </div>




            </div>
            <div id="tab02">

                <div class="tc_set_1">
                    <p class="sb_title">데몬 2기</p> <br>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon_2_1.jpg"><br><span>노은진</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon_2_2.jpg"><br><span>김정훈</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon_2_3.jpg"><br><span>김창연</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon_2_4.jpg"><br><span>김태규</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon_2_5.jpg"><br><span>방정문</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon_2_6.jpg"><br><span>변기덕</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/demon_2_7.jpg"><br><span>전길영</span></div>
                </div>

            </div>
            <div id="tab03">

                <div class="tc_set_1">
                    <p class="sb_title">데몬 3기</p> <br>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d321.jpg"><br><span>이정미</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d322.jpg"><br><span>전선옥</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d311.jpg"><br><span>김정훈</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d312.jpg"><br><span>김창연</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d313.jpg"><br><span>방정문</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d314.jpg"><br><span>변기덕</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d315.jpg"><br><span>전길영</span></div>
                </div>

            </div>
            <div id="tab04">

                <div class="tc_set_1">
                    <p class="sb_title">데몬 4기</p> <br>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d41.jpg"><br><span>김가람</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d42.jpg"><br><span>김정훈</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d43.jpg"><br><span>김창연</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d44.jpg"><br><span>방정문</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d45.jpg"><br><span>변기덕</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d46.jpg"><br><span>전길영</span></div>
                    <div><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/demon/d47.jpg"><br><span>전선옥</span></div>
                </div>

            </div>
        </div>
    </div>



</div>


<?php
include_once('../tail.php');
