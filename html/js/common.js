/*var LinkDaph1;
var LinkDaph2;*/

$(document).ready(function () {


    /*   
        var daph1 = new Array();
        var daph2 = new Array();
        var temp = new Array();
        for (var menu1 = 0; menu1 < $("#gnb_menu > li").length; menu1++) {
            daph1.push($("#gnb_menu > li:eq(" + menu1 + ") > a").attr("href"));
        }
        LinkDaph1 = daph1;
        LinkDaph2 = daph2;
    

	try{
    // #slider001
    $('#slider001').flexslider({
        animation: "fade",
        animationLoop: true,
        smoothHeight: false,
        slideshow: true,
        slideshowSpeed: 5000,
        animationSpeed: 600,
        controlNav: true,
        directionNav: true,
        prevText: "이전",
        nextText: "다음",
        pausePlay: true
    });
    
	}catch(e){console.log('err02 :',e);}
	*/

    // PC 메뉴
     $(function () {
        $("#gnb_menu li").on("mouseover", function (e) {
				var allMenu = $(".all_menu");
                var menuBg = $(".all_menu_bg");
                var header = $(".header_wrap");
                
            if ($(window).width() > 1024) {
                allMenu.slideDown(300);
                menuBg.show();
                header.mouseleave(function(){
                    allMenu.stop().slideUp(300);
                    menuBg.hide();
                });
            } else if ($(window).width() <= "1024") {
                allMenu.hide();
                menuBg.hide();
            }
        });

        $("#gnb_menu > li").each(function () {
            if ($(this).children('ul').length > 0) {
                $(this).addClass('ym');
            }
        });
    });
	
    // Mobile 메뉴
    $(function () {
        $("#toggle_menu").bind("click", function (e) {
            if ($(window).width() > 1024 && e.type == "click") {} else if ($(window).width() <= "1024" && e.type == "click") {
                if ($(this).is(".mm_on")) {
                    $("#gnb_menu").css("right", "0").animate({
                        "right": "-100%"
                    }, 300);
                    setTimeout(function () {
                        $("#gnb_menu").hide();
                    }, 300);
                    $(this).removeClass('mm_on');
                } else {
                    $(this).addClass('mm_on').hide();
                    $("#gnb_menu").css("right", "-500px").animate({
                        "right": "0"
                    }, 300).show();
                    setTimeout(function () {
                        $("#toggle_menu").show();
                    }, 300);

                }
            }
        });

        // 모바일 메뉴 click
        $("#gnb_menu > li > a").bind("click", function (e) {
            if ($(window).width() <= "1024" && e.type == "click") {
				var gnbMenu = $("#gnb_menu").find("> li");
                if ($(this).parents('li').hasClass('m_on')) {
                    gnbMenu.find("> div").stop().slideUp(120);
                    gnbMenu.removeClass('m_on');
                } else {
                    gnbMenu.removeClass('m_on');
                    gnbMenu.find("> div").stop().slideUp(120);
                    $(this).parents('li').addClass('m_on');
                    $(this).next('div').slideDown(120);
                }
            }
        });
    });

    $(".visual .visual_wrap .visual_title_box").height($(window).height() - 380);
    // resize시 메뉴 지정
    $(window).resize(function () {
        $("#gnb_menu .top_nav").click(function (e) {
            if ($(window).width() < 1025) {
                e.preventDefault();
            };

        });
    });

	$("#gnb_menu .top_nav").click(function (e) {
            if ($(window).width() < 1025) {
                e.preventDefault();
            };

    });

    //공지사항 이미지
    $(".info_area").hover(function () {
        $(this).find('img').addClass('on');
    }, function () {
        $(this).find('img').removeClass('on');
    });


    //quick
    $(window).scroll(function () {
        $('.sb_quick').stop().animate({
            "top": $(document).scrollTop() + 100 + "px"
        }, 1000);
    });

    //모바일 여부
    isMobile = function () {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    };

    //자동 스크롤
    function autoScrolling() {
        var $ww = $(window).width();
		var $hh = $(window).height();
        if ($ww <= 1550 && $hh <= 1200) { // laptop
            $('#content').fullpage.setAutoScrolling(false);
        } else {
            $('#content').fullpage.setAutoScrolling(true);
			$(".visual .visual_wrap .visual_title_box").height($(window).height() - 380);
        };
    };

    //메인화면 페이지 스크롤
    isOnePageScroll = function () {
        if (isMobile()) {
            $('#content').fullpage({
                scrollOverflow: false,
                fitToSection: false,
                navigation: true,
                navigationPosition: 'right',
                navigationTooltips: ['MAIN', 'SBAK 정보', '협회소개', '회원사'],
                showActiveTooltip: true,

                afterLoad: function (anchorLink, index) {
                    var loadedSection = $(this);

                    //using index
                    if (index == 2 || index == 3 || index == 4 || index == 5) {
                    } else {    }
                }
            });

            $(window).resize(function () {
                autoScrolling();
            });

            autoScrolling();
        } else {
            $('#content').fullpage({
                scrollOverflow: true,
                fitToSection: false,
                navigation: true,
                navigationPosition: 'right',
                navigationTooltips: ['MAIN', 'SBAK 정보', '협회소개', '회원사'],
                showActiveTooltip: true,

                afterLoad: function (anchorLink, index) {
                    var loadedSection = $(this);

                    //using index
                    if (index == 2 || index == 3 || index == 4 || index == 5) {
                        $("header, #fp-nav ul li a").addClass('scroll');
                    } else {
                        $("header, #fp-nav ul li a").removeClass('scroll');

                    }
                }
            });

            $(window).resize(function () {
                autoScrolling();
            });
            autoScrolling();
        }
    };

});

