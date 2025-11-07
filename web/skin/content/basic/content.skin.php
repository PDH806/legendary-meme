<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css?v2">', 0);
// 내용관리의 스타일은 아래 CSS파일에서 관리됩니다.
// theme/purewhite/css/contents.css
?>

<article id="ctt" class="ctt_<?php echo $co_id; ?>">
    <header>
        <h2><?php echo $g5['title']; ?></h2>
    </header>

    <div id="ctt_con">
        <?php echo $str; ?>
    </div>

</article>