<!DOCTYPE html>
<html>

<script src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="https://code.jquery.com/jquery.menu.js?ver=171222"></script>
<script src="https://code.jquery.com/common.js?ver=171222"></script>
<!-- <script src="js/wrest.js?ver=171222"></script> -->
<script src="js/placeholders.min.js"></script>
<link rel="stylesheet" href="js/font-awesome/css/font-awesome.min.css">

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta property="og:image" content="images/meta_img.jpg" />
	<meta property="og:description" content=""/>
	<title></title>
    <link rel="shortcut icon" type="image/x-icon" href="../skiresort/ski/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="http://skiresort.ivyro.net/skiresort/ski/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="http://skiresort.ivyro.net/skiresort/ski/css/common.css" />	
 	<link rel="stylesheet" type="text/css" href="http://skiresort.ivyro.net/skiresort/ski/css/main.css" /> 	
	<link rel="stylesheet" type="text/css" href="http://skiresort.ivyro.net/skiresort/ski/css/jquery.fullpage.css" />
	<link rel="stylesheet" type="text/css" href="http://skiresort.ivyro.net/skiresort/ski/css/table.css" />
	<link rel="stylesheet" type="text/css" href="http://skiresort.ivyro.net/skiresort/ski/css/sub_01.css" media='screen,print'/>	
	<link rel="stylesheet" type="text/css" href="http://skiresort.ivyro.net/skiresort/ski/css/media_01.css" />

	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/scrolloverflow.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/jquery.fullpage.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/slick.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/common.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/html5shiv.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/flexslider.js"  charset="utf-8"></script>

    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>  <!-- ���������ȣ API -->
    <!--<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script> ���������ȣ API -->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="js/html5shiv.js"></script>
	<![endif]-->
</head>
<body>
        <div class="ofl_spt">
            <script language="javascript">
                $(document).ready(function() {
                    //메인화면 PC/모바일 분기시 화면 스크롤
                    isOnePageScroll();
                });

            </script>
        </div>
        <!--//ofl_spt -->

<head>

<?
	$main_title = '한국 스키장 경영협회';
	$link 	= 	mysqli_connect("dbserver","skiresort","ll170505","skiresort");
	include 'db_config.html';
?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<link rel="shortcut icon" href="Myicon.png" type="image/x-icon">
    
    <title>
    	<?
    	echo "$main_title / $page";    	
    	?>    
    </title>
    
		<!-- Custom styles for AUGMENT-SKI -->
			<? include 'link-files.html'; ?>
		<!-- end of Link -->
		
</head>
<body>
		<!-- Navigation for AUGMENT-SKI -->
			<? include 'main-nav.html'; ?>
		<!-- end of Navigation -->

                    <script>
                        $(function() {
                            $('.slide').slick({
                                fade: true,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                autoplay: true,
                                autoplaySpeed: 3000,
                                speed: 1000,
                                cssEase: 'ease-out',
                                swipe: false,
                                dots: false,
                                arrows: false,
                                pauseOnHover: false,
                            });
                            
                        });
                    </script>

