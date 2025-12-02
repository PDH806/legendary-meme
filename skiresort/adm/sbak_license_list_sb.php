<?php
$sub_menu = '800200';
include_once('./_common.php');

add_stylesheet('<link rel="stylesheet" href="' . G5_URL . '/adm/css/sbak_css.css">', 0);


auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '스노보드 자격번호 관리';
include_once('./admin.head.php');



$colspan = 7;
$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '">처음</a>'; //페이지 처음으로 (초기화용도)
// $count_statistics = '<a href="./sbak_license_statistics.php?sports=sb" class="ov_listall">년도별통계</a>';
$sql_search = '';


$sql_common = " from SBAK_SB_MEMBER ";

//$sql_search = " where (1) ";
$sql_search = " where IS_DEL != 'Y' ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {

        case 'MEMBER_ID':
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





// 레벨3 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and K_GRADE = 'T3' ";
$row = sql_fetch($sql);
$L3_count = $row['cnt'];

// 레벨2 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and K_GRADE = 'T2' ";
$row = sql_fetch($sql);
$L2_count = $row['cnt'];

// 레벨1 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and K_GRADE = 'T1' ";
$row = sql_fetch($sql);
$L1_count = $row['cnt'];

$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';


$sql_order = isset($sql_order)?$sql_order:'';
$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);



?>


<div class="local_sch local_sch01">
    <form name="fvisit" method="get" onsubmit="return fvisit_submit(this);">


        <div class="local_ov01 local_ov">
            <?php echo $listall ?>
            <span class="btn_ov01"><span class="ov_txt">총 자격증 수 </span><span class="ov_num">
                    <?php echo number_format($total_count) ?>명
                </span></span>
            <span class="btn_ov01"> <span class="ov_txt">티칭3 </span><span class="ov_num">
                    <?php echo number_format($L3_count) ?>명
                </span></span>
            <span class="btn_ov01"> <span class="ov_txt">티칭2 </span><span class="ov_num">
                    <?php echo number_format($L2_count) ?>명
                </span></span>
            <span class="btn_ov01"> <span class="ov_txt">티칭1 </span><span class="ov_num">
                    <?php echo number_format($L1_count) ?>명
                </span></span>
            <span class="btn_ov01"> <span class="ov_txt">엑셀다운</span><span class="ov_num">
                    <a href="sbak_license_list_xls.php?sports=sb"> <i class="fa fa-file-excel-o"></i> </a>

                </span></span>

            <?php echo $count_statistics ?>
        </div>


        <label for="sch_sort" class="sound_only">검색분류</label>
        <select name="sfl" id="sch_sort" class="search_sort">
            <option value="MEMBER_ID" <?php echo get_selected($sfl, 'MEMBER_ID'); ?>>ID</option>
            <option value="K_NAME" <?php echo get_selected($sfl, 'K_NAME'); ?>>성명</option>
            <option value="K_BIRTH" <?php echo get_selected($sfl, 'K_BIRTH'); ?>>생년월일</option>
            <option value="K_GRADE" <?php echo get_selected($sfl, 'K_GRADE'); ?>>등급</option>
            <option value="GUBUN" <?php echo get_selected($sfl, 'GUBUN'); ?>>발급년도</option>
        </select>
        <label for="sch_word" class="sound_only">검색어</label>
        <input type="text" name="stx" size="20" value="<?php echo stripslashes($stx); ?>" id="sch_word"
            class="frm_input">
        <input type="submit" value="검색" class="btn_submit">
    </form>
</div>


