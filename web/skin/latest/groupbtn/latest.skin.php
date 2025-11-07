<?php
/* copyright(c) WEBsiting.co.kr */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
<a href="<?php echo get_pretty_url($bo_table); ?>" class="groupBBtn"> <?php echo $bo_subject ?> <i class="fa fa-chevron-circle-right"></i></a>

