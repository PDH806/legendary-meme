<?php


$this_title = "티칭1 응시 관리";
include_once('./header_console.php'); //공통 상단을 연결합니다.

$sports = $_GET['sports'] ?? '';

if (empty($sports)) {
    alert("비정상적인 접근입니다", $_SERVER['HTTP_REFERER']);
}

if ($sports != 'ski' && $sports != 'sb') {
    alert("비정상적인 접근입니다", $_SERVER['HTTP_REFERER']);
}


if ($sports == 'ski') {
    $sports_title = "스키";
    $event_code = 'B01';
} elseif ($sports == 'sb') {
    $sports_title = "스노보드";
    $event_code = 'B04';
} else{
     $sports_title = '';
    $event_code = '';   
}

// 취소 마감일  갖고오기

get_office_conf($event_code); //사무국 환경설정




//mainpay ----------------------------------------------
header('Content-Type: text/html; charset=utf-8');
$READY_API_URL = G5_THEME_URL . "/html/my_form/mainpay_api/pc/_9_cancel.php";

//-----------------------------------------------------

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

<style>
    .table thead th {
        color: #fff !important;
        /* 글자 흰색 */
    }


    @media (max-width: 768px) {

        .custom-table {
            table-layout: fixed;
            width: 100%;
        }

        .custom-table td {
            word-break: keep-all;
            white-space: normal;
        }
    }
</style>

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


