<?php
/* copyright (c) websiting.co.kr */
include_once('./_common.php');
$g5['title'] = "개인정보 취급방침";
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/pop.css?ver='.G5_CSS_VER.'">', 0);
include_once('./head.sub.php');
?>
<div class="term_area">
	<header><h1>이메일주소 무단수집거부</h1></header>
	<section class="noEmail">
		<h3><?php echo $config['cf_title'] ?></h3>
		<h4><?php echo $_SERVER['HTTP_HOST']; ?></h4> 
		<p>본 사이트에 게시된 이메일 주소가 전자우편 수집 프로그램이나 그 밖의 기술적 장치를 이용하여 무단으로 수집 되는 것을 거부합니다. 이를 위반시 「정보통신망 이용촉진 및 정보보호 등에 관한 법률」에 의해 형사처벌됨을 유념하시기 바랍니다. <br><br><a href="http://www.law.go.kr/법령/정보통신망이용촉진및정보보호등에관한법률/(20120818,11322,20120217)/제50조의2" target="_blank"><i class="fa fa-hashtag"></i> 정보통신망법 제50조의2(전자우편주소의 무단 수집행위 등 금지)</a></p>
	</section>
	<footer>&copy; <?php echo $_SERVER['HTTP_HOST']; ?></footer>
</div>
<?php
include_once('./tail.sub.php');