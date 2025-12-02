<?php

include_once('./header_console.php'); //공통 상단을 연결합니다.
header('Content-Type: text/html; charset=utf-8');


if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가


$refer = $_SERVER['HTTP_REFERER'] ?? '';

$unique_order_id = $_POST['unique_order_id'] ?? '';


if (!$refer) {
    alert("정상적으로 접속하세요.!", G5_URL);
}


$the_insert_table = $Table_Master_Apply;


 if (isset($_POST['profile_update']) and $_POST['profile_update'] == "yes") {

    $uid = $_POST['uid'];
    $profile = $_POST['THE_PROFILE'];

    $sql = "update {$the_insert_table}  set THE_PROFILE = '{$profile}' where UID = {$uid}";
    sql_query($sql);

    alert("프로필이 수정되었습니다.", $refer);
} elseif ($_POST['w'] == "yes") {

    $event_code = $_POST['goodsCode'] ?? '';
    $return_url = "sbak_console_04.php";

    if (empty($event_code) || empty($unique_order_id)) {
        alert("비정상적인 접속입니다.!", $refer);
    }



    //창 닫혔는데, 새로고침 안하고 뒤로가기 해서 접근할 경우, 결제 프로세스 접근을 제한하자.

    $sql = "select exists (select UID from {$Table_Mainpay} where Unique_order_id = '{$unique_order_id}' limit 1) as EXIST";
    $row = sql_fetch($sql);


    if (!empty($unique_order_id) && $row['EXIST'] > 0) {
        alert("이미 한번 처리된 신청건입니다. 결제창 닫기, 오류 등으로 재결제시에는, 처음부터 재신청해주세요.", $return_url);
    }

    $sql = "select exists (select Event_status from {$Table_Office_Conf} where Event_code = '{$event_code}' limit 1) as CHK_EXIST";
    $row_cnt = sql_fetch($sql);

    if ($row_cnt['CHK_EXIST'] < 1) {
        alert("없는 행사입니다!", $refer);
    } else {

        // 사무국 설정 함수 로드
        get_office_conf($event_code);

       
    }




    //만일 이미 신청한 사람이면 에러처리


    $sql = "SELECT exists (select MB_ID from {$the_insert_table} where (EVENT_CODE = '{$event_code}' and MB_ID = '{$mb_id}') and
            (EVENT_YEAR = '{$event_year}' and PAYMENT_STATUS = 'Y') limit 1) as CHK_EXIST";

    $get_result = sql_fetch($sql);

    if ($get_result['CHK_EXIST'] > 0) {
        alert("이미 참가신청이 등록되어 있습니다. 재신청하려면, 기존 등록건을 삭제하고 재시도 하세요.", $refer);
    }


    $sql = "select count(*) as CNT from {$the_insert_table} where EVENT_CODE = '{$event_code}' and (EVENT_YEAR = '{$event_year}' and PAYMENT_STATUS = 'Y')";
    $limit_result = sql_fetch($sql);


    if ($limit_result['CNT'] >= $event_total_limit) {
        alert("현재 참가제한인원이 초과되어, 등록할 수 없습니다. 이후, 추가등록여부에 관해서는 별도의 공지사항에 따라주시기 바랍니다.", $refer);
    }
} else {

    alert("비정상적인 접속입니다!", $refer);
}

$event_title = $_POST['goodsName'] ?? '';
$APPLY_DATE = date("Y-m-d");
$APPLY_TIME = date("H:i:s");

$MB_LICENSE_NO = $_POST['mb_license_no'] ?? '';
$THE_GENDER = $_POST['the_gender'] ?? '';


$THE_TEL = $_POST['on_hp'] ?? '';
$THE_EMAIL = $_POST['on_email'] ?? '';

