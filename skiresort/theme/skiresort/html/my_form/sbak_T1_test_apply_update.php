<?php
include_once('./header_console.php'); //공통 상단을 연결합니다.
header('Content-Type: text/html; charset=utf-8');

$refer = $_SERVER['HTTP_REFERER'] ?? '';

if (!$refer) {
    alert("비정상적인 접속입니다.", G5_URL);
}
$T_code = $_POST['t_code'] ?? '';
$_POST['test_season'] = $_POST['test_season'] ?? '';
$_POST['w'] = $_POST['w'] ?? '';
$_POST['sports'] = $_POST['sports'] ?? '';
$unique_order_id = $_POST['unique_order_id'] ?? '';

if (empty($_POST['t_code']) || empty($_POST['test_season']) || empty($_POST['w']) || empty($_POST['sports'])) {
    alert('비정상적인 접속입니다.', $refer);
}

if ($_POST['w'] !== 'yes') {
    alert('비정상적인 접속입니다.', $refer);
}


//창 닫혔는데, 새로고침 안하고 뒤로가기 해서 접근할 경우, 결제 프로세스 접근을 제한하자.

$sql = "select exists (select UID from {$Table_Mainpay} where Unique_order_id = '{$unique_order_id}' limit 1) as EXIST";
$row = sql_fetch($sql);


if (!empty($unique_order_id) && $row['EXIST'] > 0) {
    alert("이미 한번 처리된 신청건입니다. 결제창 닫기, 오류 등으로 재결제시에는, 처음부터 재신청해주세요.", $return_url);
}






$T_code = $_POST['t_code'] ?? '';
$TEST_YEAR = $_POST['test_season'] ?? '';
$T_Date = $_POST['t_date'] ?? '';
$REFUND_ACCOUNT = $_POST['t_bank_info'] ?? '';
$PHONE = $_POST['t_tel'] ?? '';
$PAYMETHOD = $_POST['the_paymethod'] ?? '';
$on_email = $_POST['on_email'] ?? '';

$REGIST_DATE = date("Y-m-d");
$REGIST_TIME = date("H:i:s");

$sports = $_POST['sports'] ?? '';
if ($sports == 'ski') {
    $TYPE = '스키';
    $event_code = 'B01';
} elseif ($sports == 'sb') {
    $TYPE = '스노보드';
    $event_code = 'B04';
} else {
    $TYPE = '';
}



$goto_url = G5_THEME_URL . "/html/my_form/sbak_console_T1_test.php?sports=" . $sports;





$sql = "select T_skiresort from {$Table_T1} where T_code = '{$T_code}' ";
$row = sql_fetch($sql);
$resort = $row['T_skiresort'] ?? '';


// 이미 레벨1 자격을 보유하고 있다면 에러처리
if ($sports == 'ski') {
    $license_table = $Table_Ski_Member;
} elseif ($sports == 'sb') {
    $license_table = $Table_Sb_Member;
} else {
    $license_table = '';
}
$sql = "select exists (select K_LICENSE from {$license_table} where K_BIRTH = '{$mb_birth}' and K_NAME = '{$mb_name}' and K_GRADE = 'T1' limit 1) as CHK_EXIST";

$row = sql_fetch($sql);

if ($row['CHK_EXIST'] > 0) {
    alert("동일 이름과 생년월일의 티칭1 자격이 이미 존재합니다.",  $goto_url);
}





$to_date = date("Y-m-d");
$sql = "select Application_Day, Expired_Day from from {$Table_T1} where T_code like '{$T_code}'";
$row = sql_fetch($sql);

if (($row['Application_Day'] > $to_date) || ($row['Expired_Day'] < $to_date)) {
    $enable_add = 'N';
} else {
    $enable_add = 'Y';
}



//검증 프로세스 시작
//이미  삭제된 시험코드면 에러처리
$sql = "select exists (select * from {$Table_T1} where T_code like '{$T_code}' and (T_status != '88' and T_status != '99') limit 1) as CHK_EXIST";
$row = sql_fetch($sql);

if ($row['CHK_EXIST'] < 1) {
    alert("해당 시험은 삭제된 시험입니다.", $refer);
}

//이미 해당 시험코드에 등록되어 있으면 에러처리
$sql = "select exists (select * from {$Table_T1_Apply} where T_code like '{$T_code}' and (MEMBER_ID like '{$mb_id}'  and PAYMENT_STATUS = 'Y') limit 1) as CHK_EXIST";
$row = sql_fetch($sql);

if ($row['CHK_EXIST'] > 0) {
    alert("이미 본 시험의 응시자로 등록되어 있는 이름입니다.", $refer);
}



//이미 해당 날짜에 등록된 검정이 있으면 에러처리
$sql = "select exists (select * from {$Table_T1_Apply} where T_Date = '{$T_Date}' and (MEMBER_ID like '{$mb_id}'  and PAYMENT_STATUS = 'Y') limit 1) as CHK_EXIST";
$row = sql_fetch($sql);

if ($row['CHK_EXIST'] > 0) {
    alert("해당 날짜에 이미 등록된 검정이 있습니다. 당일 중복신청이 불가합니다.", $refer);
}
//검증 프로세스 종료

// 사무국 설정 함수 로드
get_office_conf($event_code);



