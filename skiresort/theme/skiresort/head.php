<?php
/* copyright(c) WEBsiting.co.kr */
if (!defined('_GNUBOARD_')) exit; /* 개별 페이지 접근 불가 */

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH . '/head.php');
    return;
}

include_once(G5_THEME_PATH . '/head.sub.php');
include_once(G5_LIB_PATH . '/latest.lib.php');
?>
<a id="topID"></a>

<!-- 상단 시작 { -->
<header id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?> <?php echo $config['cf_title'] ?></h1>

    <div id="skip_to_container"><a href="#ctWrap">본문 바로가기</a></div>

    <div id="tnb">
        <ul>
            <!-- 해당 URL링크를 삽입해 주세요 // 해당사항 없을 시 제거해 주시기 바랍니다. -->
            <!--li><a href="#"><b><i class="tnbIco fa fa-facebook-square" aria-hidden="true"></i> <span class="sound_only">페이스북</span></b></a></li>
            <li><a href="#"><b><i class="tnbIco fa fa-twitter-square" aria-hidden="true"></i> <span class="sound_only">트위터</span></b></a></li>
            <li><a href="#"><b><i class="tnbIco fa fa-instagram" aria-hidden="true"></i> <span class="sound_only">인스타그램</span></b></a></li>
            <li><a href="#"><b><i class="fa fa-link" aria-hidden="true"></i> BLOG</b></a></li-->
            <?php if ($is_member) {  ?>
                <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php"><i class="fa fa-cog" aria-hidden="true"></i> 정보수정</a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> LOGOUT</a></li>
                <?php if ($is_admin) {  ?>
                    <li class="tnb_admin"><a href="<?php echo G5_ADMIN_URL ?>"><b><i class="fa fa-user-circle" aria-hidden="true"></i> 관리자</b></a></li>
                <?php }  ?>
            <?php } else {  ?>
                <li><a href="<?php echo G5_BBS_URL ?>/register.php"><b><i class="fa fa-user-plus" aria-hidden="true"></i> JOIN</b></a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/login.php"><b><i class="fa fa-power-off" aria-hidden="true"></i> LOGIN</b></a></li>
            <?php }  ?>

        </ul>

    </div>

    <nav id="gnb">
        <h2>메인메뉴</h2>
        <div class="gnb_wrap">
            <div id="logo">
                <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_IMG_URL ?>/logo.png" alt="<?php echo $config['cf_title']; ?>"></a>
            </div>
            <ul id="gnb_1dul">
                <?php
                $menu_datas = get_menu_db(0, true);
                $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
                $i = 0;
                foreach ($menu_datas as $row) {
                    if (empty($row)) continue;
                    $add_class = (isset($row['sub']) && $row['sub']) ? 'gnb_al_li_plus' : '';
                ?>
                    <li class="gnb_1dli" style="z-index:<?php echo $gnb_zindex--; ?>">
                        <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo $row['me_name'] ?><u></u></a>
                        <?php
                        $k = 0;
                        foreach ((array) $row['sub'] as $row2) {

                            if (empty($row2)) continue;

                            if ($k == 0)
                                echo '<span class="bg">하위분류</span><ul class="gnb_2dul">' . PHP_EOL;
                        ?>
                    <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo $row2['me_name'] ?></a></li>
                <?php
                            $k++;
                        }   //end foreach $row2

                        if ($k > 0)
                            echo '</ul>' . PHP_EOL;
                ?>
                </li>
            <?php
                    $i++;
                }   //end foreach $row

                if ($i == 0) {  ?>
                <li class="gnb_1dli gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
            <?php } ?>
            <li class="gnb_1dli allSchBoxWr">
                <button type="button" id="btnSchbox" title="전체검색 열기"><i class="fa fa-search"></i></button>

                <div id="allSchBox">
                    <fieldset>
                        <legend>사이트 내 전체검색</legend>
                        <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
                            <input type="hidden" name="sfl" value="wr_subject||wr_content">
                            <input type="hidden" name="sop" value="and">
                            <label for="sch_stx" class="sound_only">검색어 필수</label>
                            <input type="text" name="stx" id="sch_stx" class="topSchFocus" maxlength="20" placeholder="Search...">
                            <button type="submit" id="sch_submit" value="검색"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
                            <a id="allSchBoxClose"><i class="fa fa-close" aria-hidden="true"></i><i class="sound_only">전체검색 닫기</i></a>
                        </form>
                        <script>
                            function fsearchbox_submit(f) {
                                if (f.stx.value.length < 2) {
                                    alert("검색어는 두글자 이상 입력하십시오.");
                                    f.stx.select();
                                    f.stx.focus();
                                    return false;
                                } /* 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요. */
                                var cnt = 0;
                                for (var i = 0; i < f.stx.value.length; i++) {
                                    if (f.stx.value.charAt(i) == ' ') cnt++;
                                }
                                if (cnt > 1) {
                                    alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                                    f.stx.select();
                                    f.stx.focus();
                                    return false;
                                }
                                return true;
                            }
                        </script>
                    </fieldset>
                </div>

            </li>
            </ul>
        </div>

        <p class="clb"></p>
    </nav>
</header>
<aside id="topSpacer"><?php /* !!지우지마세요 : 상단메뉴 고정 시 사용됩니다. */ ?></aside>
<aside id="sideBarCover"><?php /* mobile nav cover !!지우지마세요 : 모바일 화면에서 출력되는 메뉴배경입니다. */ ?></aside>
<!-- } 상단 끝 -->
<hr>