$THE_PROFILE = $_POST['the_profile'] ?? '';
$REFUND_ACCOUNT = $_POST['rf_account'] ?? '';
$ENTRY_INFO_1 = $_POST['entry_info_1'] ?? '';
$ENTRY_INFO_2 = $_POST['entry_info_2'] ?? ''; // 기선전 + 티칭3 여부
if ($ENTRY_INFO_2 == 'Y'){
    $sortCode = 'B03';
}
$ENTRY_INFO_3 = $_POST['entry_info_3'] ?? ''; //필기면제여부
$ENTRY_INFO_4 = $_POST['entry_info_4'] ?? ''; //필기면제사유
$ENTRY_INFO_5 = $_POST['entry_info_5'] ?? ''; //실기면제여부
$ENTRY_INFO_6 = $_POST['entry_info_6'] ?? ''; //실기면제사유
$level_check = $_POST['level_check'] ?? ''; //레벨2 보유자에 체크했을 경우
$event_year = $_POST['event_year'] ?? date("Y");
$PAY_METHOD = $_POST['paymethod'] ?? '';
$AMOUNT = $_POST['amount'] ?? 0;

$freepass_A = $_POST['freepass_A'] ?? ''; //필기 자동면제
$freepass_B = $_POST['freepass_B'] ?? ''; //실기 자동면제

if ($freepass_A == 'Y') {
    $ENTRY_INFO_3 = '예';
}

if ($freepass_B == 'Y') {
    $ENTRY_INFO_5 = '예';
}


// 업로드 디렉토리 (그누보드 data 디렉토리 활용 권장)

//---> 이 부분은...특정폴더에 파일이 엄청 많아질 경우, 관리문제때문에 폴더를 분할하는건 어떨지..예를 들어 년도($event_year)를 폴더명에 지정하든지...(순진251012)  -> O
//--> 그리고, 무조건 파일첨부관련 프로세스를 넣지 말고, 면제대상값이 넘어올 경우만 if(!empty($ENTRY_INFO=3) && $ENTRY_INFO_3 =='Y') 식으로 하여 처리하는게 어떨지...(순진251012) -> O

if (!empty($ENTRY_INFO_3) || !empty($ENTRY_INFO_5) || !empty($level_check)) {

    $upload_dir = G5_DATA_PATH . "/file/my_upload/" . $event_year . "/";
    $upload_url = G5_DATA_URL . "/file/my_upload/" . $event_year . "/";


    if (!is_dir($upload_dir)) { //디렉토리가 존재하지 않을 때 자동으로 생성
        mkdir($upload_dir, 0755, true);
    }


    // 업로드된 파일 이름
    $upload_file = $_FILES['formFile_1']['tmp_name'] ?? '';
    $filename    = $_FILES['formFile_1']['name'] ?? '';

    $upload_file2 = $_FILES['formFile_2']['tmp_name'] ?? '';
    $filename2    = $_FILES['formFile_2']['name'] ?? '';

    $upload_file3 = $_FILES['formFile_3']['tmp_name'] ?? '';
    $filename3    = $_FILES['formFile_3']['name'] ?? '';


    // 파일 업로드 (덮어쓰기 방지)
    if ($upload_file) {
        $dest_file = $upload_dir . '/' . $filename;
    }
    // 파일 업로드 (덮어쓰기 방지)
    if ($upload_file2) {
        $dest_file2 = $upload_dir . '/' . $filename2;
    }

    // 파일 업로드 (덮어쓰기 방지)
    if ($upload_file3) {
        $dest_file3 = $upload_dir . '/' . $filename3;
    }

    if (move_uploaded_file($upload_file, $dest_file)) {
        // echo "업로드 성공";
    } else {
        // echo "업로드 실패";
    }

    if (move_uploaded_file($upload_file2, $dest_file2)) {
        // echo "업로드 성공2";
    } else {
        // echo "업로드 실패2";
    }

    if (move_uploaded_file($upload_file3, $dest_file3)) {
        // echo "업로드 성공2";
    } else {
        // echo "업로드 실패2";
    }
}

$IS_DEL = "";

// echo  "업로드파일" . $upload_file3;
// echo  "파일명" . $filename3;


?>

