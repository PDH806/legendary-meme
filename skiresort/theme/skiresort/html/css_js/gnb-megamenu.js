/*****************************************************************

		Copyright C 다온테마 All rights reserved. 
		daontheme@daum.net
		본 페이지는 유료컨텐츠 다온테마용 JS입니다. 불법복제시 법적인 제제를 받으실 수 있습니다. 
		라이센스를 삭제하지 마세요. 라이센스 삭제시 불법 사용으로 간주될 수 있습니다.

		아래 내용을 수정/삭제 하지 마세요.

******************************************************************/
function main_lnb(){
	TmenuTG = $('.lnb_wrap');
	Tmenu_H = $('.lnb_wrap').height();
	TmenuTG.find('> ul > li a').bind('mouseenter focus click',function(){
		sub_lnb(false);
	});
	TmenuTG.bind('mouseleave',function(){
		sub_lnb(true);
	});
	TmenuTG.find('> ul > li').bind('mouseenter mouseleave',function(event){
		if(event.type=='mouseenter'){
			if(!$(this).hasClass('current')){
				$(this).addClass('current');
			}
		}else{
			if(!$(this).hasClass('actived')){
				$(this).removeClass('current');
			}
		}
	});	
	TmenuTG.css({'height':60,'visibility':'visible'});
}

function sub_lnb(mode){
	if(mode==false){		
		TmenuTG.stop().animate({'height':Tmenu_H},900,'easeOutExpo');
		$("#header").addClass("header_on");
	}else{		
		TmenuTG.stop().animate({'height':60},900,'easeOutExpo');
		setTimeout(function() {
			$("#header").removeClass("header_on");
		}, 140);
	}
}

$(document).ready(function() {
	main_lnb();
});