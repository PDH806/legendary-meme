<?php
$sub_menu = '600100';
include_once('./_common.php');


auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '관리자 목록';
include_once('./admin.head.php');


$css_file = str_replace(G5_ADMIN_PATH, G5_ADMIN_URL, './css/sbak_css.css');
add_stylesheet('<link rel="stylesheet" href="' . $css_file . '">', 1);




$colspan = 8;
$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '">처음</a>'; //페이지 처음으로 (초기화용도)
$sql_search = '';


$sql_common = " from SBAK_JUDGE_LIST";


$sql_search = " where (1) ";


if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        
        case 'MEMBER_ID':
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        case 'RESORT':
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;            
        default:
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}


$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1)
    $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            order by UID desc
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);






$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';


$sql_order = isset($sql_order)?$sql_order:'';
$sql = " select * {$sql_common} {$sql_search} {$sql_order} order by UID desc limit {$from_record}, {$rows} ";
$result = sql_query($sql);


?>

<div class="local_sch local_sch01">
    <form name="fvisit" method="get" onsubmit="return fvisit_submit(this);">


        <div class="local_ov01 local_ov">
            <?php echo $listall ?>
            <span class="btn_ov01"><span class="ov_txt">총 등록건수 </span><span class="ov_num">
                    <?php echo number_format($total_count) ?>명
                </span></span>
              

        </div>


        <label for="sch_sort" class="sound_only">검색분류</label>
       
        <select name="sfl" id="sch_sort" class="search_sort">
            <option value="MEMBER_ID" <?php echo get_selected($sfl, 'MEMBER_ID'); ?>>아이디</option>
            <option value="RESORT" <?php echo get_selected($sfl, 'RESORT'); ?>>활동스키장</option>
        </select>
        <label for="sch_word" class="sound_only">검색어</label>
        <input type="text" name="stx" size="20" value="<?php echo stripslashes($stx); ?>" id="sch_word"
            class="frm_input">
        <input type="submit" value="검색" class="btn_submit">
    </form>
</div>


