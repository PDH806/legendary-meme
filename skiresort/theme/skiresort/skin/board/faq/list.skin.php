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
						<!-- <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option> -->
						<!-- <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option> -->
						<!-- <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>작성자</option> -->
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
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> FAQ등록</a></li><?php } ?>
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
    <div class="faq_table">

		<ul class="faq_list">
			<?php
			for ($i=0; $i<count($list); $i++) {
			?>

			<li>
				<dl>
					<dt>
						<?php if ($is_checkbox) { ?><div class="faq_chk"><input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>"></div><?php } ?>

						<div class="faq_ask">Q<span class="sound_only">uestion(질문)</span></div>
						<div class="faq_subject" <?php if(isset($marginl) && $marginl) {echo $marginl;} ?>>
							<a class="faq_open"><?php if ($is_category && $list[$i]['ca_name']) { ?><span class="bo_cate_link">[<?php echo $list[$i]['ca_name'] ?>]</span><?php } ?> <?php echo $list[$i]['subject']?></a>
						</div>
						<div class="faq_sh"> <i class="fa fa-chevron-up" aria-hidden="true"></i><i class="fa fa-chevron-down" aria-hidden="true"></i> </div>
					</dt>
					<dd class="faq_cont">
						<div class="faq_answer">A<span class="sound_only">nswer(답변)</span></div>
						<div class="faq_cont">
							<?php 
							// 유투브 링크 시작 2023-02-08 새로운 공유주소 및 쇼츠 링크 대응 코드
							// 유투브 공유 링크가 있을때만 표시됩니다
							// ex. https://youtu.be//게시글아이디
							if(isset($list[$i]['link'][1]) && $list[$i]['link'][1]) { 
					 
								$cnt = 0;
								for ($f=1; $f<=count($list[$i]['link']); $f++) {
									if ($list[$i]['link'][$f]) {
										$youtubeID[$i] = $list[$i]['link'][$f]; 
										$youtubeID[$i] = explode('/',$youtubeID[$i]); 
										if($youtubeID[$i][2] == "youtu.be") {
									?>
									<div class="youtube_area"><iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $youtubeID[$i][3]; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
									<?php
										} 
										if($youtubeID[$i][2] == "youtube.com" || $youtubeID[$i][2] == "www.youtube.com"){
											if($youtubeID[$i][3] == "shorts" || $youtubeID[$i][3] == "live"){ ?>
												<div class="youtube_area"><iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $youtubeID[$i][4]; ?>" frameborder="0" allowfullscreen></iframe></div>
											<?php 
											} 
											else  { 
												$youtubeIDnew[$i] = explode('=',$youtubeID[$i][3]); 
												$youtubeIDnewID[$i] = explode('&',$youtubeIDnew[$i][1]); 
											?>
												<div class="youtube_area"><iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $youtubeIDnewID[$i][0]; ?>" frameborder="0" allowfullscreen></iframe></div>
											<?php 
											}
										}
									}
								}
							} 
							//유투브 링크 끝
							?>
							<?php echo get_view_thumbnail($list[$i]['wr_content']); ?>

							<div class="fileDownList_downBtn">
								<?php
								// 가변 첨부파일 목록에서 첨부파일을 다운로드 받기위한 세션 생성 - 이 기능은 본 스킨에서만 사용됩니다.
								$ss_name = 'ss_view_'.$bo_table.'_'.$list[$i]['wr_id']; 
								set_session($ss_name, TRUE); 
								for ($j=0; $j<count($list[$i]['file']); $j++) {
									if (isset($list[$i]['file'][$j]['source']) && $list[$i]['file'][$j]['source']) {
								 ?>

									<a href="<?php echo $list[$i]['file'][$j]['href'];  ?>&listDown=true" target="_blank" alt="file download" class="btn_b03 btn">
										<b><?php echo $list[$i]['file'][$j]['source'] ?></b> <span>( <?php echo $list[$i]['file'][$j]['size'] ?> )</span> <i class="fa fa-arrow-circle-down"></i> 
									</a>	
								<?php 
									} 
								}
								?>
							</div>

						</div>
						<?php if ($is_admin) { ?><a href="<?php echo $write_href?><?php if($config['cf_bbs_rewrite'] == '1' || $config['cf_bbs_rewrite'] == '2'){echo '?';} else {echo '&';} ?>w=u&wr_id=<?php echo $list[$i]['wr_id']?>&page=<?php echo $page?>" class="btn_b02 btn_rb"><i class="fa fa-pencil" aria-hidden="true"></i>  수정</a><?php } ?>
						<a href="<?php echo $list[$i]['href'] ?>" class="btn_b01 btn_rb"><i class="fa fa-link" aria-hidden="true"></i>  <?php echo $list[$i]['subject']?> 페이지로 이동</a>

					</dd>
				</dl>
			</li> 
			<?php } ?>

		</ul>

        <?php if (count($list) == 0) {?><p class="noDataArea"><i class="fa fa-exclamation-triangle"></i> <br> <b>No data</b> <?php if ($stx){ ?><strong><?php echo $stx ?></strong>로 검색된<?php } else { echo '등록된';}?> 자료가 없습니다.</p><?php } ?>
    </div>

	<script>
	$(function(){
		const faqItems = $('.faq_list li');
		faqItems.addClass('hide').find('.faq_cont').hide();
		$('.faq_list').on('click', 'a.faq_open', function(e){
			e.preventDefault();
			const item = $(this).closest('li');
			item.toggleClass('show hide')
				.find('.faq_cont').stop(true, true).slideToggle(100);
		});
	});
	</script>


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
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> FAQ등록</a></li><?php } ?>
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