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
		<!-- HTML5 Inputs -->



		<div class="card mb-4">
			<h5 class="card-header">기본안내 <small class="text-muted "> 반드시 확인하세요.
					<?php

					echo "<a href='" . G5_THEME_URL . "/html/my_form/sbak_console_05.php' style='color:red; float:right;'><i
            class='bx bxs-cog bx-spin'></i> 전체신청내역확인</a>";
					?> </small></h5>
			<div class="card-body">


				<div class="row gy-3">
					<div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>

					<div class="basic_info">
						<dl>
							<dt>신청명</dt>
							<dd><span class="text-primary fw-bold"><?php echo $event_title; ?></span>
							</dd>
						</dl>
					</div>

					<div class="basic_info">
						<dl>
							<dt>발급수수료</dt>
							<dd><?php echo $event_entry_fee; ?> 원</dd>
						</dl>
					</div>

					<div class="basic_info">
						<dl>
							<dt>접수기간</dt>
							<dd><?php echo "<span class='text-primary'>" . $event_begin_date . "</span> " . $event_begin_time . "  ~  <span class='text-primary'>" . $event_end_date . "</span> " . $event_end_time; ?></dd>
						</dl>
					</div>

					<div class="basic_info">
						<dl>
							<dt>배송방법</dt>
							<dd> 택배 / 우편 </dd>
						</dl>
					</div>

					<div class="basic_info">
						<dl>
							<dt>결제방법</dt>
							<dd>
								신용카드 / 실시간이체
							</dd>
						</dl>
					</div>

				</div>
			</div>
		</div>





	</div>
</div>


<?php // 조건에 따라 출력폼 표출여부 결정 시작



if ($event_status == 'Y') { //사무국에서 막은거면
	$the_proceed = 1;
} else {

	//접수기간에 따른 메세지 만들기

	$time_now = strtotime(date("Y-m-d H:i:s"));


	$time_begin = $event_begin_date . " " . $event_begin_time;
	$time_begin = strtotime($time_begin);

	$time_end = $event_end_date . " " . $event_end_time;
	$time_end = strtotime($time_end);


	if ($time_now < $time_begin) { //접수기간 전이면
		$the_proceed = 3;
	} elseif ($time_now > $time_end) { //접수마감 이후면
		$the_proceed = 4;
	}
}


if ($is_admin) {
	$the_proceed = 100;
}



