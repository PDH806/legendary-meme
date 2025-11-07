var ObjVisit;
var visitedArray = new Array();

$(document).ready(function () {
  OnPutVeiwMenu = function(){
		//서브 01~ 06만 사용 (/article, /sub01 ~ 06, /voc, /organ, /gonsi, /report, /stnd, /enter)
		var url = document.URL;
		var title = "";

		ObjVisit = $("#muVisitedMenu");
		var viewedMenu = getCookie("viewedMenu");
		var arrPreMenu = new Array();
		//localStorage.clear();
		var startTag = "<div class='sbcenter_top_title' id='visitedMenu'>";
		var endTag = "</div>";

		var menu1 = "";
		var menu2 = "";
		var menu3 = "";
		var hrefVal = "";
		var tmpStr = "";
		//localStorage.clear();

		if(ObjVisit != null){
			if(viewedMenu != "undefined" && viewedMenu != ""){
				if(localStorage.getItem("visitedMenu") != null && localStorage.getItem("visitedMenu") != ""){
					var tmp = localStorage.getItem("visitedMenu");
					visitedArray = JSON.parse(tmp);

					var len = visitedArray.length;
					var newArray = new Array();

					menu1 = $("#visitedMenu1").text();
					menu2 = $("#visitedMenu2").text();
					menu3 = $("#visitedMenu3").text();

					if(menu3 != ""){
						hrefVal = $("#visitedMenu3").attr("href");
						tmpStr = "<li><a href='"+hrefVal+"'>"+menu1+">"+menu2+">"+menu3+"</a></li>";
					}else{
						hrefVal = $("#visitedMenu2").attr("href");
						tmpStr = "<li><a href='"+hrefVal+"'>"+menu1+">"+menu2+"</a></li>";
					}

					if(typeof len !== undefined){
						if(len == 1){
							newArray = new Array();
							newArray = [visitedArray[0], tmpStr];
							//newArray = [visitedArray[0], $("#visitedMenu").html()];
							localStorage.clear();
							localStorage.setItem("visitedMenu", JSON.stringify(newArray));
						}else if(len == 2){
							newArray = new Array();
							newArray = [visitedArray[0], visitedArray[1], tmpStr];
							//newArray = [visitedArray[0], visitedArray[1], $("#visitedMenu").html()];
							localStorage.clear();
							localStorage.setItem("visitedMenu", JSON.stringify(newArray));
						}else if(len == 3){
							newArray = new Array();
							newArray = [visitedArray[len-3], visitedArray[len-2], visitedArray[len-1], tmpStr];
							//newArray = [visitedArray[len-2], visitedArray[len-1], $("#visitedMenu").html()];
							localStorage.clear();
							localStorage.setItem("visitedMenu", JSON.stringify(newArray));
						}else if(len == 4){
							newArray = new Array();
							newArray = [visitedArray[len-4], visitedArray[len-3], visitedArray[len-2], visitedArray[len-1], tmpStr];
							//newArray = [visitedArray[len-2], visitedArray[len-1], $("#visitedMenu").html()];
							localStorage.clear();
							localStorage.setItem("visitedMenu", JSON.stringify(newArray));
						}else if(len >= 5){
							newArray = new Array();
							newArray = [visitedArray[len-5], visitedArray[len-4], visitedArray[len-3], visitedArray[len-2], visitedArray[len-1], tmpStr];
							//newArray = [visitedArray[len-2], visitedArray[len-1], $("#visitedMenu").html()];
							localStorage.clear();
							localStorage.setItem("visitedMenu", JSON.stringify(newArray));
						}

					}else{
						visitedArray[0] = startTag + $("#visitedMenu").html() + endTag;
						localStorage.clear();
						localStorage.setItem("visitedMenu", JSON.stringify(visitedArray));
					}
				    }else{
					menu1 = $("#visitedMenu1").text();
					menu2 = $("#visitedMenu2").text();
					menu3 = $("#visitedMenu3").text();

					if(menu3 != ""){
						hrefVal = $("#visitedMenu3").attr("href");
						tmpStr = "<li><a href='"+hrefVal+"'>"+menu1+">"+menu2+">"+menu3+"</a></li>";
					}else{
						hrefVal = $("#visitedMenu2").attr("href");
						tmpStr = "<li><a href='"+hrefVal+"'>"+menu1+">"+menu2+"</a></li>";
					}

					tmpStr = "<li><a href='"+hrefVal+"'>"+menu1+">"+menu2+"</a></li>";

					visitedArray[0] = tmpStr
					localStorage.clear();
					localStorage.setItem("visitedMenu", JSON.stringify(visitedArray));
				}

				tmp = localStorage.getItem("visitedMenu");
				visitedArray = JSON.parse(tmp);
				for(var i=0; i<visitedArray.length; i++){
					//ObjVisit.append(startTag + visitedArray[i] + endTag);
					ObjVisit.append(visitedArray[i]);
				}

			}
		}


		if(url != ""){
			var inValue = url + "==" + title;
			setCookie("viewedMenu", inValue, 1);
			satisfyUrl = document.URL;
		}
	};

	//생년월일 체크
	isValidDate = function(dateStr) {
	     var year = Number(dateStr.substr(0,4));
	     var month = Number(dateStr.substr(4,2));
	     var day = Number(dateStr.substr(6,2));
	     var today = new Date(); // 날자 변수 선언
	     var yearNow = today.getFullYear();
	     var adultYear = yearNow-20;


	     if (year < 1900 || year > adultYear){
	          alert("년도를 확인하세요. "+adultYear+"년생 이전 출생자만 등록 가능합니다.");
	          return false;
	     }
	     if (month < 1 || month > 12) {
	          alert("달은 1월부터 12월까지 입력 가능합니다.");
	          return false;
	     }
	    if (day < 1 || day > 31) {
	          alert("일은 1일부터 31일까지 입력가능합니다.");
	          return false;
	     }
	     if ((month==4 || month==6 || month==9 || month==11) && day==31) {
	          alert(month+"월은 31일이 존재하지 않습니다.");
	          return false;
	     }
	     if (month == 2) {
	          var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
	          if (day>29 || (day==29 && !isleap)) {
	               alert(year + "년 2월은  " + day + "일이 없습니다.");
	               return false;
	          }
	     }
	     return true;
	};
});

 /**
  * 쿠키값 추출
  * @param cookieName 쿠키명
  */
