<?php


$event_code = "C01";

require "./sbak_event_list_header.php"; //기본 헤더 갖고오기

?>



<?php



$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';


$sql_order = isset($sql_order) ? $sql_order : '';
$sql = " select * {$sql_common} {$sql_search} {$sql_order} order by UID desc limit {$from_record}, {$rows} ";
$result = sql_query($sql);


?>

<div class="local_sch local_sch01">
    <form name="fvisit" method="get" onsubmit="return fvisit_submit(this);">
        <input type="hidden" name="event_code" value="<?php echo $event_code; ?>">

        <div class="local_ov01 local_ov">
            <?php echo $listall ?>
            <span class="btn_ov01"><span class="ov_txt">전체 </span><span class="ov_num">
                    <?php echo number_format($total_count) ?>건
                </span></span>
            <span class="btn_ov01"> <span class="ov_txt">엑셀다운</span><span class="ov_num">
                    <a href="<?php echo "sbak_event_list_xls.php?event_code=" . $event_code . "&event_year=" . $event_year; ?>"> <i class="fa fa-file-excel-o"></i> </a>
                </span></span>

            <span class="btn_ov01"> <span class="ov_txt">사진대조</span><span class="ov_num">
                    <a href="<?php echo "sbak_photo_list.php?event_code=" . $event_code; ?>"> <i class="fa fa-photo"></i> </a>
                </span></span>

        </div>


        <label for="sch_sort" class="sound_only">검색분류</label>

        <select name="sst" id="sch_sort" class="search_sort">
            <?php
            //년도별 검색을 위해
            $sql_123 = "select EVENT_YEAR from SBAK_Master_Apply WHERE EVENT_CODE = '{$event_code}' and ENTRY_INFO_2 !='Y' group by EVENT_YEAR order by EVENT_YEAR desc ";
            $result123 = sql_query($sql_123);


            for ($i = 0; $row = sql_fetch_array($result123); $i++) {  //년도 카테고리를 갖고와서 갯수만큼 옵션 형성                   
                $THE_YEAR = $row['EVENT_YEAR'];
                echo "<option value='" . $THE_YEAR . "' " . get_selected($sst, $THE_YEAR) . " >" . $THE_YEAR . "년</option>";
            }
            ?>

        </select>
        <select name="sfl" id="sch_sort" class="search_sort">
            <option value="MB_ID" <?php echo get_selected($sfl, 'MB_ID'); ?>>신청자ID</option>
            <option value="MB_NAME" <?php echo get_selected($sfl, 'MB_NAME'); ?>>성명</option>
            <option value="THE_TEL" <?php echo get_selected($sfl, 'THE_TEL'); ?>>연락처</option>
            <option value="APPLY_DATE" <?php echo get_selected($sfl, 'APPLY_DATE'); ?>>등록일</option>
            <option value="PAYMENT_STATUS" <?php echo get_selected($sfl, 'PAYMENT_STATUS'); ?>>결제여부</option>



        </select>



        <label for="sch_word" class="sound_only">검색어</label>
        <input type="text" name="stx" size="20" value="<?php echo stripslashes($stx); ?>" id="sch_word"
            class="frm_input">
        <input type="submit" value="검색" class="btn_submit">



    </form>
</div>




