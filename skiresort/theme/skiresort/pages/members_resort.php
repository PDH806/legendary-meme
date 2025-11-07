<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "회원사 소개";

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
    /*회원사 소개*/


    ul,
    li {
        list-style: none;
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


    .list_info {
        display: block;
        width: 100%;
        margin-top: 30px;

    }

    .list_left {
        float: left;
        width: 25%;
        border-top: 1px solid #666;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .list_right {
        float: left;
        width: 75%;
        border-top: 1px solid #666;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .list_img {
        width: 100%;
        height: 100%;
    }

    .list_img img {
        width: 80%;
        align-items: center;
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

    <div class="tab_img">
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/mb_ski_list.jpg" alt="회원사 소개">
    </div>



    <div class="tab">
        <ul class="tabnav">
            <li><a href="#tab01">강원도</a></li>
            <li><a href="#tab02">경기도</a></li>
            <li><a href="#tab03">전라북도</a></li>
        </ul>
        <div class="tabcontent">

            <div id="tab01">

                <div class="list_box">

                    <ul class="list_info">
                        <li class="list_left">
                            <div class="list_img">
                                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/mb_list_1_N.jpg" alt="용평 리조트">
                            </div>
                        </li>
                        <li class="list_right">
                            <ul>
                                <li><span>주소</span> 강원도 평창군 대관령면 올림픽로 715(구 용산리 130)</li>
                                <li><span>연락처</span> <a href="tel:033-335-5757">033-335-5757</a></li>
                            </ul>
                            <a class="list_more" href="http://www.yongpyong.co.kr/" target="_blank">자세히보기</a>
                        </li>
                    </ul>
                    <ul class="list_info">
                        <li class="list_left">
                            <div class="list_img">
                                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/mb_list_4.jpg" alt="대명리조트">
                            </div>
                        </li>
                        <li class="list_right">
                            <ul>
                                <li><span>주소</span> 강원도 홍천군 서면 한치골길 262 </li>
                                <li><span>연락처</span> <a href="tel:1588-4888">1588-4888</a></li>
                            </ul>
                            <a class="list_more" href="http://www.daemyungresort.com/" target="_blank">자세히보기</a>
                        </li>
                    </ul>
                    <ul class="list_info">
                        <li class="list_left">
                            <div class="list_img">
                                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/mb_list_2.jpg" alt="휘닉스 평창">
                            </div>
                        </li>
                        <li class="list_right">
                            <ul>
                                <li><span>주소</span> 강원도 평창군 봉평면 태기로 174</li>
                                <li><span>연락처</span> <a href="tel:1577-0069">1577-0069</a></li>
                            </ul>
                            <a class="list_more" href="http://phoenixpark.co.kr/pp/index" target="_blank">자세히보기</a>
                        </li>
                    </ul>
                    <ul class="list_info">
                        <li class="list_left">
                            <div class="list_img">
                                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/mb_list_3.jpg" alt="웰리힐리파크">
                            </div>
                        </li>
                        <li class="list_right">
                            <ul>
                                <li><span>주소</span> 강원도 횡성군 둔내면 고원로 451</li>
                                <li><span>연락처</span> <a href="tel:1544-8833">1544-8833</a></li>
                            </ul>
                            <a class="list_more" href="https://www.wellihillipark.com/sub3/" target="_blank">자세히보기</a>
                        </li>
                    </ul>
                    <ul class="list_info">
                        <li class="list_left">
                            <div class="list_img">
                                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/mb_list_7.jpg" alt="엘리시안 강촌">
                            </div>
                        </li>
                        <li class="list_right">
                            <ul>
                                <li><span>주소</span> 강원도 춘천시 남산면 북한강변길 688</li>
                                <li><span>연락처</span> <a href="tel:033-260-2000">033-260-2000</a></li>
                            </ul>
                            <a class="list_more" href="http://www.elysian.co.kr/main.asp" target="_blank">자세히보기</a>
                        </li>
                    </ul>
                    <ul class="list_info">
                        <li class="list_left">
                            <div class="list_img">
                                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_27.jpg"" alt=" 오크밸리">
                            </div>
                        </li>
                        <li class="list_right">
                            <ul>
                                <li><span>주소</span> 강원도 원주시 지정면 오크밸리 1길 66</li>
                                <li><span>연락처</span> <a href="tel:1588-7676">1588-7676</a></li>
                            </ul>
                            <a class="list_more" href="http://www.oakvalley.co.kr/oak_new/index.asp" target="_blank">자세히보기</a>
                        </li>
                    </ul>
                    <ul class="list_info">
                        <li class="list_left">
                            <div class="list_img">
                                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ft_link_28.jpg" alt="하이원리조트">
                            </div>
                        </li>
                        <li class="list_right">
                            <ul>
                                <li><span>주소</span> 강원도 정선군 고한읍 하이원길 424</li>
                                <li><span>연락처</span> <a href="tel:1588-7789">1588-7789</a></li>
                            </ul>
                            <a class="list_more" href="http://www.high1.com/Hhome/main.high1" target="_blank">자세히보기</a>
                        </li>
                    </ul>
                    <ul class="list_info">
                        <li class="list_left">
                            <div class="list_img">
                                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/mb_list_8.jpg" alt="알펜시아 리조트">
                            </div>
                        </li>
                        <li class="list_right">
                            <ul>
                                <li><span>주소</span> 강원도 평창군 대관령면 솔봉로 325 (232-952)</li>
                                <li><span>연락처</span> <a href="tel:033-339-0000">033-339-0000</a></li>
                            </ul>
                            <a class="list_more" href="http://www.alpensiaresort.com" target="_blank">자세히보기</a>
                        </li>
                    </ul>
                    <ul class="list_info">
                        <li class="list_left">
                            <div class="list_img">
                                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/ot_resort.png" alt="오투 리조트">
                            </div>
                        </li>
                        <li class="list_right">
                            <ul>
                                <li><span>주소</span> 강원도 태백시 서학로 861</li>
                                <li><span>연락처</span> <a href="tel:033-580-7000">033-580-7000</a></li>
                            </ul>
                            <a class="list_more" href="http://www.o2resort.com/" target="_blank">자세히보기</a>
                        </li>
                    </ul>
                </div>


            </div>


            <div id="tab02">


                <div class="list_box">

                    <ul class="list_info">
                        <li class="list_left">
                            <div class="list_img">
                                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/mb_list_10.jpg" alt="지산포레스트리조트">
                            </div>
                        </li>
                        <li class="list_right">
                            <ul>
                                <li><span>주소</span> 경기 이천시 마장면 지산로 267</li>
                                <li><span>연락처</span> <a href="tel:031-644-1200">031-644-1200</a></li>
                            </ul>
                            <a class="list_more" href="http://www.jisanresort.co.kr/" target="_blank">자세히보기</a>
                        </li>
                    </ul>

                    <ul class="list_info">
                        <li class="list_left">
                            <div class="list_img">
                                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/mb_list_12.jpg" alt="곤지암리조트">
                            </div>
                        </li>
                        <li class="list_right">
                            <ul>
                                <li><span>주소</span> 경기도 광주시 도척면 도척윗로 278</li>
                                <li><span>연락처</span> <a href="tel:02-1661-8787">02-1661-8787</a></li>
                            </ul>
                            <a class="list_more" href="https://www.konjiamresort.co.kr/main.dev" target="_blank">자세히보기</a>
                        </li>
                    </ul>

                </div>


            </div>

            <div id="tab03">


                <div class="list_box">

                    <ul class="list_info">
                        <li class="list_left">
                            <div class="list_img">
                                <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/mb_list_13.jpg" alt="덕유산 리조트">
                            </div>
                        </li>
                        <li class="list_right">
                            <ul>
                                <li><span>주소</span> 전북 무주군 설천면 만선로 185</li>
                                <li><span>연락처</span> <a href="tel:063-322-9000">063-322-9000</a></li>
                            </ul>
                            <a class="list_more" href="http://www.mdysresort.com/" target="_blank">자세히보기</a>
                        </li>
                    </ul>

                </div>



            </div>
        </div>
    </div>






</div>


<?php
include_once('../tail.php');
