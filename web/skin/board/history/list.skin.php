<?php
/* copyright(c) WEBsiting.co.kr */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php'); 

if ($is_checkbox) {$marginl = 'style="margin-left:60px;"'; $paddingl = 'style="padding-left:60px;"';};

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/board.common.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">


    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div id="bo_btn_top">

        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn"><i class="fa fa-user-circle" aria-hidden="true"></i> 관리자</a></li><?php } ?>
            <?php if ($admin_href) { ?><?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> 연혁 등록</a></li><?php }} ?>
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
    <div class="history_table">

		<ul class="history_list">
			<?php
			for ($i=0; $i<count($list); $i++) {
			?>

			<li class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
				<?php if ($is_checkbox) { ?><div class="history_chk"><input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>"></div><?php } ?>
				<?php
				if ($list[$i]['is_notice']) {
				?>
					<h2 class="history_h2"><?php echo $list[$i]['subject']?></h2>
					<div class="history_cont">
						<?php echo get_view_thumbnail($list[$i]['wr_content']); ?>
					</div>
					<?php if ($is_admin) { ?><a href="<?php echo $write_href?><?php if($config['cf_bbs_rewrite'] == '1' || $config['cf_bbs_rewrite'] == '2'){echo '?';} else {echo '&';} ?>w=u&wr_id=<?php echo $list[$i]['wr_id']?>&page=<?php echo $page?>" class="btn_b02 btn_rb"><i class="fa fa-pencil" aria-hidden="true"></i>  수정</a><?php } ?>

				<?php } else {?>
				<dl>
					<dt><?php if ($is_category && $list[$i]['ca_name']) { ?><span class="bo_cate_link">[<?php echo $list[$i]['ca_name'] ?>]</span><?php } ?> <?php echo $list[$i]['subject']?></dt>
					<dd >
						<div class="history_cont">
							<?php echo get_view_thumbnail($list[$i]['wr_content']); ?>
						</div>

					</dd>
					<?php if ($is_admin) { ?><a href="<?php echo $write_href?><?php if($config['cf_bbs_rewrite'] == '1' || $config['cf_bbs_rewrite'] == '2'){echo '?';} else {echo '&';} ?>w=u&wr_id=<?php echo $list[$i]['wr_id']?>&page=<?php echo $page?>" class="btn_b02 btn_rb"><i class="fa fa-pencil" aria-hidden="true"></i>  수정</a><?php } ?>
					<i class="hstr_line"></i>
					<i class="hstr_dot"></i>
				</dl>
				<?php } ?>
			</li> 
			<?php } ?>

		</ul>

        <?php if (count($list) == 0) {?><p class="noDataArea"><i class="fa fa-exclamation-triangle"></i> <br> <b>Coming soon!</b> <strong><?php echo $board['bo_subject']?></strong> 페이지 준비중입니다.</p><?php } ?>
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
             <?php if ($admin_href) { ?><?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> 연혁 등록</a></li><?php }} ?>
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
