<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "시험정보 및 자료";

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

    .box_div_content .left_content_a {
        width: 23%;

        margin-top: 20px;
        padding-top: 20px;
        float: left;

    }

    .box_div_content .right_content_a {
        width: 77%;
        padding-bottom: 25px;
        padding-top: 20px;
        float: left;
        margin-top: 20px;
    }



    .table_simple_b {
        width: 100%;
        border-spacing: 0;
        border-top: 3px solid #000;
    }

    .table_simple_b tr:hover {
        background-color: #f4f4f4;
    }

    .table_simple_b th {
        width: 20%;
        font-weight: 600;
        padding: 15px;
        border-left: none;
        border-bottom: 1px solid #c6c6c6;

    }

    .table_simple_b td {
        text-align: left;
        padding: 15px;
        border-bottom: 1px solid #c6c6c6;

    }

    @media screen and (max-width:576px) {
        .box_div_content .left_content_a {
            float: none;
            width: 100%;
        }

        .box_div_content .right_content_a {
            width: 100%;
            padding: 0 0 25px 0px;
            float: none;
        }

        .table_simple_b {
            margin: 20px 0 20px 0;
            width: 100%;
        }

        .table_simple_b th {
            width: 30%;

        }
    }
</style>


<div id="page-content">


    <div class="box_div_content">

        <div>
            <div class="left_content_a"><span class="sb_title">Teaching 1 교본</span></div>
            <div class="right_content_a">
                <table class="table_simple_b">
                    <tr>
                        <th>필기교본</th>
                        <td>
                            <a href="<?php echo G5_THEME_URL; ?>/sbak_files/ski_teaching_guide.pdf" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/img/PDF-59.svg" width="30px"> 교본</a>
                        </td>
                    </tr>
                    <tr>
                        <th>실기교본</th>
                        <td>
                            <ul class="video_tab">
                                <li><a href="https://www.youtube.com/embed/eABS1oixjSQ" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/img/YouTube.svg" width="30px"> 플루그보겐</a></li>
                                <li><a href="https://www.youtube.com/embed/toE8-PeFXpo" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/img/YouTube.svg" width="30px"> 슈템턴</a></li>
                                <li><a href="https://www.youtube.com/embed/5OtcmDw3BGo" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/img/YouTube.svg" width="30px"> 스탠다드롱턴</a></li>
                                <li><a href="https://www.youtube.com/embed/_dnMVC4-thw" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/img/YouTube.svg" width="30px"> 스탠다드숏턴</a></li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>

        </div>





        <div>
            <div class="left_content_a"><span class="sb_title">Teaching 2 교본</span></div>
            <div class="right_content_a">
                <table class="table_simple_b">
                    <tr>
                        <th>필기교본</th>
                        <td><a href="<?php echo G5_THEME_URL; ?>/sbak_files/ski_teaching_guide.pdf" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/img/PDF-59.svg" width="30px"> 교본</a></td>
                    </tr>
                    <tr>
                        <th>실기교본</th>
                        <td>
                            <ul class="video_tab">
                                <li><a href="https://www.youtube.com/embed/8sIdTaWbLhs" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/img/YouTube.svg" width="30px"> 종합할강</a></li>
                                <li><a href="https://www.youtube.com/embed/bSQNvsQaVFs" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/img/YouTube.svg" width="30px"> 스탠다드숏턴</a></li>
                                <li><a href="https://www.youtube.com/embed/7N7eMZsuIyo" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/img/YouTube.svg" width="30px"> 스탠다드롱턴</a></li>
                                <li><a href="https://www.youtube.com/embed/EcmUw2hKzEU" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/img/YouTube.svg" width="30px"> 프로그레시브롱턴</a></li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>

        </div>


        <div>
            <div class="left_content_a"><span class="sb_title">Teaching 3 교본</span></div>
            <div class="right_content_a">
                <table class="table_simple_b">
                    <tr>
                        <th>필기교본</th>
                        <td><a href="<?php echo G5_THEME_URL; ?>/sbak_files/ski_teaching_guide.pdf" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/img/PDF-59.svg" width="30px"> 교본</a></td>
                    </tr>

                </table>
            </div>

        </div>


    </div>

</div>


<?php
include_once('../tail.php');
