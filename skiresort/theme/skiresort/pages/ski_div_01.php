<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "스키지도요원 소개";

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
        margin-right: 2%;
        margin-top: 20px;
        padding-top: 20px;
        float: left;
        border-top: 1px solid black;
    }

    .box_div_content .right_content_a {
        width: 75%;
        padding-bottom: 25px;
        padding-top: 20px;
        float: left;
        border-top: 1px solid black;
        margin-top: 20px;
    }




    .table_simple_a {
        margin: 20px;
        border: 5px;
        width: 100%;
    }

    .table_simple_a img {
        width: 100%;
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
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/teach_ski.jpg" alt="스키지도요원">
    </div>

    <div class="box_div_content">

        <div>
            <div class="left_content_a"><span class="sb_title">스키지도요원의 정의</span></div>
            <div class="right_content_a">
                <h5>체육시설의 설치 · 이용에 관한 법률 제24조 및 동시행규칙 제 23조 [별표6]</h5>
                <p>안전, 위생기준 관련 스키장에서 스키어들이 스키기술을 습득케 하는 자로서 안전한 스키문화정착을 위하여 노력하고 있다.
                </p>
            </div>

        </div>


        <div>
            <div class="left_content_a"><span class="sb_title">스키지도요원의 임무</span></div>
            <div class="right_content_a">
                <h5 class="text_size_18"><i class="fa fa-square"></i> 스키어들의 스키기술 습득</h5>

                <br>
                <p>최근 통계에 의하면 스키장 사고의 원인 중 스키 기술 미숙으로 인한 사고가 높은 비율을 차지하고 있다.
                    따라서 처음 스키에 입문하는 스키어들은 각 사의 스키지도요원에게 체계적인 스키기술을 배워야한다.
                </p>

                <br><br>
                <h5 class="text_size_18"><i class="fa fa-square"></i> 안전한 스키문화 정착에 기여</h5>
                <br>

                <p>스키장 사고의 대부분이 안전 수칙을 지키지 않아 생기는 만큼 스키지도요원들은 스키기술을 전수할 때 안전수칙의 중요성을 강조하고 있다.</p>
            </div>
        </div>


    </div><!--/tab_txt-->

</div>


<?php
include_once('../tail.php');
