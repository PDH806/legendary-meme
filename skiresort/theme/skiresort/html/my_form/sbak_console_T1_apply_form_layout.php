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

            <h5 class="card-header">행사정보 (
                <?php echo $test_season; ?> 시즌)&nbsp;&nbsp;
                <small class="text-muted "> 반드시 확인하세요.
                    <a href="<?php echo G5_THEME_URL ?>/html/my_form/sbak_console_T1_test_open_list.php?sports=<?php echo $the_sports; ?>"
                        style="color:red; float: right;"><i class='bx bxs-cog bx-spin'></i> 티칭1 상세관리</a>
                </small>
            </h5>
            <div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>
            <div class="card-body">




                <div class="row gy-3">


                    <div class="basic_info">
                        <dl>
                            <dt>
                                <span>관리자</span>
                            </dt>
                            <dd>
                                <?php echo $member['mb_name']; ?> (
                                <?php echo $member['mb_id']; ?> )
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
                                <span>개최장소</span>
                            </dt>
                            <dd>
                                <?php echo $resort_name; ?>
                            </dd>
                        </dl>
                    </div>
                    <div class="basic_info">
                        <dl>
                            <dt>
                                <span>종목</span>
                            </dt>
                            <dd>
                                <?php echo $event_title_1; ?>
                            </dd>
                        </dl>
                    </div>



                </div>
            </div>
        </div>

    </div>


    <?php // 조건에 따라 출력폼 표출여부 결정 시작



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

	if ($is_admin or $member['mb_id'] == 'admin01') { //어드민이거나 테스트아이디이면 무조건 출력
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

		default: // 모든 것이 유효할 경우 참가신청 등록 가능처리			

			// 조건에 따라 출력폼 표출여부 결정 종료

	?>
    <br><br>

    </span>
    </h2>
    <br><br>

    <form name="fwrite" id="fwrite" action="./sbak_T1_apply_update.php" onsubmit="return fwrite_submit(this)"
        method="post">

        <input type="hidden" name="is_group" value="Y">
        <input type="hidden" name="sports" value="<?php echo $the_sports; ?>">
        <input type="hidden" name="event_code" value="<?php echo $event_code; ?>">
        <input type="hidden" name="test_year" value="<?php echo $test_season; ?>">
        <input type="hidden" name="event_entry_fee" value="<?php echo $event_entry_fee; ?>">
        <input type="hidden" name="w" value="yes">


        <!-- Content -->
        <div class="row">

            <div class="col-xl-12">
                <!-- HTML5 Inputs -->
                <div class="card mb-4">
                    <h5 class="card-header">티칭1 등록</h5>

                    <div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>

                    <div class="card-body">

                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">접수기간</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <input class="form-control" type="date" name="apply_start" id="apply_start"
                                            placeholder="시작일" value="">
                                        <span>~</span>
                                        <input class="form-control" type="date" name="apply_end" id="apply_end"
                                            placeholder="마감일" value="">
                                    </dd>
                                </dl>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">개최스키장</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <input class="form-control" type="hidden" name="t_where" id="t_where"
                                            value="<?php echo $resort_no; ?>">
                                        <input class="form-control" type="text" name="resort_name" id="resort_name"
                                            readonly value="<?php echo $resort_name; ?>">
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">개최일</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <input class="form-control" type="date" name="t_date" id="t_date"
                                            placeholder="검정일자를 입력하세요." value="">
                                    </dd>
                                </dl>
                            </div>
                        </div>



                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">참가인원</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <input class="form-control" type="number" name="limit_member" id="limit_member"
                                            value="" placeholder="숫자로만 입력" required>
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">집합시간</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <input class="form-control" type="time" name="t_time"
                                            placeholder="검정당일 집합시간을 입력하세요." value="">
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">집합장소</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <input class="form-control" type="text" name="t_meeting"
                                            placeholder="응시자들과 만날 장소를 입력하세요.(예 : 시계탑앞)" required>
                                    </dd>
                                </dl>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">휴대폰</h6>
                            </label>
                            <div class="col-md-5">
                                <dl>
                                    <dd>
                                        <input class="form-control" type="text" name="t_tel"
                                            placeholder="담당자의 휴대폰번호를 숫자로만 입력하세요." oninput="autoHyphen(this)"
                                            maxlength="13" value="<?php echo $mb_hp; ?>" required>

                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-date-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0">비공개검정 </h6>
                            </label>
                            <div class="col-md-10">
                                <dl>
                                    <dd>
                                        <input class="form-check-input" type="checkbox" name="is_private"
                                            id="Is_private" value="Y" class="Is_private"> <label for="Is_private">비공개
                                            (아이디로 신청자격 제한시 체크)</label><br class="sview">

                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div class="mb-3 row" id="id_lists" style="display:none;">
                            <label for="html5-date-input" class="col-md-2 col-form-label">
                                <h6 class="mb-0" style="color:blueviolet;font-weight:400;">[대상자 회원 ID]</h6>
                            </label>
                            <div class="col-md-12">
                                <dl>
                                    <dd>
                                        <textarea style="width:100%" name="target_id_list" rows=6
                                            placeholder="아이디(대소문자 구분)를 콤마로 구분하여 입력하세요."></textarea>
                                    </dd>
                                </dl>
                            </div>
                        </div>


                        <div class="online_bt" style="float: right;">
                            <input type="submit" class="btn btn-primary" id="btn_submit" value="등록하기">
                            <!-- 이 라인을 수정,삭제하지 마세요.-->
                            &nbsp;&nbsp;<a href="javascript:history.back()" class="btn btn-danger">취소</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <br><br>

    </form>



    <?php } //switch문 끝내기 
	?>
