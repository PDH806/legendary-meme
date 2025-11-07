<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//error_reporting(E_ALL);
ini_set('display_errors', '0');
error_reporting(~E_NOTICE);

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    // 상태바에 표시될 제목
    $g5_head_title = implode(' | ', array_filter(array($g5['title'], $config['cf_title'])));
}

$g5['title'] = strip_tags($g5['title']);
$g5_head_title = strip_tags($g5_head_title);

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<?php 
if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=no">';
} else if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') ||
    strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
	$contactDevice = "iphone";
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=no">';
} else {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">';
}
?>

<meta name="HandheldFriendly" content="true">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="format-detection" content="telephone=no">
<?php
if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>
<title><?php echo $g5_head_title; ?></title>
<?php
$shop_css = '';
if (defined('_SHOP_')) $shop_css = '_shop';
echo '<link rel="stylesheet" href="'.run_replace('head_css_url', G5_THEME_CSS_URL.'/'.(G5_IS_MOBILE?'mobile':'default').$shop_css.'.css?ver='.G5_CSS_VER, G5_THEME_URL).'">'.PHP_EOL;
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL ?>/responsive.css?ver=<?php echo G5_CSS_VER; ?>">
<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL ?>/contents.css?ver=<?php echo G5_CSS_VER; ?>">
<link rel="stylesheet" href="<?php echo G5_JS_URL ?>/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo G5_THEME_URL ?>/plugin/featherlight/featherlight.min.css?ver=<?php echo date("Hi");?>">
<!--[if lte IE 9]><script src="<?php echo G5_JS_URL ?>/html5.js"></script><script src="<?php echo G5_THEME_JS_URL ?>/respond.js"></script><![endif]-->
<script>var g5_url = "<?php echo G5_URL ?>"; var g5_bbs_url = "<?php echo G5_BBS_URL ?>"; var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>"; var g5_is_admin = "<?php echo isset($is_admin)?$is_admin:''; ?>"; var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>"; var g5_bo_table = "<?php echo isset($bo_table)?$bo_table:''; ?>"; var g5_sca = "<?php echo isset($sca)?$sca:''; ?>"; var g5_editor = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>"; var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";</script>
<script src="<?php echo G5_THEME_JS_URL ?>/jquery-1.12.4.min.js"></script>
<script src="<?php echo G5_THEME_JS_URL ?>/jquery.menu.min.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_JS_URL ?>/common.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_THEME_JS_URL ?>/WEBsiting.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_JS_URL ?>/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_JS_URL ?>/placeholders.min.js"></script>
<script src="<?php echo G5_THEME_URL ?>/plugin/featherlight/featherlight.min.js"></script>
<?php
if(G5_IS_MOBILE) {
    echo '<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
}
if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>
<?php 
/* 서브페이지 좌측메뉴 및 테마색상 지적은 theme.config.php 파일에서 지정 가능합니다.  */
if(isset($themeColor) && $themeColor != '#333333'){ ?><style>/* font color change */.WCMSSwrCenter .WCMSStit,.h2_title_center,#test, .themeColor{color:<?php echo $themeColor ?> !important;}/* border color change */.themeBorderColor,.WCMSStit,.btn_b02,input.btn_submit,.btn_submit,	a.btn_frmline,button.btn_frmline,#bo_cate_on,#bo_cate_ul li a:hover,#sideBar #snb .snb.active > h2,.h2_title{border-color:<?php echo $themeColor ?> !important;}/* BG change */.leftMenuUseFlase .contentTitle:after,.term_area header,#bo_cate_on,#top_btn ,#top_btn:hover,#snbMvAr a#snbClose,#snbOpen,#gnb .gnb_1dli:hover .gnb_1da u,#tnbWr,.background-dark,.gnb_2dul,#snb > li > h2,.btn_b02,input.btn_submit,.btn_submit,	a.btn_frmline,button.btn_frmline,.bNBar ul li.snb2d.active a,.bNBarMw > li ul li.active a,.WCMSScontT:after,.bNBar ul li a:hover:after,.themeBgColor{background-color:<?php echo $themeColor ?> !important;} ::selection{background:<?php echo $themeColor ?> !important;color:#ffffff !important;} ::-moz-selection{background:<?php echo $themeColor ?> !important;color:#ffffff !important;} </style><?php } ?>
</head>
<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : '';?> class="body<?php if(isset($subLeftMenu) && $subLeftMenu == 'false'){ echo ' leftMenuUseFlase'; } ?><?php if(isset($contactDevice) && $contactDevice == 'iphone'){ echo ' contactIphone'; } ?>">
<?php
if ($is_member) { // 회원이라면 로그인 중이라는 메세지를 출력해준다.
    $sr_admin_msg = '';
    if ($is_admin == 'super') $sr_admin_msg = "최고관리자 ";
    else if ($is_admin == 'group') $sr_admin_msg = "그룹관리자 ";
    else if ($is_admin == 'board') $sr_admin_msg = "게시판관리자 ";

    echo '<div id="hd_login_msg">'.$sr_admin_msg.get_text($member['mb_nick']).'님 로그인 중 ';
    echo '<a href="'.G5_BBS_URL.'/logout.php">로그아웃</a></div>';
}