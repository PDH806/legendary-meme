<?php



$sub_menu = '700100';


include_once('./_common.php');
add_stylesheet('<link rel="stylesheet" href="' . G5_URL . '/adm/css/sbak_css.css">', 0);

auth_check_menu($auth, $sub_menu, 'r');


$g5['title'] = '자격증 재발급 접수 관리';


include_once('./admin.head.php');

//mainpay ----------------------------------------------
header('Content-Type: text/html; charset=utf-8');
$READY_API_URL = G5_THEME_URL . "/html/my_form/mainpay_api/pc/_9_cancel.php";

//-----------------------------------------------------


$colspan = 9;
$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '">처음</a>'; //페이지 처음으로 (초기화용도)



$sql_search = '';
$sql_common = " from SBAK_SERVICE_LIST ";

$_GET['get_payment'] = $_GET['get_payment'] ?? '';

if ($_GET['get_payment'] == 'YC') {
    $sql_search = " where PAYMENT_STATUS IN ('Y', 'C') ";
} else {
    $sql_search = " where PAYMENT_STATUS ='Y' ";
}


if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'PAYMENT_STATUS':

            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'TRAN_STATUS':
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
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





// 등급별 회원수




$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';

$sql_order = "order by UID desc";

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);





?>


<head>

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
</head>



<div class="local_sch local_sch01">
    <form name="fvisit" method="get" onsubmit="return fvisit_submit(this);">


        <div class="local_ov01 local_ov">
            <?php echo $listall ?>
            <span class="btn_ov01"><span class="ov_txt">전체 </span><span class="ov_num">
                    <?php echo number_format($total_count) ?>건
                </span></span>
            <span class="btn_ov01"> <span class="ov_txt">엑셀다운</span><span class="ov_num">
                    <a href="<?php echo "sbak_service_list_xls.php"; ?>"> <i class="fa fa-file-excel-o"></i> </a>
                </span></span>

        </div>


        <label for="sch_sort" class="sound_only">검색분류</label>
        <select name="sfl" id="sch_sort" class="search_sort">
            <option value="MEMBER_ID" <?php echo get_selected($sfl, 'MEMBER_ID'); ?>>신청자ID</option>
            <option value="MEMBER_NAME" <?php echo get_selected($sfl, 'MEMBER_NAME'); ?>>성명</option>
            <option value="MEMBER_PHONE" <?php echo get_selected($sfl, 'MEMBER_PHONE'); ?>>연락처</option>
            <option value="REGIS_DATE" <?php echo get_selected($sfl, 'REGIS_DATE'); ?>>신청년도</option>
            <option value="PRODUCT_CODE" <?php echo get_selected($sfl, 'PRODUCT_CODE'); ?>>카테고리</option>
        </select>



        <label for="sch_word" class="sound_only">검색어</label>
        <input type="text" name="stx" size="20" value="<?php echo stripslashes($stx); ?>" id="sch_word"
            class="frm_input">
        <input type="submit" value="검색" class="btn_submit">



    </form>
</div>

<div class="local_desc01 local_desc">
    <p>
        카테고리는 세자리로 입력하세요. 자격증(A4) : A01 | 자격증(ID카드) : A02 | 자격증(A4 + ID카드) : A03


    </p>
</div>



