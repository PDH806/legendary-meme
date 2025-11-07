<?php


$this_title = "티칭1 시험 진행 관리";
include_once('./header_console.php'); //공통 상단을 연결합니다.


$the_sports = $_GET['sports'] ?? '';
$refer =  $_SERVER['HTTP_REFERER'] ?? '';

if (empty($the_sports) || empty($refer)) {
    alert("비정상적인 접속입니다.", $_SERVER['HTTP_REFERER']);
}

if ($the_sports != 'ski' && $the_sports != 'sb') {
    alert("비정상적인 접속입니다.", $_SERVER['HTTP_REFERER']);
}

//스키장관리자인지

if (empty($resort_no) || empty($resort_name)) {
    alert("스키장 관리자가 아닙니다.", $refer);
}

if ($the_sports == 'ski') {
    if ($resort_judge_gubun != 'SK') {
        alert("스키 티칭1 관리자가 아닙니다.", $_SERVER['HTTP_REFERER']);
    }
} elseif (($the_sports == 'sb')) {
    if ($resort_judge_gubun != 'SB') {
        alert("스노보드 티칭1 관리자가 아닙니다.", $_SERVER['HTTP_REFERER']);
    }
}





if ($the_sports == 'ski') {
    $title_sports = '스키';
    $type_no = 1;
} elseif ($the_sports == 'sb') {
    $title_sports = '스노보드';
    $type_no = 2;
} else {
    $title_sports = '';
    $type_no = '';
}

$edit_btn = true; //수정버튼 처리를 위한 변수 정의

?>

<style>
    .table thead th {
        color: #fff !important;
        /* 글자 흰색 */
    }
</style>