</div>


<script>
function fwrite_submit(f) {

    var apply_start = f.apply_start.value;
    if (apply_start == '') {
        alert("신청기간(시작일) 을 입력하세요.");
        return false;
    }

    const startVal = document.getElementById("apply_start").value;
    const endVal = document.getElementById("apply_end").value;
    const testVal = document.getElementById("t_date").value;

    if (startVal && endVal) {
        const startDate = new Date(startVal);
        const endDate = new Date(endVal);

        // 1. 마감일이 시작일보다 앞서면 오류
        if (startDate > endDate) {
            alert("신청 마감일은 접수 시작일보다 이후여야 합니다.");
            return false;
        }

        // 2. 응시일이 마감일보다 앞서면 오류
        if (testVal) {
            const testDate = new Date(testVal);
            if (testDate < endDate) {
                alert("시험개최일은 접수 마감일 이후여야 합니다.");
                return false;
            }
        }
    }


    var apply_end = f.apply_end.value;
    if (apply_end == '') {
        alert("신청기간(마감일) 을 입력하세요.");
        return false;
    }

    var t_meeting = f.t_meeting.value;
    if (t_meeting == '') {
        alert("집합장소를 입력하세요.");
        return false;
    }

    var limit_member = f.limit_member.value;
    if (limit_member < 3) {
        alert("참가인원은 3명 이상이어야 합니다.");
        return false;
    }

    var t_date = f.t_date.value;
    if (t_date == '') {
        alert("개최일을 입력하세요.");
        return false;
    }

    var t_time = f.t_time.value;
    if (t_time == '') {
        alert("집합시간을 입력하세요.");
        return false;
    }

    var t_tel = f.t_tel.value;
    if (t_tel == '') {
        alert("휴대폰번호를 입력하세요.");
        return false;
    }

    var t_private = f.is_private;
    var t_id_list = f.target_id_list.value;
    if (t_private.checked) {
        if (t_id_list == '') {
            alert("응시 대상자 아이디를 입력하세요.");
            return false;
        }
    }



    return true;

}



const autoHyphen = (target) => {
    target.value = target.value
        .replace(/[^0-9]/g, '')
        .replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`);
}


// 체크박스 클릭 이벤트
document.getElementById("Is_private").addEventListener("change", function() {
    const block = document.getElementById("id_lists");

    if (this.checked) {
        block.style.display = "block"; // 체크되면 보이기
    } else {
        block.style.display = "none"; // 체크 해제되면 숨기기  

    }
});
</script>