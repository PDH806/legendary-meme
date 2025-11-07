<?php
/* copyright (c) websiting.co.kr */

include_once('./_common.php');

/* 페이지설정 코드 입력! */

	//페이지 제목 지정
	$g5['title'] = "테스트페이지";
	
	//본 페이지에 해당되는 css가 있을 경우 아래 css 삽입 코드를 활성화 해주시기 바랍니다.
	//add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/page.css?ver='.G5_CSS_VER.'">', 0);

/* 페이지설정 코드 입력! */
include_once('./head.php');
?>


	<h2 class="h2_title">일반PHP파일 링크입니다.</h2>
	<div class="cont_text_important">
		g5폴더/theme/purewhite/testPage.php
	</div>
	<h3 class="h3_title">본 페이지를 사용하는 이유</h3>
	<div class="cont_text">
		그누보드에서 기본으로 제공하는 내용관리, 게시판관리 및 게시판그룹으로의 링크로는 해결이 안되는 커스텀 페이지가 필요 할 경우 본 페이지를 참고하여 일반 링크 페이지를 작성하실 수 있습니다. 본 페이지는 상단 및 좌측 메뉴바와 연동이 되이 않으므로 새롭게 작성될 페이지의 상단에 메뉴바에 해당하는 설정을 코드로 입력해 주셔야 합니다. <br><br>
		웹사이트 관리측면에서 볼 때 특수한 경우를 제외하고는 사용을 권장해 드리지는 않습니다.
	</div>
	<div class="cont_text_info">
		테마 구매 후 본 페이지를 메모장 또는 편집프로그램(에디트플러스, 울트라 에디트, 노트패드 등)으로 오픈하신 후 
		아래 제공되는 HTML 샘플 구조를 베이스로 페이지를 작성하시기 바랍니다.
		메뉴관리에서 http 를 포함한 링크를 넣어주시면 자동으로 활성화 됩니다. <br><br>
		이 페이지를 그누보드가 설치된 폴더에 넣어주시면 아래와 같은 주소로 이용이 가능합니다.<br>

		http://도메인/testPage.php<br><br>
		
		다른 폴더에서 사용을 원하시면 본 페이지 상단의 include_once('./_common.php'); 부분의 경로를 해당페이지의 위치에 맞게 설정해 주세요.

	</div>

	<hr>
	<br>
	<h3 class="h3_title">테마의 메뉴바와 연결되는 페이지</h3>
	<div class="cont_text_info">
		<ul style="list-style:circle;padding-left:20px;">
			<li><b>content/basic</b> 내용관리를 활용한 일반페이지 </li>
			<li><b>content/basic</b> 구글,다음 지도 퍼가기를 활용한 지도 삽입 페이지(내용관리에서 작성 가능) </li>
			<li><b>board/basic</b> 기본형 게시판 </li>
			<li><b>board/qna</b> 질문답변 게시판(글 작성 시 접수완료, 답변 시 답변완료) </li>
			<li><b>board/faq</b> 자주묻는 질문 게시판(목록에서 질문과 답변 확인) </li>
			<li><b>board/webzine</b> 웹진형 게시판(목록에서 내용일부분과 첨부 이미지 확인) </li>
			<li><b>board/gallery</b> 갤러리 게시판 2종(일반 갤러리 게시판, 박스형 갤러리 게시판) </li>
			<li><b>board/gallery_box</b> 제품소개 게시판(갤러리형 리스트, 웹진형 리스트 설정) </li>
			<li><b>board/history</b> 연혁을 쉽게 추가 수정이 가능한 연혁 게시판 </li>
			<li><b>board/form</b> 고객상담 시 유용한 폼메일형 게시판 </li>
			<li><b>group.php</b>  각 게시판에 적용된 스킨에 따라 자동 적용되는 그룹 최신글 페이지 </li>
		<ul>
	</div>


	<br><br>

	<h2 class="h2_title_center">
		HTML STYLE SAMPLE<br>
		<small>아래 html 코드를 활용하여 내용관리의 html 입력으로 페이지를 꾸미실 수 있습니다.</small>
	</h2>

	<p class="cont_text_info">관련 css : 설치된테마폴더/css/contents.css</p>


	<h2 class="h2_title"> class="h2_title" H2 제목 적용</h2>
	<h3 class="h3_title"> class="h3_title" H3 제목 적용</h3>
	<div class="cont_text_important">
		class="cont_text_important" 중요한 내용
	</div>
	
	<div class="cont_text">
		 class="cont_text" 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 
	</div>
	<div class="cont_text_info">
		 class="cont_text_info" 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다. 중요한 내용이 있을경우 사용할 수 있는 점선박스입니다.
	</div>

	<h3 class="h3_title"> 내용의 좌측에 이미지 적용</h3>
	<div class="cont_text_important">
		이미지에  class="cont_img_left50p" 추가
	</div>
	
	<div class="cont_text">
		<img src="http://sir.websiting.kr/purewhite/theme/purewhite/img/aboutImg01.jpg" class="cont_img_left50p">
		 class="cont_text" 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 
	</div>

	<h3 class="h3_title"> 내용의 우측에 이미지 적용</h3>
	<div class="cont_text_important">
		이미지에  class="cont_img_right50p" 추가
	</div>
	
	<div class="cont_text">
		<img src="http://sir.websiting.kr/purewhite/theme/purewhite/img/aboutImg02.jpg" class="cont_img_right50p">
		 class="cont_text" 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 일반적인 텍스트 내용일때 사용 되는 클래스입니다. 
	</div>

	<h3 class="h3_title"> 아이콘과 함께 사용되는 도형</h3>
	<div class="cont_text_important">
		Font Awesome 버전 참고 -&gt; https://fontawesome.com/v4.7.0/icons/
	</div>
	
	<div class="cont_text">
		<ul class="figure_list">
			<li>
				<i class="fa fa-desktop"></i>
				<strong>WEBSITE</strong>
				<span>웹사이트 제작 및 관리</span>
			</li>
			<li>
				<i class="fa fa-code"></i>
				<strong>MOBILE</strong>
				<span>모바일 웹사이트 제작 및 관리</span>
			</li>
			<li>
				<i class="fa fa-shopping-cart"></i>
				<strong>E-commerce</strong>
				<span>쇼핑몰 제작 및 운영대행</span>
			</li>
			<li>
				<i class="fa fa-android"></i>
				<strong>Application</strong>
				<span>웹 어플리케이션 개발 및 운영</span>
			</li>
		</ul>
	</div>

	

	<h3 class="h3_title"> 테이블 스타일</h3>
	<div class="cont_text_important">
		table 을 감싼 DIV에 class="basic_table" 클래스 추가
	</div>

	<br>
	
	<div class="basic_table">
		<table>
			<colgroup>
				<col style="width:25%;">
				<col style="width:25%;">
				<col style="width:25%;">
				<col style="width:25%;">
			</colgroup>
			<thead>
				<tr>
					<th>THEAD TH</th>
					<th>THEAD TH</th>
					<th>THEAD TH</th>
					<td>THEAD TD</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>TBODY TH</th>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
				</tr>
				<tr>
					<th>TBODY TH</th>
					<td class="center">TBODY TD center</td>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
				</tr>
				<tr>
					<th>TBODY TH</th>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
				</tr>
				<tr>
					<th>TBODY TH</th>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th>TFOOT TH</th>
					<td>TFOOT TD</td>
					<td>TFOOT TD</td>
					<td>TFOOT TD</td>
				</tr>
				<tr>
					<th>TFOOT TH</th>
					<td>TFOOT TD</td>
					<td>TFOOT TD</td>
					<td class="center">TFOOT TD center</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<br>
	
	<div class="basic_table">
		<table>
			<colgroup>
				<col style="width:25%;">
				<col style="width:25%;">
				<col style="width:25%;">
				<col style="width:25%;">
			</colgroup>
			<tbody>
				<tr>
					<th rowspan="2">TBODY TH</th>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
				</tr>
				<tr>
					<td class="center">TBODY TD center</td>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
				</tr>
				<tr>
					<th>TBODY TH</th>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
				</tr>
				<tr>
					<th>TBODY TH</th>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
					<td>TBODY TD</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th rowspan="2">TFOOT TH</th>
					<td>TFOOT TD</td>
					<td>TFOOT TD</td>
					<td>TFOOT TD</td>
				</tr>
				<tr>
					<td colspan="3" class="center">TFOOT TD center</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<br>
	<br>

	<h3 class="h3_title"> 내용관리에 반응형 유튜브영상 삽입</h3>
	<div class="cont_text_important">
		유튜브 퍼가기소스 아이프레임을 감싼 DIV에 class="youtube_area" 클래스 추가
	</div>

	<div class="youtube_area">
		<iframe width="560" height="315" src="https://www.youtube.com/embed/aYCXBdMavx8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>
	<div class="youtube_area">
		<iframe width="560" height="315" src="https://www.youtube.com/embed/NTi5XGsD2ho" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>



<?php
include_once('./tail.php');