<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"> <?php echo $resort_name; ?> <span class="text-muted fw-light"> / <?php echo $title_sports; ?><?php echo $this_title; ?></span></h4>

    <!-- 기본정보 -->
    <div class="card">


        <?php


        $query = "select count(*) as CNT from {$Table_T1} where T_mb_id like '{$mb_id}' and TYPE =  {$type_no}  and (T_status != '88' and T_status != '99')";


        $row_cnt = sql_fetch($query);
        $total_cnt = $row_cnt['CNT'];


        echo "<h5 class='card-header'> 시험일정 [ 총 <font color=red>" . $total_cnt . "</font> 건]<small>
        <a href='" . G5_THEME_URL . "/html/my_form/sbak_console_T1_apply.php?sports=" . $the_sports . "' style='color:red; float:right;'>
        <i class='bx bxs-cog bx-spin'></i> " . $title_sports . " 티칭1 시험 개최 등록</a> </small></h5>";

        /* paging : 한 페이지 당 데이터 개수 */
        $list_num = 5;

        /* paging : 한 블럭 당 페이지 수 */
        $page_num = 5;

        /* paging : 현재 페이지 */
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;

        /* paging : 전체 페이지 수 = 전체 데이터 / 페이지당 데이터 개수 */
        $total_page = ceil($total_cnt / $list_num);
        // echo "전체 페이지 수 : ".$total_page;

        /* paging : 전체 블럭 수 = 전체 페이지 수 / 블럭 당 페이지 수 */
        $total_block = ceil($total_page / $page_num);

        /* paging : 현재 블럭 번호 = 현재 페이지 번호 / 블럭 당 페이지 수 */
        $now_block = ceil($page / $page_num);

        /* paging : 블럭 당 시작 페이지 번호 = (해당 글의 블럭번호 - 1) * 블럭당 페이지 수 + 1 */
        $s_pageNum = ($now_block - 1) * $page_num + 1;
        // 데이터가 0개인 경우
        if ($s_pageNum <= 0) {
            $s_pageNum = 1;
        };

        /* paging : 블럭 당 마지막 페이지 번호 = 현재 블럭 번호 * 블럭 당 페이지 수 */
        $e_pageNum = $now_block * $page_num;
        // 마지막 번호가 전체 페이지 수를 넘지 않도록
        if ($e_pageNum > $total_page) {
            $e_pageNum = $total_page;
        };

        /* paging : 시작 번호 = (현재 페이지 번호 - 1) * 페이지 당 보여질 데이터 수 */
        $start = ($page - 1) * $list_num;


        $rec_num = 1 + (($page - 1) * $list_num);


        $query = "select * from {$Table_T1} where T_mb_id like '{$mb_id}' and TYPE =  {$type_no} and (T_status != '88' and T_status != '99') order by UID desc 
        limit {$start}, {$list_num};"; //페이징구현할것

        $result = sql_query($query);

        ?>

        <div>
            <table class="table mb-0">
                <thead class="table table-dark">
                    <tr>

                        <th>기본정보</th>
                        <th>응시인원</th>

                        <th>상태/관리</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                    for ($i = 0; $row = sql_fetch_array($result); $i++) {

                        /* paging : 글번호 */
                        $cnt = $start + 1;


                        $uid = $row['UID'];
                        $sql_get_cnt = "select count(*) as CNT from {$Table_T1_Apply} where T_code = '{$row['T_code']}' and PAYMENT_STATUS = 'Y' and (T_status != '88' and T_status != '99')";
                        $result_cnt = sql_fetch($sql_get_cnt);
                        $payment_cnt = $result_cnt['CNT']; //각 검정코드별 납부확정 응시자수   (삭제조치된 응시건 제외)       


                        $detail_info_Modal = "detail_info_Modal" . $i;
                        $data_target = "#" . $detail_info_Modal;


                    ?>


                        <!-- Modal -->
                        <?php
                        $fwrite_id = "fwrite" . $i;
                        $fwrite_name = "fwrite" . $i;
                        ?>
                        <form name="<?php echo $fwrite_name; ?>" id="<?php echo $fwrite_id; ?>" action="./sbak_T1_apply_update.php" onsubmit="return fwrite_submit(this)" method="post">
                            <input type='hidden' name='is_update' value='yes'>
                            <input type='hidden' name='uid' value='<?php echo $uid; ?>'>
                            <input type='hidden' name='t_date' value='<?php echo $row['T_date']; ?>'>
                            <div class="modal fade" id="<?php echo $detail_info_Modal; ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog <?php if (preg_match("/" . G5_MOBILE_AGENT . "/i", $_SERVER['HTTP_USER_AGENT'])) {
                                                                echo 'modal-fullscreen';
                                                            } else {
                                                                echo 'modal-dialog-scrollable';
                                                            } ?>" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                '
                                                <?php echo $mb_name; ?>' 회원님의 <font color=blue> <?php echo $row['T_code']; ?>
                                                </font> 시험 상세내역
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="container-fluid">

                                                <div class="row border-bottom">
                                                    <div class="col-4 my-2"><span class='h6'>[행사코드]</span></div>
                                                    <div class="col-8 my-2">
                                                        <?php echo $row['T_code']; ?>
                                                        <?php
                                                        if ($row['Is_private'] == 'Y') {
                                                            echo "<span class='badge border border-primary text-primary'>비공개 행사</span>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="row border-bottom">
                                                    <div class="col-4 my-2"><span class='h6'>[인원]</span></div>
                                                    <div class="col-8 my-2">
                                                        <?php echo  "등록 : " . $payment_cnt . "명 (최대 " . $row['limit_member'] . "명)"; ?>
                                                    </div>
                                                </div>

                                                <div class="row border-bottom">
                                                    <div class="col-4 my-2"><span class='h6'>[개최일정]</span></div>
                                                    <div class="col-8 my-2">
                                                        <?php echo $row['T_date']; ?>
                                                    </div>
                                                </div>

                                                <div class="row border-bottom">
                                                    <div class="col-4 my-2"><span class='h6'>[접수기간]</span></div>
                                                    <div class="col-8 my-2">
                                                        <input type="date" name="apply_start" value="<?php echo $row['Application_Day']; ?>" <?php if ($payment_cnt > 0) {
                                                            echo "disabled";
                                                        } ?> required>
                                                        - <input type="date" name="apply_end" value="<?php echo $row['Expired_Day']; ?>" <?php if ($payment_cnt > 0) {
                                                            echo "disabled";
                                                        } ?> required>
                                                    </div>
                                                </div>

                                                <div class="row border-bottom">
                                                    <div class="col-4 my-2"><span class='h6'>[시간/집합장소]</span></div>
                                                    <div class="col-8 my-2">
                                                        시간: <input type="time" name="t_time" value="<?php echo $row['T_time']; ?>" <?php if ($row['T_date'] <= date("Y-m-d")) {
                                                            echo "disabled";
                                                        } ?> required> <br>
                                                        장소: <input type="text" name="t_meeting" width="100%" value="<?php echo $row['T_meeting']; ?>" <?php if ($row['T_date'] <= date("Y-m-d")) {
                                                            echo "disabled";
                                                        } ?>
                                                            required>

                                                    </div>
                                                </div>


                                                <?php if ($row['Is_private'] == 'Y') { ?>
                                                    <div class="row border-bottom">
                                                        <div class="col-4 my-2">
                                                            <span class='h6'>[공개여부]</span> <br><br>
                                                            <small class='text-danger'>&#8251; 공개로 변경시, 비공개로 재변경 불가함</small><br>
                                                            <input class="form-check-input" type="radio" name="is_private" value="N" <?php if ($row['Is_private'] !== 'Y') {
                                                                echo 'checked';
                                                            } ?>> <label>공개</label>&nbsp;
                                                            <input class="form-check-input" type="radio" name="is_private" value="Y" <?php if ($row['Is_private'] == 'Y') {
                                                                echo 'checked';
                                                            } ?>> <label>비공개</label>&nbsp;




                                                        </div>
                                                        <div class="col-8 my-2"><textarea name="target_id_list" style='width:100%' rows='4' <?php if ($row['T_date'] <= date("Y-m-d")) {
                                                                echo "disabled";
                                                            } ?>><?php echo $row['Subject_lists']; ?></textarea>
                                                            <br>
                                                            <small class='text-danger'>등록을 허가할 회원 ID를 콤마(,)로 구분하여 입력. 대소문자 구분.</small>
                                                        </div>
                                                    </div>

                                                <?php }      ?>


                                                <div class="row border-bottom">
                                                    <div class="col-4 my-2"><span class='h6'>[등 록 일]</span></div>
                                                    <div class="col-8 my-2">
                                                        <?php echo $row['T_regis_date']; ?>
                                                    </div>
                                                </div>

                                                <div class="row border-bottom">
                                                    <div class="col-4 my-2"><span class='h6'>[연 락 처]</span></div>
                                                    <div class="col-8 my-2">
                                                        <input class="form-control" type="text" name="t_tel" placeholder="담당자의 휴대폰번호를 숫자로만 입력하세요." oninput="autoHyphen(this)"
                                                            maxlength="13" value="<?php echo $row['T_tel']; ?>" <?php if ($row['T_date'] <= date("Y-m-d")) {
                                                            echo "disabled";
                                                        } ?> required>
                                                    </div>
                                                </div>


                                                <div class="row border-bottom">
                                                    <div class="col-4 my-2"><span class='h6'>[처리상태]</span></div>
                                                    <div class="col-8 my-2">

                                                        <?php if ($row['T_status'] == '77' and ($row['RESULT_DATE'] !== '' and !is_null($row['RESULT_DATE']))) {
                                                            echo "<span class='badge rounded-pill bg-label-dark'>응시종료</span>";
                                                            $edit_btn = false;
                                                        } ?>
                                                        <?php if ($row['T_status'] == '77') {
                                                            echo "<span class='badge rounded-pill bg-label-dark'>승인</span>";
                                                        } ?>


                                                        <?php if ($row['T_date'] < date("Y-m-d")) {

                                                            echo "<span class='badge rounded-pill bg-label-dark'>일정경과</span>";
                                                            $edit_btn = false;
                                                        } ?>


                                                        <?php if ($row['RESULT_DATE'] !== '' and !is_null($row['RESULT_DATE'])) {
                                                            echo "<span class='btn btn-info badge rounded-pill bg-dark'>심사완료(" . $row['RESULT_DATE'] . ")</span>";
                                                            $edit_btn = false;
                                                        } ?>



                                                    </div>
                                                </div>



                                                <div class="row border-bottom">
                                                    <div class="col-4 my-2"><span class='h6'>[메 &nbsp;&nbsp;&nbsp; &nbsp; 모]</span></div>
                                                    <div class="col-8 my-2">
                                                        <?php
                                                        if ($row['T_memo'] == "") {
                                                            echo "없음";
                                                        } else {
                                                            echo $row['T_memo'];
                                                        }

                                                        ?>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <?php
                                                if ($edit_btn == true) {
                                                    echo "<button type='button' class='btn btn-primary' onclick='form.submit()'>수정확인</button>";
                                                }
                                                ?>

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                        <!---모달 끝 -->


                        <tr>
                            <td>
                                <div class="exam-info">
                                    <div><small>[행사코드]</small>
                                        <?php echo $row['T_code']; ?>
                                    </div>

                                    <div style='float:left;padding-right:10px;'><small>[개최일]</small>
                                        <span style='color:#000;border:1px solid #000;border-radius:10px;font-weight:500;padding:0 5 0 5;'><?php echo $row['T_date']; ?></span>
                                    </div>
                                    <div><small> [등록일]</small>
                                        <?php echo $row['T_regis_date']; ?>
                                    </div>
                                    <div style='float:left;'><small>[접수기간] </small>
                                        <span class='text-dark'><i> <?php echo $row['Application_Day']; ?> ~ <?php echo $row['Expired_Day']; ?> </i></span>
                                    </div>
                                </div>
        </div>

    </div>
    </td>



    <td>
        <div class="exam-info">
            <div><span>
                    <?php echo "등록 : " . $payment_cnt . "명 (최대 " . $row['limit_member'] . "명)"; ?>
                </span>
                <?php if (($row['T_status'] == '77') && $payment_cnt > 0) {  //확정 상태이고, 응시자가 1명 이상이면 응시자관리 버튼 출력
                            echo "<button class='btn btn-info btn-sm mb-1' onclick=\"location.href='./sbak_console_T1_test_open_list_detail.php?t_code=" . $row['T_code'] . "&sports=" . $the_sports . "'\">응시자관리</button>";
                        } ?></div>

            <?php
                        if ($row['Is_private'] == 'Y') {
                            echo "<div><span class='badge border border-primary text-primary'>비공개 행사</span></div>";
                        }
            ?>
        </div>
    </td>


    <td>
        <?php if ($row['T_status'] == '77' and ($row['RESULT_DATE'] == '' or is_null($row['RESULT_DATE']))) {
                            echo "<span class='badge rounded-pill bg-label-dark'>승인</span>";
                        } ?>


        <?php if ($row['T_date'] < date("Y-m-d")) {
                            echo "<span class='badge rounded-pill bg-label-dark'>일정경과</span>";
                        } ?>



        <?php if ($row['RESULT_DATE'] !== '' and !is_null($row['RESULT_DATE'])) {
                            echo "<span class='btn btn-info badge rounded-pill bg-dark'>심사완료(" . $row['RESULT_DATE'] . ")</span>";
                        } ?>

        <div class="d-flex flex-wrap gap-2 mt-2">

            <button type='button' class='btn btn-secondary btn-sm my-2' data-bs-toggle='modal'
                data-bs-target='<?php echo $data_target; ?>'>상세조회</button>
        </div>

        <?php
                        if (($row['T_status'] == '77') && $payment_cnt < 1) { //승인 상태이고, 연결된 응시생이 없을 경우에만 삭제메뉴 출력
                            echo "<form name='frm_1' method='post' action='sbak_T1_test_open_update.php'>";
                            echo "<input type='hidden' name='is_del' value='yes'>";
                            echo "<input type='hidden' name='uid' value='" . $uid . "'>";
                            echo "<input type='hidden' name='chk_test_code' value='" . $row['T_code'] . "'>";
                            echo "<input type='hidden' name='sports' value='" . $the_sports . "'>";
                            echo "<button type='button' class=\"btn btn-danger btn-sm\" data-bs-toggle='modal'
       data-bs-target='#want_tel" . $i . "'>취소하기</button></h6>";

        ?>



            <!-- Modal -->
            <div class="modal fade" id="want_tel<?php echo $i; ?>" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                [
                                <?php echo $row['T_code']; ?>] 신청건 삭제확인
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="container-fluid">

                                선택하신 티칭1 응시 신청건을 삭제하시겠습니까? 삭제후에는 복구되지 않습니다.

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">취소</button>
                                <button type="button" class="btn btn-primary"
                                    onclick="form.submit()">삭제확인</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal 종료-->

            <?php echo "</form>";
                        } ?>



    </td>
    </tr>

<?php } ?>

