<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "역대회장";

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
    #page-content .cp_president ol {
        list-style: none;
        content: "";
        display: block;
        clear: both;

    }

    #page-content .cp_president ol>li {
        width: 21%;
        margin-bottom: 25px;
        float: left;
        margin-right: 3%;
        list-style: none;

    }

    #page-content .cp_president ol ul img {
        width: 100%;
    }

    #page-content .cp_president ol ul .prd_name {
        margin-bottom: 12px;
        padding: 10px;
        background-color: #210058;
        color: #fff;
        font-size: 15px;
        text-align: center;
        border-radius: 5px;

    }

    #page-content .cp_president ol ul .prd_img {
        padding: 5px;
        border: 1px solid #ccc;
    }

    #page-content .cp_president ol ul .prd_txt {
        padding: 0 5px;

    }

    #page-content .cp_president ol ul .prd_txt .txt {
        position: relative;
        padding-left: 10px;
        font-size: 14px;
        line-height: 1.5;
    }

    #page-content .cp_president ol ul .prd_txt .txt:before {
        position: absolute;
        content: "·";
        left: 0;
    }

    #page-content .cp_president ol ul .prd_txt_name {
        padding: 20px 0 15px;
        font-size: 16px;
        font-weight: 500;
    }

    #page-content .cp_president ol ul .prd_txt_name span {
        margin-left: 7px;
        color: #210058;
        font-size: 14px;
    }



    @media screen and (max-width:576px) {
        #page-content .cp_president ol>li {
            width: 45%;
            margin-bottom: 25px;
            float: left;
            margin: 5px;
        }

        #page-content .cp_president ol ul .prd_txt {
            height: 150px;

        }
    }
</style>


<div id="page-content">

    <div class="tab_img">
        <img src="../sbak_imgs/cp_about_4.jpg" alt="역대회장">
    </div>

    <br>


    <div class="cp_president">


        <ol>
            <li>
                <ul>
                    <li class="prd_name">제16대</li>
                    <li class="prd_img"><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/president_8.jpg"></li>
                    <li class="prd_txt">
                        <p class="prd_txt_name">임충희 <span>회장</span></p>
                        <p class="txt">2022.07.19</p>
                        <p class="txt">엘리시안 강촌 대표이사</p>
                    </li>
                </ul>
            </li>
            <li>
                <ul>
                    <li class="prd_name">제13대~제15대</li>
                    <li class="prd_img"><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/president_7.jpg"></li>
                    <li class="prd_txt">
                        <p class="prd_txt_name">신달순 <span>회장</span></p>
                        <p class="txt">2017.10.17</p>
                        <p class="txt">용평리조트 사장</p>
                    </li>
                </ul>
            </li>
            <li>
                <ul>
                    <li class="prd_name">제12대</li>
                    <li class="prd_img"><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/president_6.jpg"></li>
                    <li class="prd_txt">
                        <p class="prd_txt_name">정창주 <span>사장</span></p>
                        <p class="txt">2016.07.21 ~ 2017.10.16</p>
                        <p class="txt">용평리조트</p>
                    </li>
                </ul>
            </li>
            <li>
                <ul>
                    <li class="prd_name">제10대~제11대</li>
                    <li class="prd_img"><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/president_5.jpg"></li>
                    <li class="prd_txt">
                        <p class="prd_txt_name">조현철 <span>사장</span></p>
                        <p class="txt">2011.05.25 ~ 2016.07.20</p>
                        <p class="txt">대명리조트</p>
                    </li>
                </ul>
            </li>
            <li>
                <ul>
                    <li class="prd_name">제9대</li>
                    <li class="prd_img"><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/president_4.jpg"></li>
                    <li class="prd_txt">
                        <p class="prd_txt_name">장해석 <span>대표이사</span></p>
                        <p class="txt">2009.03.16 ~ 2011.05.24</p>
                        <p class="txt">무주리조트 대표이사</p>
                    </li>
                </ul>
            </li>
            <li>
                <ul>
                    <li class="prd_name">제7대~제8대</li>
                    <li class="prd_img"><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/president_3.jpg"></li>
                    <li class="prd_txt">
                        <p class="prd_txt_name">안명호 <span>대표이사</span></p>
                        <p class="txt">2003.06.20 ~ 2009.03.15</p>
                        <p class="txt">보광휘트니스파크 대표이사</p>
                    </li>
                </ul>
            </li>
            <li>
                <ul>
                    <li class="prd_name">제5대~제6대</li>
                    <li class="prd_img"><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/president_no.jpg"></li>
                    <li class="prd_txt">
                        <p class="prd_txt_name">박동석 <span>대표이사</span></p>
                        <p class="txt">1998.06.20 ~ 2003.06.18</p>
                        <p class="txt">알프스 리조트</p>
                    </li>
                </ul>
            </li>
            <li>
                <ul>
                    <li class="prd_name">제1대~제4대</li>
                    <li class="prd_img"><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/president_no.jpg"></li>
                    <li class="prd_txt">
                        <p class="prd_txt_name">석두성 <span>사장</span></p>
                        <p class="txt">1990.09.13 ~ 1998.06.19</p>
                        <p class="txt">베어스타운</p>
                    </li>
                </ul>
            </li>
        </ol>
    </div>

</div>


<?php
include_once('../tail.php');