/*fangda&suoxiao*/
var vbm = 100;

function plus() {

    vbm = vbm + 10;

    if (vbm >= 500) vbm = 500;

    processes();

}

function processes() {

    document.body.style.zoom = vbm + '%';



}

function reset() {

    vbm = 100;

    processes();

}

function minus() {

    vbm = vbm - 10;

    processes();

}

$(window).on('load resize', function () {
    $(".slide div").height($(window).height());

    if ($(window).width() <= 1024) {
		
    } else {
		//spon();
        $("#gnb_menu").show();
        $(".sbcenter_top_title > ul > li").removeClass('on');
        $(".sbcenter_top_title > ul > li > ul").hide();
    }

});


// 맨 위로 이동
$(function () {
    $(window).scroll(function () {
        var scrTop = $(window).scrollTop()
        if (scrTop > 200) {
            $("#scroll_top").addClass("on");
        } else {
            $("#scroll_top").removeClass("on");
        };

    });
    $("#scroll_top button").on("click", function () {
        $("html, body").animate({
            scrollTop: 0
        }, 800)
    });
});

// Sub > scroll시 메뉴 사이즈 변경
$(function () {
    $(window).scroll(function () {
        var scrTop = $(window).scrollTop()

        if ($(window).width() > 1024) {
            if (scrTop > 100) {
                $("#sb_header").addClass("scroll");
            } else {
                $("#sb_header").removeClass("scroll");
            };
        } else if ($(window).width() <= 1024) {
            $("#sb_header").removeClass("scroll");
        }
    });
    $(window).resize(function () {
        if ($(this) > 1025) {
			
        } else {
            $("#sb_header").removeClass("scroll");
        };
    });
});

// ALL TAB CLICK
$(function () {
    //$('.tab_click_list div').eq(0).show();

    $('.tab_click li a').on('click', function (e) {

        var activeList = $(this).attr('href');
        $('.tab_click_list div' + activeList).show().siblings().hide();

        e.preventDefault();

    });

    $('.tab_click li').on('click', function () {
        $(this).addClass('on').siblings().removeClass('on');
    })
});

$(function () {
    $(".prev_next_box ul li").on('click', function (e) {
        $(this).addClass('on').siblings().removeClass('on');
        $(".prev, .next").removeClass('on');

        // e.preventDefault();
    });
});

// 팝업창 1-3
$(function () {
    $(".act_chk a").eq(0).click(function () {
        $("#popup , #pop_1").show();
    });
    $(".act_chk a").eq(1).click(function () {
        $("#popup , #pop_2").show();
    });
    $(".photo a").click(function () {
        $("#popup , #pop_3").show();
    });
    $("#popup .close").click(function () {
        $("#popup , #popup div").hide();
    });
})