function getCookie(cookieName){
	var cookies = document.cookie;
	var value  = "";
	if(cookies.indexOf(cookieName) != -1) {
		var start = cookies.indexOf(cookieName) + cookieName.length + 1;
		var end   = cookies.indexOf(";",start);

		if(end == -1) {
			end = cookies.length;
		}

		value = cookies.substring(start,end);
		value = unescape(value);
	}

	return value;
};

 /**
  * 쿠키 설정
  * @param cookieName 쿠키명
  * @param cookieValue 쿠키값
  * @param expireDay 쿠키 유효날짜
  */
function setCookie( cookieName, cookieValue, expireDate ) {
	var today = new Date();
	today.setDate( today.getDate() + parseInt( expireDate ) );
	document.cookie = cookieName + "=" + escape( cookieValue ) + "; path=/; expires=" + today.toGMTString() + ";";
};


function getTrim() {
	var tempStr = this;
	if (this.isEmpty()) return "";
	if (tempStr.charAt(0) == " ")
		tempStr = $.trim(tempStr.substring(1, tempStr.length));
 	if (tempStr.charAt(tempStr.length - 1) == " ")
 		tempStr = $.trim(tempStr.substring(0, tempStr.length - 1));
  return tempStr;
};

function printPage(){
	var win = window.open("/sub08/printRenewal.jsp", "printPage", "top=50, left=150, scrollbars=yes, status=yes, width=1280, height=600");
	if(win != null){
		win.focus();
	}
	return false;
};

function engPrintPage(){
	var win = window.open("/sub08/engPrintRenewal.jsp", "printPage", "top=50, left=150, scrollbars=yes, status=yes, width=1280, height=600");
	if(win != null){
		win.focus();
	}
	return false;
};