<head>
    <?php if ($SCRIPT_API_URL == "mainpay.mobile-1.0.js") {  // Mobile 일때
        echo '<meta name="viewport" content="width=device-width, user-scalable=no">';
    } ?>
    <script src="https://api-std.mainpay.co.kr/js/<?php echo $SCRIPT_API_URL ?>"></script>
    <script type='text/javascript'>
    var READY_API_URL = "<?php echo $READY_API_URL; ?>";


    function ajax_chk_register() {
        var event_code = "<?php echo $event_code; ?>";
        var event_year = "<?php echo $event_year; ?>";
        var mypage = "sbak_console_01.php";


        $.ajax({
            type: "POST",
            url: "ajax_chk_register.php",

            data: {
                event_code: event_code,
                event_year: event_year
            },
            dataType: "text",
            success: function(result) {


                // E1 접수기간 이전  E2 접수기간 이후 E3 사무국 폐쇄  E4 이미 등록  E5 인원초과
                if (result == 'E2') {
                    if (confirm("접수기간이 종료되었습니다. 마이페이지로 돌아가시겠습니까? ")) {
                        location.replace(mypage);
                    }
                    return false;
                }
                if (result == 'E3') {
                    if (confirm("사무국에서 접수를 종료한 업무입니다. 마이페이지로 돌아가시겠습니까? ")) {
                        location.replace(mypage);
                    }
                    return false;
                }
                if (result == 'E4') {
                    if (confirm("이미 등록 완료한 회원입니다. 재등록하려면, 기존 신청건을 삭제하고 다시 시도하세요.. 마이페이지로 돌아가시겠습니까? ")) {
                        location.replace(mypage);
                    }
                    return false;
                }
                if (result == 'E5') {
                    if (confirm("등록인원이 마감되었습니다. 요강을 확인하세요. 마이페이지로 돌아가시겠습니까? ")) {
                        location.replace(mypage);
                    }
                    return false;
                }
                if (result == 'E100') {
                    if (confirm("비정상적인 접근입니다. 마이페이지로 돌아가시겠습니까? ")) {
                        location.replace(mypage);
                    }
                    return false;
                }
                if (result == 'E200') {
                    payment();
                }
                return;



            },
            error: function(e) {
                alert("결제시스템에 장애가 발생했습니다.");
                return false;
            }
        });
    }



    function payment() {


        <?php

            // 혹시 모를 임의 접속을 대비해서, payment 함수 띄우기 전에 다시한번 중복주문번호 체크
            $sql = "select exists (select UID from {$Table_Mainpay} where Unique_order_id = '{$unique_order_id}' limit 1) as EXIST";
            $row = sql_fetch($sql);
            if (!empty($unique_order_id) && $row['EXIST'] > 0) {
                alert("이미 한번 처리된 신청건입니다. 결제창 닫기, 오류 등으로 재결제시에는, 처음부터 재신청해주세요.", $return_url);
                exit;
            } else {  //정상적인 등록이면

            ?>



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


        <?php } ?>

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

    <h4 class="fw-bold py-3 mb-4"><?php echo $event_title; ?> <span class="text-muted fw-light">/ REGISTRATION</span>
    </h4>
    <div class="alert  alert-dark mb-0" role="alert">
        각종 행사에 온라인으로 신청하세요.
    </div> <br>

    <!-- 여기부터 -->

    <!-- 유효할 경우 참가폼 생성 시작 -->

    <form name="MAINPAY_FORM" id="MAINPAY_FORM">
        <input type="hidden" name="goodsCode" value="<?php echo $event_code; ?>">
        <input type="hidden" name="goodsName" value="<?php echo $event_title; ?>">
        <input type="hidden" name="event_year" value="<?php echo $event_year; ?>">
        <input type="hidden" name="amount" value="<?php echo $AMOUNT; ?>">
        <input type="hidden" name="paymethod" value="<?php echo $PAY_METHOD; ?>">
        <input type="hidden" name="on_hp" value="<?php echo $THE_TEL; ?>">
        <input type="hidden" name="the_profile" value="<?php echo $THE_PROFILE; ?>">
        <input type="hidden" name="entry_info_1" value="<?php echo $ENTRY_INFO_1; ?>">
        <input type="hidden" name="entry_info_2" value="<?php echo $ENTRY_INFO_2; ?>">
        <input type="hidden" name="entry_info_3" value="<?php echo $ENTRY_INFO_3; ?>">
        <input type="hidden" name="entry_info_4" value="<?php echo $ENTRY_INFO_4; ?>">
        <input type="hidden" name="entry_info_5" value="<?php echo $ENTRY_INFO_5; ?>">
        <input type="hidden" name="entry_info_6" value="<?php echo $ENTRY_INFO_6; ?>">
        <input type="hidden" name="mb_license_no" value="<?php echo $MB_LICENSE_NO; ?>">
        <input type="hidden" name="filename1" value="<?php echo $filename; ?>">
        <input type="hidden" name="filename2" value="<?php echo $filename2; ?>">
        <input type="hidden" name="filename3" value="<?php echo $filename3; ?>">

        <input type="hidden" name="mb_name" value="<?php echo $mb_name; ?>">
        <input type="hidden" name="mb_id" value="<?php echo $mb_id; ?>">
        <input type="hidden" name="the_gender" value="<?php echo $THE_GENDER; ?>">
        <input type="hidden" name="the_email" value="<?php echo $THE_EMAIL; ?>">
        <input type="hidden" name="the_birth" value="<?php echo $mb_birth; ?>">
        <input type="hidden" name="unique_order_id" value="<?php echo $unique_order_id; ?>">
        <input type="hidden" name="sortCode" value="<?php echo $sortCode; ?>">

        <!-- Content -->
        <div class="row">

            <div class="col-xl-12">
                <!-- HTML5 Inputs -->
                <div class="card mb-4">
                    <h5 class="card-header">참가자정보<small class="text-muted"> 신청 후 정보수정은 불가능하며, 삭제 후 재등록만 가능하오니, 정확하게
                            확인하세요.</small></h5>

                    <div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>


                    <div class="card-body">


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



                        <?php

                        $arr = array('B02', 'B03', 'B05', 'B06', 'C01');

                        if (in_array($event_code, $arr)) { //스키티칭2,3,기선전, 보드티칭 2,3 이면 
                        ?>

                        <div class="mb-3 row">
                            <label for="html5-email-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">자격번호</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <?php echo $MB_LICENSE_NO; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <?php } ?>


                        <div class="mb-3 row">
                            <label for="html5-tel-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">생년월일</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <?php echo $mb_birth; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-password-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">성 별</h6>
                            </label>
                            <div class="col-md-10">
                                <dl>
                                    <dd>
                                        <?php echo $THE_GENDER; ?>
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
                                        <?php echo $THE_TEL; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>





                        <?php if ($event_code == "B03") { //티칭3 
                        ?>
                        <div class="mb-3 row">
                            <label for="html5-date-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">참가행사</h6>
                            </label>
                            <div class="col-md-10">
                                <dl>
                                    <dd>
                                        <?php echo $ENTRY_INFO_1; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <?php } ?>




                        <div class="mb-3 row">
                            <label for="html5-date-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">결제금액</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <?php echo $AMOUNT; ?>
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
                                        <?php echo $PAY_METHOD; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>





                        <?php if ($event_code == "C01") { //스키기선전이면 
                        ?>

                        <div class="mb-3 row">
                            <label for="html5-date-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">장내 방송멘트</h6>
                            </label>
                            <div class="col-md-10">
                                <dl>
                                    <dd>
                                        <?php echo $THE_PROFILE; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="online_bt" style="float: right;">
                            <input type='hidden' name='payment_category' value='event'>
                            <button type="button" class="btn btn-primary" id="btn_submit"
                                onclick="ajax_chk_register()">결제하기</button>
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
include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
?>