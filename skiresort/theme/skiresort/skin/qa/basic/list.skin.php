<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/board.common.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<div id="bo_list">


     <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div id="bo_btn_top">
        <div id="bo_list_total">
            <span><i class="fa fa-bars" aria-hidden="true"></i> Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div>
     
		<!-- 게시판 검색 시작 { -->
		<div id="bo_schWr">
			<div id="bo_schOnOff"><i class="bo_schOn fa fa-search" aria-hidden="true"></i> <i class="bo_schOff fa fa-times-circle" aria-hidden="true"></i><span class="sound_only">검색 열기 닫기</span></div>
			<div id="bo_schIn">
				<fieldset id="bo_sch">
					<legend>게시물 검색</legend>					
					<form name="fsearch" method="get">
					<input type="hidden" name="sca" value="<?php echo $sca ?>">
					<input type="hidden" name="sop" value="and">
					<label for="sfl" class="sound_only">검색대상</label>
					<select name="sfl" id="sfl">
						<?php echo get_qa_sfl_select_options($sfl); ?>
					</select>
					<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
					<input type="text" name="stx" value="<?php echo stripslashes($stx); ?>" id="stx" required class="sch_input" size="25" maxlength="15" placeholder=" 검색어를 입력해주세요">
					<button type="submit" value="검색" class="sch_btn" title="검색"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
					</form>

				</fieldset>
			</div>
		</div>
		<!-- } 게시판 검색 끝 -->  

        <?php if ($admin_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn"><i class="fa fa-cog" aria-hidden="true"></i> 1:1문의 설정</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> 문의등록</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <?php if ($category_option) { ?>
    <!-- 카테고리 시작 { -->
    <nav id="bo_cate">
        <h2><?php echo $qaconfig['qa_title'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <!-- } 카테고리 끝 -->
    <?php } ?>

    <form name="fqalist" id="fqalist" action="./qadelete.php" onsubmit="return fqalist_submit(this);" method="post">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="sca" value="<?php echo $sca; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">

    <h2 class="sound_only"><?php echo $board['bo_subject'] ?> 목록</h2>
    <div class="likeTbl">
        <ul>
        <li class="likeTblTr likeTblTh">
            <?php if ($is_checkbox) { ?>
            <div class="td_chk">
                <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            </div>
            <?php } ?>
            <div class="mvInlineN td_num">번호</div>
            <div>상태/제목</div>
            <div class="mvInlineN">글쓴이</div>
            <div class="mvInlineN td_datetime">등록일</div>
        </li>
        <?php
        for ($i=0; $i<count($list); $i++) {
        ?>
        <li class="likeTblTr likeTblTd">
            <?php if ($is_checkbox) { ?>
            <div class="td_chk">
                <label for="chk_qa_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject']; ?></label>
                <input type="checkbox" name="chk_qa_id[]" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>">
            </div>
            <?php } ?>
            <div class="mvInlineN td_num2"><?php echo $list[$i]['num']; ?></div>
            <div class="td_subject">
                <a class="bo_cate_link"><?php echo $list[$i]['category']; ?></a>
				
                <div class="bo_tit">
					<a href="<?php echo $list[$i]['view_href']; ?>">
						<span class="td_stat"><span class=" <?php echo ($list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($list[$i]['qa_status'] ? '<i class="fa fa-check-circle" aria-hidden="true"></i> 답변완료' : '<i class="fa fa-times-circle" aria-hidden="true"></i> 답변대기'); ?></span></span> 
						<?php echo $list[$i]['subject']; ?>
						<?php if ($list[$i]['icon_file']) echo " <i class=\"fa fa-download\" aria-hidden=\"true\"></i>" ; ?>
					</a>
				</div>
            </div>
            <div class="mvInlinev td_name"><?php echo $list[$i]['name']; ?></div>
            <div class="mvInlinev td_date"><i class="fa fa-clock-o"></i> <?php echo $list[$i]['date']; ?></div>
            
        </li>
        <?php
        }
        ?>
        </ul>
        <?php if (count($list) == 0) {?><p class="noDataArea"><b>No data</b> <?php if ($stx){ ?><strong><?php echo $stx ?></strong>로 검색된<?php } else { echo '등록된';}?> 자료가 없습니다.</p><?php } ?>
    </div>

    <div class="bo_fx">
        <ul class="btn_bo_user">
            <?php if ($is_checkbox) { ?>
            <li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_admin"><i class="fa fa-trash-o" aria-hidden="true"></i> 선택삭제</button></li>
            <?php } ?>
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn_b01 btn"><i class="fa fa-list" aria-hidden="true"></i> 목록</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> 문의등록</a></li><?php } ?>
        </ul>
    </div>
    </form>

    
    <!-- 게시판 검색 시작 { -->
    <fieldset id="bo_sch">
        <legend>게시물 검색</legend>

        <form name="fsearch" method="get">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" required  class="sch_input" size="25" maxlength="15" placeholder="검색">
        <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
        </form>
    </fieldset>
    <!-- } 게시판 검색 끝 -->
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $list_pages;  ?>


<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다"))
            return false;
    }

    return true;
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->