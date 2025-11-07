<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
/* copyright (c) WEBsiting.kr */
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css?v2">', 0);
// 내용관리의 스타일은 아래 CSS파일에서 관리됩니다.
// theme/purewhite/css/contents.css
if ($is_admin) {  ?>
	<style type="text/css">
		.pageLinkSkinInfo{height:1px; width:100%; position:relative;text-align:right;}
		.ctt_admin{display:none;}
	</style>
	<aside class="pageLinkSkinInfo">
		<a class="btn_admin btn" href="javascript:alert('Notice !\n(테마)page_Link 스킨이 적용된 페이지 입니다.\n내용 수정은 테마의 /pages/ 폴더 <?php echo $co_id; ?>.php 파일을 직접 수정해 주시기 바랍니다.');"><span class="sound_only">내용 수정</span><i class="fa fa-cog fa-spin fa-fw"></i></a>
	</aside>
<?php }  
include_once(G5_THEME_PATH.'/pages/'.$co_id.'.php');