$return_url = "sbak_console_T1_test.php?sports={$sports}";
?>

<head>
    <?php if ($SCRIPT_API_URL == "mainpay.mobile-1.0.js") {  // Mobile 일때
        echo '<meta name="viewport" content="width=device-width, user-scalable=no">';
    } ?>
    <script src="https://api-std.mainpay.co.kr/js/<?php echo $SCRIPT_API_URL ?>"></script>
    <script type='text/javascript'>
        var READY_API_URL = "<?php echo $READY_API_URL; ?>";

        function payment() {

            if ("<?php echo $SCRIPT_API_URL; ?>" === "mainpay.mobile-1.0.js") {
                var request = mainpay_ready(READY_API_URL); // Mobile
            } else {
                var request = Mainpay.ready(READY_API_URL); // PC
            }

            request.done(function(response) {
                if (response.resultCode == '200') {
                    /* 결제창 호출 */
                    if ("<?php echo $SCRIPT_API_URL; ?>" === "mainpay.mobile-1.0.js") {
                        location.href = response.data.nextMobileUrl; // Mobile
                    } else {
                        Mainpay.open(response.data.nextPcUrl); // PC
                    }

                    return false;
                }
                alert("ERROR : " + JSON.stringify(response));
            });


        }
        window.onpopstate = function() {
            history.go(-1)
        };

        /* 결제 팝업이 닫혔을 경우 호출*/
        function mainpay_close_event() {

            alert("결제창이 닫혔습니다. 재시도하려면, 신청서를 다시 작성해주세요.");
            //location.href로 하지말고, replace로 해야 뒤로가기 페이지에서 삭제
            location.replace("<?php echo $return_url; ?>");
        }
    </script>
</head>


<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><?php echo $event_title; ?> <span class="text-muted fw-light">/ REGISTRATION</span></h4>
    <div class="alert  alert-dark mb-0" role="alert">
        각종 SBAK 행사에 온라인으로 신청하세요.

    </div> <br>

    <!-- 여기부터 -->

    <!-- 유효할 경우 참가폼 생성 시작 -->

    <form name="MAINPAY_FORM" id="MAINPAY_FORM">
        <input type="hidden" name="amount" value="<?php echo $event_entry_fee; ?>">
        <input type="hidden" name="goodsName" value="<?php echo $event_title; ?>">
        <input type="hidden" name="goodsCode" value="<?php echo $event_code; ?>">
        <input type="hidden" name="paymethod" value="<?php echo $PAYMETHOD; ?>">
        <input type="hidden" name="mb_name" value="<?php echo $mb_name; ?>">
        <input type="hidden" name="mb_id" value="<?php echo $mb_id; ?>">
        <input type="hidden" name="on_hp" value="<?php echo $PHONE; ?>">
        <input type="hidden" name="t_code" value="<?php echo $T_code; ?>">
        <input type="hidden" name="the_type" value="<?php echo $TYPE; ?>">
        <input type="hidden" name="event_year" value="<?php echo $TEST_YEAR; ?>">
        <input type="hidden" name="t_date" value="<?php echo $T_Date; ?>">
        <input type="hidden" name="the_email" value="<?php echo $on_email; ?>">
        <input type="hidden" name="unique_order_id" value="<?php echo $unique_order_id; ?>">



        <!-- Content -->
        <div class="row">

            <div class="col-xl-12">
                <!-- HTML5 Inputs -->
                <div class="card mb-4">
                    <h5 class="card-header">참가자정보<small class="text-muted"> 신청 후 정보수정은 불가능하며, 삭제 후 재등록만 가능하오니, 정확하게 입력하세요.</small></h5>

                    <div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>



                    <div class="card-body">


                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">응시코드</h6>
                            </label>
                            <div class="col-md-10">
                                <dl>
                                    <dd>
                                        <?php echo $T_code; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">구분</h6>
                            </label>
                            <div class="col-md-10">
                                <dl>
                                    <dd>
                                        <?php echo $TYPE; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">신청자</h6>
                            </label>
                            <div class="col-md-10">
                                <dl>
                                    <dd>
                                        <?php echo $mb_name; ?> (
                                        <?php echo $mb_id; ?> )
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-search-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">참가자명</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>

                                    <dd>
                                        <?php echo $mb_name; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>



                        <div class="mb-3 row">
                            <label for="html5-number-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">휴대폰번호(연락가능한)</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <?php echo $PHONE; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="html5-number-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">이메일</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <?php echo $on_email; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="html5-date-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">응시일</h6>
                            </label>
                            <div class="col-md-10">
                                <dl>
                                    <dd>
                                        <?php echo $T_Date; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="html5-date-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">결제금액</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <?php echo $event_entry_fee; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="html5-date-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">결제수단</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <?php echo $PAYMETHOD; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>




                        <div class="online_bt" style="float: right;">
                            <input type='hidden' name='payment_category' value='t1'>
                            <button type="button" class="btn btn-primary" id="btn_submit" onclick="payment()">결제하기</button>
                            &nbsp;&nbsp;
                            <button type="button" class="btn btn-danger" onclick="history.back()">취소</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <!-- 유효할 경우 참가폼 생성 끝 -->
</div>

<?php
include_once('./footr_console.php'); //공통 하단을 연결합니다.
?>