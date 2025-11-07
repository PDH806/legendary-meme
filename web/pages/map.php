<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

	//페이지 제목 지정
	$g5['title'] = "오시는 길";
	
	//본 페이지에 해당되는 css가 있을 경우 아래 css 삽입 코드를 활성화 해주시기 바랍니다.
	//add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/page.css?ver='.G5_CSS_VER.'">', 0);
	/*
		테마폴더로의 링크가 길어지는 경우 테마폴더 내 pages 폴더를 
		그누보드 adm, data 폴더와 동일한 경로로 복사해 주시면 
		http://도메인/pages/company.php 와 같은 링크로 이용 가능합니다. 

		관리자모드 메뉴관리에서 본 페이지의 주소는 http 또는 https 부터 시작되는 주소로 넣어주시기 바랍니다.
	*/

/* 페이지설정 코드 입력! */
include_once('../head.php');
?>


	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3166.0730591341667!2d126.90463811584834!3d37.48260227981367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357ca200896e6461%3A0xad70cecf2eb888d6!2z7Ju57IKs7J207YyF!5e0!3m2!1sko!2skr!4v1517386121645" width="100%" height="350" frameborder="0" style="border:0;"></iframe>

	<br><br>

	<h3 class="h3_title">웹사이팅 오시는 길</h3>

	<div class="cont_text_info">
		<h2>웹사이팅</h2>
		<ul>
			<li>Address : 서울시 관악구 조원중앙로 한별빌딩</li>
			<li>Tel : 070-7558-6420 / Fax : 050-4156-1305</li>
			<li>E-mail : cs@@websiting.co.kr</li>
		</ul>
	</div>



<?php
include_once('../tail.php');