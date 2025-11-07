<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
/* copyright(c) WEBsiting.co.kr */
global $is_admin;
if ($is_admin == "super") { 
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$visit_skin_url.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.run_replace('head_css_url', G5_ADMIN_URL.'/css/admin.css?ver='.G5_CSS_VER, G5_URL).'">', 0);
?>
<style type="text/css">
	body{background:#fff;}
</style>
<div class="btn_list03 btn_list btn_list00">
	<a class="themeBgColor" style="float:left;"><i class="fa fa-desktop"></i> 현재 적용중인 테마색상</a>
	<a href="<?php echo G5_ADMIN_URL ?>/board_form.php" target="_parent" style=" margin-right:10px; background:#15264d;"><i class="fa fa-list-alt"></i> 게시판 생성 바로가기</a>
	<a href="<?php echo G5_ADMIN_URL ?>/WCMSS_form.php?WCMSS=true" target="_parent" style=" background:#15264d;"><i class="fa fa-file-text-o"></i> 컨텐츠메이커 게시판 간편 생성 바로가기</a>
</div>
<!-- 접속자집계 시작 { -->
<section id="visitAdm">
	<h2>접속자집계 <small style="font-weight:normal; color:#999;">(테마에서 제공되는 접속자 집계표 입니다. 다른테마를 선택하시면 자동으로 사라집니다.)</small></h2>
	<table>
		<tbody>
			<tr>
				<td><div class=""><i class="fa fa-calendar-check-o "></i>  <p>오늘접속자<b><?php echo number_format($visit[1]) ?></b></p></div></td>
				<td><div class=""><i class="fa fa-calendar-minus-o "></i>  <p>어제접속자<b><?php echo number_format($visit[2]) ?></b></p></div></td>
				<td><div class=""><i class="fa fa-calendar-plus-o  "></i>  <p>최대접속자<b><?php echo number_format($visit[3]) ?></b></p></div></td>
				<td><div class=""><i class="fa fa-calendar "></i>  <p>전체접속자<b><?php echo number_format($visit[4]) ?></b></p></div></td>
			</tr>
		</tbody>
	</table>
	<div class="btn_list03 btn_list">
		<a href="<?php echo G5_ADMIN_URL ?>/visit_list.php" target="_parent">접속자 집계 상세보기</a>
	</div>
</section>
<!-- } 접속자집계 끝 -->
<?php }