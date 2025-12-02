<?php
$sub_menu = '600500';
include_once('./_common.php');


auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '티칭1 시험 응시자 관리';
include_once('./admin.head.php');


$css_file = str_replace(G5_ADMIN_PATH, G5_ADMIN_URL, './css/sbak_css.css');
add_stylesheet('<link rel="stylesheet" href="' . $css_file . '">', 1);



$colspan = 7;
$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '">처음</a>'; //페이지 처음으로 (초기화용도)
$sql_search = '';

$sql_common = " from SBAK_T1_TEST_Apply A INNER JOIN SBAK_T1_TEST B ON A.T_code = B.T_code";

$sql_search = " WHERE  (1) ";


if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {

        case 'PAYMENT_STATUS':
            $sql_search .= " ({$sfl} = {$stx}) ";
            break;
        case 'MEMBER_NAME':
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        case 'MEMBER_ID':
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        case 'A.T_code':
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



$sql = " select A.UID as UID, A.T_code as T_code,  B.TYPE as TYPE, B.T_date as T_date, B.T_name as T_name, 
        A.MEMBER_NAME as MEMBER_NAME, A.MEMBER_ID as MEMBER_ID, A.REGIST_DATE as REGIST_DATE, A.REGIST_TIME as REGIST_TIME, 
        B.T_where as T_where, A.PHONE as PHONE, A.T_status as T_status, A.PAYMENT_STATUS as PAYMENT_STATUS, 
        A.SCORE1_1 as SCORE1_1, A.SCORE1_2 as SCORE1_2, A.SCORE1_3 as SCORE1_3, 
        A.SCORE2_1 as SCORE2_1, A.SCORE2_2 as SCORE2_2, A.SCORE2_3 as SCORE2_3, 
        A.SCORE3_1 as SCORE3_1, A.SCORE3_2 as SCORE3_2, A.SCORE3_3 as SCORE3_3, 
        A.SCORE4_1 as SCORE4_1, A.SCORE4_2 as SCORE4_2, A.SCORE4_3 as SCORE4_3,
        A.AVERAGE as AVERAGE, A.LICENSE_NO as LICENSE_NO, A.MEMO as MEMO, A.AMOUNT as AMOUNT, A.AID as AID
        {$sql_common} {$sql_search}  order by UID desc limit {$from_record}, {$rows}  ";

$result = sql_query($sql);



?>

<!-- <head>

  <script type='text/javascript'>
    function payment_cancel(form) {
      form.action = "<?php echo $READY_API_URL; ?>";
      form.method = "POST";
      const result = confirm("취소처리시 자동 결제취소됩니다. 취소된 건은 복구할 수 없습니다. 정말 취소하시겠습니까? ");
      if (result) {
        form.submit();
      } else {
        return false;
      }
    }
  </script>
</head> -->


<div class="local_sch local_sch01">



    <div class="local_ov01 local_ov">
        <?php echo $listall ?>
        <span class="btn_ov01">
            <span class="ov_txt">총 등록건수 </span>
            <span class="ov_num">
                <?php echo number_format($total_count) ?>건
            </span>
        </span>



    </div>





    <div>
        <table width="100%">
            <tr>
                <td>
                    <form name="fvisit" method="get" onsubmit="return fvisit_submit(this);">
                        <label for="sch_sort" class="sound_only">검색분류</label>
                        <select name="sfl" id="sch_sort" class="search_sort">
                            <option value="MEMBER_NAME" <?php echo get_selected($sfl, 'MEMBER_NAME'); ?>>등록자</option>
                            <option value="MEMBER_ID" <?php echo get_selected($sfl, 'MEMBER_ID'); ?>>ID</option>
                            <option value="A.T_code" <?php echo get_selected($sfl, 'A.T_code'); ?>>코드</option>
                            <option value="PAYMENT_STATUS" <?php echo get_selected($sfl, 'PAYMENT_STATUS'); ?>>결제여부
                            </option>
                        </select>
                        <label for="sch_word" class="sound_only">검색어</label>
                        <input type="text" name="stx" size="20" value="<?php echo stripslashes($stx); ?>" id="sch_word"
                            class="frm_input">
                        <input type="submit" value="검색" class="btn_submit">
                    </form>
                </td>
                <td align="right">
                    <form name="frm_toexcel" method="post" action="./sbak_T1_test_apply_xls.php">
                        응시일 : <input type="date" name="from_date" size="20" value="<?php echo stripslashes($stx); ?>"
                            class="frm_input"> ~
                        <input type="date" name="to_date" size="20" value="<?php echo stripslashes($stx); ?>"
                            class="frm_input">
                        <input type="submit" value="EXCEL">
                    </form>
                </td>

            </tr>
        </table>
    </div>



</div>

<div class="local_desc01 local_desc">
    <p>
        검색시, 결제여부를 조회하려면, 결제완료는 Y, 취소완료는 C 로 조회하세요.
    </p>
</div>


<form name="ksia_license_list" id="ksia_license_list" action="./sbak_T1_test_apply_update.php"
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
                    <th scope="col" width="5%">응시번호</th>
                    <th scope="col">응시자</th>
                    <th scope="col">종목</th>
                    <th scope="col">응시정보</th>

                    <th scope="col">결제내역</th>
                    <th scope="col">결제금액</th>

                    <th scope="col">진행상황</th>
                    <th scope="col">메모</th>
                    <th scope="col" width="5%">삭제</th>


                </tr>
            </thead>
            <tbody>
                <?php


            for ($i = 0; $row = sql_fetch_array($result); $i++) {


                $MEMBER_ID = $row['MEMBER_ID'];

                $query = "select mb_2 from g5_member where mb_id like '{$MEMBER_ID}'";
                $mem_birth = sql_fetch($query);
                $THE_BIRTH = $mem_birth['mb_2'];






                $member_payment_status = $row['PAYMENT_STATUS'];
                if ($member_payment_status == 'Y') {
                    $member_payment_status = "<span class='box_sbak_label'>결제완료</span>";
                }  elseif ($member_payment_status == 'C') {
                    $member_payment_status = "<span class='box_sbak_red_label'>취소완료</span>";
                }


                if ($row['TYPE'] == 1){
                    $t_code = 'B01';
                } else {
                    $t_code = 'B04';
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


                        <input type="text" name="MEMBER_NAME[<?php echo $i ?>]"
                            value="<?php echo $row['MEMBER_NAME']; ?>" <?php 
                        if ($row['PAYMENT_STATUS'] == "C") 
                        {
                            echo "class='ksia_input_deleted' readonly";
                        } else {
                            echo "class='ksia_input' readonly";
                        }
                        ?>><br>
                        <input type="text" name="MEMBER_ID[<?php echo $i ?>]" value="<?php echo $row['MEMBER_ID']; ?>" <?php 
                        if ($row['PAYMENT_STATUS'] == "C") 
                        {
                            echo "class='ksia_input_deleted' readonly";
                        } else {
                            echo "class='ksia_input' readonly";
                        }
                        ?>><br>
                        <input type="text" name="PHONE[<?php echo $i ?>]" value="<?php echo $row['PHONE']; ?>" <?php 
                        if ($row['PAYMENT_STATUS'] == "C") 
                        {
                            echo "class='ksia_input_deleted' readonly";
                        } else {
                            echo "class='ksia_input' readonly";
                        }
                        ?>><br>


                        <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        <?php echo $THE_BIRTH; ?> <br>
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

                        <input type="text" name="T_code[<?php echo $i ?>]" readonly
                            value="<?php echo $row['T_code']; ?>" <?php 
                        if ($row['PAYMENT_STATUS'] == "C") 
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

                    <td>
                        <?php echo $member_payment_status; ?>
                    </td>

                    <td>
                        <?php echo $row['AMOUNT']; ?>
                    </td>



                    <td class="td_left">


                        <?php if (!empty($row['LICENSE_NO'])) {
                            echo "<h1 class='pageSubTitle'>" . $row['LICENSE_NO'] . "</h1>";
                        } ?>
                        <br>
                        <?php if (!empty($row['SCORE1_1'])) {
                            echo "<span class='btnOrange'>" . $row['SCORE1_1'] . " " . $row['SCORE1_2'] . " " . $row['SCORE1_3'] . "</span> |";
                        } ?>
                        <?php if (!empty($row['SCORE2_1'])) {
                            echo "<span class='btnOrange'>" . $row['SCORE2_1'] . " " . $row['SCORE2_2'] . " " . $row['SCORE2_3'] . "</span> |";
                        } ?>
                        <?php if (!empty($row['SCORE3_1'])) {
                            echo "<span class='btnOrange'>" . $row['SCORE3_1'] . " " . $row['SCORE3_2'] . " " . $row['SCORE3_3'] . "</span> |";
                        } ?>
                        <?php if (!empty($row['SCORE4_1'])) {
                            echo "<span class='btnOrange'>" . $row['SCORE4_1'] . " " . $row['SCORE4_2'] . " " . $row['SCORE4_3'] . "</span> |";
                        } ?>
                        <?php if ($row['AVERAGE'] > 0) {
                            echo "<span class='box_ksia_darkblue'>" . $row['AVERAGE'] . "</span>";
                        } ?>

                        <?php
                        if ($row['AVERAGE'] > 0) {
                            if ($row['AVERAGE'] >= 70) {
                                echo "<a href='#' class='button btnFade btnBlueGreen'>합격</a>";
                            } else {
                                echo "<a href='#' class='button btnLightBlue'>불합격</a>";
                            }
                        }
                        ?>
                    </td>


                    <td>

                        <textarea name="MEMO[<?php echo $i ?>]" placeholder="메모사항" <?php if ($row['PAYMENT_STATUS'] == "C") {
                               echo "class='ksia_input_deleted' readonly";
                           } else {
                               echo "class='ksia_input'";
                           } ?>
                            style="resize: none ; display: block ; width: 100%; height: 20px; border: solid 2px #1E90FF;border-radius: 5px;"><?php echo $row['MEMO']; ?>
                               </textarea>

                    </td>


                    <td>
                        <?php

            //mainpay ----------------------------------------------
                            if ($row['PAYMENT_STATUS'] == "Y") {

                 echo "<a href='sbak_cancle.php?UID=" . $row['UID'] . "&category=t1'><i class='btn btn_01'>취소</i></a>"; //결제 취소 페이지
            } else {
                        //----------------------------------------------------

            $sql222 = "select CANCELED_DATE from sbak_mainpay where AID = '{$row['AID']}'";
            $row222 = sql_fetch($sql222);
            
            if ($row['T_status'] == '88') {
                echo "<br><span style='color:red'>(사무국 취소)</span>";  
                echo "<br>". $row222['CANCELED_DATE'];
                } elseif ($row['T_status'] == '99') {
                    echo "<br><span style='color:red'>(본인 취소)</span>";  
                echo "<br>". $row222['CANCELED_DATE']; }
                }
               
                  ?>
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