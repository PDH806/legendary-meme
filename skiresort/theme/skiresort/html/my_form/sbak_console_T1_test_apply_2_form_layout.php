<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가


?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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

        <?php

        $query = "SELECT  T_code, T_date, T_name, T_time, T_skiresort, T_meeting, T_tel, T_status  
            FROM {$Table_T1} WHERE T_code like '{$t_code}'";
        $result = sql_fetch($query);

        $resort_no = $result['T_skiresort'] ?? '';


        $query = "select RESORT_NAME from {$Table_Skiresort} where NO = {$resort_no}"; //스키장 자료 갖고오기
        $result5 = sql_fetch($query);
        $resort_name = $result5['RESORT_NAME'] ?? '';



        ?>

<!-- 참가약관 모달 -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-light">
				<h5 class="modal-title">
					<?php
					$arr = array('A01', 'A02', 'A03');
					if (in_array($event_code, $arr)) {
						$subtitle_rule = "서비스 이용 약관";
					} else {
						$subtitle_rule = "행사신청 약관";
					}
					echo $subtitle_rule;
					?>

				</h5>
			</div>

			<div class="modal-body" style="max-height:400px; overflow-y:auto; line-height:1.0;">
				<div style='padding:10px;border-radius:10px;background-color:#efefef'>
					<?php
					// 참가요강 내용 불러오기
					$sql = "SELECT wr_content FROM g5_write_sbak_event_rule WHERE wr_id = '{$event_rule}'";
					$row = sql_fetch($sql);
					echo nl2br($row['wr_content']); // 줄바꿈 유지
					?>
				</div>

			</div>

			<div class="modal-footer">
				<div class="d-inline-block border-bottom border-1 border-dark w-100 mt-2"> </div>
				<!-- 동의 체크박스 -->
				<div class="d-line-block mt-4">

					<label class="custom-control-label" for="agreeCheck">
						안내사항을 확인했고, <?php echo $subtitle_rule; ?>에 동의합니다. &nbsp;&nbsp;
						<input class="custom-control-input" type="checkbox" id="agreeCheck">
						<br><small class='text-danger'> (체크해야 확인버튼이 활성화 됨) </small>
					</label>
				</div>

				<button type="button" class="btn btn-primary" id="confirmBtn" disabled>확인</button>
				<button type="button" class="btn btn-info btn-sm" id="go_before" onclick="history.go(-1);">취소</button>
			</div>
		</div>
	</div>
