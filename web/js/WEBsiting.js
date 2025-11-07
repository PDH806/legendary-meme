/* copyright(c) WEBsiting.co.kr */

$(document).ready(function(){
	/* 스크롤 탑 버튼 */
	$("#top_btn").hide();
	//var topId = $("#topID").offset().top; 
	$(window).scroll(function(){ 
		if($(window).scrollTop() >= 2) {
			$("#top_btn").fadeIn(300);
			$("body").addClass("scDown");
			$("#hd").addClass("scDown");
		} else { 
			$("#top_btn").fadeOut(300);
			$("body").removeClass("scDown");
			$("#hd").removeClass("scDown");
		};
		return false;
	}); 
	$("#top_btn").click(function() {
		$("html, body").animate({scrollTop:0}, "500");
		return false;
	});

	/* 모바일용 on off */
	$("#snbOpen,#sideBarCover").click(function() {
		$("html , body").toggleClass("ovfH");
		$("#sideBar").toggleClass("on");
		$("#sideBarCover").toggleClass("on");
		return false;
	});
	
	/* 전체검색 열기닫기 */
	$("#btnSchbox").click(function() {
		$("#allSchBox").slideDown("fast");
		$(".allSchBoxWr").addClass("on");
		$(".topSchFocus").focus();
		return false;
	});
	$("#allSchBoxClose").click(function() {
		$("#allSchBox").slideUp("fast");
		$(".allSchBoxWr").removeClass("on");
		return false;
	});
	
	/* 게시판검색 열기닫기 */
	$("#bo_schOnOff .bo_schOn").click(function() {
		$("#bo_schWr").addClass("on");
		return false;
	});
	$("#bo_schOnOff .bo_schOff").click(function() {
		$("#bo_schWr").removeClass("on");
		return false;
	});
	
	/* 글쓰기 내용입력폼에 placeholder 추가 / 에디터 출력 시 제외 */
	$( '#wr_content' ).attr( 'placeholder', '내용을 입력해 주세요.' );

	/* 서브페이지 타이틀 효과 */
	$("#page_title").addClass('on');
});