<form name="ksia_license_list" id="ksia_license_list" action="./sbak_license_list_update.php"
    onsubmit="return ksia_license_list_submit(this);" method="post">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="">
    <input type="hidden" name="sports" value="sb">


    <div class="tbl_wrap tbl_head01">
        <table>
            <thead>
                <tr>
                    <th scope="col">
                        <label for="chkall" class="sound_only">그룹 전체</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>
                    <th scope="col">Rec_NO</th>
                    <th scope="col">구분</th>
                    <th scope="col">ID</th>
                    <th scope="col">성명</th>
                    <th scope="col">생년월일</th>
                    <th scope="col">등급</th>
                    <th scope="col">자격번호</th>
                    <th scope="col">메모</th>
                    <th scope="col">삭제</th>

                </tr>
            </thead>
            <tbody>
                <?php


                for ($i = 0; $row = sql_fetch_array($result); $i++) {

                  
                    $bg = 'bg' . ($i % 2);
                    ?>



                <tr class="<?php echo $bg; ?>">
                    <td class="td_chk">
                        <input type="hidden" name="UID[<?php echo $i ?>]" value="<?php echo $row['UID'] ?>">
                        <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['K_NAME']); ?>
                            자격증</label>
                        <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">



                    </td>
                    <td>
                        <?php echo $row['UID']; ?>
                    </td>
                    <td width=50px>
                        <input type="text" name="GUBUN[<?php echo $i ?>]" value="<?php echo $row['GUBUN']; ?>"
                            maxlength=4
                            <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?>
                            required
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    </td>
                    <td>
                        <input type="text" name="MEMBER_ID[<?php echo $i ?>]" readonly
                            value="<?php echo $row['MEMBER_ID']; ?>"
                            <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>
                            size="8">
                    </td>
                    <td>
                        <input type="text" name="K_NAME[<?php echo $i ?>]" value="<?php echo $row['K_NAME']; ?>"
                            <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>
                            size="8" required>
                    </td>
                    <td>
                        <input type="date" name="K_BIRTH[<?php echo $i ?>]" value="<?php echo $row['K_BIRTH']; ?>"
                            <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?>
                            required>
                    </td>
                    <td>
                        <input type="text" name="K_GRADE[<?php echo $i ?>]" readonly
                            value="<?php echo $row['K_GRADE']; ?>"
                            <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?>
                            id="member_grade" maxlength="2" required>
                    </td>
                    <td>
                        <input type="text" name="K_LICENSE[<?php echo $i ?>]" readonly
                            value="<?php echo $row['K_LICENSE']; ?>"
                            <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?>
                            required>
                    </td>
                    <td>
                        <input type=" text" name="K_MEMO[<?php echo $i ?>]" value="<?php echo $row['K_MEMO']; ?>"
                            <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>
                            size="8">
                    </td>
                    <td>
                        <input type=checkbox name="IS_DEL[<?php echo $i ?>]" value="Y"
                            <?php if ($row['IS_DEL'] == 'Y') { echo "checked"; } ?>>
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
        <input type="submit" name="act_button" value="선택인쇄" onclick="document.pressed=this.value" class="btn btn_02">


    </div>


</form>

<a href="./sbak_license_add.php?sports=sb" class="btn btn_03">자격증 정보 추가하기</a> <br>
성명, 생년월일, 등급, 자격번호 필드 필수입력
<br>

<?php
$domain = isset($domain) ? $domain : '';
$pagelist = get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;domain=' . $domain . '&amp;page=');
if ($pagelist) {
    echo $pagelist;
}
?>

<script>
$(function() {
    $("#sch_sort").change(function() { // select #sch_sort의 옵션이 바뀔때
        if ($(this).val() == "vi_date") { // 해당 value 값이 vi_date이면
            $("#sch_word").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd",
                showButtonPanel: true,
                yearRange: "c-99:c+99",
                maxDate: "+0d"
            }); // datepicker 실행
        } else { // 아니라면
            $("#sch_word").datepicker("destroy"); // datepicker 미실행
        }
    });

    if ($("#sch_sort option:selected").val() == "vi_date") { // select #sch_sort 의 옵션중 selected 된것의 값이 vi_date라면
        $("#sch_word").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            showButtonPanel: true,
            yearRange: "c-99:c+99",
            maxDate: "+0d"
        }); // datepicker 실행
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