<form name="ksia_license_list" id="ksia_license_list" action="./sbak_service_list_update.php"
    onsubmit="return ksia_license_list_submit(this);" method="post">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="">

    <div class="L1"><textarea name="sms_msg" placeholder="문자입력" style="display: block ; background-color: yellow; width: 200px; height: 150px; "></textarea> </div>


    <div class="tbl_wrap tbl_head01">
        <table>
            <thead>
                <tr>
                    <th scope="col" id="mb_list_chk">
                        <label for="chkall" class="sound_only">회원 전체</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>
                    <th scope="col">NO</th>
                    <th scope="col">사진</th>
                    <th scope="col">신청품목</th>
                    <th scope="col" width=15%>신청자</th>
                    <th scope="col" width=5%>신청일</th>
                    <th scope="col" width=15%>주소</th>
                    <th scope="col" width=5%>결제수단</th>
                    <th scope="col">입금액</th>
                    <th scope="col">배송</th>
                    <th scope="col" width=15%>메모</th>
                    <th scope="col" width=5%>삭제</th>

                </tr>
            </thead>
            <tbody>


                <?php

                for ($i = 0; $row = sql_fetch_array($result); $i++) {




                    // 회원이미지 경로
                    $mb_img_path = G5_DATA_PATH . '/member_image/' . substr($row['MEMBER_ID'], 0, 2) . '/' . get_mb_icon_name($row['MEMBER_ID']) . '.jpg';
                    $mb_img_filemtile = (defined('G5_USE_MEMBER_IMAGE_FILETIME') && G5_USE_MEMBER_IMAGE_FILETIME && file_exists($mb_img_path)) ? '?' . filemtime($mb_img_path) : '';
                    $mb_img_url = G5_DATA_URL . '/member_image/' . substr($row['MEMBER_ID'], 0, 2) . '/' . get_mb_icon_name($row['MEMBER_ID']) . '.jpg' . $mb_img_filemtile;

                    $member_link = G5_ADMIN_URL . "/sbak_service_list.php?sfl=MEMBER_ID&stx=" . urlencode($row['MEMBER_ID']) . "&get_payment=YC";



                    $service_regis_date = $row['REGIS_DATE'] . " <br> " . $row['REGIS_TIME'];

                    $service_zip = $row['ZIP'];
                    $service_addr1 = $row['ADDR1'];
                    $service_addr2 = $row['ADDR2'];
                    $service_addr3 = $row['ADDR3'];

                    $service_code = $row['PRODUCT_CODE'];

                    $sql_service_name = "select Event_title from SBAK_OFFICE_CONF where Event_code ='{$service_code}'";
                    $row_1 = sql_fetch($sql_service_name);
                    $service_name = $row_1['Event_title'];



                    $link = "";
                    $referer = "";
                    $title = "";


                    $sql10 = "select mb_2 from g5_member where mb_id = '{$row['MEMBER_ID']}' ";
                    $row10 = sql_fetch($sql10);
                    $mb_birth = $row10['mb_2'];





                    $bg = 'bg' . ($i % 2);
                ?>
                    <tr class="<?php echo $bg; ?>">
                        <td class="td_chk">
                            <input type="hidden" name="UID[<?php echo $i ?>]" value="<?php echo $row['UID'] ?>">
                            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['MEMBER_ID']); ?>
                                회원</label>
                            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
                        </td>

                        <td>
                            <?php echo $row['UID']; ?>
                        </td>

                        <td>

                            <?php if (file_exists($mb_img_path)) { ?>
                                <a href="<?php echo $member_link ?>">
                                    <img src="<?php echo $mb_img_url ?>" width=100 alt="회원이미지">
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo $member_link ?>">
                                    <img src="<?php echo G5_THEME_IMG_URL ?>/sbak_logo.jpg" width=100 alt="회원이미지">
                                </a>
                            <?php } ?>

                        </td>

                        <td>
                            [<?php echo $row['PRODUCT_CODE']; ?>] <br>
                            <?php echo $service_name; ?> <br><span class="btnOrange"> <?php echo $row['CATE_1']; ?> </span>
                        </td>


                        <td>
                            <?php echo $row['MEMBER_NAME']; ?>
                            (<?php echo $row['MEMBER_ID']; ?>)
                            <input type="text" name="MEMBER_PHONE[<?php echo $i ?>]"
                                value="<?php echo $row['MEMBER_PHONE']; ?>" <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                                                                echo "class='ksia_input_deleted' readonly";
                                                                            } else {
                                                                                echo "class='ksia_input' readonly";
                                                                            } ?>
                                placeholder="전화번호">
                            <input type="text" name="MEMBER_EMAIL[<?php echo $i ?>]"
                                value="<?php echo $row['MEMBER_EMAIL']; ?>" <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                                                                echo "class='ksia_input_deleted' readonly";
                                                                            } else {
                                                                                echo "class='ksia_input' readonly";
                                                                            } ?>
                                placeholder="이메일">
                            <input type="text" name="LICENSE_NO[<?php echo $i ?>]" readonly value="<?php echo $row['LICENSE_NO']; ?>"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input'";
                                } ?> placeholder="자격번호">
                            <input type="text" name="MB_BIRTH[<?php echo $i ?>]" readonly value="<?php echo $mb_birth; ?>"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input'";
                                } ?> placeholder="생년월일">
                        </td>

                        <td>
                            <?php echo $service_regis_date; ?>
                        </td>


                        <td>
                            <input type="text" name="ZIP[<?php echo $i ?>]" value="<?php echo $row['ZIP']; ?>" <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                                                                                                    echo "class='ksia_input_deleted' readonly";
                                                                                                                } else {
                                                                                                                    echo "class='ksia_input'";
                                                                                                                } ?>>
                            <input type="text" name="ADDR1[<?php echo $i ?>]" value="<?php echo $row['ADDR1']; ?>" <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                                                                                                        echo "class='ksia_input_deleted' readonly";
                                                                                                                    } else {
                                                                                                                        echo "class='ksia_input'";
                                                                                                                    } ?>>
                            <input type="text" name="ADDR2[<?php echo $i ?>]" value="<?php echo $row['ADDR2']; ?>" <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                                                                                                        echo "class='ksia_input_deleted' readonly";
                                                                                                                    } else {
                                                                                                                        echo "class='ksia_input'";
                                                                                                                    } ?>>
                            <input type="text" name="ADDR3[<?php echo $i ?>]" value="<?php echo $row['ADDR3']; ?>" <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                                                                                                        echo "class='ksia_input_deleted' readonly";
                                                                                                                    } else {
                                                                                                                        echo "class='ksia_input'";
                                                                                                                    } ?>>
                        </td>
                        <td>
                            <?php echo $row['PAY_METHOD']; ?>
                        </td>
                        <td>
                            <input type="text" name="AMOUNT[<?php echo $i ?>]" readonly value="<?php echo $row['AMOUNT']; ?>" <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                                                                                                                    echo "class='ksia_input_deleted' readonly";
                                                                                                                                } else {
                                                                                                                                    echo "class='ksia_input'";
                                                                                                                                } ?>>

                            <?php

                            if ($row['PAYMENT_STATUS'] == 'Y') {
                                $member_payment_status = "<span class='box_sbak_label'>결제완료</span>";
                            } elseif ($row['PAYMENT_STATUS'] == 'C') {
                                $member_payment_status = "<span class='box_sbak_red_label'>취소완료</span>";
                            }

                            echo $member_payment_status;

                            ?>



                        </td>

                        <td>
                            <input type="text" name="DELIVERY_AGENCY[<?php echo $i ?>]" value="<?php echo $row['DELIVERY_AGENCY']; ?>"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input'";
                                } ?> placeholder="택배사">
                            <input type="text" name="TRACKING_NO[<?php echo $i ?>]" value="<?php echo $row['TRACKING_NO']; ?>"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input'";
                                } ?> placeholder="송장번호">
                            <input type="date" name="DELIVERY_DATE[<?php echo $i ?>]" value="<?php echo $row['DELIVERY_DATE']; ?>"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input'";
                                } ?>>



                            <input type='radio' name='TRAN_STATUS[<?php echo $i ?>]' value='Y' <?php if ($row['TRAN_STATUS'] == 'Y')
                                                                                                    echo "checked"; ?> <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                                                                                                            echo " disabled";
                                                                                                                        } ?>>배송완료

                        </td>


                        <td>
                            <textarea name="MEMO1[<?php echo $i ?>]" placeholder="메모사항"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input'";
                                } ?>
                                style="resize: none ; display: block ; width: 100%; height: 20px; border: solid 2px #1E90FF;border-radius: 5px;"><?php echo $row['MEMO1'];; ?>
                        </textarea>

                        </td>

                        <td>

                            <?php

                            //mainpay ----------------------------------------------
                            if ($row['PAYMENT_STATUS'] == "Y") {
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='is_del' value='yes'>";
                                echo "<input type='hidden' name='AID' value='" . $row['AID'] . "'>";
                                echo "<input type='hidden' name='product_code' value='" . $row['PRODUCT_CODE'] . "'>";
                                echo "<input type='hidden' name='payment_category' value='service'>";
                                echo "<input type='hidden' name='the_status' value='88'>";
                                echo "<button type='button' class='btn btn_01' onclick=\"payment_cancel(this.form)\">취소</button>";
                                echo "</form>";
                            } else {
                                //----------------------------------------------------

                                $sql222 = "select CANCELED_DATE from sbak_mainpay where AID = '{$row['AID']}'";
                                $row222 = sql_fetch($sql222);

                                if ($row['THE_STATUS'] == '88') {
                                    echo "<br><span style='color:red'>(사무국 취소)</span>";
                                    echo "<br>" . $row222['CANCELED_DATE'];
                                } elseif ($row['THE_STATUS'] == '99') {
                                    echo "<br><span style='color:red'>(본인 취소)</span>";
                                    echo "<br>" . $row222['CANCELED_DATE'];
                                }
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

        <input type="submit" name="act_button" value="문자발송" onclick="document.pressed=this.value" class="btn btn_02">
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