<form name="ksia_license_list" id="ksia_license_list" action="./sbak_judge_list_update.php"
    onsubmit="return ksia_license_list_submit(this);" method="post">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="">





    <div class="tbl_wrap tbl_head01">
        <table>
            <thead>
                <tr>
                    <th scope="col">
                        <label for="chkall" class="sound_only">그룹 전체</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>
                    <th scope="col"></th>
                    <th scope="col">기본정보</th>
                    <th scope="col" width="7%">스키장</th>
                    <th scope="col" width="5%">스키장번호</th>

                    <th scope="col" width="20%">검정등록현황</th>
                    <th scope="col" width="20%">메모</th>
                    <th scope="col" width="3%">삭제</th>

 


                </tr>
            </thead>
            <tbody>
                <?php


     

                for ($i = 0; $row = sql_fetch_array($result); $i++) {

                    // 회원이미지 경로
                    $mb_img_path = G5_DATA_PATH . '/member_image/' . substr($row['MEMBER_ID'], 0, 2) . '/' . get_mb_icon_name($row['MEMBER_ID']) . '.jpg';
                    $mb_img_filemtile = (defined('G5_USE_MEMBER_IMAGE_FILETIME') && G5_USE_MEMBER_IMAGE_FILETIME && file_exists($mb_img_path)) ? '?' . filemtime($mb_img_path) : '';
                      $mb_img_url = G5_DATA_URL . '/member_image/' . substr($row['MEMBER_ID'], 0, 2) . '/' . get_mb_icon_name($row['MEMBER_ID']) . '.jpg' . $mb_img_filemtile;


                    $link = "";
                    $referer = "";
                    $title = "";

                    $bg = 'bg' . ($i % 2);
                    ?>
                    <tr class="<?php echo $bg; ?>">

                        <td class="td_chk">
                            <input type="hidden" name="UID[<?php echo $i ?>]" value="<?php echo $row['UID'] ?>">
                            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['MEMBER_ID']); ?>
                                지도자</label>
                            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">

                        </td>
                        <td>
                        
                            <?php if (file_exists($mb_img_path)) { ?>
							<img src="<?php echo $mb_img_url ?>" width=100 alt="회원이미지">
					     	<?php } else { ?>
							<img src="<?php echo G5_THEME_IMG_URL ?>/sbak_logo.jpg" width=100 alt="회원이미지">
                          	<?php } ?>

                        </td>

                        <td class="td_left">
                            <?php
                            $sql = "SELECT * FROM g5_member WHERE mb_id = '" . $row['MEMBER_ID'] . "'";

                            $row2 = sql_fetch($sql);
                            ?>


                              <h1 class="pageSubTitle"> <i class="fa fa-user" aria-hidden="true"></i> <?php echo $row2['mb_name']; ?> ( <?php echo $row2['mb_id']; ?> ) </h1>
                                        
                            <input type="text" name="PHONE[<?php echo $i ?>]" value="<?php echo $row2['mb_hp']; ?>" readonly placeholder="연락처" 
                            <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>>  

                            <input type="text" name="EMAIL[<?php echo $i ?>]" value="<?php echo $row2['mb_email']; ?>" readonly placeholder="이메일" 
                            <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>>
                          
                           
                        </td>

                        <td>
                            <?php echo $row['RESORT'];?>
                        </td>

                        <td>
                            <?php echo $row['T_skiresort'];?>
                        </td>

                        <td>
                            <?php
                            $test_year = date("Y"); 
                            $sql2 = "SELECT T_code 
                            FROM SBAK_T1_TEST 
                            WHERE T_mb_id = '{$row['MEMBER_ID']}' AND TEST_YEAR = '{$test_year}'";
                            $result2 = sql_query($sql2);

                            while ($row2 = sql_fetch_array($result2)) {

                                $sort_url = G5_ADMIN_URL . "/sbak_T1_test_list.php?sst={$test_year}&sfl=T_code&stx={$row2['T_code']}";

                                echo "<a href= '{$sort_url}' class='btn btn-primary'>{$row2['T_code']}</a><br>";
                            }


                            ?>
                            
                        </td>

                        <td>
                            <textarea name="MEMO[<?php echo $i ?>]" placeholder="메모사항"  <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?> style="resize: none ; display: block ; width: 100%; height: 20px; border: solid 2px #1E90FF;border-radius: 5px;"><?php echo $row['MEMO']; ?></textarea>
                        </td>
                        <td>
                           <input type="checkbox" name="IS_DEL[<?php echo $i; ?>]" value="Y" id="IS_DEL<?php echo $i; ?>" <?php if ($row['IS_DEL'] == 'Y') { echo 'checked';} ?>>    
                        </td>




                    </tr>
                <?php } ?>
                <?php if ($i == 0)
                    echo '<tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>'; ?>
            </tbody>
        </table>
    </div>

    <div class="btn_fixed_top">
        <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn btn_02">
    </div>


</form>

<?php
$domain = isset($domain) ? $domain : '';
$pagelist = get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;domain=' . $domain . '&amp;page=');
if ($pagelist) {
    echo $pagelist;
}
?>

<script>
    $(function () {
        $("#sch_sort").change(function () { // select #sch_sort의 옵션이 바뀔때
            if ($(this).val() == "vi_date") { // 해당 value 값이 vi_date이면
                $("#sch_word").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" }); // datepicker 실행
            } else { // 아니라면
                $("#sch_word").datepicker("destroy"); // datepicker 미실행
            }
        });

        if ($("#sch_sort option:selected").val() == "vi_date") { // select #sch_sort 의 옵션중 selected 된것의 값이 vi_date라면
            $("#sch_word").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" }); // datepicker 실행
        }
    });

    function fvisit_submit(f) {
        return true;
    }
</script>

<script>
    function ksia_license_list_submit(f) {
        if (!is_checked("chk[]")) {
            alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
            return false;
        }

        if (document.pressed == "선택삭제") {
            if (!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
                return false;
            }
        }

        return true;
    }
</script>

<?php
include_once('./admin.tail.php');