<?php
/* copyright(c) WEBsiting.co.kr */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/board.common.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css?v2">', 0);
include_once(G5_THEME_PATH.'/plugin/websiting/ytID.php');
?>

<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">


    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div id="bo_btn_top">
        <div id="bo_list_total">
            <span><i class="fa fa-bars" aria-hidden="true"></i> Total <?php echo number_format($total_count) ?> /</span>
            <?php echo $page ?> page
        </div>
     
		<!-- 게시판 검색 시작 { -->
		<div id="bo_schWr">
			<div id="bo_schOnOff"><i class="bo_schOn fa fa-search" aria-hidden="true"></i> <i class="bo_schOff fa fa-times-circle" aria-hidden="true"></i><span class="sound_only">검색 열기 닫기</span></div>
			<div id="bo_schIn">
				<fieldset id="bo_sch">
					<legend>게시물 검색</legend>

					<form name="fsearch" method="get">
					<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
					<input type="hidden" name="sca" value="<?php echo $sca ?>">
					<input type="hidden" name="sop" value="and">
					<label for="sfl" class="sound_only">검색대상</label>
					<select name="sfl" id="sfl">
						<option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
						<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
						<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
						<option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
						<!-- <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option> -->
						<option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>작성자</option>
						<!-- <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>작성자(코)</option> -->
					</select>
					<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
					<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" size="25" maxlength="20" placeholder="검색어를 입력해주세요">
					<button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
					</form>
				</fieldset>
			</div>
		</div>
		<!-- } 게시판 검색 끝 --> 

        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn"><i class="fa fa-rss" aria-hidden="true"></i> RSS</a></li><?php } ?>
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn"><i class="fa fa-cog" aria-hidden="true"></i> 게시판 설정</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <!-- 게시판 카테고리 시작 { -->
    <?php if ($is_category) { ?>
    <nav id="bo_cate">
        <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <?php } ?>
    <!-- } 게시판 카테고리 끝 -->

    <form name="fboardlist" id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">


    <h2 class="sound_only"><?php echo $board['bo_subject'] ?> 목록</h2>
	<?php if ($is_checkbox) { ?>
	<div>
		<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
		<label for="chkall"><span class="sound_only">현재 페이지 게시물 </span>전체 선택</label><br><br>
	</div>
	<?php } ?>
    <div class="webzineList">
        <ul>
        <?php
        for ($i=0; $i<count($list); $i++) {
         ?>
        <li class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <?php if ($is_checkbox) { ?>
            <div class="td_chk">
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </div>
            <?php } ?>
			<?php
				$thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);
				$youtube_url = $list[$i]['wr_link1'];
				$youtube_video_id = getYoutubeVideoId($youtube_url);

				if(isset($thumb['src']) && $thumb['src']) {
					$img_content = '<a href="'.$list[$i]['href'].'" class="list_img"><img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" ></a>';
				} else {
					
					if (isset($youtube_video_id) && $youtube_video_id) {
						$img_content = '<a href="'.$list[$i]['href'].'" class="list_img"><i class="youtube_img"><sup style="background-image:URL(//img.youtube.com/vi/'.$youtube_video_id.'/maxresdefault.jpg);" alt="'.$list[$i]['subject'].'"></sup><sub><i class="imgAr"><img src="'.G5_THEME_URL.'/plugin/websiting/imageSpacer.php?w='.$board['bo_gallery_width'].'&h='.$board['bo_gallery_height'].'" alt="youtube image spacer"></i></sub></i></a>
					';
					
					} else {
					$img_content = '<!-- 이미지없음 -->';
					}
				}
				if (isset($list[$i]['icon_secret']) && !$list[$i]['icon_secret']){
					echo $img_content;
				}
			 ?>

			<?php
			if ($is_category && $list[$i]['ca_name']) {
			 ?>
			<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
			<?php } ?>
			<a href="<?php echo $list[$i]['href'] ?>" class="bo_tit">
				
				<?php
				if ($list[$i]['is_notice']) // 공지사항
					echo '<strong class="notice_icon"><i class="fa fa-bullhorn" aria-hidden="true"></i><span class="sound_only">공지</span></strong>';
				else if ($wr_id == $list[$i]['wr_id'])
					echo '<span class="sound_only">열람중</span>';
				else
					echo '<span class="sound_only">'.$list[$i]['num'].'</span>';
				?>
				<?php
					if (isset($list[$i]['icon_secret'])) echo rtrim($list[$i]['icon_secret']);
				 ?>
				<strong><?php echo $list[$i]['subject'] ?></strong>
			   
				<?php
				if (isset($list[$i]['icon_file'])) echo rtrim($list[$i]['icon_file']);
				if (isset($list[$i]['icon_link'])) echo rtrim($list[$i]['icon_link']);
				if ($list[$i]['icon_new']) echo "<span class=\"new_icon\">N<span class=\"sound_only\">새글</span></span> ";
				if ($list[$i]['icon_hot']) echo "<span class=\"hot_icon\">H<span class=\"sound_only\">인기글</span></span> ";
				if (isset($youtube_video_id) && $youtube_video_id)  echo "<i class=\"fa fa-youtube-play fts13px\"><span class=\"sound_only\">유투브영상</span></i> ";
				?>
				<?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><span class="cnt_cmt">+ <?php echo $list[$i]['wr_comment']; ?></span><span class="sound_only">개</span><?php } ?>
				
				<em>
					<?php 
					if (isset($list[$i]['icon_secret']) && $list[$i]['icon_secret']){
						echo '비밀글입니다. 로그인 또는 비밀번호 입력 후 확인 가능 합니다.';
					} else {
						echo cut_str(strip_tags($list[$i]['wr_content']),160," . . . ");
					}
					?>
				</em>
			</a>
			
			<u>
				<span><?php echo $list[$i]['name'] ?></span>
				<span><i class="fa fa-eye"></i> <?php echo $list[$i]['wr_hit'] ?></span>
				<?php if ($is_good) { ?><span><i class="fa fa-thumbs-up"></i> <?php echo $list[$i]['wr_good'] ?></span><?php } ?>
				<?php if ($is_nogood) { ?><span><i class="fa fa-thumbs-down"></i> <?php echo $list[$i]['wr_nogood'] ?></span><?php } ?>
				<span><i class="fa fa-clock-o"></i> <?php echo $list[$i]['datetime2'] ?></span>
			</u>

        </li>
        <?php } ?>
        </ul>
        <?php if (count($list) == 0) {?><p class="noDataArea"><i class="fa fa-exclamation-triangle"></i> <br> <b>No data</b> <?php if ($stx){ ?><strong><?php echo $stx ?></strong>로 검색된<?php } else { echo '등록된';}?> 자료가 없습니다.</p><?php } ?>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($list_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($is_checkbox) { ?>
            <li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_admin"><i class="fa fa-trash-o" aria-hidden="true"></i> 선택삭제</button></li>
            <li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn btn_admin"><i class="fa fa-files-o" aria-hidden="true"></i> 선택복사</button></li>
            <li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn btn_admin"><i class="fa fa-arrows" aria-hidden="true"></i> 선택이동</button></li>
            <?php } ?>
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn_b01 btn"><i class="fa fa-list" aria-hidden="true"></i> 목록</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>

    </form>
     
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>



<!-- 페이지 -->
<?php echo $write_pages;  ?>


<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = g5_bbs_url+"/board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = g5_bbs_url+"/move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
