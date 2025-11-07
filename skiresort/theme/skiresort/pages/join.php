<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "협회가입안내";

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
        margin: 40px 20px 0 20px;
    }

    .box_div_content .left_content_a {
        width: 23%;
        margin-right: 2%;
        float: left;
    }

    .box_div_content .right_content_a {
        width: 75%;
        padding-bottom: 25px;
        float: left;
    }

    .box_div_content .dot {
        list-style-type: disc;
    }

    @media screen and (max-width:576px) {
        .box_div_content .left_content_a {
            float: none;
            width: 100%;
        }

        .box_div_content .right_content_a {
            width: 100%;
            padding: 0 0 25px 20px;
            float: none;
        }
    }
</style>


<div id="page-content">

    <div class="tab_img">
        <img src="../sbak_imgs/cp_join.jpg" alt="협회 가입">
    </div>

    <div class="box_div_content">
        <ul>
            <li>
                <div class="left_content_a"><span class="sb_title">가입안내</span></div>
                <ul class="right_content_a">
                    <li class="dot">현재 스키장업으로 등록되어 운영중에 있는 스키장</li>
                    <li class="dot">현재 공사 진행중에 있는 스키장</li>
                </ul>
            </li>
            <li>
                <div class="left_content_a"><span class="sb_title">가입절차</span></div>
                <ul class="right_content_a">
                    <li class="dot">본 협회의 취지에 동의하고 정관과 모든 규칙을 준수하여야 한다는 전제가 있습니다.</li>
                    <li class="dot">아래에 정해진 구비 서류를 갖춘 후 가입 신청서(별도양식 참조)를 작성하여 협회 사무국에 제출해야 합니다.</li>
                    <li style="margin-top:20px;"><a href="<?php echo G5_THEME_URL; ?>/sbak_files/membership_form.hwp"><img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/cp_join_btn.jpg" alt="가입서류 다운로드"></a></li>
                </ul>
            </li>
            <li>
                <div class="left_content_a"><span class="sb_title">구비서류</span></div>
                <ul class="right_content_a">
                    <li>1. 법인등기부등본 1통</li>
                    <li>2. 회사정관 1통</li>
                    <li>3. 법인인감증명 1통</li>
                    <li>4. 이력서(대표자) 1통</li>
                    <li>5. 스키장 시설현황 1통</li>
                    <li>6. 사업자등록증사본 1통</li>
                    <li>7. 사업계획승인서 1통</li>
                    <li>8. 건설공사공정확인서 1통</li>
                    <li class="ps">* 7,8번은 현재 공사 진행 중인 경우에만 제출- 협회 이사회 및 총회의 의결을 거쳐 가입이 확정됩니다.<br>(단, 회원자격에 결격 사유가 있을 경우에는 반려될 수도 있습니다.)</li>
                </ul>
            </li>
            <li>
                <div class="left_content_a"><span class="sb_title">신청 및 처리 기간</span></div>
                <ul class="right_content_a">
                    <li class="dot">우편이나 방문 신청이 가능합니다.</li>
                    <li class="dot">가입 확정에는 일정 기간이 소요됩니다.</li>
                </ul>
            </li>
            <li>
                <div class="left_content_a"><span class="sb_title">회원의 의무</span></div>
                <ul class="right_content_a">
                    <li class="dot">본 협회의 정관, 각종 규정, 총회 및 이사회의 결의 사항 등을 준수하여야 합니다.</li>
                    <li class="dot">협회의 각종 현황파악을 위한 자료요청에 협조하셔야 합니다.</li>
                    <li class="dot">협회 회비를 납부하셔야합니다.</li>
                </ul>
            </li>
            <li>
                <div class="left_content_a"><span class="sb_title">기타 문의사항</span></div>
                <ul class="right_content_a">
                    <li class="dot">기타 자세한 사항은 아래로 문의하여 주시기 바랍니다.</li>
                    <li class="dot">주소 : 서울 송파구 오금로 58 아이스페이스 1201호</li>
                    <li class="dot">전화 : 02-3473-1275, 1277</li>
                    <li class="dot">팩스 : 02-3473-1278</li>
                </ul>
            </li>
        </ul>
    </div><!--/tab_txt-->

</div>


<?php
include_once('../tail.php');
