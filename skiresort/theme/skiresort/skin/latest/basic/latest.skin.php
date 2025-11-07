<?php
/* copyright(c) WEBsiting.co.kr */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css?v8">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="basicLat">
    <h2 class="basicLatTit"><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?> <u class="themeBgColor"></u></a></h2>
    <ul>
    <?php for ($i=0; $i<count($list); $i++) {  ?>
        <li>
            <?php
            echo "<a href=\"".$list[$i]['href']."\"> ";
			echo "<i  class=\"fa fa-caret-right\" aria-hidden=\"true\"></i> ";
            if ($list[$i]['icon_secret']) echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> ";
            if ($list[$i]['icon_new']) echo "<span class=\"new_icon\">N<span class=\"sound_only\">새글</span></span> ";
            if ($list[$i]['icon_hot']) echo "<span class=\"hot_icon\">H<span class=\"sound_only\">인기글</span></span> ";
            if ($list[$i]['ca_name']) echo "<span class='bo_cate_link'>[ ".$list[$i]['ca_name']." ]</span> ";
            echo "<b>".$list[$i]['subject']."</b>";
            if ($list[$i]['comment_cnt'])  echo "
            <span class=\"lt_cmt\">+ ".$list[$i]['comment_cnt']."</span>";
            ?> 
			<span class="lt_date"><?php echo $list[$i]['datetime'] ?></span>
            </a>
        </li>
    <?php 
	} 
	if (count($list) == 0) { //게시물이 없을 때  ?>
    <li class="empty_li"><i class="fa fa-exclamation-triangle"></i> 게시물이 없습니다.</li>
    <?php }  ?>
    </ul>
    <a href="<?php echo get_pretty_url($bo_table); ?>" class="lt_more themeBgColor "><?php echo $bo_subject ?> 더보기 <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
</div>