<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "협회업무";

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




<div id="page-content">

    <div class="tab_img">
        <img src="../sbak_imgs/cp_work.jpg" alt="협회 소개">
    </div>

    <div class="gubun_content">


        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/work_icon1.png" class="sbak-icon-list-big">

        <span class="txt-mid">스키장 사업과 관련되는 법적, 제도적 규제 완화 또는 철폐 건의</span>
        <ul class="standard-ui-list">
            <li>스키장 발전에 저해가 되는 각종 법률상, 행정상의 요인(과잉규제) 분석 및 제기</li>
            <li>체육시설의 설치, 이용에 관한 법령 중 등록 체육시설업의 시설, 안전 관리 및 위생, 기준상의 규제완화</li>
        </ul>

    </div>
    <div class="gubun_content">
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/work_icon2.png" class="sbak-icon-list-big">
        <span class="txt-mid">연구용역 활용 확대</span>
        <ul class="standard-ui-list">
            <li>스키장 사업의 각종 금융, 세제 및 환경 관리 제도 개선을 위한 연구</li>
            <li>협회의 전문 분과위원회 활성화로 현안문제 해결에 주력</li>
            <li>국내외 정보자료(스키장 시설 현황, 이용실태 등)의 수집, 분석 및 통계</li>
        </ul>
    </div>




    <div class="gubun_content">
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/work_icon3.png" class="sbak-icon-list-big">
        <span class="txt-mid">체육시설로서의 스키장의 위상 정립</span>
        <ul class="standard-ui-list">
            <li>스키장 사업의 지속적 발전을 위한 효율적 정책 실현으로 스키장의 체육시설로서의 이미지 제고 및 위상 정립</li>
            <li>건전 스포츠 시설 및 종합 휴양지로서의 역할 인식을 위한 대국민 홍보 강화</li>
            <li>동계 스포츠의 활성화 방안 강구 및 스키장 시설의 확충</li>
        </ul>
    </div>
    <div class="gubun_content">
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/work_icon4.png" class="sbak-icon-list-big">
        <span class="txt-mid">대국민 홍보 강화</span>
        <ul class="standard-ui-list">
            <li>언론매체를 통하여 국민 건강 및 생활체육으로서의 스키 스포츠 중요성 홍보</li>
            <li>스키장을 청소년 및 가족단위의 건전한 레크리에이션 공간으로 인식하도록 유도/li>
            <li>스키장 홍보 활동</li>
            <li>매체 홍보 : 종합 일간지 기사와 유도, TV 및 라디오와 광고 활용</li>
            <li>빈 매체 홍보 : 스키장에 관한 가이드북, 팸플릿 제작 배포</li>
        </ul>
    </div>



    <div class="gubun_content">
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/work_icon5.png" class="sbak-icon-list-big">
        <span class="txt-mid">회원사의 상호 간의 결속과 의사소통의 체계화</span>
        <ul class="standard-ui-list">
            <li>회원사 간 자료 교환을 통하여 상호 이익 도모</li>
            <li>의견수렴을 통한 회의체제 운영으로 내실화를 기함
                (총회, 이사회 간사회, 실무자 회의 등)</li>

        </ul>
    </div>
    <div class="gubun_content">
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/work_icon6.png" class="sbak-icon-list-big">
        <span class="txt-mid">스키관련(패트롤, 스키 강사) 자격 검정</span>
        <ul class="standard-ui-list">
            <li>스키장의 안전을 지키는 패트롤과 스키 입문자들의 기술 향상을 도와줄 스키강사들의 자격검정 시행</li>
        </ul>
    </div>




    <div class="gubun_content">
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/work_icon7.png" class="sbak-icon-list-big">
        <span class="txt-mid">정부 및 언론기관과의 정책 간담회 개최</span>
        <ul class="standard-ui-list">
            <li>정부 중앙부처 및 시, 도 관계자, 기타 언론기관과의 대화 증진과 유대 강화를 위한 간담회 개최(업계 현안 해결)</li>
            <li>정책 건의 사항 실현을 위하여, 경기 단체, 유관단체와의 역할 분담 및 협력 체제 확대(스키협회, 콘도미니엄 협회, 골프장 협회, 수영장 협회, 한국체육단체 연합 등)</li>
            <li>대정부 정책 자료의 제시, 대국민 이미지 재선을 위한 심포지엄 개최</li>
            <li>스키 관련 저명인사 및 외국인들 초정하여 안전사고 예방 등 경영 기술 제고를 위한 토론회 개최
                (관계 공무원, 스키 전문가, 언론인, 기타 스키 관련 단체 등)</li>
        </ul>
    </div>
    <div class="gubun_content">
        <img src="<?php echo G5_THEME_URL; ?>/sbak_imgs/work_icon8.png" class="sbak-icon-list-big">
        <span class="txt-mid">종사원 사기진작과 근무의욕 고취</span>
        <ul class="standard-ui-list">
            <li>스키장 종사원의 전문 의식 양양과 자질 향상을 위한 교육활동<br>
                1. 안전관리자(패트롤 및 리프트, 제설장비 등) 세미나<br>
                2. 판촉(해외) 담당자 세미나<br>
                3. 총무, 회계 세미나

            </li>
        </ul>

    </div>



</div>

</div>


<?php
include_once('../tail.php');
