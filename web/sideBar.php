<?php
/* copyright(c) WEBsiting.co.kr */
/* 2020-02-04 짧은글 주소 메뉴 활성화 대응코드 */
/* PHP 5.4-8.4 호환성 개선 버전 */
if (!defined('_GNUBOARD_')) exit; /* 개별 페이지 접근 불가 */

// PHP 5.4 호환용 함수들 정의
if (!function_exists('array_key_first')) {
    function array_key_first($array) {
        if (empty($array)) return null;
        foreach ($array as $key => $value) {
            return $key;
        }
        return null;
    }
}

// 안전한 htmlspecialchars 함수 (PHP 5.4 호환)
function safe_htmlspecialchars($string, $flags = null, $encoding = null) {
    if ($flags === null) $flags = ENT_QUOTES;
    if ($encoding === null) $encoding = 'UTF-8';
    return htmlspecialchars($string, $flags, $encoding);
}

// 안전한 배열 접근 함수
function safe_array_get($array, $key, $default = '') {
    return isset($array[$key]) ? $array[$key] : $default;
}

if($bo_table){
    $https_check = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    
    $actual_link = $https_check . "://" . $host . $request_uri;
    $realLink = str_replace(G5_URL, '', strtok($actual_link, '&'));
    $path = explode('/', $realLink);
    $path1 = isset($path[1]) ? $path[1] : '';
    $mnNewActive = preg_replace("/[ #&+%@=\/\\\\:;,.'\"^`~|!?*$#<>\(\)\[\]\{\}]/", "", strtok($path1, '?'));
    $mnNewActive2 = preg_replace("/[ #&+%@=\/\\\\:;,.'\"^`~|!?*$#<>\(\)\[\]\{\}]/", "", safe_htmlspecialchars($request_uri));

 /* 주의사항 아래 코드를 수정하시면 페이지 현재위치 및 서브메뉴,모바일메뉴가 정상작동되지 않을 수 있습니다. */ 
echo '<ul id="snb">'; 
$sql = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '2' order by me_order, me_id "; 
    $result = sql_query($sql, false); 
    if ($result) {
        for ($i=0; $row=sql_fetch_array($result); $i++) {
            // 1. 도메인을 제거하고 경로와 쿼리만 추출
            $parsed_url = parse_url($row['me_link']);
            $parsed_path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
            $parsed_query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
            $relative_link = $parsed_path . $parsed_query;

            // 2. 쿼리 문자열을 파싱하여 배열로 분해
            $query_params = array();
            if (isset($parsed_url['query'])) {
                parse_str($parsed_url['query'], $query_params);
            }

            // 3. 원하는 파라미터 추출
            $gnbM_kind = !empty($query_params) ? array_key_first($query_params) : '';
            $gnbM_id = isset($query_params[$gnbM_kind]) ? $query_params[$gnbM_kind] : '';
            
            // PHP 5.4 호환용 array_slice
            $query_values = array_values($query_params);
            $slice_result = array_slice($query_values, 2, 1);
            $gnbM_idL = !empty($slice_result) ? $slice_result[0] : '';

            // 4. 정리된 메뉴 링크 키
            $menuLink = preg_replace("/[ #&+%@=\/\\\\:;,.'\"^`~|!?*$#<>()\[\]\{\}]/", "", $relative_link);

?>
<li class="snb <?php echo safe_htmlspecialchars($gnbM_kind . $gnbM_id . $gnbM_idL); ?> d1_<?php echo safe_htmlspecialchars($menuLink); ?> <?php 
$sql2 = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '4' and substring(me_code, 1, 2) = '{$row['me_code']}' order by me_order, me_id "; 
$result2 = sql_query($sql2); 
if ($result2) {
    for ($k=0; $row2=sql_fetch_array($result2); $k++) {
        // 1. 파싱해서 URL 경로와 쿼리만 추출
        $parsed_url = parse_url($row2['me_link']);
        $parsed_path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $parsed_query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $relative_link = $parsed_path . $parsed_query;

        // 2. 쿼리 파라미터 분해
        $params = array();
        if (isset($parsed_url['query'])) {
            parse_str($parsed_url['query'], $params);
        }
        $gnbM_keys = array_keys($params);

        // 3. 필요한 값 추출
        $gnbM_kind2 = isset($gnbM_keys[0]) ? $gnbM_keys[0] : '';
        $gnbM_id2 = isset($params[$gnbM_kind2]) ? $params[$gnbM_kind2] : '';
        $gnbM_key2 = isset($gnbM_keys[2]) ? $gnbM_keys[2] : '';
        $gnbM_idL2 = isset($params[$gnbM_key2]) ? $params[$gnbM_key2] : '';

        // 4. 출력
        if ($k == 0) echo '';
        echo safe_htmlspecialchars($gnbM_kind2 . $gnbM_id2 . $gnbM_idL2) . ' ';
    }
}

$sql2 = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '4' and substring(me_code, 1, 2) = '{$row['me_code']}' order by me_order, me_id "; 
$result2 = sql_query($sql2); 
if ($result2) {
    for ($k=0; $row2=sql_fetch_array($result2); $k++) {
        if($k == 0)  echo '';
        echo '';
        // 1. 파싱해서 URL 경로와 쿼리만 추출
        $parsed_url = parse_url($row2['me_link']);
        $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';

        // 2. 도메인 제거하고 경로 + 쿼리만 조합
        $relative_link = $path . $query;
        
        $menuRealLink2 = str_replace(G5_URL,'',$relative_link);
        $menuLink2 = preg_replace("/[ #\&\+%@=\/\\\:;,\.'\"\^`~\|\!\?\*$#<>\(\)\[\]\{\}]/i", "", $relative_link); 
        if($mnNewActive == $menuLink2){
            echo ' d1_';
            echo safe_htmlspecialchars($menuLink2); 
        }
        $menuLink3root = explode("/",$relative_link);
        if(isset($menuLink3root[2]) && $menuLink3root[2] == 'write'){
            echo ' d1_';
            $menu_root_1 = isset($menuLink3root[1]) ? $menuLink3root[1] : '';
            echo safe_htmlspecialchars($menu_root_1);
        }
    }
}
$k_check = isset($k) ? $k : 0;
if ($k_check == 0) echo ' noSubSpacer';

?>"><h2 class="bnBar_<?php echo safe_htmlspecialchars($row['me_code']); ?>"><a href="<?php echo $row['me_link']; ?>" target="_<?php echo safe_htmlspecialchars($row['me_target']); ?>"><b><?php echo safe_htmlspecialchars($row['me_name']); ?></b> <sub></sub></a></h2><?php 

$sql2 = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '4' and substring(me_code, 1, 2) = '{$row['me_code']}' order by me_order, me_id "; 
$result2 = sql_query($sql2); 
if ($result2) {
    for ($k=0; $row2=sql_fetch_array($result2); $k++) {
        // 1. URL 경로와 쿼리 파싱
        $parsed_url = parse_url($row2['me_link']);
        $parsed_path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $parsed_query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $relative_link = $parsed_path . $parsed_query;

        // 2. 쿼리 파라미터 파싱
        $params = array();
        if (isset($parsed_url['query'])) {
            parse_str($parsed_url['query'], $params);
        }
        $param_keys = array_keys($params);

        $gnbM_kind2 = isset($param_keys[0]) ? $param_keys[0] : '';
        $gnbM_id2   = isset($params[$gnbM_kind2]) ? $params[$gnbM_kind2] : '';
        $param_key_2 = isset($param_keys[2]) ? $param_keys[2] : '';
        $gnbM_idL2  = isset($params[$param_key_2]) ? $params[$param_key_2] : '';

        // 3. 링크 처리
        $menuRealLink2 = str_replace(G5_URL, '', $row2['me_link']);
        $menuLink2 = preg_replace("/[ #&\+%@=\/\\\:;,\.'\"\^`~|!?*$<>\(\)\[\]\{\}]/i", "", $relative_link);

        $menuLink3root = explode("/", $relative_link);
        $is_write = (isset($menuLink3root[2]) && $menuLink3root[2] === 'write');
        if ($is_write) {
            $exploded_write = explode("write", $menuLink2);
            $menuLinkD2 = isset($exploded_write[0]) ? $exploded_write[0] : $menuLink2;
        } else {
            $menuLinkD2 = $menuLink2;
        }
        
        $menuLinkD2wr_id = '';
        if (strpos($row2['me_link'], 'wr_id=') !== false) {
            // 정규식을 이용해 wr_id 값을 추출
			if (isset($row2['me_link']) && strpos($row2['me_link'], 'wr_id=') !== false) {
				$menuLinkD2wr_id = 'wr_idok';
			}
        }
        $menuLinkD2sca = '';
        if (strpos($row2['me_link'], 'sca=') !== false) {
            // 정규식을 이용해 sca 값을 추출
			if (isset($row2['me_link']) && strpos($row2['me_link'], 'sca=') !== false) {
				$menuLinkD2sca = 'scaok';
			}
        }

        if($k == 0) echo '<em class="snb2dDown"><b></b><i class="fa fa-angle-down"></i><u class="fa fa-angle-up"></u></em><ul class="snb2dul">';
		
		$menuLinkD2_safe = preg_replace("/[ #&+%@=\/\\\\:;,.'\"^`~|!?*$#<>\(\)\[\]\{\}]/", "", safe_htmlspecialchars(urlencode($menuLinkD2)));
		$gnbM_idL2_safe = preg_replace("/[ #&+%@=\/\\\\:;,.'\"^`~|!?*$#<>\(\)\[\]\{\}]/", "", safe_htmlspecialchars(urlencode($gnbM_idL2)));
        
?><li class="snb2d snb2d_<?php echo safe_htmlspecialchars($gnbM_kind2 . $gnbM_id2 . $gnbM_idL2_safe . $menuLinkD2wr_id . $menuLinkD2sca); ?> d2_<?php echo $menuLinkD2_safe; ?> "><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo safe_htmlspecialchars($row2['me_target']); ?>"><b><i class="fa fa-angle-right"></i> <?php echo safe_htmlspecialchars($row2['me_name']); ?></b></a></li><?php 
    } 
    if($k > 0) echo '</ul>'; 
}
?></li><?php 
        }
    }
?><li class="snb noInfoPageTit <?php 
    $sql = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '2' order by me_order, me_id "; 
    $result = sql_query($sql, false);
    if ($result) {
        for ($i=0; $row=sql_fetch_array($result); $i++) {
            // 1. URL 경로와 쿼리만 추출
            $parsed = parse_url($row['me_link']);
            $path = isset($parsed['path']) ? $parsed['path'] : '';
            $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';

            // 2. 도메인 제거 후 경로 + 쿼리 결합
            $menuRealLink = $path . $query;

            // 3. 경로 문자열 정제 (단, _, - 제외)
            $menuLink = preg_replace("/[^a-zA-Z0-9_\-]/", "", $menuRealLink);

            // 4. 현재 메뉴 활성 상태와 비교
            if ($mnNewActive === $menuLink) {
                echo ' none_' . safe_htmlspecialchars($menuLink);

                $menuParts = explode('/', $menuRealLink);
                if (isset($menuParts[2]) && $menuParts[2] === 'write') {
                    $exploded_write = explode('write', $menuLink);
                    $menuBase = isset($exploded_write[0]) ? $exploded_write[0] : '';
                    echo ' none_' . safe_htmlspecialchars($menuBase);
                }
            }
            
            $sql2 = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '4' and substring(me_code, 1, 2) = '{$row['me_code']}' order by me_order, me_id "; 
            $result2 = sql_query($sql2); 
            if ($result2) {
                for ($k=0; $row2=sql_fetch_array($result2); $k++) {
                    // 1. URL 경로와 쿼리 추출
                    $parsed = parse_url($row2['me_link']);
                    $parsed_path = isset($parsed['path']) ? $parsed['path'] : '';
                    $parsed_query = isset($parsed['query']) ? '?' . $parsed['query'] : '';
                    $menuRealLink2 = $parsed_path . $parsed_query;

                    // 2. 특수문자 제거 (단, _와 -는 유지)
                    $menuLink2 = preg_replace("/[^a-zA-Z0-9_\-]/", "", $menuRealLink2);

                    // 3. 활성 메뉴 확인
                    if ($mnNewActive === $menuLink2) {
                        echo ' none_' . safe_htmlspecialchars($menuLink2);

                        // 4. write 포함 여부 체크
                        $segments = explode('/', $menuRealLink2);
                        if (isset($segments[2]) && $segments[2] === 'write') {
                            $exploded_write = explode('write', $menuLink2);
                            $menuLink3 = isset($exploded_write[0]) ? $exploded_write[0] : '';
                            echo ' none_' . safe_htmlspecialchars($menuLink3);
                        }
                    }
                } 
            }
        }
    }

?>"></li></ul>
<?php /* 주의사항 아래 코드를 수정하시면 페이지 현재위치 및 서브메뉴,모바일메뉴가 정상작동되지 않을 수 있습니다. */ 
	
		$sca_safe = preg_replace("/[ #&+%@=\/\\\\:;,.'\"^`~|!?*$#<>\(\)\[\]\{\}]/", "", safe_htmlspecialchars(urlencode($sca)));
?>
<script>
$(function(){
    $(".snb.bo_table<?php echo safe_htmlspecialchars($bo_table);?>, .snb .snb2d_bo_table<?php echo safe_htmlspecialchars($bo_table);?>").addClass("active");
    $(".snb.d1_<?php echo safe_htmlspecialchars($mnNewActive);?>, .snb .d2_<?php echo safe_htmlspecialchars($mnNewActive);?>, .snb .d2_<?php echo safe_htmlspecialchars($mnNewActive2);?>").addClass("active");
	<?php if (isset($wr_id, $sca) && $wr_id !== '' && $sca !== '') {?>
		$(".d2_<?php echo $bo_table ?>sca<?php echo $sca_safe; ?>, .d2_bbsboardphpbo_table<?php echo $bo_table ?>ampsca<?php echo $sca_safe; ?>").addClass("active");
		$(".d2_<?php echo $bo_table ?>sca<?php echo $sca_safe; ?>, .d2_bbsboardphpbo_table<?php echo $bo_table ?>ampsca<?php echo $sca_safe; ?>").parents(".snb").addClass("active");
	<?php } ?>
    if ($('.snb .d2_<?php echo safe_htmlspecialchars($mnNewActive2);?>').hasClass('active')) {
        $('.d2_<?php echo safe_htmlspecialchars($bo_table);?>').addClass('active');
    }
});
$(document).ready(function(){
    if($("#snb > li").is(".snb.active")){
        $(".loc1D").html($(".snb.active h2 a b").html());
        $(".loc2D").html($(".snb2d.active a b").html());
        $(".faArr").html('<i class="fa fa-angle-right"></i>');
        var a=$("#snb > li").index("#snb > li.active");
        $("#page_title").addClass("subTopBg_"+($("#snb > li.bo_table<?php echo safe_htmlspecialchars($bo_table); ?>, #snb > li.d1_<?php echo safe_htmlspecialchars($mnNewActive); ?>").index()+1));
    } else {
        $(".loc1D, .bNBarMw .snb2dDown > b").text("<?php echo safe_htmlspecialchars(get_head_title($g5['title'])); ?>");
        $(".noInfoPageTit").html("<h2><a><b><?php echo safe_htmlspecialchars(get_head_title($g5['title'])); ?></b><sub></sub></a></h2>");
        $(".noInfoPageTit").addClass("active");
        $(".subTopLocNav").addClass("subTopLocNav2Dnone");
        $("#page_title").addClass("subTopBg_");
    }
});
$(function(){
    $(".noInfoPageTit.none_<?php echo safe_htmlspecialchars($mnNewActive);?>").addClass("displayNoneImportant");
    $(".noInfoPageTit.none_<?php echo safe_htmlspecialchars($mnNewActive);?>").removeClass("active");
});
$(".bNBar > ul").html($("#snb").html());
$(function(){ var a=$("#snb li.snb"); a.addClass("hide"); $("#snb li.active").removeClass("hide").addClass("show"); $("#snb li.active .snb2dul").show(); $(".snb2dDown").click(function(){ var b=$(this).parents("#snb li.snb"); if(b.hasClass("hide")){ a.addClass("hide").removeClass("show"); a.find(".snb2dul").slideUp("fast"); b.removeClass("hide").addClass("show"); b.find(".snb2dul").slideDown("fast"); } else { b.removeClass("show").addClass("hide"); b.find(".snb2dul").slideUp("fast"); } }) }); $(".snb").removeClass("d1_bbscontentphp"); $(".snb2d").removeClass("d2_bbscontentphp");
</script>
<?php } else { 
/* copyright(c) WEBsiting.co.kr */
/* 2021-02-13 php8 대응코드 */
$actual_link = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
$topMNactiveLink = preg_replace("/[ #\&\+%@=\/\\\:;,\.'\"\^`~\|\!\?\*$#<>\(\)\[\]\{\}]/i", "", $actual_link);
 /* 주의사항 아래 코드를 수정하시면 페이지 현재위치 및 서브메뉴,모바일메뉴가 정상작동되지 않을 수 있습니다. */ 
?><ul id="snb"><?php 
$sql = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '2' order by me_order, me_id "; 

$result = sql_query($sql, false); 
if ($result) {
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        // 1. 파싱해서 URL 경로와 쿼리만 추출
        $parsed_url = parse_url($row['me_link']);
        $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';

        // 2. 도메인 제거하고 경로 + 쿼리만 조합
        $relative_link = $path . $query;
    
        $snb1Class = preg_replace("/[ #\&\+%@=\/\\\:;,\.'\"\^`~\|\!\?\*$#<>\(\)\[\]\{\}]/i", "", $relative_link);
?><li class="snb D1_<?php echo safe_htmlspecialchars($snb1Class);?>"><h2><a href="<?php echo $row['me_link']; ?>" target="_<?php echo safe_htmlspecialchars($row['me_target']); ?>"><b><?php echo safe_htmlspecialchars($row['me_name']); ?></b> <sub></sub></a></h2><?php 
$sql2 = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '4' and substring(me_code, 1, 2) = '{$row['me_code']}' order by me_order, me_id "; 
$result2 = sql_query($sql2); 
if ($result2) {
    for ($k=0; $row2=sql_fetch_array($result2); $k++) {
        // 1. 파싱해서 URL 경로와 쿼리만 추출
        $parsed_url2 = parse_url($row2['me_link']);
        $path2 = isset($parsed_url2['path']) ? $parsed_url2['path'] : '';
        $query2 = isset($parsed_url2['query']) ? '?' . $parsed_url2['query'] : '';

        // 2. 도메인 제거하고 경로 + 쿼리만 조합
        $relative_link2 = $path2 . $query2;
        $snb2Class = preg_replace("/[ #\&\+%@=\/\\\:;,\.'\"\^`~\|\!\?\*$#<>\(\)\[\]\{\}]/i", "", $relative_link2);
        if($k == 0) echo '<em class="snb2dDown"><b></b><i class="fa fa-angle-down"></i><u class="fa fa-angle-up"></u></em><ul class="snb2dul">';
?><li class="snb2d D2_<?php echo safe_htmlspecialchars($snb2Class);?>"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo safe_htmlspecialchars($row2['me_target']); ?>"><b><i class="fa fa-angle-right"></i> <?php echo safe_htmlspecialchars($row2['me_name']); ?></b></a></li><?php 
    } 
    if($k > 0) echo '</ul>'; 
}
?></li><?php 
    }
}
?><li class="snb noInfoPageTit "></li></ul>
<script>
$(function(){
    $(".D1_<?php echo safe_htmlspecialchars($topMNactiveLink);?>, .D2_<?php echo safe_htmlspecialchars($topMNactiveLink);?>").addClass("active");
    $(".D2_<?php echo safe_htmlspecialchars($topMNactiveLink);?>").parents(".snb").addClass("active");
});
$(document).ready(function(){
    if($("#snb > li").is(".snb.active")){
        $(".loc1D").html($(".snb.active h2 a b").html());
        $(".loc2D").html($(".snb2d.active a b").html());
    } else {
        $(".loc1D").text("<?php echo safe_htmlspecialchars(get_head_title($g5['title'])); ?>");
        $(".noInfoPageTit").html("<h2><a><b><?php echo safe_htmlspecialchars(get_head_title($g5['title'])); ?></b><sub></sub></a></h2>");
        $(".noInfoPageTit").addClass("active");
        $(".subTopLocNav").addClass("subTopLocNav2Dnone");
        $("#page_title").addClass("subTopBg_");
    }
    var a=$("#snb > li").index("#snb > li.active");
    $("#page_title").addClass("subTopBg_"+($(".snb.active").index()+1));

});
$(".bNBar > ul").html($("#snb").html());
$(function(){ var a=$("#snb li.snb"); a.addClass("hide"); $("#snb li.active").removeClass("hide").addClass("show"); $("#snb li.active .snb2dul").show(); $(".snb2dDown").click(function(){ var b=$(this).parents("#snb li.snb"); if(b.hasClass("hide")){ a.addClass("hide").removeClass("show"); a.find(".snb2dul").slideUp("fast"); b.removeClass("hide").addClass("show"); b.find(".snb2dul").slideDown("fast"); } else { b.removeClass("show").addClass("hide"); b.find(".snb2dul").slideUp("fast"); } }) }); $(".snb").removeClass("d1_bbscontentphp"); $(".snb2d").removeClass("d2_bbscontentphp");
</script>
<?php } ?>
<script>
$(document).ready(function(){
    if($("#snb > li.snb.active em.snb2dDown").length){
        $(".subTopLocNav").addClass("subTopLocNav2Don");

        if($("#snb > li.snb.active .snb2dul .snb2d.active").length){
            /* 2-1 메뉴 동일 */
        } else {
            $(".loc2DA .loc2D").html($(".snb.active h2 a b").html());
        }
    }
    else {
        $(".subTopLocNav").addClass("subTopLocNav2Doff");
    }
});
</script>