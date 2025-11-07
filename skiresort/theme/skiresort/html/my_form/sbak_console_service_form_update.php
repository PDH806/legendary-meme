<?php

include_once('./header_console.php'); //공통 상단을 연결합니다.

if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가


$refer = $_SERVER['HTTP_REFERER'] ?? '';
$event_code = $_POST['product_code'] ?? '';
$unique_order_id = $_POST['unique_order_id'] ?? '';

$return_url = 'sbak_console_02.php';

if (!$refer) {
    alert("비정상적인 접속입니다!", G5_URL);
}

if (empty($event_code) || empty($unique_order_id) || empty($refer)) {
    alert("비정상적인 접속입니다!", $refer);
}



//창 닫혔는데, 새로고침 안하고 뒤로가기 해서 접근할 경우, 결제 프로세스 접근을 제한하자.

$sql = "select exists (select UID from {$Table_Mainpay} where Unique_order_id = '{$unique_order_id}' limit 1) as EXIST";
$row = sql_fetch($sql);


if (!empty($unique_order_id) && $row['EXIST'] > 0) {
    alert("이미 한번 처리된 신청건입니다. 결제창 닫기, 오류 등으로 재결제시에는, 처음부터 재신청해주세요.", $return_url);
}

$the_insert_table = $Table_Service_List;


$arr = array('A01', 'A02', 'A03');

if (in_array($event_code, $arr)) { //product_code가 유효하다면


        // 사무국 설정 함수 로드
        get_office_conf($event_code);
        

        // e-mail 체크

        $MEMBER_ID = $member['mb_id'] ?? '';
        $MEMBER_NAME = $member['mb_name'] ?? '';
        $MEMBER_PHONE = $_POST['on_hp'] ?? '';
        $MEMBER_EMAIL = $on_email;
        $MEMBER_EMAIL = $_POST['on_email'] ?? '';
        $ZIP = $_POST['post_code'] ?? '';
        $ADDR1 = $_POST['road_address'] ?? '';
        $ADDR2 = $_POST['detail_address'] ?? '';
        $ADDR3 = $_POST['extra_address'] ?? '';
        $LICENSE_NO = $_POST['license_no'] ?? '';
        $event_code = $_POST['product_code'] ?? '';
        $AMOUNT = $_POST['amount'] ?? '';
        $PAYMETHOD = $_POST['the_paymethod'] ?? '';
        $PRODUCT_NAME = $event_title ?? '';
        $CATE_1 = $_POST['the_sports'] ?? '';
        $DEPOSITOR = $_POST['on_depositor_name'] ?? '';

        // 동일날짜, 동일서비스코드, 동일종목에 결제내역이 있으면 못하게 막자
        $this_date = date("Y-m-d");

        $sql_duplicate = "select exists (select UID from {$the_insert_table} where MEMBER_ID = '{$mb_id}' 
                         and (PRODUCT_CODE = '{$event_code}' and CATE_1 = '{$CATE_1}') and 
                         (REGIS_DATE = '{$this_date}' and PAYMENT_STATUS = 'Y') limit 1) as CHK_EXIST";


        $result_duplicate = sql_fetch($sql_duplicate);



        if ($result_duplicate['CHK_EXIST'] > 0) {
            alert("오늘 날짜에 신청된 동일민원이 있습니다. 재신청하시려면 기존 신청내역을 삭제하고, 다시 시도하세요.", G5_THEME_URL . "/html/my_form/sbak_console_05.php");
        }

} else {

    alert("비정상적인 접속입니다.", $refer);
}

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

    <h4 class="fw-bold py-3 mb-4"><?php echo $event_title; ?> <span class="text-muted fw-light">/ ORDER CONFIRM</span></h4>
    <div class="alert  alert-dark mb-0" role="alert">
        정보입력 확인 및 결제가 진행됩니다.

    </div> <br>


    <!-- 여기부터 -->

    <!-- 유효할 경우 참가폼 생성 시작 -->

    <form name="MAINPAY_FORM" id="MAINPAY_FORM">


<input type="hidden" name="mb_id" value="<?php echo $MEMBER_ID ?>">
<input type="hidden" name="mb_name" value="<?php echo $MEMBER_NAME ?>">
<input type="hidden" name="on_hp" value="<?php echo $MEMBER_PHONE ?>">
<input type="hidden" name="the_email" value="<?php echo $MEMBER_EMAIL ?>">
<input type="hidden" name="mb_license_no" value="<?php echo $LICENSE_NO ?>">
<input type="hidden" name="goodsCode" value="<?php echo $event_code ?>">
<input type="hidden" name="goodsName" value="<?php echo $PRODUCT_NAME ?>">
<input type="hidden" name="paymethod" value="<?php echo $PAYMETHOD ?>">
<input type="hidden" name="amount" value="<?php echo $AMOUNT ?>">