<form name="ksia_license_list" id="ksia_license_list" action="./sbak_event_list_update.php"
    onsubmit="return sbak_license_list_submit(this);" method="post">
    <input type="hidden" name="event_season" value="<?php echo $event_year; ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="event_code" value="<?php echo $event_code ?>">
    <input type="hidden" name="token" value="">

    <div class="L1"><textarea name="sms_msg" placeholder="문자입력" style="display: block ; background-color: yellow; width: 200px; height: 150px; "></textarea> </div>

    <div class="local_desc01 local_desc">

        <p>회원 사진 누를 시 취소정보까지</p>

    </div>

    <div class="tbl_wrap tbl_head01">
        <table>


            <thead>

                <tr>
                    <th scope="col" id="mb_list_chk" rowspan="2">
                        <label for="chkall" class="sound_only">회원 전체</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>

                    <th scope="col" colspan="2" width="15%">신청자</th>
                    <th scope="col" rowspan="2">결제수단</th>
                    <th scope="col">입금액</th>
                    <th scope="col" rowspan="2">레벨2 증빙자료</th>
                    <th scope="col" rowspan="2">프로필</th>
                    <th scope="col" rowspan="2" width="15%">메모</th>
                    <th scope="col" rowspan="2" width="15%">문자</th>
                    <th scope="col" rowspan="2" width="5%">관리</th>
                    <th scope="col" rowspan="2" width="5%">BIB</th>
                </tr>
                <tr>
                    <th scope="col">사진</th>
                    <th scope="col">기본정보</th>
                    <th scope="col">입금확인</th>
                </tr>

            </thead>




            <tbody>


                <?php



                for ($i = 0; $row = sql_fetch_array($result); $i++) {


                    // 회원이미지 경로
                    $mb_img_path = G5_DATA_PATH . '/member_image/' . substr($row['MB_ID'], 0, 2) . '/' . get_mb_icon_name($row['MB_ID']) . '.jpg';
                    $mb_img_filemtile = (defined('G5_USE_MEMBER_IMAGE_FILETIME') && G5_USE_MEMBER_IMAGE_FILETIME && file_exists($mb_img_path)) ? '?' . filemtime($mb_img_path) : '';
                    $mb_img_url = G5_DATA_URL . '/member_image/' . substr($row['MB_ID'], 0, 2) . '/' . get_mb_icon_name($row['MB_ID']) . '.jpg' . $mb_img_filemtile;

                    $member_link = G5_ADMIN_URL . "/sbak_event_list_C01.php?sfl=MB_ID&stx=" . urlencode($row['MB_ID']) . "&get_payment=YC";


                    $link = "";
                    $referer = "";
                    $title = "";
                    $bg = 'bg' . ($i % 2);
                ?>


                    <tr class="<?php echo $bg; ?>">
                        <td class="td_chk" rowspan="2">
                            <?php echo $i + 1; ?>
                            <input type="hidden" name="UID[<?php echo $i ?>]" value="<?php echo $row['UID'] ?>">
                            <label for="chk_<?php echo $i; ?>" class="sound_only">
                                <?php echo get_text($row['MB_ID']); ?>
                            </label>
                            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
                        </td>

                        <td rowspan="2">
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
                            <?php echo $row['MB_NAME']; ?> (
                            <?php echo $row['MB_ID']; ?>) <br><span class="txt_true"> 등록 :
                                <?php echo $row['APPLY_DATE']; ?> <?php echo $row['APPLY_TIME']; ?>
                            </span>
                        </td>




                        <td rowspan="2">
                            <?php
                            if ($row['PAY_METHOD'] == "CARD") {
                                echo "신용카드";
                            } else {
                                echo "타행이체";
                            }
                            ?>
                        </td>


                        <td>
                            <input type="text" name="BANK_AMOUNT[<?php echo $i ?>]" readonly value="<?php echo $row['AMOUNT']; ?>"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input'";
                                } ?> placeholder="입금액">
                        </td>

                        <td rowspan="2">
                            <?php if (!empty($row['ENTRY_INFO_7_FILE'])) { ?>
                                <a href="<?php echo G5_DATA_URL; ?>/file/my_upload/<?php echo $event_year; ?>/<?php echo $row['ENTRY_INFO_7_FILE']; ?>"
                                    class="btn btn_03" style='background-color:#1E90FF;font-size:10px'
                                    target="_blank">
                                    <i class='fa fa-download'></i>첨부
                                </a>
                                <!-- 레벨2 자격 파일링크-->
                            <?php } ?>
                        </td>

                        <td rowspan="2">
                            <textarea name="THE_PROFILE[<?php echo $i ?>]" placeholder="프로필"
                                style="resize: none ; display: block ; width: 100%; height: 60px;  border: solid 1px #1E90FF;"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input'";
                                } ?>><?php echo $row['THE_PROFILE']; ?>
                            </textarea>
                        </td>

                        <td rowspan="2">
                            <textarea name="THE_MEMO[<?php echo $i ?>]" placeholder="메모"
                                style="resize: none ; display: block ; width: 100%; height: 60px;  border: solid 1px #1E90FF;"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input'";
                                } ?>><?php echo $row['THE_MEMO']; ?>
                            </textarea>
                        </td>

                        <td rowspan="2">
                            <?php
                            if (!empty($row['SMS_TIME'])) {
                                echo $row['SMS_MSG'] . "   <span style='color:red'>(" . $row['SMS_TIME'] . ")</span>";
                            }
                            ?>

                        </td>

                        <td rowspan="2">


                            <?php

                            //mainpay ----------------------------------------------
                            if ($row['PAYMENT_STATUS'] == "Y") {
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='is_del' value='yes'>";
                                echo "<input type='hidden' name='AID' value='" . $row['AID'] . "'>";
                                echo "<input type='hidden' name='product_code' value='" . $row['EVENT_CODE'] . "'>";
                                echo "<input type='hidden' name='payment_category' value='event'>";
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




                        <td rowspan="2">
                            <input type="text" name="ENTRY_BIB[<?php echo $i ?>]" value="<?php echo $row['ENTRY_BIB']; ?>"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input'";
                                } ?> placeholder="BIB" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);"><br>

                            <input type="checkbox" name="BIB_STATUS[<?php echo $i ?>]" value="Y" <?php if ($row['BIB_STATUS'] == 'Y')
                                                                                                        echo "checked"; ?>
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "disabled";
                                } ?>>
                        </td>



                    </tr>

                    <tr class="<?php echo $bg; ?>">


                        <td>

                            <select name="THE_GENDER[<?php echo $i ?>]" style="width:100%" onFocus="this.initialSelect = this.selectedIndex;" onChange="this.selectedIndex = this.initialSelect;">
                                <option value="남자" <?php if ($row['THE_GENDER'] == '남자') {
                                                        echo "selected";
                                                    }  ?>>남자</option>
                                <option value="여자" <?php if ($row['THE_GENDER'] == '여자') {
                                                        echo "selected";
                                                    }  ?>>여자</option>
                            </select>


                            <input type="date" name="THE_BIRTH[<?php echo $i ?>]" value="<?php echo $row['THE_BIRTH']; ?>"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input' readonly";
                                } ?>>

                            <input type="text" name="THE_TEL[<?php echo $i ?>]" value="<?php echo $row['THE_TEL']; ?>"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input' readonly";
                                } ?> placeholder="전화번호">


                            <input type="text" name="MB_LICENSE_NO[<?php echo $i ?>]" value="<?php echo $row['MB_LICENSE_NO']; ?>"
                                <?php if ($row['PAYMENT_STATUS'] == 'C') {
                                    echo "class='ksia_input_deleted' readonly";
                                } else {
                                    echo "class='ksia_input' readonly";
                                } ?> placeholder="자격번호">
                        </td>


                        <td>
                            <?php
                            if ($row['PAYMENT_STATUS'] == 'Y') {
                                $member_payment_status = "<span class='box_sbak_label'>결제완료</span>";
                            } elseif (($row['PAYMENT_STATUS'] == 'C')) {
                                $member_payment_status = "<span class='box_sbak_red_label'>취소완료</span>";
                            }

                            echo $member_payment_status;

                            ?>

                            <?php

                            if ($row['PAYMENT_STATUS'] == 'Y') {

                                // 확정 순서를 뽑아내자
                                $sql = "select count(*) as CNT from SBAK_Master_Apply where EVENT_CODE like '{$event_code}' 
                                         and EVENT_YEAR = '{$sst}' and  PAYMENT_STATUS = 'Y' and UID <= {$row['UID']}";


                                $result_cnt = sql_fetch($sql);
                                $ok_cnt = intval($result_cnt['CNT']);


                                if ($ok_cnt > 0 && ($ok_cnt <=  $event_total_limit)) {
                                    echo "<div style='padding:3px;margin:10px;border:1px solid blue;color:blue;border-radius:10px;justify-content:center;align-items:center'>확정순번: " . $ok_cnt . "</div>";
                                } elseif ($ok_cnt > 0 && ($ok_cnt >  $event_total_limit)) {
                                    $stanby_no = $ok_cnt - $event_total_limit;
                                    echo "<div style='padding:3px;margin:10px;border:1px solid red;color:red;border-radius:10px;justify-content:center;align-items:center'>대기순번: " .  $stanby_no . "</div>";
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





<?php
include_once('./admin.tail.php');
