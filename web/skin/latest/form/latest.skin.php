<?php
/* copyright(c) WEBsiting.co.kr */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$admin = get_admin("super"); 
?>

<div class="formLat">
    <h2 class="formLatTit"><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?> <u class="themeBgColor"></u></a></h2>
    <ul>
		<li class="empty_li">
			<p>
				<?php 
				if(isset($admin['mb_tel']) && $admin['mb_tel']){			echo '<strong><i class="fa fa-phone-square"></i> '.$admin['mb_tel'].'</strong>'; } 
				if(isset($admin['mb_1']) && $admin['mb_1']){			echo '<span>FAX: '.$admin['mb_1'].'</span>'; } 
				if(isset($admin['mb_email']) && $admin['mb_email']){		echo '<span>E-mail: '.$admin['mb_email'].'</span>'; } 
				?>
				<br><i class="fa fa-exclamation-triangle"></i> 문의사항이 있으시면 문의를 남겨주세요.
			</p>
		</li>
    </ul>
    <a href="<?php echo get_pretty_url($bo_table); ?>" class="lt_more themeBgColor "><?php echo $bo_subject ?> 바로가기 <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
</div>				