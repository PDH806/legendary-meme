<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "회원사 대표자 소개";

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
    /*협회 회원사 대표*/
    .table_width_100 {
        width: 100%;
        margin-bottom: 40px;
        border-top: 3px solid #333;
        border-bottom: 3px solid #333;
        border-collapse: collapse;
    }


    .table_width_100 th,
    td {
        text-align: center;
        padding: 10px;
        border: 1px solid #888;
    }

    .table_width_100 th {
        background-color: #efefef;
    }
</style>


<div id="page-content">

    <div class="tab_img">
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/mb_ceo.jpg" alt="회원사 대표자 소개">
    </div>

    <div style="padding-top:50px">
        <span class="sb_title">임원사</span> Officer
        <table class="table_width_100">
            <tbody>
                <tr>
                    <th width="50%">한국스키장경영협회(회장)</th>
                    <th width="50%"><a href="http://www.daemyungresort.com/vp/" target="_blank">비발디파크(부회장)</a></th>

                </tr>
                <tr class="name">
                    <td>임충희 대표이사</td>
                    <td>이병천 대표이사</td>

                </tr>
            </tbody>
        </table>
        <span class="sb_title">감사사</span> Auditor
        <table class="table_width_100">
            <tbody>
                <tr>
                    <th><a href="http://www.jisanresort.co.kr/" target="_blank">지산포레스트리조트(감사)</a></th>
                </tr>
                <tr class="name">
                    <td>고호림 대표이사</td>
                </tr>
            </tbody>
        </table>
        <span class="sb_title">회원사</span> Member Company
        <table class="table_width_100">
            <tbody>
                <tr>

                    <th width="25%"><a href="http://www.yongpyong.co.kr/" target="_blank">용평리조트</a></th>
                    <th width="25%"><a href="http://www.mdysresort.com/" target="_blank">무주덕유산리조트</a></th>
                    <th width="25%"><a href="http://phoenixhnr.co.kr/pyeongchang/index" target="_blank">휘닉스파크</a></th>
                    <th width="25%"><a href="https://www.wellihillipark.com/sub3/" target="_blank">웰리힐리파크</a></th>
                </tr>
                <tr class="name">

                    <td>임학운 대표이사</td>
                    <td>배성수 사장</td>
                    <td>전영기 대표이사</td>

                    <td>민영민 대표이사</td>
                </tr>
                <tr>
                    <th><a href="https://www.elysian.co.kr/main.asp" target="_blank">엘리시안 강촌</a></th>
                    <th><a href="http://www.oakvalley.co.kr/" target="_blank">오크밸리</a></th>
                    <th><a href="http://www.high1.com/Hhome/main.high1" target="_blank">하이원리조트</a></th>
                    <th><a href="https://www.konjiamresort.co.kr/main.dev" target="_blank">곤지암리조트</a></th>
                </tr>
                <tr class="name">
                    <td>김태진 대표이사</td>
                    <td>조영환 대표이사</td>
                    <td>&nbsp;</td>
                    <td>정현 상무</td>
                </tr>
                <tr>
                    <th><a href="http://www.alpensiaresort.com" target="_blank">알펜시아리조트</a></th>
                    <th><a href="http://www.o2resort.com/" target="_blank">오투리조트</a></th>
                </tr>
                <tr class="name">
                    <td>김강우 부사장</td>
                    <td>김남규 대표이사</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /cp_box -->

</div>


<?php
include_once('../tail.php');
