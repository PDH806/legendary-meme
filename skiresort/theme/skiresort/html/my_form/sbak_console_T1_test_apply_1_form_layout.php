<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가
?>

<style>
.basic_info dl {
    display: flex;
    flex-wrap: wrap;
}

.basic_info dt {
    width: 120px;
    /* 고정 너비 지정 */

}

.basic_info dd {
    flex: 1;
    margin: 0;
}
</style>



<div class="row">

    <div class="col-xl-12">
        <div class="card mb-4">

            <h5 class="card-header"><?php echo $event_title; ?> (
                <?php echo $test_season; ?> 시즌) <small class="text-muted "> 반드시 확인하세요.
                    <a href="<?php echo G5_THEME_URL ?>/html/my_form/sbak_console_T1_test.php?sports=<?php echo $the_sports; ?>"
                        style="color:red; float: right;"><i class="bx bxs-cog bx-spin"></i> 신청내역보기</a>
                </small> </h5>
            <div class="card-body">

                <div class="row gy-3">
                    <div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>

                    <div class="basic_info">
                        <dl>
                            <dt>
                                <span>기존 신청내역 관리</span>
                            </dt>
                            <dd>
                                우측상단의 신청내역관리 메뉴를 이용해, 기존 신청 검정의 진행상태/결과확인 등의 절차를 진행하세요.

                            </dd>
                        </dl>
                    </div>

                    <div class="basic_info">
                        <dl>
                            <dt>
                                <span>1인당 응시비용</span>
                            </dt>
                            <dd>
                                <?php echo "<font style='color:red;'>" . number_format($event_entry_fee) . "</font> 원"; ?>
                            </dd>
                        </dl>
                    </div>

                    <div class="basic_info">
                        <dl>
                            <dt>
                                <span>등록기간</span>
                            </dt>
                            <dd>
                                <?php echo $event_begin_date . " " . $event_begin_time . " ~ " . $event_end_date . " " . $event_end_time; ?>
                            </dd>
                        </dl>
                    </div>



                    <div class="basic_info">
                        <dl>
                            <dt>
                                <span>신청자격</span>
                            </dt>
                            <dd>
                                <?php echo $event_birthdate; ?>
                                이전 출생자
                            </dd>
                        </dl>
                    </div>

                    <div class="basic_info">
                        <dl>
                            <dt>
                                <span>취소기간</span>
                            </dt>
                            <dd>
                                <?php echo $t1_before_days . "일전 까지"; ?>
                            </dd>
                        </dl>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <?php // 조건에 따라 출력폼 표출여부 결정 시작



    if ($event_birthdate < $mb_birth) {
        $the_proceed = 7;
    }

    if ($event_status == 'Y') {
        $the_proceed = 1;
    } else {

        //접수기간에 따른 메세지 만들기


        if ($time_now < $time_begin) { //접수기간 전이면
            $the_proceed = 5;
        } elseif ($time_now > $time_end) { //접수마감 이후면
            $the_proceed = 6;
        }
    }

    if ($is_admin || $member['mb_id'] == 'admin01') { //어드민이면 무조건 출력
        $the_proceed = 10;
    }

    switch ($the_proceed) {
        case 1:
            echo "티칭1 시험은 현재 개최 요강이 확정되어 있지 않습니다. 추후 확정된 후 정보를 갱신하여, 접수를 진행하겠습니다.";
            break;
        case 5:
            echo "아직 접수기간 이전입니다.";
            break;
        case 6:
            echo "접수기간이 마감되었습니다.";
            break;
        case 7:
            echo "신청 불가능 연령입니다." . $event_birthdate . "  이후 출생자만 가능합니다.";
            break;

        default: // 모든 것이 유효할 경우 참가신청 등록 가능처리			

            // 조건에 따라 출력폼 표출여부 결정 종료

    ?>
    <br><br>

    <?php
    $query = "select NO, RESORT_NAME from {$Table_Skiresort} where NO = {$skiresort}"; //스키장 자료 갖고오기
    $result = sql_fetch($query);
    $resort_name = $result['RESORT_NAME'] ?? '';



    $query = "SELECT T_code, T_mb_id, T_date, T_name, T_time, T_meeting, T_tel, T_status, Application_Day, Expired_Day, Is_private, Subject_lists, RESULT_DATE, limit_member   
    FROM {$Table_T1} WHERE (TEST_YEAR = {$test_season} and TYPE = {$the_type}) 
    and (T_status != '88' && T_status != '99') and (T_skiresort = {$skiresort}) order by  T_date desc"; // 개별검정중  삭제 아닌것
    $result = sql_query($query);



    ?>

    <div class="col-xl-12">
        <div class="card mb-4">
            <h5 class="card-header">
                <?php echo "<span style='font-size:1.4em;color:#000;font-weight:600;'>" . $resort_name . "</span> | " . $sports; ?>
                티칭1 시험 목록&nbsp;&nbsp;
                <small class="text-muted" style='font-weight:300;'> 스키장별로 개설된 응시일정을 확인하고, 선택하세요. (비공개 행사의 경우, 회원에 따라, 아래
                    목록에 나타나지 않을수 있습니다.)
                </small>
            </h5>

            <div class="card-body">

                <div class="row gy-3">
                    <div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>


                    <?php for ($i = 0; $row = sql_fetch_array($result); $i++) {

                        $display_test = 'Y';
                        if ($row['Is_private'] == 'Y') { // 만일 개별검정이면
                            $arr = explode(',', $row['Subject_lists'], 100); //등록된 대상자를 콤마단위로 최대 100개까지만 가져오자

                            $arr = array_map('trim', $arr);
                            if (in_array($mb_id, $arr)) {
                                $display_test = 'Y';
                            } else {
                                $display_test = 'N';
                            }
                        }

                        if ($display_test == 'Y') { //공개여부처리 시작

                    ?>

                    <div class="basic_info" style="width: 100%;">
                        <dl>
                            <dt>
                                <span style='padding-right:20px;'>
                                    <?php echo "[일정] <br> " . $row['T_date']; ?>
                                </span>
                            </dt>
                            <dd>

                                <?php
                                        $T_code = $row['T_code'] ?? '';
                                        $query = "select count(*) as CNT from {$Table_T1_Apply} where T_code = '{$T_code}' 
                            and PAYMENT_STATUS = 'Y'"; //응시자수 계산

                                        $row_cnt = sql_fetch($query);
                                        $total_cnt = $row_cnt['CNT'];

                                        echo "<span class='badge rounded-pill bg-danger'>최대: " . $row['limit_member'] . "명, 현재: " . $total_cnt . "명</span>";
                                        if ($row['Is_private'] == 'Y') { // 만일 비공개검정이면
                                            echo "<span class='badge rounded-pill bg-success'>비공개검정</span>  ";
                                        }

                                        // echo "<span class='badge rounded-pill bg-info'>" . $row['T_code'] . "</span> | ";
                                        // echo "<small>접수기간 :</small> " . $row['Application_Day'] . " ~ " . $row['Expired_Day'] . " | ";
                                        // echo "<small>장소 : </small>" . $row['T_meeting'] . " | ";
                                        // echo "<small>시간 : </small>" . $row['T_time'] . " | ";
                                        // echo "<small>문의 : </small>" . $row['T_tel'] . " | ";

                                        echo "<span class='badge rounded-pill bg-info'>" . ($row['T_code'] ?? '') . "</span> | ";
                                        echo "<small>접수기간 :</small> " . ($row['Application_Day'] ?? '') . " ~ " . ($row['Expired_Day'] ?? '') . " | ";
                                        echo "<small>장소 : </small>" . ($row['T_meeting'] ?? '') . " | ";
                                        echo "<small>시간 : </small>" . ($row['T_time'] ?? '') . " | ";
                                        echo "<small>문의 : </small>" . ($row['T_tel'] ?? '') . " | ";

                                        $T_Date = $row['T_date'] ?? '';
                                        $to_date = date("Y-m-d");




                                        $enable_apply = 'YES';
                                        if ($row['T_date'] < $to_date) {
                                            $enable_apply = 'NO';
                                            echo "<span class='badge rounded-pill bg-danger'>일정경과</span>";
                                        }
                                        if (($row['Application_Day'] > $to_date)) { //접수기간 이전
                                            $enable_apply = 'NO';
                                            echo "<span class='badge rounded-pill bg-danger'>접수대기</span>";
                                        }
                                        if (($row['Expired_Day'] < $to_date)) { //접수기간 종료
                                            $enable_apply = 'NO';
                                            echo "<span class='badge rounded-pill bg-danger'>접수일 경과</span>";
                                        }

                                        if ($total_cnt >= $row['limit_member']) {
                                            echo "<span class='badge rounded-pill bg-danger'>마감완료</span>";
                                        }

                                        ?>

                                <?php
                                        if ($enable_apply == 'YES') {
                                            echo "<button type=\"button\" class=\"btn btn-primary\" onclick=\"location.href='sbak_console_T1_test_apply_2.php?t_code=" . $row['T_code'] . "&sports=" . $the_sports . "&event_code=" . $event_code . "'\"> 응시신청 </button>";
                                        }
                                        ?>
                            </dd>
                        </dl>
                    </div>
                    <?php  } //공개여부처리끝
                        ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <br><br>


    <?php break;
    } //switch문 끝내기 
    ?>


</div>