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
    font-weight: bold;
}

.basic_info dd {
    flex: 1;
    margin: 0;
}
</style>

<div class="row">

    <div class="col-xl-12">
        <div class="card mb-4">


            <h5 class="card-header">행사정보 (<?php echo $test_season; ?> 시즌) <small class="text-muted "><a
                        href="<?php echo G5_THEME_URL ?>/html/my_form/sbak_console_T1_test.php?sports=<?php echo $the_sports; ?>"
                        style="color:red; float:right;"><i class="bx bxs-cog bx-spin"></i> 신청내역보기</a></small></h5>

            <div class="card-body">


                <div class="row gy-3">
                    <div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>

                    <div class="basic_info">
                        <dl>
                            <dt>
                                <span>기존 신청내역 관리</span>
                            </dt>
                            <dd>
                                우측상단의 신청내역관리 메뉴를 이용해, 기존 신청 시험의 진행상태/결과확인 등의 절차를 진행하세요.
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
                                <?php echo $event_birthdate; ?> 이전 출생자
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

if ($is_admin) {
    $the_proceed = 20;
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



    $query = "select exists (select T_skiresort from {$Table_T1} WHERE TEST_YEAR = {$test_season} and TYPE = {$the_type} 
    and (T_status != '88' && T_status != '99')) as CHK_EXIST";

    $chk_exists = sql_fetch($query);
    ?>

    <div class="card mb-4">


        <h5 class="card-header">티칭1 개최 목록&nbsp;&nbsp;<small class="text-muted "> 스키장별로 개설된 응시일정을 확인하고, 선택하세요. (숫자버튼
                클릭)</small>
        </h5>
        <div class="card-body">
            <div class="row gy-3">

                <?php
                if ($chk_exists['CHK_EXIST'] < 0) {
                    echo "<div class='online_box'>현재 등록된 시험이 없습니다.</div>";
                } else {
                    $query = "SELECT T_skiresort, T_where, count(*) as CNT FROM {$Table_T1} WHERE (TEST_YEAR = {$test_season} and TYPE = {$the_type}) 
                and (T_status != '88' && T_status != '99') group by T_skiresort"; //
                    $result = sql_query($query);

                    for ($i = 0; $row = sql_fetch_array($result); $i++) { ?>

                <div class="basic_info">
                    <dl>
                        <dt>
                            <span>
                                <?php
                                        $resort_no = $row['T_skiresort'] ?? '';
                                        $query = "select RESORT_NAME from {$Table_Skiresort} where NO = {$resort_no}"; //스키장 자료 갖고오기
                                        $result_3 = sql_fetch($query);
                                        echo $result_3['RESORT_NAME'] ?? '';
                                        ?></span>
                        </dt>
                        <dd>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="location.href='sbak_console_T1_test_apply_1.php?skiresort=<?php echo $row['T_skiresort']; ?>&sports=<?php echo $sports; ?>'"><?php echo $row['CNT']; ?></button>
                        </dd>
                    </dl>
                </div>
                <?php } ?>


            </div>
        </div>


        <br><br>

        <?php } ?>

    </div>




    <?php } //switch문 끝내기 
    ?>


</div>