<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><?php echo $this_title; ?><span class="text-muted fw-light"> / MY EVENTS</span></h4>


    <div class="alert  alert-dark mb-0" role="alert">
        <?php echo $mb_name; ?> 회원님께서 신청한 응시신청목록입니다. 새로 티칭 1에 응시신청하려면 '<?php echo $sports_title; ?>티칭1 응시 신청'을 클릭하세요.
    </div> <br>

    <!-- 기본정보 -->
    <div class="card">

        <h5 class='card-header'>
            <?php echo $sports_title; ?>티칭1 응시자료<a
                href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_T1_test_apply.php?sports=<?php echo $sports; ?>"
                style="color:red; float: right;"><small>
                    <i class="bx bxs-cog bx-spin"></i>
                    <?php echo $sports_title; ?>티칭1 응시 신청
                </small></a>
        </h5>


        <?php
        $sql = "select * from {$Table_T1_Apply} where MEMBER_ID = '{$mb_id}' and TYPE = '{$sports_title}' and (PAYMENT_STATUS = 'Y' or PAYMENT_STATUS = 'C') order by UID desc limit 0, 20";
        $result = sql_query($sql);

        ?>

        <div>
            <table class="table mb-0 custom-table">
                <thead class="table table-dark">
                    <tr>
                        <th>응시정보</th>
                        <th><?php echo $mb_name . " 님 "; ?>응시정보</th>
                        <th>관리</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    for ($i = 0; $row = sql_fetch_array($result); $i++) {
                        $uid = $row['UID'];
                        $test_no = $row['T_code'];
                        $regis_date = $row['REGIST_DATE'];


                        $payment_status = $row['PAYMENT_STATUS'];
                        if ($payment_status == 'Y') {
                            $payment_status = "<span class='badge rounded-pill bg-label-primary border border-primary text-primary'>결제완료</span>";
                        } elseif ($payment_status == 'C') {
                            $payment_status = "<span class='badge rounded-pill bg-label-dark'>취소완료</span>";
                        } else {
                            $payment_status = "<span class='badge rounded-pill bg-danger'>미결제</span>";
                        }


                        $license_no = $row['LICENSE_NO'] ?? '';
                        $score1_1 = $row['SCORE1_1'] ?? '';
                        $score1_2 = $row['SCORE1_2'] ?? '';
                        $score1_3 = $row['SCORE1_3'] ?? '';
                        $score2_1 = $row['SCORE2_1'] ?? '';
                        $score2_2 = $row['SCORE2_2'] ?? '';
                        $score2_3 = $row['SCORE2_3'] ?? '';
                        $score3_1 = $row['SCORE3_1'] ?? '';
                        $score3_2 = $row['SCORE3_2'] ?? '';
                        $score3_3 = $row['SCORE3_3'] ?? '';
                        $score4_1 = $row['SCORE4_1'] ?? '';
                        $score4_2 = $row['SCORE4_2'] ?? '';
                        $score4_3 = $row['SCORE4_3'] ?? '';
                        $AVERAGE = $row['AVERAGE'] ?? '';
                        $judge_comment = $row['COMMENT'] ?? '';

                        $sql_code = "select T_date, T_mb_id, T_name, T_tel, T_skiresort, T_time, T_meeting, T_status from {$Table_T1} where T_code = '{$test_no}'";

                        $row_code = sql_fetch($sql_code);
                        $judge_name = $row_code['T_name'] ?? '';
                        $judge_id = $row_code['T_mb_id'] ?? '';
                        $t_date = $row_code['T_date'] ?? '';
                        $t_status = $row_code['T_status'] ?? '';



                        $resort_no = $row_code['T_skiresort'] ?? '';
                        $query = "select RESORT_NAME from {$Table_Skiresort} where NO = {$resort_no}";
                        $resort_name = sql_fetch($query);
                        $resort_name = $resort_name['RESORT_NAME'] ?? '';
                        $t_where = $resort_name;


                        $t_time = $row_code['T_time'] ?? '';
                        $t_meeting = $row_code['T_meeting'] ?? '';


                        $detail_info_Modal = "detail_info_Modal" . $i;
                        $data_target = "#" . $detail_info_Modal;


                    ?>


                        <!-- Modal -->
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
                                            <?php echo $mb_name; ?>' 회원님의 <font color=blue> <?php echo $sports_title; ?> 티칭1 </font> 신청 상세내역
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="container-fluid">

                                            <div class="row border-bottom">
                                                <div class="col-4 my-2"><span class='h6'>[응시코드]</span></div>
                                                <div class="col-8 my-2">
                                                    <?php echo $row['T_code']; ?>
                                                </div>
                                            </div>

                                            <div class="row border-bottom">
                                                <div class="col-4 my-2"><span class='h6'>[응시정보]</span></div>
                                                <div class="col-8 my-2">
                                                    <?php echo $row_code['T_date']; ?> |
                                                    <?php echo $t_where; ?> |
                                                    <?php echo $row_code['T_meeting']; ?> |
                                                    <?php echo $row_code['T_time']; ?>

                                                </div>
                                            </div>

                                            <div class="row border-bottom">
                                                <div class="col-4 my-2"><span class='h6'>[개최자]</span></div>
                                                <div class="col-8 my-2">

                                                    <?php
                                                    echo $row_code['T_name'];

                                                    echo " | " . $row_code['T_tel'];

                                                    ?>

                                                </div>
                                            </div>



                                            <div class="row border-bottom">
                                                <div class="col-4 my-2"><span class='h6'>[등록일]</span></div>
                                                <div class="col-8 my-2">
                                                    <?php echo $row['REGIST_DATE']; ?> |
                                                    <?php echo $row['REGIST_TIME']; ?>
                                                </div>
                                            </div>

                                            <div class="row border-bottom">
                                                <div class="col-4 my-2"><span class='h6'>[연 락 처]</span></div>
                                                <div class="col-8 my-2">
                                                    <?php echo $row['PHONE']; ?>

                                                </div>
                                            </div>


                                            <div class="row border-bottom">
                                                <div class="col-4 my-2"><span class='h6'>[결제정보]</span></div>
                                                <div class="col-8 my-2">
                                                    <?php
                                                    echo $payment_status;

                                                    $sql5 = "select PAY_METHOD, INSERT_DATE, CANCELED_DATE from {$Table_Mainpay} where AID = '{$row['AID']}'";
                                                    $result_c = sql_fetch($sql5);
                                                    $pay_method = $result_c['PAY_METHOD'];
                                                    if ($pay_method == 'CARD') {
                                                        $pay_method = "신용카드";
                                                    } else {
                                                        $pay_method = "타행이체";
                                                    }
                                                    if ($row['PAYMENT_STATUS'] == 'C') { //결제취소건이면
                                                        echo " <small>" . $pay_method . " (" . $result_c['CANCELED_DATE'] . ")</small>";
                                                    } elseif ($row['PAYMENT_STATUS'] == 'Y') { //결제성공건이면
                                                        echo " <small>" . $pay_method . " (" . $result_c['INSERT_DATE'] . ")</small>";
                                                    }
                                                    ?>

                                                </div>
                                            </div>



                                            <div class="row border-bottom">
                                                <div class="col-4 my-2"><span class='h6'>[심사결과]</span></div>
                                                <div class="col-8 my-2">
                                                    <?php

                                                    if ($sports == 'ski') {
                                                        $sport1_name = '플루그보겐';
                                                        $sport2_name = '슈템턴';
                                                        $sport3_name = '스탠다드롱턴';
                                                        $sport4_name = '스탠다드숏턴';
                                                    } else {
                                                        $sport1_name = '사이드슬립,펜듈럼';
                                                        $sport2_name = '비기너턴';
                                                        $sport3_name = '너비스턴';
                                                        $sport4_name = '카빙롱턴';
                                                    }



                                                    //결제완료 이고, 각 스키장 관리자가 최종 확정을 해야 점수를 볼수 있게
                                                    if (($row['AVERAGE'] > 0) && $row['PAYMENT_STATUS'] == 'Y') {


                                                        if (!empty($row['SCORE1_1'])) {
                                                            echo  $sport1_name . " : <span class='badge rounded-pill bg-primary'>" . $row['SCORE1_1'] . " " . $row['SCORE1_2'] . " " . $row['SCORE1_3'] . "</span>";
                                                        }
                                                        if (!empty($row['SCORE2_1'])) {
                                                            echo  $sport2_name . " : <span class='badge rounded-pill bg-primary'>" . $row['SCORE2_1'] . " " . $row['SCORE2_2'] . " " . $row['SCORE2_3'] . "</span>";
                                                        }
                                                        if (!empty($row['SCORE3_1'])) {
                                                            echo  $sport3_name . " : <span class='badge rounded-pill bg-primary'>" . $row['SCORE3_1'] . " " . $row['SCORE3_2'] . " " . $row['SCORE3_3'] . "</span>";
                                                        }
                                                        if (!empty($row['SCORE4_1'])) {
                                                            echo  $sport4_name . " : <span class='badge rounded-pill bg-primary'>" . $row['SCORE4_1'] . " " . $row['SCORE4_2'] . " " . $row['SCORE4_3'] . "</span> <br>";
                                                        }

                                                        echo "<i class='fa fa-dot-circle-o' aria-hidden='true'></i> 평균 : <span class='L1_point_f_btn'>" . $row['AVERAGE'] . "</span> ";


                                                        if ($row['AVERAGE'] >= 70) {
                                                            echo "<span class='badge rounded-pill bg-info'>합격</span><br>";
                                                        } else{
                                                            echo "<span class='badge rounded-pill bg-info'>불합격</span><br>";
                                                        }

                                                        if (!empty($row['LICENSE_NO'])) {
                                                            echo "*자격번호 : <b>" . $row['LICENSE_NO'] . "</b> <br>";
                                                        }

                                                        echo "(심사결과에 대한 문의, 이의제기 등은 직접 심사위원에게 연락하여 확인해주세요.)";
                                                    } else {
                                                        if ($row['PAYMENT_STATUS'] !== 'Y') {
                                                            echo "<span class='badge rounded-pill bg-info'>미응시</span>";
                                                        } else {
                                                            echo "<span class='badge rounded-pill bg-info'>결과입력전</span>";
                                                        }
                                                    }


                                                    ?>


                                                </div>
                                            </div>



                                            <div class="row border-bottom">
                                                <div class="col-4 my-2"><span class='h6'>[메 &nbsp;&nbsp;&nbsp; &nbsp; 모]</span></div>
                                                <div class="col-8 my-2">
                                                    <?php
                                                    if ($row['MEMO'] == "") {
                                                        echo "없음";
                                                    } else {
                                                        echo $row['MEMO'];
                                                    }

                                                    ?>
                                                </div>

                                            </div>



                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!--모달 끝-->




                            <script>
                                // PHP 변수로부터 모달 ID 가져오기
                                var modalId = "<?php echo $detail_info_Modal; ?>";
                            </script>


                            <tr>
                                <td>
                                    <?php

                                    if ($row['T_status'] == "66" || $row['PAYMENT_STATUS'] == "C") {
                                        if ($row['PAYMENT_STATUS'] == "C") {


                                            echo "<p>* 응시코드 : <span class='text-info' style='text-decoration: line-through;'>" . $test_no . "</span></p>";
                                            echo "<p>* 응시일 : <span class='text-info' style='text-decoration: line-through;'>" . $t_date . "</span></p>";
                                            echo "<p>* 스키장 : <span class='text-info' style='text-decoration: line-through;'>" . $t_where . "</span></p>";
                                            echo "<p>* 집합장소 : <span class='text-info' style='text-decoration: line-through;'>" . $t_meeting . "</span></p>";
                                            echo "<p>* 집합시간 : <span class='text-info' style='text-decoration: line-through;'>" . $t_time . "</span></p>";
                                        } else {


                                            echo "<p>* 응시코드 : <span class='text-dark' style='text-decoration: line-through;'>" . $test_no . "</span></p>";
                                            echo "<p>* 응시일 : <span class='text-dark' style='text-decoration: line-through;'>" . $t_date . "</span></p>";
                                            echo "<p>* 스키장 : <span class='text-dark' style='text-decoration: line-through;'>" . $t_where . "</span></p>";
                                            echo "<p>* 집합장소 : <span class='text-dark' style='text-decoration: line-through;'>" . $t_meeting . "</span></p>";
                                            echo "<p>* 집합시간 : <span class='text-dark' style='text-decoration: line-through;'>" . $t_time . "</span></p>";
                                        }
                                    } else {
                                        echo "<p>* 응시코드 : <span style='color:#000'>" . $test_no . "</span></p>";
                                        echo "<p>* 응시일 : <span style='color:#000'>" . $t_date . "</span></p>";
                                        echo "<p>* 스키장 : <span style='color:#000'>" . $t_where . "</span></p>";
                                        echo "<p>* 집합장소 : <span style='color:#000'>" . $t_meeting . "</span></p>";
                                        echo "<p>* 집합시간 : <span style='color:#000'>" . $t_time . "</span></p>";
                                    }




                                    ?>
                                </td>

                                <td>

                                    <?php
                                    echo "* 신청일 :" . $regis_date . "<br>";
                                    echo "* 연락처 :" . $row['PHONE'] . "<br>";

                                    if ($t_status == '77') {
                                        echo "<button type='button' class='btn btn-success btn-sm' data-bs-toggle='modal'
                    data-bs-target='" . $data_target . "'> 상세조회</button>";
                                    } else {
                                        echo "<span class='badge rounded-pill bg-info' >삭제검정</span>";
                                    }



                                    echo $payment_status;

                                    if (date("Y-m-d") > $row_code['T_date']) {
                                        echo "<span class='badge bg-dark'></i>응시일 경과</span>";
                                    }


                                    if (($row['AVERAGE'] > 0) && $row['PAYMENT_STATUS'] == 'Y') { //총점이 입력되어 있고, 결제완료면
                                        echo " <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal'
                            data-bs-target='" . $data_target . "'onclick='showAlert()'>결과확인</span>";
                                    }
                                    ?>

                                </td>
                                <td>

                                    <?php

                                    //정해진 날짜 이전만 취소 가능하게 설정

                                    $to_date = date("Y-m-d");
                                    $T_Date = $row_code['T_date'];
                                    $timestamp = strtotime($T_Date);
                                    $past_timestamp = $timestamp - ($t1_before_days * 24 * 60 * 60);
                                    $until_date = date("Y-m-d", $past_timestamp);



                                    //mainpay ----------------------------------------------
                                    if ($row['PAYMENT_STATUS'] == "Y") { //결제했으면
                                        if ($to_date <= $until_date) { //취소기간이면
                                            echo "<form method='post'>";
                                            echo "<input type='hidden' name='is_del' value='yes'>";
                                            echo "<input type='hidden' name='AID' value='" . $row['AID'] . "'>";
                                            echo "<input type='hidden' name='product_code' value='" . $event_code . "'>";
                                            echo "<input type='hidden' name='payment_category' value='t1'>";
                                            echo "<input type='hidden' name='the_status' value='99'>";
                                            echo "<button type='button' class='btn btn-danger btn-sm' onclick=\"payment_cancel(this.form)\">취소</button>";


                                            echo "<br><small>[취소마감] : 검정 3일전 <i>(" . $until_date . ")</i>까지</small>";
                                            echo "</form>";
                                        } else { //취소불가 기간이면
                                            echo "<span class='badge rounded-pill bg-info' >취소불가</span>";
                                        }
                                    }

                                    //----------------------------------------------------       

                                    if ($row['PAYMENT_STATUS'] == "C") {
                                        $canceled_date = $result_c['CANCELED_DATE'];
                                        echo "<small>[취소처리일]<i> " . $canceled_date . "</i></small><br>";
                                    }
                                    ?>

                                </td>

                            </tr>

                        <?php } ?>

                        <?php if ($i == 0)
                            echo '<tr><td colspan="3" class="empty_table">자료가 없습니다.</td></tr>'; ?>

                </tbody>

            </table>

        </div>

    </div>
</div>

<?php
include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
?>