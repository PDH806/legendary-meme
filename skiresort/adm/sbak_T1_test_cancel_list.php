<?php
$sub_menu = '600500';
include_once('./_common.php');


auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '티칭1 취소/환불관리';
include_once('./admin.head.php');


$css_file = str_replace(G5_ADMIN_PATH, G5_ADMIN_URL, './css/sbak_css.css');
add_stylesheet('<link rel="stylesheet" href="' . $css_file . '">', 1);



$colspan = 8;
$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '">처음</a>'; //페이지 처음으로 (초기화용도)
$sql_search = '';


$nowDate = date_create(date('Y-m-d'));
$modDate = date_create($T_date ?? 'now');
$interval = date_diff($nowDate, $modDate);
$interval_day = $interval->days;

$set_today = date("Y-m-d");




$sql_common = " from SBAK_T1_TEST_Apply A INNER JOIN SBAK_T1_TEST B ON A.T_code = B.T_code";

$sql_search = " WHERE  A.PAYMENT_STATUS < 3 and B.T_status != '77' and A.BANK_DATE < {$set_today}";





if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        
        case 'T_mb_id':
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








$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';

$sql = " select A.UID as UID, A.T_code as T_code, B.TYPE as TYPE, B.T_date as T_date, 
        A.MEMBER_NAME as MEMBER_NAME, A.MEMBER_ID as MEMBER_ID, A.REGIST_DATE as REGIST_DATE, A.REGIST_TIME as REGIST_TIME, 
        B.T_where as T_where, A.PHONE as PHONE, A.T_status as T_status, A.PAYMENT_STATUS as PAYMENT_STATUS, 
        A.BANK_DATE as BANK_DATE, A.BANK_DEPOSITOR as BANK_DEPOSITOR, A.SCORE1 as SCORE1, 
        A.SCORE2 as SCORE2, A.SCORE3 as SCORE3, A.SCORE4 as SCORE4, 
        A.REFUND_STATUS as REFUND_STATUS, A.REFUND_DATE as REFUND_DATE, A.REFUND_ACCOUNT as REFUND_ACCOUNT, A.REFUND_DEPOSITOR as REFUND_DEPOSITOR,
        A.TOTAL_SCORE as TOTAL_SCORE, A.LICENSE_NO as LICENSE_NO, A.MEMO as MEMO
        {$sql_common} {$sql_search}  order by UID desc limit {$from_record}, {$rows}  ";
$result = sql_query($sql);



?>


<div class="local_sch local_sch01">
   


        <div class="local_ov01 local_ov">
            <?php echo $listall ?>
            <span class="btn_ov01"><span class="ov_txt">총 등록건수 </span><span class="ov_num">
                    <?php echo number_format($total_count) ?>건
                </span></span>

        </div>





        <div>
            <table width="100%">
                <tr>
                    <td>
                      <form name="fvisit" method="get" onsubmit="return fvisit_submit(this);">
                            <label for="sch_sort" class="sound_only">검색분류</label>
                                <select name="sfl" id="sch_sort" class="search_sort">
                                    <option value="MEMBER_NAME" <?php echo get_selected($sfl, 'MEMBER_NAME'); ?>>등록자</option>
                                    <option value="T_date" <?php echo get_selected($sfl, 'T_date'); ?>>검정일</option>
                                    <option value="T_code" <?php echo get_selected($sfl, 'T_code'); ?>>검정코드</option>
                                    <option value="REGIST_DATE" <?php echo get_selected($sfl, 'REGIST_DATE'); ?>>등록일</option>
                                    <option value="PAYMENT_STATUS" <?php echo get_selected($sfl, 'PAYMENT_STATUS'); ?>>결제여부(미납3,납부2)
                                    </option>
                                </select>
                                <label for="sch_word" class="sound_only">검색어</label>
                                <input type="text" name="stx" size="20" value="<?php echo stripslashes($stx); ?>" id="sch_word"
                                    class="frm_input">
                                <input type="submit" value="검색" class="btn_submit">
                        </form>
                    </td>
                    <td align="right">
             
                    </td>

            </tr>
        </table>
        </div>  


    
</div>

<div class="local_desc01 local_desc">
    <p>
        전체 응시자 중에서, 응시일이 지난 자료중, 납부처리가 되어 있으나, 심사위원의 응시코드가 '확정'되어 있지 않아,
        시험이 취소된 걸로 취급하여, 응시자에게 환불처리 확인이 필요한 목록입니다.
    </p>
</div>


