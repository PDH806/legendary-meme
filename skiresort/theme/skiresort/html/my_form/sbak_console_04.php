<?php

include_once('./header_console.php'); //공통 상단을 연결합니다.
$this_title = "행사신청 종합관리"; //커스텀페이지의 타이틀을 입력합니다.
header('Content-Type: text/html; charset=utf-8');
$READY_API_URL = G5_THEME_URL . "/html/my_form/mainpay_api/pc/_9_cancel.php";
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

    <style>
    .table thead th {
        color: #fff !important;
        /* 글자 흰색 */
    }
    </style>
</head>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><?php echo $this_title; ?><span class="text-muted fw-light"> / MY EVENTS</span></h4>

    <div class="alert  alert-dark mb-0" role="alert">
        <?php echo $mb_name; ?> 회원님께서 신청한 모든 행사목록입니다. 정상적으로 행사등록이 완료되면 <span
            class="badge rounded-pill bg-primary">참가확정</span> 표식이 생성됩니다.
        <span class="badge rounded-pill bg-label-danger border border-danger text-danger">대기순번 </span>의 경우는, 결제되었으나,
        확정명단에 들지 못한 대기자의 대기순번입니다.
        이 경우, 참석확정 인원 중 취소 등으로, 결원이 발생시에만 참가확정될 수 있으며, 대기순번은 사유발생시마다 변동됩니다.
        그외의 경우, 취소된 신청건이거나, 신청인원 초과 후 결제로 인한 등록실패건입니다.
    </div> <br>

    <!-- 기본정보 -->
    <div class="card">

        <?php

        $query = " select count(*) as CNT from {$Table_Master_Apply} where MB_ID = '{$mb_id}' and (PAYMENT_STATUS = 'Y' or PAYMENT_STATUS = 'C')";

        $row_cnt = sql_fetch($query);
        $total_cnt = $row_cnt['CNT'] ?? '';

        echo "<h5 class='card-header'> 각종 행사신청관리 [ 총 <font color=red>" . $total_cnt . "</font> 건]</h5>";

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

        $query = "
    select * 
    from {$Table_Master_Apply} 
    where (MB_ID = '{$mb_id}') and (PAYMENT_STATUS = 'Y' or PAYMENT_STATUS = 'C')
    order by UID desc 
    limit {$start}, {$list_num}";  //페이징구현할것



        $result = sql_query($query);


        ?>


        <table class="table mb-0">
            <thead class="table table-dark">
                <tr>
                    <th>행사명</th>
                    <th>신청일/상태</th>
                    <th>관리</th>
                </tr>
            </thead>
            <tbody>

                <?php
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $uid = $row['UID'];
                    $event_code = $row['EVENT_CODE'];
                    $regis_date = $row['APPLY_DATE'];
                    $regis_time = $row['APPLY_TIME'];

                    /* paging : 글번호 */
                    $cnt = $start + 1;


                    get_office_conf($event_code); //사무국 환경설정

                    $detail_info_Modal = "detail_info_Modal" . $i;
                    $data_target = "#" . $detail_info_Modal;


                ?>


                <form name='frm_2' method='post' action='./sbak_console_event_form_update.php'>
                    <input type='hidden' name='profile_update' value='yes'>
                    <input type='hidden' name='uid' value='<?php echo $uid; ?>'>


                    <!-- Modal -->
                    <div class="modal fade" id="<?php echo $detail_info_Modal; ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <!--div class="modal-dialog modal-dialog-centered modal-lg"-->
                        <div class="modal-dialog <?php if (preg_match("/" . G5_MOBILE_AGENT . "/i", $_SERVER['HTTP_USER_AGENT'])) {
                                                            echo 'modal-fullscreen';
                                                        } else {
                                                            echo 'modal-dialog-scrollable';
                                                        } ?>" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                        '
                                        <?php echo $mb_name; ?>' 회원님의 참가신청 상세내역
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="container-fluid">


                                        <div class="row border-bottom">
                                            <div class="col-4 my-2"><span class='h6'>[생년월일]</span></div>
                                            <div class="col-8 my-2">
                                                <?php echo $mb_birth; ?>

                                            </div>
                                        </div>


                                        <div class="row border-bottom">
                                            <div class="col-4 my-2"><span class='h6'>[행사명]</span></div>
                                            <div class="col-8 my-2">
                                                <li class="list-group-item list-group-item-dark">
                                                    <?php echo $event_title; ?>
                                                </li>
                                            </div>
                                        </div>

                                        <?php if ($event_code == "B02" or $event_code == "B05") { // KSIA만 해당
                                            ?>

                                        <!--div class="row border-bottom">
                                                    <div class="col-4 my-2"><span class='h6'>[응시일]</span></div>
                                                    <div class="col-8 my-2">
                                                        <?php echo "<h6><span class=\"badge rounded-pill bg-success\">" . $row['ENTRY_INFO_1'] . "</span></h6>"; ?> (요강에서 날짜를 정확히 확인하세요.)
                                                    </div>
                                                </div-->

                                        <?php } ?>
                                        <div class="row border-bottom">
                                            <div class="col-4 my-2"><span class='h6'>[부 &nbsp;&nbsp;&nbsp; &nbsp;
                                                    문]</span></div>
                                            <div class="col-8 my-2">
                                                <span class='text-danger'>
                                                    <?php
                                                        echo  $row['THE_GENDER'];
                                                        ?>
                                                </span>
                                            </div>
                                        </div>

                                        <?php if (!empty($row['ENTRY_BIB']) && $row['ENTRY_BIB'] > 0) { //250109 BIB코드추가 
                                            ?>
                                        <div class="row border-bottom">
                                            <div class="col-4 my-2"><span class='h6'>[BIB]</span></div>
                                            <div class="col-8 my-2">
                                                <?php echo "<button type='button' class=\"btn btn-outline-primary\">" . $row['ENTRY_BIB'] . "</button>"; ?>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <div class="row border-bottom">
                                            <div class="col-4 my-2"><span class='h6'>[신청등록일]</span></div>
                                            <div class="col-8 my-2">
                                                <?php echo $row['APPLY_DATE'] . "  <small class='text-muted'>" . $row['APPLY_TIME'] . "</small>"; ?>

                                            </div>
                                        </div>

                                        <div class="row border-bottom">
                                            <div class="col-4 my-2"><span class='h6'>[연 락 처]</span></div>
                                            <div class="col-8 my-2">
                                                <?php echo $row['THE_TEL']; ?>

                                            </div>
                                        </div>



                                        <?php
                                            $arr_event = array('B03', 'C01');

                                            if (in_array($event_code, $arr_event)) { //대회면

                                            ?>

                                        <div class="row border-bottom">
                                            <div class="col-4 my-2"><span class="h6">[프 로 필]</span></div>
                                            <div class="col-8 my-2">
                                                <textarea rows="5" id="THE_PROFILE" name="THE_PROFILE"
                                                    class="form-control"
                                                    <?php echo (($row['PAYMENT_STATUS'] != "Y" || $row['THE_STATUS'] != "77")) ? " disabled" : ""; ?>><?php echo $row['THE_PROFILE']; ?></textarea>
                                            </div>
                                        </div>

                                        <?php }

                                            $arr_test = array('B02', 'B07', 'B05');

                                            if (in_array($event_code, $arr_test)) { //티칭2, 3검정이면

                                            ?>

                                        <div class="row border-bottom">
                                            <div class="col-4 my-2">
                                                <b>

                                                    <span class='h6'>[필기면제]</span>

                                                </b>
                                            </div>
                                            <div class="col-8 my-2">

                                                <?php
                                                        if ($row['ENTRY_INFO_3'] == "예") {
                                                            echo $row['ENTRY_INFO_3'] . " | " . $row['ENTRY_INFO_4'];
                                                        } else {
                                                            echo "해당사항 없음";
                                                        }
                                                        ?>

                                            </div>
                                        </div>


                                        <div class="row border-bottom">
                                            <div class="col-4 my-2"><span class="h6">[실기면제]</span></div>
                                            <div class="col-8 my-2">
                                                <?php
                                                        if ($row['ENTRY_INFO_5'] == "예") {
                                                            echo $row['ENTRY_INFO_5'] . " | " . $row['ENTRY_INFO_6'];
                                                        } else {
                                                            echo "해당사항 없음";
                                                        }
                                                        ?>
                                            </div>
                                        </div>

                                        <?php } ?>



                                        <div class="row border-bottom">
                                            <div class="col-4 my-2"><span class="h6">[처리상태]</span></div>
                                            <div class="col-8 my-2">


                                                <?php

                                                    $query = "select INSERT_DATE,CANCELED_DATE from {$Table_Mainpay} where AID = '{$row['AID']}'";
                                                    $row_date = sql_fetch($query);

                                                    if ($row['PAYMENT_STATUS'] == "Y") {
                                                        $pay_date = $row_date['INSERT_DATE'];

                                                        if ($row['THE_STATUS'] == "66") {
                                                            echo "<h6><span class=\"badge rounded-pill border border-danger text-danger\">등록실패</span></h6>";
                                                        }
                                                        if ($row['THE_STATUS'] == "77") {


                                                            // 확정 순서를 뽑아내자
                                                            $sql = "select count(*) as CNT from {$Table_Master_Apply} where EVENT_CODE like '{$event_code}' 
                                         and EVENT_YEAR = '{$event_year}' and  PAYMENT_STATUS = 'Y' and UID <= {$row['UID']}";


                                                            $result_cnt = sql_fetch($sql);
                                                            $ok_cnt = intval($result_cnt['CNT']);


                                                            $stanby_no = 0;

                                                            if ($ok_cnt > 0 && ($ok_cnt <=  $event_total_limit)) {
                                                                echo "<span class=\"badge rounded-pill bg-primary\">참가확정</span>";
                                                                echo "<span class='badge rounded-pill bg-info'>확정순번: " . $ok_cnt . "</span>";
                                                            } elseif ($ok_cnt > 0 && ($ok_cnt >  $event_total_limit)) {
                                                                $stanby_no = $ok_cnt - $event_total_limit;
                                                                echo "<span class='badge rounded-pill bg-danger'>대기순번: " .  $stanby_no . "</span>";
                                                            }
                                                        }

                                                        echo "<h6><span class=\"badge rounded-pill bg-label-primary border border-primary text-primary\">결제완료</span></h6>";
                                                        echo "<small>[결제일] " . $pay_date . "</small><br>";


                                                        if ($row['PAY_METHOD'] == "CARD") {
                                                            $pay_method = "[신용카드]";
                                                        } else {
                                                            $pay_method = "[타행이체]";
                                                        }

                                                        echo "<small style='color:blue;'>" . $pay_method . " / " . $row['AMOUNT'] . "원</small>";
                                                    } elseif ($row['PAYMENT_STATUS'] == "C") {
                                                        $canceled_date = $row_date['CANCELED_DATE'];
                                                        echo "<h6><span class=\"badge rounded-pill bg-label-dark\">취소완료</span></h6>";
                                                        echo "<small>[취소일] " . $canceled_date . "</small><br>";

                                                        if ($row['PAY_METHOD'] == "CARD") {
                                                            $pay_method = "[신용카드]";
                                                        } else {
                                                            $pay_method = "[타행이체]";
                                                        }

                                                        echo "<small style='color:blue;'>" . $pay_method . " / " . $row['AMOUNT'] . "원</small>";
                                                    } else {
                                                        echo "<h6><span class=\"badge rounded-pill bg-label-dark\">미결제</span></h6>";
                                                    }

                                                    ?>


                                            </div>
                                        </div>



                                        <div class="row border-bottom">
                                            <div class="col-4 my-2"><span class='h6'>[메 &nbsp;&nbsp;&nbsp; &nbsp;
                                                    모]</span></div>
                                            <div class="col-8 my-2">
                                                <?php
                                                    if (empty($row['THE_MEMO'])) {
                                                        echo "없음";
                                                    } else {
                                                        echo $row['THE_MEMO'];
                                                    }
                                                    ?>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <?php
                                        if ($row['PAYMENT_STATUS'] == "Y" && $row['THE_STATUS'] == "77") { //결제완료자에 한해 수정버튼 출력
                                            if (in_array($event_code, $arr_event)) { //대회면
                                                echo "<button type='button' class='btn btn-primary' onclick='form.submit()'>프로필 변경완료</button>";
                                            }
                                        }
                                        ?>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- 모달끝 -->

                </form>


                <tr <?php if ($row['THE_STATUS'] == "66") {
                            echo "style='background-color:#efefef'";
                        } ?>>

                    <td>
                        <?php

                            if ($row['THE_STATUS'] == "66" || $row['PAYMENT_STATUS'] == "C") {
                                if ($row['PAYMENT_STATUS'] == "C") {
                                    echo "<span class='text-info' style='text-decoration: line-through;'>" . $row['EVENT_TITLE'] . "</span>";
                                } else {
                                    echo "<i class='bx  bx-x'><span class='text-dark' style='text-decoration: line-through;'>" . $row['EVENT_TITLE'] . "</span>";
                                }
                            } else {
                                echo "<span class='text-dark'>" . $row['EVENT_TITLE'] . "</span>";
                            }

                            ?>


                        <button type='button' class='btn btn-secondary btn-sm' data-bs-toggle='modal'
                            data-bs-target='<?php echo $data_target; ?>'> 상세조회</button>
                    </td>
                    <td>
                        <?php
                            echo "<small>" . $regis_date . "</small>";
                            if ($row['THE_STATUS'] == "77") {
                                if ($stanby_no > 0) { //대기자면
                                    echo "<h6><span class=\"badge rounded-pill bg-label-danger border border-danger text-danger\">대기순번 " . $stanby_no . "</span></h6>";
                                } else {
                                    echo "<h6><span class=\"badge rounded-pill bg-primary\">참가확정</span></h6>";
                                }
                            }
                            if ($row['THE_STATUS'] == "66") {
                                echo "<h6><span class=\"badge rounded-pill border border-danger text-danger\">등록실패</span></h6>";
                            }

                            if ($row['PAYMENT_STATUS'] == "Y") {
                                echo "<h6><span class=\"badge rounded-pill bg-label-primary border border-primary text-primary\">결제완료</span></h6>";
                            } elseif ($row['PAYMENT_STATUS'] == "C") {
                                echo "<h6><span class=\"badge rounded-pill bg-label-dark\">취소완료</span></h6>";
                            } else {
                                echo "<h6><span class=\"badge rounded-pill bg-label-dark\">미결제</span></h6>";
                            }

                            ?>


                    </td>

                    <td>

                        <?php

                            $pay_limit = $Pay_end_date . " " . $Pay_end_time;


                            if ($row['PAYMENT_STATUS'] == "Y" && $row['EVENT_YEAR'] == $this_season) { // 결제완료건에 한해 //251201 + 올해 건 만 취소 가능하게 (대현)
                                if (date("Y-m-d H:i:s") <= $pay_limit) { //취소마감기간 이전이면
                                    echo "<form id='MAINPAY_FORM' method='post'>";
                                    echo "<input type='hidden' name='is_del' value='yes'>";

                                    echo "<input type='hidden' name='AID' value='" . $row['AID'] . "'>";
                                    echo "<input type='hidden' name='product_code' value='" . $event_code . "'>";
                                    echo "<input type='hidden' name='payment_category' value='event'>";
                                    echo "<input type='hidden' name='the_status' value='99'>";
                                    echo "<button type='button' class=\"btn  btn-danger btn-sm\" onclick='payment_cancel(this.form)'>취소</button></h6>";
                                    echo "<br><small>[취소마감] <em>" . $pay_limit . "</em></small>";
                                    echo "</form>";

                                    if ($row['THE_STATUS'] == "66") {
                                        echo "<h6><i class='bx  bx-notification'  ></i>이 신청건은, 신청인원 초과 후 결제되어, 
                                        행사등록 실패 되었으니, 반드시 결제취소해주세요.</h6> <small class='text-danger'>재신청하려면, 본 결제건을 취소하여야 가능합니다.</small>";
                                    }
                                } else {
                                    echo "<span class='badge rounded-pill bg-info' >취소불가</span>";
                                }
                            }


                            if ($row['PAYMENT_STATUS'] == "C") {
                                $canceled_date = $row_date['CANCELED_DATE'];
                                echo "<small>[취소처리일]<i> " . $canceled_date . "</i></small><br>";
                            }
                            ?>

                    </td>
                </tr>
                <?php
                }

                if ($i == 0)
                    echo '<tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>'; ?>

            </tbody>

        </table>



        <!-- 줄 띠우고 -->
        <hr class="my-2" />

        <!-- 페이징 시작 -->
        <div class="d-flex justify-content-center mx-auto gap-3">
            <nav aria-label="Page navigation example">
                <div style="text-align:center;">
                    <ul class="pagination">

                        <?php $basename = basename($_SERVER["PHP_SELF"]); ?>
                        <li class='page-item'><a class='page-link' href="<?php echo $basename; ?>" aria-label='전체'>
                                <span aria-hidden='true'>처음</span></a></li>

                        <?php

                        /* paging : 이전 페이지 */
                        if ($page <= 1) {
                        ?>
                        <li class='page-item'><a class='page-link' href="<?php echo $basename; ?>?page=1"
                                aria-label='Previous'>
                                <span aria-hidden='true'>&laquo;</span></a></li>
                        <?php } else { ?>
                        <li class='page-item'><a class='page-link'
                                href="<?php echo $basename; ?>?page=<?php echo ($page - 1); ?>" aria-label='Previous'>
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
                                href="<?php echo $basename; ?>?page=<?php echo $print_page; ?>">
                                <?php echo $print_page; ?>
                            </a></li>

                        <?php }
                        }
                        /* paging : 다음 페이지 */
                        if ($page >= $total_page) {
                            ?>
                        <li class='page-item'><a class='page-link'
                                href="<?php echo $basename; ?>?page=<?php echo $total_page; ?>" aria-label='Next'>
                                <span aria-hidden='true'>&raquo;</span></a></li>
                        <?php } else { ?>
                        <li class='page-item'><a class='page-link'
                                href="<?php echo $basename; ?>?page=<?php echo ($page + 1); ?>" aria-label='Next'>
                                <span aria-hidden='true'>&raquo;</span></a></li>
                        <?php }
                        ?>


                        <li class='page-item'><a class='page-link'
                                href="<?php echo $basename; ?>?page=<?php echo $total_page; ?>" aria-label='마지막'>
                                <span aria-hidden='true'>마지막</span></a></li>
                    </ul>

                </div>
            </nav>
        </div>


        <!-- 페이징 끝 -->

    </div>
</div>


<?php
include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
?>