<!-- 콘텐츠 시작 { -->
<?php if (!defined("_INDEX_")) {  /*인덱스에서 사용하지 않음*/ ?>
    <div id="page_title" class="sbtImg">
        <div class="page_title_in">
            <h2>
                <strong title="<?php echo get_text($g5['title']); ?>" class="loc1D"><?php echo get_head_title($g5['title']); ?></strong>
                <span class="titleBbar"></span>
            </h2>
        </div>
    </div>
    <aside class="subTopLocNav">
        <a class="loc1DA"><b class="loc1D themeColor"></b><i class="fa fa-angle-down"></i><u class="themeBgColor"></u></a>
        <a class="loc2DA"><b class="loc2D themeColor"></b><i class="fa fa-angle-down"></i><u class="themeBgColor"></u></a>
        <div class="bNBar bNBar1D themeBorderColor">
            <ul><!-- 서브1차메뉴 --></ul>
        </div>
        <div class="bNBar bNBar2D themeBorderColor">
            <ul><!-- 서브2차메뉴 --></ul>
        </div>

    </aside>
    <script>
        $(document).ready(function() {
            $(".loc1DA").click(function() {
                $(".bNBar1D").slideToggle("fast");
                $(".loc1DA").toggleClass("on");
                return false;
            });
            $(".loc2DA").click(function() {
                $(".bNBar2D").slideToggle("fast");
                $(".loc2DA").toggleClass("on");
                return false;
            });
        });
    </script>


<?php }  /*인덱스에서 사용하지 않음*/ ?>
<section id="ctWrap">

    <?php if (!defined("_INDEX_")) {  /*인덱스에서 사용하지 않음*/ ?>
        <div id="container">

            <h2 class="contentTitle">
                <!--strong title="<?php echo get_text($g5['title']); ?>"><?php echo get_head_title($g5['title']); ?></strong-->
                <span class="title_wints_01"><?php echo get_head_title($g5['title']); ?></span>
                <span class="locationBar" title="현재위치"><span> <em class="fa fa-home" aria-hidden="true"></em> HOME <i class="fa fa-angle-right" aria-hidden="true"></i> </span> <span class="loc1D"><!-- 1차메뉴 --></span> <span class="loc2D"><!-- 2차메뉴 --></span></span>
            </h2>

            <hr>

        <?php }  /*인덱스에서 사용하지 않음*/