<form name="ksia_license_list" id="ksia_license_list" action="./ksia_L1_test_apply_update.php"
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
                <th scope="col">응시번호</th>
                <th scope="col">응시자</th>
                <th scope="col">종목</th>
                <th scope="col">응시정보</th>

                <th scope="col">결제내역</th>
                <th scope="col">환불처리</th>

                
                <th scope="col">삭제</th>
                <th scope="col">메모</th>


            </tr>
        </thead>
        <tbody>
            <?php


            for ($i = 0; $row = sql_fetch_array($result); $i++) {


                $member_payment_status = $row['PAYMENT_STATUS'];
                if ($member_payment_status == '2') {
                    $member_payment_status = "<span class='box_ksia_blue'>결제완료</span>";
                } elseif ($member_payment_status == '3') {
                    $member_payment_status = "<span class='box_ksia_darkblue'>미납</span>";
                }









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
                        <?php echo $row['UID']; ?>
                    </td>
                    <td class="td_left">
                        <h1 class="pageSubTitle">
                            <?php echo $row['MEMBER_NAME']; ?>
                        </h1>
                        (<?php echo $row['MEMBER_ID']; ?>) <br>
                        <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        <?php echo $row['PHONE']; ?> <br>

                        <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        <?php echo $row['REGIST_DATE']; ?>
                        <?php echo $row['REGIST_TIME']; ?>
                    </td>
                    <td>
                        <?php
                        if ($row['TYPE'] == 1) {
                            echo "<span class='box_ksia_blue'>SKI</span>";
                        } elseif ($row['TYPE'] == 2) {
                            echo "<span class='box_ksia_orange'>SB</span>";
                        }
                        ?>
                    </td>


                    <td class="td_left">
                        
                        <input type="text" name="T_code[<?php echo $i ?>]" value="<?php echo $row['T_code']; ?>" 
                        <?php 
                        if ($row['T_status'] == '88' or $row['T_status'] == '99') 
                        {
                            echo "class='ksia_input_deleted' readonly";
                        } else {
                            echo "class='ksia_input'";
                        }
                        ?>><br>


                        <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        <?php echo $row['T_date']; ?> <br>
                        <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        <?php echo $row['T_where']; ?> <br>

                    </td>

                    <td class="td_left">

                        <input type="date" name="BANK_DATE[<?php echo $i ?>]" value="<?php echo $row['BANK_DATE']; ?>" 
                        <?php 
                        if ($row['T_status'] == '88' or $row['T_status'] == '99') 
                        {
                            echo "class='ksia_input_deleted' readonly";
                        } else {
                            echo "class='ksia_input'";
                        }
                        ?>><br>

                        <input type="text" placeholder="입금자명" name="BANK_DEPOSITOR[<?php echo $i ?>]"
                            value="<?php echo $row['BANK_DEPOSITOR']; ?>" 

                            <?php 
                        if ($row['T_status'] == '88' or $row['T_status'] == '99') 
                        {
                            echo "class='ksia_input_deleted' readonly";
                        } else {
                            echo "class='ksia_input'";
                        }
                        ?>><br>  

                        <br>

                        <input type='radio' name="PAYMENT_STATUS[<?php echo $i ?>]" value="3" <?php if ($row['PAYMENT_STATUS'] == '3') { echo " checked" ; } ?> 
                        <?php  if ($row['T_status'] == '88' or $row['T_status'] == '99')  { echo " readonly";  } ?>> 미납
                        <input type='radio' name="PAYMENT_STATUS[<?php echo $i ?>]" value="2" <?php if ($row['PAYMENT_STATUS'] == '2') { echo " checked" ; } ?> 
                        <?php  if ($row['T_status'] == '88' or $row['T_status'] == '99')  { echo " readonly";  } ?>> 결제완료

                        <br>
                        <?php echo $member_payment_status; ?>
                    </td>
                    <td>

                        <input type="date" name="REFUND_DATE[<?php echo $i ?>]"
                            value="<?php echo $row['REFUND_DATE']; ?>" 
                            <?php 
                        if ($row['T_status'] == '88' or $row['T_status'] == '99') 
                        {
                            echo "class='ksia_input_deleted' readonly";
                        } else {
                            echo "class='ksia_input'";
                        }
                        ?>><br>
                        <input type="text" placeholder="계좌번호" size=30 name="REFUND_ACCOUNT[<?php echo $i ?>]"
                            value="<?php echo $row['REFUND_ACCOUNT']; ?>" 
                            <?php 
                        if ($row['T_status'] == '88' or $row['T_status'] == '99') 
                        {
                            echo "class='ksia_input_deleted' readonly";
                        } else {
                            echo "class='ksia_input'";
                        }
                        ?>><br>
                        <input type="text" placeholder="예금주명" name="REFUND_DEPOSITOR[<?php echo $i ?>]"
                            value="<?php echo $row['REFUND_DEPOSITOR']; ?>" 
                            <?php 
                        if ($row['T_status'] == '88' or $row['T_status'] == '99') 
                        {
                            echo "class='ksia_input_deleted' readonly";
                        } else {
                            echo "class='ksia_input'";
                        }
                        ?>><br>

                        <input type="checkbox" name="REFUND_STATUS[<?php echo $i ?>]" value="2" <?php if ($row['REFUND_STATUS'] > 0)
                               echo "checked"; ?> 
                                                       <?php 
                        if ($row['T_status'] == '88' or $row['T_status'] == '99') 
                        {
                            echo "class='ksia_input_deleted' readonly";
                        } else {
                            echo "class='ksia_input'";
                        }
                        ?>>

                    </td>





                    <td>

                        <input type="checkbox" name="T_status[<?php echo $i ?>]" value="<?php echo $row['T_status'] == "88" ? "88": "99";  ?>" <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') {
                               echo "checked";} ?>>
                        <?php echo $row['T_status'] == "88" ? "<br><span style='color:red'>사무국 삭제</span>": "";  ?>  <?php echo $row['T_status'] == "99" ? "<br><span style='color:red'>본인 삭제</span>": "";  ?>        

                    </td>
                    <td>

                        <textarea name="MEMO[<?php echo $i ?>]" placeholder="메모사항" <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') {
                               echo "class='ksia_input_deleted' readonly";
                           } else {
                               echo "class='ksia_input'";
                           } ?>
                            style="resize: none ; display: block ; width: 100%; height: 20px; border: solid 2px #1E90FF;border-radius: 5px;"><?php echo $row['MEMO']; ?>
                               </textarea>

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