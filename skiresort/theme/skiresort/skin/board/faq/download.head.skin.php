<?php
/* copyright(c) WEBsiting.co.kr */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (isset($listDown) && $listDown) {
?>
<div class="box_CloseDownloadWindow">
	<p>
		<b>조건지정 파일 다운로드 페이지 입니다.</b>
		파일 다운로드 실행이 완료되었거나 본 메세지가 보인다면 창닫기를 눌러주시기 바랍니다.
	</p>
	<a href="javascript:window.close();" class="btn_CloseDownloadWindow"><b># 창닫기</b></a>
</div>
<aside class="bg_CloseDownloadWindow"></aside>
<style type="text/css">
	.bg_CloseDownloadWindow{position:fixed; z-index:9; top:0px; left:0px; right:0px; bottom:0px; background:#003160;}
	.box_CloseDownloadWindow{ position:fixed; z-index:10; left:50%; top:50%; margin-top:-150px; margin-left:-150px; width:300px; background:RGBA(0,0,0,0.3); padding:30px; border-radius:10px;}
	.box_CloseDownloadWindow p{color:RGBA(255,255,255,0.7); font-size:12px;}
	.box_CloseDownloadWindow p b{font-size:16px; color:#e2cd99; display:block; padding-bottom:20px;}
	.btn_CloseDownloadWindow{display:block; width:200px; height:60px; line-height:60px; margin:15px auto 0; background:#fff; text-align:center; font-size:26px; color:#000; border-radius:8px; text-decoration:none;}
	.btn_CloseDownloadWindow:hover{background:#efefef;}
</style>
<?php
}