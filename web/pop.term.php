<?php
/* copyright (c) websiting.co.kr */
include_once('./_common.php');
$g5['title'] = "홈페이지 이용약관";
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/pop.css?ver='.G5_CSS_VER.'">', 0);
include_once('./head.sub.php');
?>
<div class="term_area">
	<header><h1>홈페이지 이용약관</h1></header>
	<section>
		<p><?php echo get_text($config['cf_stipulation']) ?></p>
	</section>
	<footer>&copy; <?php echo $_SERVER['HTTP_HOST']; ?></footer>
</div>
<?php
include_once('./tail.sub.php');