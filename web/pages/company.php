<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

//페이지 제목 지정
$g5['title'] = "협회정보";

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
		<img src="../sbak_imgs/cp_about_1.jpg" alt="협회 소개">
	</div>
	<div>
		<div class="left-45">
			<ul class="big-ui-list">
				<li>스키장 사업에 관한 지도, 감독 및 홍보 업무</li>
				<li>스키장 사업에 대한 대정부 건의</li>
				<li>스키장 안전사고 예방에 관한 제반 업무</li>
				<li>문화체육관광부 장관이 위임하는 사업</li>
				<li>기타 본회의 목적 달성을 위한 필요한 업무</li>
			</ul>
		</div>
		<div class="right-55">
			<ul class="big-ui-list">
				<li>스키장 사업의 건전한 발전과 회원사의 권익증진을 위한 사업</li>
				<li>본 회의 목적 달성을 위한 자율 규제에 관한 업무</li>
				<li>스키장 설치 및 운영에 관한 조사연구 및 정보 교환</li>
				<li>스키장 종사자에 대한 교육훈련 및 연수사업</li>
				<li>스키장 사업에 관한 관계 기관, 제 단체와 관련된 업무</li>
			</ul>
		</div>
	</div>
	<div>

		<div class="left-70">
			<span class="sb_title">CI소개</span>
			<p>&nbsp;&nbsp;본 심볼의 기본형은 역동적인 스키어의 모습을 나타냄으로써 남녀노소 누구라도 한눈에 스키라는 스포츠를 인지할 수 있으며 한국스키장경영협회의 진취적인 이미지를 떠올릴 수 있도록 하였다.
				<br>&nbsp;&nbsp;빨강, 주황 라인은 리조트의 산을 의미하며 스키어가 슬로프에서 내려오는 모습을 하얀색으로 형상화하여 포실포실한 눈의 느낌과 활강 후 생긴 눈보라를 표현하였다.
			</p>
		</div>
		<div class="right-30">
			<img src="../sbak_imgs/ci.png" width="100% " alt="한국스키장경영협회 CI소개">
		</div>
	</div>
	<div>
		<div class="left-50">
			<img src="../sbak_imgs/cp_logo.jpg" style="width:100%;" alt="한국스키장경영협회 로고">
		</div>
		<div class="right-50">
			<table class="table-style-01">
				<tr>
					<th>법인명</th>
					<td>사단법인 한국스키장경영협회</td>
				</tr>
				<tr>
					<th>소재지</th>
					<td>서울 송파구 오금로 58 아이스페이스 1201호</td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td>02-3473-1275, 02-3473-1277</td>
				</tr>
				<tr>
					<th>설립일</th>
					<td>1990년 9월 7일</td>
				</tr>
				<tr>
					<th>지도, 감독기관</th>
					<td>문화체육관광부</td>
				</tr>
				<tr>
					<th>법인성격</th>
					<td>비영리</td>
				</tr>
			</table>

		</div>
	</div>
</div>

</div>


<?php
include_once('../tail.php');
