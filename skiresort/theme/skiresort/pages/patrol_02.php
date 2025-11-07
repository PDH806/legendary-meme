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




    .table_simple_a {
        margin: 0px;
        border: 5px;
        width: 100%;
    }

    .table_simple_a img {
        width: 90%;
        border-radius: 10px;
        margin-left: auto;
        margin-right: auto;
        display: block;

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

        .table_simple_a {
            margin: 20px 0 20px 0;
            border: 5px;
            width: 100%;
        }
    }
</style>


<div id="page-content">

    <div class="tab_img">
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/cp_patrol.jpg" alt="시험정보 및 자료">
    </div>

    <div class="box_div_content">

        <div>
            <div class="left_content_a"><span class="sb_title">스키구조요원 교본</span></div>
            <div class="right_content_a">
                <table class="table_simple_a">
                    <tr>
                        <td><a href="<?php echo G5_THEME_URL; ?>/sbak_files/patrol_guide_1.pdf" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/test_1.jpg"></a></td>
                        <td><a href="<?php echo G5_THEME_URL; ?>/sbak_files/patrol_guide_2.pdf" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/test_2.jpg"></a></td>
                        <td><a href="<?php echo G5_THEME_URL; ?>/sbak_files/patrol_guide_3.pdf" target="_blank"><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/test_3.jpg"></a></td>

                    </tr>
                    <tr>
                        <td style="text-align:center"><a href="<?php echo G5_THEME_URL; ?>/sbak_files/patrol_guide_1.pdf" target="_blank">[응급처치법]</a></td>
                        <td style="text-align:center"><a href="<?php echo G5_THEME_URL; ?>/sbak_files/patrol_guide_2.pdf" target="_blank">[인체 해부학 및 골절]</a></td>
                        <td style="text-align:center"><a href="<?php echo G5_THEME_URL; ?>/sbak_files/patrol_guide_3.pdf" target="_blank">[후송법-스키와기상-통신전달법]</a></td>
                    </tr>
                </table>
            </div>

        </div>





    </div>

</div>


<?php
include_once('../tail.php');