switch ($the_proceed) {
	case 1:

		echo "<span style='color:red;font-size:1.2em;font-weight:600;'><i class='bx bx-block'></i> '";
		echo  $event_title . "'<span style='font-weight:500;'> 재고부족 또는 사무국의 행사 장기출장 등의 사유로 현재 신청할 수 없습니다.</span></span>";
		break;

	case 3:

		echo "<span style='color:red;font-size:1.2em;font-weight:600;'><i class='bx bx-block'></i> '";
		echo  $event_title . "'<span style='font-weight:500;'> 신청업무는 현재 준비 또는 대기기간이어서, 신청이 불가능합니다.</span></span>";

		break;
	case 4:
		echo "<span style='color:red;font-size:1.2em;font-weight:600;'><i class='bx bx-block'></i> '";
		echo  $event_title . "'<span style='font-weight:500;'> 신청업무는 현재 처리기간이 마감되었습니다.</span></span>";

		break;
	default: // 모든 것이 유효할 경우 신청 등록 가능처리			

		// 조건에 따라 출력폼 표출여부 결정 종료

?>


<?php

$rand_num = rand(000000, 999999);
$unique_order_id = "SV-" . $product_code . "-" . date('Ymdhis') . "-" . $mb_id . "-" . $rand_num;

?>


<!-- 여기부터 -->

<!-- 유효할 경우 참가폼 생성 시작 -->


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

<form name="fwrite" id="fwrite" action="./sbak_console_service_form_update.php" onsubmit="return fwrite_submit(this);"
	method="post">


	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="product_code" value="<?php echo $event_code ?? '' ?>">
	<input type="hidden" name="sbak_sports" value="<?php echo $sbak_sports ?? ''; ?>">
	<input type="hidden" name="amount" value="<?php echo $event_entry_fee ?? ''; ?>">
	<input type="hidden" name="unique_order_id" value="<?php echo $unique_order_id ?? ''; ?>">

	<!-- Content -->
	<div class="row">

		<div class="col-xl-12">
			<!-- HTML5 Inputs -->
			<div class="card mb-4">
				<h5 class="card-header">신청정보작성<small class="text-muted"> 등록 후에는 수정이 불가능하니, 잘 확인하시고 등록해주세요.</small></h5>

				<div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>




				<div class="card-body">




					<div class="mb-3 row">
						<label for="html5-text-input" class="col-md-2 col-form-label">
							<h6 class="mb-0">회원정보</h6>
						</label>
						<div class="col-md-10">
							<dl>
								<dd>
									<?php echo "<span style='font-size:1.2em;font-weight:600;'>" . $member['mb_name'] . "</span>"; ?> (
									<?php echo $member['mb_id']; ?> ) / <?php echo $the_birth; ?>
								</dd>
							</dl>
						</div>
					</div>



					<div class="mb-3 row">
						<label for="html5-search-input" class="col-md-2 col-form-label">
							<h6 class="mb-0">사진</h6>
						</label>
						<div class="col-md-5">
							<dl>

								<dd>
									<?php if (file_exists($mb_img_path)) { ?>
										<img src="<?php echo $mb_img_url ?>" style='width:250px;border-radius: 10px;margin-bottom:20px;' alt="회원이미지">
									<?php } else {
										echo "<i class='bx bx-block'></i> 회원사진이 등록되어 있지 않습니다.";
									} ?>

									<p style='color:blueviolet;'><i class='bx bx-info-square'></i>
										사진을 교체하려면, <a href="<?php echo G5_BBS_URL; ?>/register_form.php" style='font-weight:600'>[회원정보수정]</a> 메뉴를 이용하세요.
									</p>
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
								<dd>
									<input type='text' class="form-control" name='the_sports' placeholder='자동으로 입력됩니다.' readonly
										value='<?php echo $the_sports; ?>'>


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
								<dd>
									<input type="text" class="form-control" name="license_no" readonly value="<?php echo $the_license_no; ?>">
								</dd>
							</dl>
						</div>
					</div>

					<div class="mb-3 row">
						<label for="html5-tel-input" class="col-md-2 col-form-label">
							<h6 class="mb-0">자격등급</h6>
						</label>
						<div class="col-md-5">
							<dl>
								<dd>
									<input type="text" class="form-control" name="license_level" readonly value="<?php echo $the_level; ?>">
								</dd>
							</dl>
						</div>
					</div>

					<hr style="margin-bottom:30px;">



					<div class="mb-3 row">
						<label for="html5-date-input" class="col-md-2 col-form-label">
							<h6 class="mb-0">휴대폰번호</h6>
						</label>
						<div class="col-md-5">
							<dl>
								<dd>
									<input class="form-control" type="text" name="on_hp" placeholder="휴대폰번호를 11자리 숫자로만 입력하세요." oninput="autoHyphen(this)"
										maxlength="13" required class="required" value="<?php echo $mb_hp; ?>">
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
									<?php if (empty($member['mb_email'])) {
										echo "<input class='form-control' type='text' name='on_email' placeholder='예) email@email.com' required>";
									} else {
										echo "<input class='form-control' type='text' name='on_email' value='" . $member['mb_email'] . "'required>";
									}
									?>

								</dd>
							</dl>
						</div>
					</div>

	<?php if ($product_code !== 'D01' && $product_code !== 'D02') { ?>
		<div class="mb-3 row">
			<label for="html5-date-input" class="col-md-2 col-form-label">
				<h6 class="mb-0">배송주소</h6>
			</label>
			<div class="col-md-5">
				<dl>
					<dd>
						
	<input class="form-control" type="text" id="post_code" name="post_code" placeholder="우편번호" required>
	<input class="btn btn-secondary btn-sm" type="button" onclick="sample3_execDaumPostcode()" value="우편번호 찾기"><br>
	<input class="form-control" type="text" id="road_address" name='road_address' placeholder="주소" required><br>
	<input class="form-control" type="text" id="detail_address" name='detail_address' placeholder="상세주소">
	<input class="form-control" type="text" id="extra_address" name='extra_address' placeholder="참고항목">



	<div id="wrap"
		style="display:none;border:1px solid;width:350px;height:200px;margin:5px 0;position:relative">
		<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap"
			style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1"
			onclick="foldDaumPostcode()" alt="접기 버튼">
	</div>



	<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
	<script>
		// 우편번호 찾기 찾기 화면을 넣을 element
		var element_wrap = document.getElementById('wrap');

		function foldDaumPostcode() {
			// iframe을 넣은 element를 안보이게 한다.
			element_wrap.style.display = 'none';
		}

		function sample3_execDaumPostcode() {
			// 현재 scroll 위치를 저장해놓는다.
			var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
			new daum.Postcode({
				oncomplete: function(data) {
					// 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

					// 각 주소의 노출 규칙에 따라 주소를 조합한다.
					// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
					var addr = ''; // 주소 변수
					var extraAddr = ''; // 참고항목 변수

					//사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
					if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
						addr = data.roadAddress;
					} else { // 사용자가 지번 주소를 선택했을 경우(J)
						addr = data.jibunAddress;
					}

					// 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
					if (data.userSelectedType === 'R') {
						// 법정동명이 있을 경우 추가한다. (법정리는 제외)
						// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
						if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
							extraAddr += data.bname;
						}
						// 건물명이 있고, 공동주택일 경우 추가한다.
						if (data.buildingName !== '' && data.apartment === 'Y') {
							extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
						}
						// 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
						if (extraAddr !== '') {
							extraAddr = ' (' + extraAddr + ')';
						}
						// 조합된 참고항목을 해당 필드에 넣는다.
						document.getElementById("extra_address").value = extraAddr;

					} else {
						document.getElementById("extra_address").value = '';
					}

					// 우편번호와 주소 정보를 해당 필드에 넣는다.
					document.getElementById('post_code').value = data.zonecode;
					document.getElementById("road_address").value = addr;
					// 커서를 상세주소 필드로 이동한다.
					document.getElementById("detail_address").focus();

					// iframe을 넣은 element를 안보이게 한다.
					// (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
					element_wrap.style.display = 'none';

					// 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
					document.body.scrollTop = currentScroll;
				},
				// 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
				onresize: function(size) {
					element_wrap.style.height = size.height + 'px';
				},
				width: '100%',
				height: '100%'
			}).embed(element_wrap);

			// iframe을 넣은 element를 보이게 한다.
			element_wrap.style.display = 'block';
		}
	</script>

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

									<input class="form-check-input" type="radio" name="the_paymethod" id="on_31" value="CARD" required class="required">
									<label for="on_31">신용카드</label>&nbsp;
									<?php // 필수 입력이면 required class="required" 를 추가합니다.
									?>
									<input class="form-check-input" type="radio" name="the_paymethod" id="on_32" value="ACCT" required class="required">
									<label for="on_32">계좌이체</label>&nbsp;
									<?php // 필수 입력이면 required class="required" 를 추가합니다.
									?>
								</dd>
							</dl>
						</div>
					</div>



					<!-- <div class="mb-3 row">
						<label for="html5-date-input" class="col-md-2 col-form-label">
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

					<hr style="margin-bottom:30px;">


					<div class="online_bt" style="float: right;">
						<input type="submit" class="btn btn-primary" id="btn_submit" value="등록하기"> <!-- 이 라인을 수정,삭제하지 마세요.-->
						&nbsp;&nbsp;<a href="javascript:history.back()" class="btn btn-danger">취소</a>
					</div>
				</div>
			</div>
		</div>
	</div>

</form>


		<!-- 유효할 경우 참가폼 생성 끝 -->

<?php } //switch문 끝내기 
?>

<script>
	//------------ 부트스트랩 모달 자동 실행
	document.addEventListener('DOMContentLoaded', function() {
		const modalElement = document.getElementById('termsModal');
		const modal = new bootstrap.Modal(modalElement, {
			backdrop: 'static', // 바깥 클릭 방지
			keyboard: false // ESC 키 방지
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