<div id="sbcenter" class="sb_notice report">
 <div class="sb_top_bg">
 
  <?php if($bo_table=='report'){?>
  
  <div class="inner_wrap"><h2>보도자료</h2></div>
   <div class="sb_top_menu">
    <ul class="sbclear">
     <li style='width:33.3%' <?php if(!$sca) echo 'class="on"';?>><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=report">전체보기</a></li>
     <li style='width:33.3%' <?php if($sca=='협회보도자료') echo 'class="on"';?>><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=report&sca=<?php echo urlencode("협회보도자료")?>">협회보도자료</a></li>
     <li style='width:33.3%' <?php if($sca=='회원사보도자료') echo 'class="on"';?>><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=report&sca=<?php echo urlencode("회원사보도자료")?>">회원사보도자료</a></li>
    </ul>
   </div>
   <!--/sb_top_menu-->
  </div><!-- sb_top_bg -->
  
  <div class="sbcenter report_all">
   <div class="sb_content">
    <div class="sb_top_text sbclear">
     <a href="#self" class="sb_prev"><img src="<?php echo G5_SKI_URL?>/images/sb_prev_btn_off.png" alt="이전"></a>
     <a href="sb_safe.html" class="sb_next"><img src="<?php echo G5_SKI_URL?>/images/sb_next_btn_on.png" alt="다음"></a>
     <?php if($bo_table=='report' && !$sca):?>
      <h3>전체보기</h3>
      <p>한국 스키장 경영협회의 새 소식을 확인하실 수 있습니다.</p>
     <?php elseif($bo_table=='report' && $sca=='협회보도자료'):?>
      <h3>협회 보도 자료</h3>
      <p>한국 스키장 경영협회의 새 소식을 확인하실 수 있습니다.</p>
     <?php elseif($bo_table=='report' && $sca=='회원사보도자료'):?>
      <h3>회원사 보도 자료</h3>
      <p>한국 스키장 경영협회의 새 소식을 확인하실 수 있습니다.</p>
     <?php endif;?>     
    </div>
    <!--/sb_top_text-->
   </div><!-- .sb_center -->
  
  <?php }else{?>

  <div class="inner_wrap"><h2>커뮤니티</h2></div>
  <div class="sb_top_menu">
   <ul class="sbclear">
    <li <?php if($bo_table=='notice') echo 'class="on"';?>><a href="board.php?category=notice">공지사항</a></li>
    <li><a href="sb_safe.html">안전수칙</a></li>
    <?php if($bo_table=='qa'){?>
    <li  class="on"><!-- <a href="sb_data.html"> -->
     <a href='board.php?bo_table=qa'>자료실</a>
     </li>
    <?php }?>
    <li <?php if($bo_table=='gallery') echo 'class="on"';?>><!-- <a href="sb_gallery.html">갤러리</a> -->
     <a href='board.php?category=gallery'>갤러리</a>
    </li>
    <!-- <li><a href="sb_qna.html">1:1 문의하기</a></li> -->
   </ul>
   </div>
   <!--/sb_top_menu-->
   </div><!-- sb_top_bg -->
   
   <div class="sbcenter sb_gallery">
    <div class="sb_content">
     <div class="sb_top_text sbclear">
     <?php if($bo_table=='notice'):?>
		<a href="#self" class="sb_prev"><img src="<?php echo G5_SKI_URL?>/images/sb_prev_btn_off.png" alt="이전"></a>
		<a href="<?php echo G5_SKI_URL?>/sb_safe.html" class="sb_next"><img src="<?php echo G5_SKI_URL?>/images/sb_next_btn_on.png" alt="다음"></a>	
      <h3>공지사항</h3>
      <p>한국 스키장 경영협회의 새 소식을 확인하실 수 있습니다.</p>
     <?php elseif($bo_table=='qa'):?>
      <h3>자료실</h3>
      <p>한국 스키장 경영협회의 자료를 확인하실 수 있습니다.</p>
     <?php elseif($bo_table=='gallery'):?>
		<a href="<?php echo G5_SKI_URL?>/sb_safe.html" class="sb_prev"><img src="<?php echo G5_SKI_URL?>/images/sb_prev_btn_on.png" alt="이전"></a>
		<a href="#self" class="sb_next"><img src="<?php echo G5_SKI_URL?>/images/sb_next_btn_off.png" alt="다음"></a>	
      <h3>갤러리</h3>
      <p>한국 스키장 경영협회의 갤러리입니다.</p>
     <?php endif;?>
     
     </div>
     <!--/sb_top_text-->
   
  <?php } ?>
 
   
 
  
  
<?php 
// 게시물 아이디가 있다면 게시물 보기를 INCLUDE
if (isset($wr_id) && $wr_id) {
    include_once(G5_BBS_PATH.'/view.php');
}

// 전체목록보이기 사용이 "예" 또는 wr_id 값이 없다면 목록을 보임
//if ($board['bo_use_list_view'] || empty($wr_id))
if ($member['mb_level'] >= $board['bo_list_level'] && $board['bo_use_list_view'] || empty($wr_id))
    include_once (G5_BBS_PATH.'/list.php');

//include_once(G5_BBS_PATH.'/board_tail.php');
?>
    
   
  </div><!-- #sbcenter sb_notice -->
 </div><!-- .sb_top_bg  --> 
</div><!-- #sbcenter -->

<?php     
echo "\n<!-- 사용스킨 : ".(G5_IS_MOBILE ? $board['bo_mobile_skin'] : $board['bo_skin'])." -->\n";
//include_once(G5_PATH.'/tail.sub.php');
include G5_SKI_PATH."/include/footer.html";
?>



<?
          include "include/sb_quick.html";
?>
            </div>
            <!-- //sbcenter -->

            <!-- ㅡㅡㅡㅡㅡㅡㅡㅡFOOTERㅡㅡㅡㅡㅡㅡㅡㅡ -->
            <?
    include "include/footer3.html";
?>
