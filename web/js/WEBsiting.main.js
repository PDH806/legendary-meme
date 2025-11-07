/* copyright(c) WEBsiting.co.kr */
$(document).ready(function(){

	$(".mvSlider ul").bxSlider({
		onSliderLoad: function(){
			$(".mvSlider ul li").addClass('on');
			$(".mvSlider").css("visibility", "visible").animate({opacity:1});
			var h = $("#sliderSpace").map(function(){return $(this).height();}).get(),maxHeight = Math.max.apply(null, h);
			$(".mvSlider .mbYTP_wrapper,.mvSlider .inline-YTPlayer, .youtubeBackgroundBG,.youtubeBackgroundBG .youtubePlayer").css("height", maxHeight - 0).css("min-height", maxHeight - 0);
			var w = $("#sliderSpace").map(function(){return $(this).width();}).get(),maxWidth = Math.max.apply(null, w);
			$(".mvSlider .mbYTP_wrapper,.mvSlider .inline-YTPlayer, .youtubeBackgroundBG,.youtubeBackgroundBG .youtubePlayer").css("width", maxWidth - 0).css("min-width", maxWidth - 0);
		},
		onSlideBefore: function(){
			$(".mvSlider ul li").removeClass('on');
		},
		onSlideAfter: function(){
			$(".mvSlider ul li").addClass('on');
		},
		auto: true,
		useCSS: false,
		adaptiveHeight: true,
		autoControls: false,
		stopAutoOnClick: true,
		autoDelay: '100',
		pause: 6000,
		pager: true
	});
	$('.youtubePlayer').YTPlayer({containment:'self', mute:true, autoPlay:true, loop:true, stopMovieOnBlur:true, playOnlyIfVisible:false, showControls:false});
});
$(window).resize(function(){
	var h = $("#sliderSpace").map(function(){return $(this).height();}).get(),maxHeight = Math.max.apply(null, h);
	$(".mvSlider .mbYTP_wrapper,.mvSlider .inline-YTPlayer, .youtubeBackgroundBG,.youtubeBackgroundBG .youtubePlayer").css("height", maxHeight - 0).css("min-height", maxHeight - 0);
	var w = $("#sliderSpace").map(function(){return $(this).width();}).get(),maxWidth = Math.max.apply(null, w);
	$(".mvSlider .mbYTP_wrapper,.mvSlider .inline-YTPlayer, .youtubeBackgroundBG,.youtubeBackgroundBG .youtubePlayer").css("width", maxWidth - 0).css("min-width", maxWidth - 0);
});