<input type="hidden" name="ZIP" value="<?php echo $ZIP ?>">
<input type="hidden" name="ADDR1" value="<?php echo $ADDR1 ?>">
<input type="hidden" name="ADDR2" value="<?php echo $ADDR2 ?>">
<input type="hidden" name="ADDR3" value="<?php echo $ADDR3 ?>">
<input type="hidden" name="CATE_1" value="<?php echo $CATE_1 ?>">

<input type="hidden" name="unique_order_id" value="<?php echo $unique_order_id; ?>">


<!-- Content -->
<div class="row">

    <div class="col-xl-12">
        <!-- HTML5 Inputs -->
        <div class="card mb-4">
            <h5 class="card-header">신청정보<small class="text-muted">에 이상이 없으면, 결제를 진행하세요.</small></h5>

            <div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>

            <style>
                .input_value_prn {
                    color: black;
                    border: 1px solid #adacacff;
                    padding: 10px;
                    width: 100%;
                }
            </style>


<div class="card-body">





    <div class="mb-3 row">
        <label for="html5-text-input" class="col-md-2 col-form-label">
            <h6 class="mb-0">회원정보</h6>
        </label>
        <div class="col-md-5">
            <dl>
                <dd>
                    <input type="text" class="input_value_prn"
                        value="<?php echo $member['mb_name']; ?> (<?php echo $member['mb_id']; ?> )" readonly>
                </dd>
            </dl>
        </div>
    </div>




    <div class="mb-3 row">
        <label for="html5-email-input" class="col-md-2 col-form-label">
            <h6 class="mb-0">종목</h6>
        </label>
        <div class="col-md-5">
            <dl>
                <dd><input type="text" class="input_value_prn"
                        value="<?php echo $CATE_1; ?>" readonly>
                </dd>
            </dl>
        </div>
    </div>


    <div class="mb-3 row">
        <label for="html5-url-input" class="col-md-2 col-form-label">
            <h6 class="mb-0">자격번호</h6>
        </label>
        <div class="col-md-5">
            <dl>
                <dd><input type="text" class="input_value_prn"
                        value="<?php echo $LICENSE_NO; ?>" readonly>
                </dd>
            </dl>
        </div>
    </div>


    <div class="mb-3 row">
        <label for="html5-date-input" class="col-md-2 col-form-label">
            <h6 class="mb-0">휴대폰번호</h6>
        </label>
        <div class="col-md-5">
            <dl>
                <dd><input type="text" class="input_value_prn"
                        value="<?php echo $MEMBER_PHONE; ?>" readonly>
                </dd>
            </dl>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="html5-date-input" class="col-md-2 col-form-label">
            <h6 class="mb-0">이메일</h6>
        </label>
        <div class="col-md-5">
            <dl>
                <dd><input type="text" class="input_value_prn"
                        value="<?php echo $MEMBER_EMAIL; ?>" readonly>
                </dd>
            </dl>
        </div>
    </div>

    <?php if ($event_code !== 'D01' && $event_code !== 'D02') { ?>
        <div class="mb-3 row">
            <label for="html5-date-input" class="col-md-2 col-form-label">
                <h6 class="mb-0">배송주소</h6>
            </label>
            <div class="col-md-5">
                <dl>
                    <dd>
                        <?php echo $ZIP; ?><br>
                        <?php echo $ADDR1; ?><br>
                        <?php echo $ADDR2; ?><br>
                        <?php echo $ADDR3; ?><br>
                    </dd>
                </dl>
            </div>
        </div>
    <?php } ?>

    <div class="mb-3 row">
        <label for="html5-date-input" class="col-md-2 col-form-label">
            <h6 class="mb-0">결제수단</h6>
        </label>
        <div class="col-md-5">
            <dl>
                <dd>
                    <span style='color:blue;border:2px solid blue;border-radius:10px;padding:5px 40px 10px 40px;'>
                        <?php
                        if ($PAYMETHOD == 'CARD') {
                            $PAYMETHOD = '신용카드';
                        } else {
                            $PAYMETHOD = '계좌이체';
                        }
                        echo $PAYMETHOD; ?>
                    </span>

                    <span style="color:red;padding-left:50px;"><?php echo $event_entry_fee; ?></span> 원
                </dd>
            </dl>
        </div>
    </div>


    <hr style="margin-bottom:30px;">


    <div class="online_bt" style="float: right;">
        <input type='hidden' name='payment_category' value='service'>
        <button type="button" class="btn btn-primary" id="btn_submit" onclick="payment()">결제하기</button>

        &nbsp;&nbsp;
        <button type="button" class="btn btn-danger" onclick="history.back()">뒤로</button>

        <br><br>

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