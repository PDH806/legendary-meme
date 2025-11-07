<?php
/* copyright(c) WEBsiting.co.kr */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
$thumb_width = 70;
$thumb_height = 70;
?>

<div class="historyLat">
    <h2 class="historyLatTit"><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?> <u class="themeBgColor"></u></a></h2>
	<i class="fa fa-clock-o"></i>
    <ul>
    <?php for ($i=0; $i<count($list); $i++) { 
		$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);
		$youtubeID = $list[$i]['wr_link1']; 
		$youtubeID = explode('/',$youtubeID); 

		if(isset($thumb['src']) && $thumb['src']) {
			$img = $thumb['src'];
			$thumb['alt'] = $list[$i]['subject'];
			$img_content = '<i class="historyLatThumb"><img src="'.$img.'" alt="'.$thumb['alt'].'" ></i>';
		} else {
			if(isset($youtubeID[2]) == "youtu.be") {
				$img_content = '<i class="historyLatThumb" style="background-image:URL(//img.youtube.com/vi/'.$youtubeID[3].'/sddefault.jpg); bakcground-size:cover;" alt="'.$list[$i]['subject'].');"><img src="'.G5_THEME_URL.'/plugin/websiting/imageSpacer.php?w='.$thumb_width.'&h='.$thumb_height.'" class="youtubeImbBlank" alt=""></i>';
			} else {
				$img_content = "<!-- 이미지 없음 -->";
			}
		}
	?>
        <li>
            <a href="<?php echo get_pretty_url($bo_table); ?>">
				<?php //echo $img_content; ?>
				<?php
				echo "<b>";
				if ($list[$i]['ca_name']) echo "<span class='bo_cate_link'>[ ".$list[$i]['ca_name']." ]</span> ";
				if ($list[$i]['icon_secret']) echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> ";
				if ($list[$i]['icon_new']) echo "<span class=\"new_icon\">N<span class=\"sound_only\">새글</span></span> ";
				if ($list[$i]['icon_hot']) echo "<span class=\"hot_icon\">H<span class=\"sound_only\">인기글</span></span> ";

				echo $list[$i]['subject'];
				if ($list[$i]['comment_cnt'])  echo "
				<span class=\"lt_cmt\">+ ".$list[$i]['comment_cnt']."</span>";
				echo "</b>";

				?><em><?php echo cut_str(strip_tags($list[$i]['wr_content']),100," . . . ") ?></em>
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