<?php if ($i == 0)
    echo '<tr><td colspan="3" class="empty_table">자료가 없습니다.</td></tr>'; ?>

</tbody>

</table>

</div>


<!-- 줄 띠우고 -->
<hr class="my-2" />

<!-- 페이징 시작 -->

<div class="d-flex justify-content-center mx-auto gap-3">
    <nav aria-label="Page navigation example">
        <div style="text-align:center;">
            <ul class="pagination">

                <?php $basename = basename($_SERVER["PHP_SELF"]); ?>
                <li class='page-item'><a class='page-link'
                        href="<?php echo $basename . "?sports=" . $the_sports; ?>" aria-label='전체'>
                        <span aria-hidden='true'>처음</span></a></li>

                <?php

                /* paging : 이전 페이지 */
                if ($page <= 1) {
                ?>
                    <li class='page-item'><a class='page-link'
                            href="<?php echo $basename; ?>?page=1&sports=<?php echo $the_sports; ?>"
                            aria-label='Previous'>
                            <span aria-hidden='true'>&laquo;</span></a></li>
                <?php } else { ?>
                    <li class='page-item'><a class='page-link'
                            href="<?php echo $basename; ?>?page=<?php echo ($page - 1); ?>&sports=<?php echo $the_sports; ?>"
                            aria-label='Previous'>
                            <span aria-hidden='true'>&laquo;</span></a></li>
                <?php }; ?>

                <?php
                /* pager : 페이지 번호 출력 */
                for ($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++) {

                    if ($page == $print_page) {
                ?>
                        <li class='page-item active' aria-current="page"><a class='page-link' href="#">
                                <?php echo $print_page; ?>
                            </a>
                        </li>
                    <?php } else { ?>

                        <li class='page-item'><a class='page-link'
                                href="<?php echo $basename; ?>?page=<?php echo $print_page; ?>&sports=<?php echo $the_sports; ?>"><?php echo $print_page; ?></a></li>

                <?php }
                } ?>

                <?php
                /* paging : 다음 페이지 */
                if ($page >= $total_page) {
                ?>
                    <li class='page-item'><a class='page-link'
                            href="<?php echo $basename; ?>?page=<?php echo $total_page; ?>&sports=<?php echo $the_sports; ?>"
                            aria-label='Next'>
                            <span aria-hidden='true'>&raquo;</span></a></li>
                <?php } else { ?>
                    <li class='page-item'><a class='page-link'
                            href="<?php echo $basename; ?>?page=<?php echo ($page + 1); ?>&sports=<?php echo $the_sports; ?>"
                            aria-label='Next'>
                            <span aria-hidden='true'>&raquo;</span></a></li>
                <?php }; ?>


                <li class='page-item'><a class='page-link'
                        href="<?php echo $basename; ?>?page=<?php echo $total_page; ?>&sports=<?php echo $the_sports; ?>"
                        aria-label='마지막'>
                        <span aria-hidden='true'>마지막</span></a></li>


            </ul>

        </div>
    </nav>
</div>


<!-- 페이징 끝 -->


</div>
</div>



<script>
    function fwrite_submit(f) {

        return true;

    }

    const autoHyphen = (target) => {
        target.value = target.value
            .replace(/[^0-9]/g, '')
            .replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`);
    }
</script>



<?php
include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
?>