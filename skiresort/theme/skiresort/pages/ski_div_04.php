<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "기술선수권대회";

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





    .table_simple_b {
        width: 100%;
        border-spacing: 0;
    }

    .table_simple_b tr:hover {
        background-color: #f4f4f4;
    }

    .table_simple_b th {
        width: 20%;
        font-weight: 600;
        text-align: right;
        padding: 15px;
        border-left: none;
        border-bottom: 1px solid #c6c6c6;
    }

    .table_simple_b td {
        text-align: left;
        padding: 15px;
        border-bottom: 1px solid #c6c6c6;
    }

    #page-content .tc {
        padding: 30px 0 20px 0;
        display: flex;
        justify-content: center;
    }


    #page-content .tc_set_1 {
        padding: 30px 0 20px 0;

    }

    .table_bd_top_3 {
        border-top: 3px solid black;
    }




    @media screen and (max-width:576px) {

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


    <div class="tab_img">
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/carve_contest.jpg" alt="CARVE">
    </div>


    <div class="tc_set_1">
        <p class="sb_title">기술선수권대회</p>
        <table class="table_simple_b">
            <tr>
                <th class="table_bd_top_3">대회명</th>
                <td class="table_bd_top_3">카브배 기술선수권대회</td>
            </tr>

            <tr>
                <th>접수비</th>
                <td>
                    1. 기술선수권대회(165,000원,부가세 포함) <br>
                    2. 기술선수권대회 + 티칭Ⅲ(242,000원,부가세 포함) <br>
                    <span style="color:chocolate">※기술선수권대회+티칭3 신청자는 기술선수권대회 불합격으로 인한 티칭3 취소 불가</span>
                </td>
            </tr>

            <tr>
                <th>기술선수권대회 <br>응시조건</th>
                <td>
                    1. 티칭2 자격 소지자 <br>
                    2. 레벨2 자격증 소지자 (레벨2 자격증 자료 파일 업로드 필수)
                </td>
            </tr>

            <tr>
                <th>티칭3 응시조건</th>
                <td>당해 연도 기술선수권대회 예선 평균 90점이상 선수 중 티칭Ⅱ 소지자</td>
            </tr>

            <tr>
                <th style="border-bottom: 3px solid black;">환불규정</th>
                <td style="border-bottom: 3px solid black;">
                    참가비 환불은 아래기간의 경우에만 가능하며 이 후에는 취소 및 환불이 일체 불가능합니다. <br>
                    또한, 환불 시 이체 수수료는 참가자 본인이 부담해야 합니다. <br><br>
                    Bib(비브) 배부 2일전 취소 100% 환불 <br>
                    Bib(비브) 배부 1일전 취소 환불 불가

                </td>
            </tr>

        </table>
    </div>



    <div class="tc">
        <div class="btn_over"><a href="<?php echo G5_THEME_URL . "/html/my_form/sbak_console_10.php?event_sort=C01"; ?>" class="navy_btn">접수하기</a></div>
        <div class="btn_over"><a href="<?php echo G5_THEME_URL . "/html/my_form/sbak_console_04.php"; ?>" class="navy_btn">접수확인 및 취소</a></div>
    </div>






</div>


<?php
include_once('../tail.php');
