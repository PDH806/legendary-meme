<?php
/* copyright(c) WEBsiting.co.kr */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
$thumb_width = 0;
$thumb_height = 0;

?>

<div class="qnaLat">
    <h2 class="qnaLatTit"><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?> <u class="themeBgColor"></u></a></h2>
    <ul>
    <?php for ($i=0; $i<count($list); $i++) {  ?>
        <li>
			<a href="<?php echo $list[$i]['href'] ?>">
		
				<?php  if ($list[$i]['is_notice']) { ?> 
					<span class="qnaIco qnaIco1"><i class="fa fa-bullhorn" aria-hidden="true"></i> 공지사항</span>
				<?php } else {?>
					<?php if ($list[$i]['comment_cnt']) { ?>
					<span class="qnaIco qnaIco2"><i class="fa fa-smile-o" aria-hidden="true"></i> 답변완료</span>
					<?php } else {?>
					<span class="qnaIco qnaIco3"><i class="fa fa-spinner" aria-hidden="true"></i> 접수완료</span>
					<?php } ?>
				<?php } ?>
            <?php
            if ($list[$i]['icon_secret']) echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> ";
            if ($list[$i]['icon_new']) echo "<span class=\"new_icon\">N<span class=\"sound_only\">새글</span></span>";
            if ($list[$i]['icon_hot']) echo "<span class=\"hot_icon\">H<span class=\"sound_only\">인기글</span></span>";
            if ($list[$i]['ca_name']) echo "<span class='bo_cate_link'>[ ".$list[$i]['ca_name']." ]</span> ";
            echo "<b>".$list[$i]['subject']."</b>";

            ?>
            <span class="lt_date"><?php echo $list[$i]['datetime2'] ?></span>
            </a>
        </li>
    <?php 
	} 
    if (count($list) == 0) { //게시물이 없을 때  ?>
    <li class="empty_li"><i class="fa fa-exclamation-triangle"></i> 게시물이 없습니다.</li>
    <?php }  ?>
    </ul>
    <a href="<?php echo get_pretty_url($bo_table); ?>" class="lt_more themeBgColor"><?php echo $bo_subject ?> 더보기 <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
</div>