</div>

        <form name="fwrite1" id="fwrite1" action="./sbak_T1_test_apply_update.php" onsubmit="return fwrite_submit(this)"
            method="post">

            <input type="hidden" name="t_code" value="<?php echo $t_code; ?>">
            <input type="hidden" name="test_season" value="<?php echo $test_season; ?>">
            <input type="hidden" name="sports" value="<?php echo $sports; ?>">
            <input type="hidden" name="t_date" value="<?php echo $result['T_date']; ?>">
            <input type="hidden" name="t_resort" value="<?php echo $resort_name; ?>">
            <input type="hidden" name="t_name" value="<?php echo $result['T_name']; ?>">
            <input type="hidden" name="w" value="yes">


            <div class="row">
                <div class="col-xl-12">
                    <div class="card mb-4">

                        <h5 class="card-header"> 기본 정보<small class="text-muted ">
                                <a href="<?php echo G5_THEME_URL ?>/html/my_form/sbak_console_T1_test.php?sports=<?php echo $the_sports; ?>"
                                    style="color:red; float:right;"><i class="bx bxs-cog bx-spin"></i> 신청내역보기</a></small>
                        </h5>
                        <div class="card-body">

                            <div class="row gy-3">
                                <div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>


                                <div class="basic_info">
                                    <dl>
                                        <dt>
                                            <span>응시코드</span>
                                        </dt>
                                        <dd>
                                            <?php
                                            echo $t_code;
                                            ?>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="basic_info">
                                    <dl>
                                        <dt>
                                            응시일
                                        </dt>
                                        <dd>
                                            <?php
                                            echo $result['T_date'];
                                            ?>
                                        </dd>
                                    </dl>
                                </div>
                                <div class="basic_info">
                                    <dl>
                                        <dt>
                                            스키장
                                        </dt>
                                        <dd>
                                            <?php
                                            echo $resort_name;
                                            ?>
                                        </dd>
                                    </dl>
                                </div>



                                <div class="basic_info">
                                    <dl>
                                        <dt>
                                            개최자
                                        </dt>
                                        <dd>
                                            <?php
                                            echo $result['T_name'];
                                            ?>
                                        </dd>
                                    </dl>
                                </div>


                                <div class="basic_info">
                                    <dl>
                                        <dt>
                                            집합시간/장소
                                        </dt>
                                        <dd>
                                            <?php
                                            echo $result['T_time'] . " / " . $result['T_meeting'];
                                            ?>
                                        </dd>
                                    </dl>
                                </div>


                                <div class="basic_info">
                                    <dl>
                                        <dt>
                                            <span>취소기간</span>
                                        </dt>
                                        <dd>
                                            <?php
                                            //정해진 날짜 이전만 취소 가능하게 설정

                                            $to_date = date("Y-m-d");
                                            $T_Date = $result['T_date'] ?? '';
                                            $timestamp = strtotime($T_Date);
                                            $past_timestamp = $timestamp - ($T1_before_days * 24 * 60 * 60);
                                            $until_date = date("Y-m-d", $past_timestamp);

                                            echo $T1_before_days . "일전(" . $until_date . ") 까지";
                                            ?>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="basic_info">
                                    <dl>
                                        <dt>
                                            <span>신청요강</span>
                                        </dt>
                                        <dd>
                                            <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=sbak_event_notice&wr_id=<?php echo $event_notice;?>">확인하기</a>
                                        </dd>
                                    </dl>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <br><br>

                <div class="col-xl-12">
                    <!-- HTML5 Inputs -->
                    <div class="card mb-4">

                        <h5 class="card-header"> 응시자 정보 <small class="text-muted "> 아래 항목을 입력하세요. </small>
                        </h5>
                        <div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>
                        <div class="card-body">

                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">
                                    <h6 class="mb-0">응시자명</h6>
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
                                <label for="html5-text-input" class="col-md-2 col-form-label">
                                    <h6 class="mb-0">ID</h6>
                                </label>
                                <div class="col-md-5">
                                    <dl>
                                        <dd>

                                            <?php echo $mb_id; ?>

                                        </dd>
                                    </dl>
                                </div>
                            </div>




                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">
                                    <h6 class="mb-0">휴대폰번호</h6>
                                </label>
                                <div class="col-md-5">
                                    <dl>
                                        <dd>
                                            <input class="form-control" type="text" name="t_tel" required class='required' placeholder="휴대폰번호를 숫자로만 입력하세요." oninput="autoHyphen(this)"
                                                maxlength="13" value="<?php echo $member['mb_hp']; ?>">
                                            <?php // 필수 입력이면 required class="required" 를 추가합니다.
                                            ?>
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
                                        <dd>
                                            <input class="form-control" type="text" name="on_email" placeholder="예) email@email.com">
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

                                            <input class="form-check-input" type="radio" name="the_paymethod" id="on_99" value="CARD" required class="required">
                                            <label for="on_99">신용카드</label>&nbsp;
                                            <?php // 필수 입력이면 required class="required" 를 추가합니다.
                                            ?>
                                            <input class="form-check-input" type="radio" name="the_paymethod" id="on_98" value="ACCT" required class="required">
                                            <label for="on_98">계좌이체</label>&nbsp;
                                            <?php // 필수 입력이면 required class="required" 를 추가합니다.
                                            ?>
                                        </dd>
                                    </dl>
                                </div>
                            </div>

                            <!-- <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">
                                    <h6 class="mb-0">사무국 메모</h6>
                                </label>
                                <div class="col-md-10">
                                    <dl>
                                        <dd>
                                            <input class="form-control" type="text" name="on_memo" placeholder="신청, 입금 등 관련하여 따로 사무국에 전달할 내용이 있으면 입력"
                                                style="max-width:100%;">
                                        </dd>
                                    </dl>
                                </div>
                            </div> -->



                            <div class="online_bt" style="float: right;">
                                <input type="submit" class="btn btn-primary" id="btn_submit" value="등록하기"> <!-- 이 라인을 수정,삭제하지 마세요.-->
                                &nbsp;&nbsp;<a href="javascript:history.back()" class="btn btn-danger">취소</a>
                            </div>

                        </div>
                    </div>
                </div>

        </form>



<?php break;
} //switch문 끝내기 
?>

</div>



<script>

document.addEventListener('DOMContentLoaded', function() {
	const modalElement = document.getElementById('termsModal');
	const modal = new bootstrap.Modal(modalElement, {
		backdrop: 'static',  // 바깥 클릭 방지
		keyboard: false      // ESC 키 방지
	});
	modal.show();

	const agreeCheck = document.getElementById('agreeCheck');
	const confirmBtn = document.getElementById('confirmBtn');

	// 체크 여부에 따라 버튼 활성화
	agreeCheck.addEventListener('change', function() {
		confirmBtn.disabled = !this.checked;
	});

	// 확인 버튼 클릭 시
	confirmBtn.addEventListener('click', function() {
		if (agreeCheck.checked) {
			modal.hide();
			document.getElementById('MAINPAY_FORM').style.display = 'block';
		} else {
			alert("참가약관에 동의해야 신청이 가능합니다.");
		}
	});
});
    //----------------------------------모달 컨트롤 끝	


    const autoHyphen = (target) => {
        target.value = target.value
            .replace(/[^0-9]/g, '')
            .replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`);
    }
</script>