/* Size control */
var zoomRate = 10;
var curRate = 100;
var minRate = 100;
var maxRate = 200;

function initZoom(){

	if(getCookie("zoomName") != null && getCookie("zoomName") != ""){
		curRate = getCookie("zoomName");
		if(!((curRate >=minRate)&(curRate<=maxRate))){curRate = 100;}
		setCookie("zoomName",curRate, 5);
		document.body.style.zoom = curRate + '%';
	}	else{document.body.style.zoom = '100%';
		curRate = 200;
		setCookie("zoomName",100, 1);
	}
}
function zoomInOut(value){
	document.body.style.position="relative";
	var ue = navigator.userAgent.toLowerCase();
	if(ue.indexOf('firefox')!=-1){ alert("익스플로러에서만 동작합니다."+"\n파이어폭스 브라우저 메뉴 [보기]-[크기조정]을 이용하세요."); }
	else if(ue.indexOf('opera')!=-1){ alert("익스플로러에서만 동작합니다."+"\n오페라 브라우저 메뉴 [보기]-[Zoom]을 이용하세요."); }
	else if(ue.indexOf('chrome')!=-1){ alert("익스플로러에서만 동작합니다."+"\n구글 크롬 브라우저 메뉴 [글꼴 크기]를 이용하세요."); }
	else if(ue.indexOf('safari')!=-1){ /* alert("익스플로러에서만 동작합니다."+"\n사파리 브라우저 메뉴 [보기]-[텍스트 크게]/[텍스트 작게]를 이용하세요."); */ }
	else if(ue.indexOf('msie')!=-1){  }
	else { alert("익스플로러에서만 동작합니다.\n"+ue+"\n브라우저 메뉴의 확대축소 기능을 이용하세요."); }
	if(((value=="plus")&&(curRate >= maxRate))||((value == "minus") && (curRate <= minRate))){return;}
  if(value=="plus"){curRate = parseInt(curRate) + parseInt(zoomRate);}
  else if (value=="minus"){curRate = parseInt(curRate) - parseInt(zoomRate);}
  else{curRate = 100}
	document.body.style.zoom = curRate + '%';
  //setCookie("zoomName",curRate, 1);
}