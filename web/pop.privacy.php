<?php
/* copyright (c) websiting.co.kr */
include_once('./_common.php');
$g5['title'] = "개인정보 취급방침";
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/pop.css?ver='.G5_CSS_VER.'">', 0);
include_once('./head.sub.php');
?>
<div class="term_area">
	<header><h1>개인정보처리방침</h1></header>
	<section>
		<p><?php echo get_text($config['cf_privacy']) ?></p>
	</section>
	<footer>&copy; <?php echo $_SERVER['HTTP_HOST']; ?></footer>
</div>
<?php
include_once('./tail.sub.php');