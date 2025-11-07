<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "원서접수 및 조회";

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
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/cp_patrol.jpg" alt="원서접수 및 조회">
    </div>

    <div class="box_div_content">


        <div class="tc_set_1">
            <p class="sb_title">원서접수 및 조회</p>
            <table class="table_simple_b">
                <tr>
                    <th style="border-top:3px solid black">자격명</th>
                    <td style="border-top:3px solid black">스키구조요원</td>
                </tr>
                <tr>
                    <th>자격의 종류</th>
                    <td>등록민간자격</td>
                </tr>
                <tr>
                    <th>등록번호</th>
                    <td>2018-001772</td>
                </tr>
                <tr>
                    <th>자격발급기관</th>
                    <td>(사)한국스키장경영협회</td>
                </tr>
                <tr>
                    <th>응시료</th>
                    <td>165,000원(부가세 포함)</td>
                </tr>
                <tr>
                    <th>응시조건</th>
                    <td>1. 만 19세 이상인 자 <br>
                        2. 패트롤 업무를 원활하게 수행할 수 있는 스키실력을 갖고 있는 자
                    </td>
                </tr>
                <tr>
                    <th>필기면제자</th>
                    <td>생활체육지도자 및 경기지도자 중 스키종목 자격자 <br>
                        (해당 자격 자료 파일 업로드 필수)
                    </td>
                </tr>
                <tr>
                    <th style="border-bottom:3px solid black">환불규정</th>
                    <td style="border-bottom:3px solid black">참가비 환불은 아래기간의 경우에만 가능하며 이 후에는 취소 및 환불이 일체 불가능합니다. <br>
                        또한, 환불 시 이체 수수료는 참가자 본인이 부담해야 합니다. <br><br>

                        <span style="color:chocolate">
                            - Bib(비브) 배부 2일전 취소 100% 환불 <br>
                            - Bib(비브) 배부 1일전 취소 환불 불가
                        </span>

                    </td>
                </tr>
            </table>
        </div>

        <div class="tc_set_1">
            <p class="sb_title">자격관리기관 정보</p>
            <table class="table_simple_b">
                <tr>
                    <th style="border-top:3px solid black">기관명</th>
                    <td style="border-top:3px solid black">(사)한국스키장경영협회</td>
                </tr>
                <tr>
                    <th>대표자</th>
                    <td>임충희</td>
                </tr>
                <tr>
                    <th>연락처</th>
                    <td>02-3473-1275 (이메일 : ski@skiresort.or.kr)</td>
                </tr>
                <tr>
                    <th>소재지</th>
                    <td>서울 송파구 오금로 58 아이스페이스 1201호</td>
                </tr>
                <tr>
                    <th style="border-bottom:3px solid black">홈페이지</th>
                    <td style="border-bottom:3px solid black">www.skiresort.or.kr</td>
                </tr>
            </table>

        </div>

        <div style="padding:30px 0 20px 0;border-bottom:1px solid #666;">
            <b>- 민간자격조회 바로가기</b> <br>
            <a href="https://www.pqi.or.kr" target="_blank">민간자격정보서비스 (www.pqi.or.kr) </a>
        </div>

        <div class="tc">
            <div class="btn_over"><a href="<?php echo G5_THEME_URL . "/html/my_form/sbak_console_10.php?event_sort=B07"; ?>" class="navy_btn">접수하기</a></div>
            <div class="btn_over"><a href="<?php echo G5_THEME_URL . "/html/my_form/sbak_console_04.php"; ?>" class="navy_btn">접수확인 및 취소</a></div>
        </div>



    </div>

</div>


<?php
include_once('../tail.php');
