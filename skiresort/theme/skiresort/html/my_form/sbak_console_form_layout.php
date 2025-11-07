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
			<h5 class="card-header">행사정보 <small class="text-muted "> 반드시 확인하세요. </small> </h5>
			<div class="card-body">

				<div class="row gy-3">
					<div class="d-inline-block border-bottom border-1 border-dark w-100"> </div>

					<div class="basic_info">
						<dl>
							<dt>행사명</dt>
							<dd><span class="text-primary fw-bold"><?php echo $event_title; ?></span>
							</dd>
						</dl>
					</div>

					<div class="basic_info">
						<dl>
							<dt>행사일정</dt>
							<dd><?php echo $event_date; ?></dd>
						</dl>
					</div>

					<div class="basic_info">
						<dl>
							<dt>행사장소</dt>
							<dd><?php echo $event_where; ?></dd>
						</dl>
					</div>

					<div class="basic_info">
						<dl>
							<dt>참가대상</dt>
							<dd><?php echo $event_whom; ?></dd>
						</dl>
					</div>

					<div class="basic_info">
						<dl>
							<dt>접수기간</dt>
							<dd>
								<?php echo  "<span class='text-primary'>" . $event_begin_date . "</span> " . $event_begin_time . "  ~  <span class='text-primary'>" . $event_end_date . "</span> " . $event_end_time; ?>
							</dd>
						</dl>
					</div>

					<div class="basic_info">
						<dl>
							<dt>접수인원</dt>
							<dd><?php echo $event_total_limit; ?> </dd>
						</dl>
					</div>

					<?php
					$fee_text = "";

					if ($sub_sort == 'default') {
						$fee_text = "기술선수권: " . $event_entry_fee;
					} elseif ($sub_sort == 'T3') {
						$fee_text = "기술선수권 + 티칭3 검정: " . $event_entry_fee;
					} else {
						$fee_text = $event_entry_fee;
					}
					?>

					<div class="basic_info">
						<dl>
							<dt>참가비</dt>
							<dd><span class="text-danger"><?php echo $fee_text; ?></span> 원</dd>
						</dl>
					</div>

					<div class="basic_info">
						<dl>
							<dt>행사요강</dt>
							<dd>
								<a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=sbak_event_notice&wr_id=<?php echo $event_notice;?>">확인하기</a>
							</dd>
						</dl>
					</div>

					<div class="basic_info">
						<dl>
							<dt>취소기간</dt>
							<dd><span class="text-danger"><?php echo $Pay_end_date . " " . $Pay_end_time . "까지"; ?></span></dd>
						</dl>
					</div>


				</div>
			</div>
		</div>



	</div>
</div>

<?php

$rand_num = rand(000000, 999999);
$unique_order_id = "EV-" . $event_code . "-" . date('Ymdhis') . "-" . $mb_id . "-" . $rand_num;

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

<form name="MAINPAY_FORM" id="MAINPAY_FORM" action="./sbak_console_event_form_update.php" method="post" enctype="multipart/form-data" onsubmit="return validateGender()">

	<input type="hidden" name="w" value="yes">

	<input type="hidden" name="fname" value="rf_write">
	<input type="hidden" name="goodsCode" value="<?php echo $event_code; ?>">
	<input type="hidden" name="goodsName" value="<?php echo $event_title; ?>">
	<input type="hidden" name="event_year" value="<?php echo $event_year; ?>">
	<input type="hidden" name="amount" value="<?php echo $event_entry_fee; ?>">
	<input type="hidden" name="mb_name" value="<?php echo $mb_name; ?>">
	<input type="hidden" name="mb_id" value="<?php echo $mb_id; ?>">
	<input type="hidden" name="fee_text" value="<?php echo $fee_text; ?>">
	<input type="hidden" name="entry_info_2" value="<?php echo $entry_info_2; ?>">
	<input type="hidden" name="unique_order_id" value="<?php echo $unique_order_id ?? ""; ?>">


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
							<h6 class="mb-0">신청자</h6>
						</label>
						<div class="col-md-10">
							<dl>
								<dd>
									<?php echo $mb_name; ?> (
									<?php echo $mb_id; ?> ) /
									<?php echo $mb_birth; ?>
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
									<input class="form-control" type="text" name="mb_name" placeholder="가입정보에서 자동으로 입력됩니다." readonly
										value="<?php echo $mb_name; ?>">
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
										<?php

										$license_no = $license_no ?? "";
										if ($license_no == "") {
											echo "<input class=\"form-control\" type=\"text\" name=\"mb_license_no\" placeholder=\"보유한 자격증이 없습니다.\" readonly value=\"\">";
										} else {
											echo "<input class=\"form-control\" type=\"text\" name=\"mb_license_no\" placeholder=\"자동으로 입력\" readonly value=\"" . $license_no . "\">";
										}
										?>

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
									<input class="form-control" type="text" name="mb_birth" placeholder="가입정보에서 자동으로 입력됩니다." readonly
										value="<?php echo $mb_birth; ?>">
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
	
										<input class="form-check-input" type="radio" name="the_gender" id="on_31"
											value="남자" <?php if ($mb_gender == '남자') echo 'checked'; ?>
											onclick="return false;">
										<label for="on_31">남 자</label>&nbsp;

										<input class="form-check-input" type="radio" name="the_gender" id="on_32"
											value="여자" <?php if ($mb_gender == '여자') echo 'checked'; ?>
											onclick="return false;">
										<label for="on_32">여 자</label>&nbsp;


								</dd>
							</dl>
						</div>
					</div>

					<hr style="margin-bottom:30px;">

					<div class="mb-3 row">
						<label for="html5-number-input" class="col-md-2 col-form-label">
							<h6 class="mb-0">휴대폰번호(연락가능한)</h6>
						</label>
						<div class="col-md-5">
							<dl>
								<dd>
									<input class="form-control" type="text" name="on_hp" placeholder="휴대폰번호를 숫자로만 입력하세요." oninput="autoHyphen(this)"
										maxlength="13" required class="required" value="<?php echo $mb_hp; ?>">
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




					<?php if ($event_code == "B02") { //스키티칭2 검정이면 
					?>

						<div class="mb-3 row">
							<label for="html5-date-input" class="col-md-2 col-form-label">
								<h6 class="mb-0">자격증 종류</h6>
							</label>
							<div class="col-md-10">
								<dl>
									<dd>

										<input class="form-check-input" type="radio" name="the_part_1" id="on_the_part_1" value="일반티칭2" required
											> <label for="on_31">일반티칭2</label>&nbsp;
										<input class="form-check-input" type="radio" name="the_part_1" id="on_the_part_2" value="시니어티칭2" required
											> <label for="on_32">시니어티칭2</label>&nbsp;

									</dd>
								</dl>
							</div>
						</div>
					<?php } ?>



					<?php if ($event_code == "B02" or $event_code == "B05" or $event_code == "B07") { //스키티칭2, 스노보드티칭2 검정이면 

						$sql234 = "select EXEMPT_1, EXEMPT_2 from SBAK_EXEMPTION_LIST where K_name = '{$mb_name}' and K_BIRTH = '{$mb_birth}' and SPORTS = '{$event_code}'";
						$row234 = sql_fetch($sql234);
						$freepass_A =	$row234['EXEMPT_1'];	 //필기
						$freepass_B =	$row234['EXEMPT_2'];	 //실기

					?>
	
					<input type="hidden" name="freepass_A" value="<?php echo $freepass_A ?? ""; ?>">
					<input type="hidden" name="freepass_B" value="<?php echo $freepass_B ?? ""; ?>">


						<div class="mb-3 row">
							<label for="html5-date-input" class="col-md-2 col-form-label">
								<h6 class="mb-0">필기면제</h6>
							</label>
							<div class="col-md-10">
								<dl>
									<dd>
										<input class="form-check-input exclusive" type="checkbox" name="entry_info_3" id="on_41" value="예" class="on_4"
											<?php if ($freepass_A == 'Y') echo 'checked disabled'; ?>> <label
											for="on_41">
											<?php if ($freepass_A == 'Y') {
												echo '<span style="color:red;">자동면제 대상입니다.</span>';
											} else {
												echo "필기면제 (면제대상시 체크)";
											} ?></label><br class="sview">
									</dd>
								</dl>
							</div>
						</div>

						<div class="mb-3 row" style='border-radius:5px;border:1px solid #666;display:none;' id="exemptionBlock">
							<label for="html5-date-input" class="col-md-8 col-form-label">
								<h6 class="mb-0">필기면제사유 선택 및 증빙서류 첨부</h6>
							</label>
							<div class="col-md-5">
								<dl>
									<dd>
										<select class="form-select" id="entry_info_4" name="entry_info_4">
											<?php if ($event_code == "B07") {?>

													<option value="">필기면제사유 (해당자만 선택)</option>
													<option value="생활체육지도자">생활체육지도자</option>
													<option value="전문스포츠지도사">전문스포츠지도사</option>

												<?php } else{?>

													<option value="">필기면제사유 (해당자만 선택)</option>
													<option value="지난해 합격" <?php if ($freepass_A == 'Y') echo 'selected'; ?>>지난해 합격</option>
													<option value="생활스포츠지도사">생활스포츠지도사</option>
													<option value="전 · 현직 데몬스트레이터">전 · 현직 데몬스트레이터</option>
													<option value="전문스포츠지도사">전문스포츠지도사</option>

												<?php }?>
										</select>
									</dd>
									<dd>
										<label for="formFile" class="form-label text-danger">&#8251; 이론면제 증빙 파일 첨부 시 주의사항(파일크기 10MB 미만의 pdf,jpg,png,gif 형식만 가능)</label>
										<input class="form-control" type="file" id="formFile_1" name="formFile_1" accept=".pdf,.PDF,.jpg,.JPG,.PNG,.png,.gif,.GIF" onchange="checkFile(this)">
									</dd>
								</dl>
							</div>
						</div>

					<?php } ?>

					<?php if ($event_code == "B02" or $event_code == "B05" or $event_code == "B07") { //스키티칭2,  스노보드티칭2 검정이면 
					?>

						<div class="mb-3 row">
							<label for="html5-date-input" class="col-md-2 col-form-label">
								<h6 class="mb-0">실기면제</h6>
							</label>
							<div class="col-md-10">
								<dl>
									<dd>
										<input class="form-check-input exclusive" type="checkbox" name="entry_info_5" id="on_42" value="예" class="on_4"
											<?php if ($freepass_B == 'Y') {echo 'checked disabled';} elseif ($event_code == "B07") {echo 'disabled';} ?>> <label
											for="on_42"><?php if ($freepass_B == 'Y') {
															echo '<span style="color:red;">자동면제 대상입니다.</span>';
														} else {
															echo "실기면제 (면제대상시 체크)";
														} ?></label><br class="sview">
									</dd>
								</dl>
							</div>
						</div>

						<div class="mb-3 row" style='border-radius:5px;border:1px solid #666;display:none;' id="exemptionBlock2">
							<label for="html5-date-input" class="col-md-8 col-form-label">
								<h6 class="mb-0">실기면제사유 선택 및 증빙서류 첨부</h6>
							</label>
							<div class="col-md-5">
								<dl>
									<dd>

										<select class="form-select" id="entry_info_6" name="entry_info_6">
											<option value="">실기면제사유 (해당자만 선택)</option>
											<option value="지난해 합격" <?php if ($freepass_B == 'Y') echo 'selected'; ?>>지난해 합격</option>
											<option value="전·현직 스키 국가대표">전·현직 스키 국가대표</option>
											<option value="전 · 현직 데몬스트레이터">전 · 현직 데몬스트레이터</option>
											<option value="전문스포츠지도사">전문스포츠지도사</option>

										</select>

									</dd>
									<dd>
										<label for="formFile" class="form-label text-danger">&#8251; 실기면제 증빙 파일 첨부 시 주의사항(파일크기 10MB 미만의 pdf,jpg,png,gif 형식만 가능)</label>
										<input class="form-control" type="file" id="formFile_2" name="formFile_2" accept=".pdf,.PDF,.jpg,.JPG,.PNG,.png,.gif,.GIF" onchange="checkFile(this)">
									</dd>
								</dl>
							</div>
						</div>

					<?php } ?>


					<?php if ($event_code == "C01" && $level == 'L2') { // 스키 기선전이면
					?>


						<div class="mb-3 row" style='border-radius:5px;border:1px solid #666;' id="exemptionBlock3">
							<label for="html5-date-input" class="col-md-8 col-form-label">
								<h6 class="mb-0">레벨2 자격증 증빙서류 첨부</h6>
							</label>
							<div class="col-md-5">
								<dl>
									<dd>
										<label for="formFile3" class="form-label text-danger">&#8251; 레벨2자격 증빙 파일 첨부 시 주의사항(파일크기 10MB 미만의 pdf,jpg,png,gif 형식만 가능)</label>
										<input class="form-control" type="file" id="formFile_3" name="formFile_3"  required accept=".pdf,.PDF,.jpg,.JPG,.PNG,.png,.gif,.GIF" onchange="checkFile(this)">
										<input type = "hidden" name="level_check" value="Y">
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

									<input class="form-check-input" type="radio" name="paymethod" id="on_99" value="CARD" required class="required">
									<label for="on_99">신용카드</label>&nbsp;
									<input class="form-check-input" type="radio" name="paymethod" id="on_98" value="ACCT" required class="required">
									<label for="on_98">계좌이체</label>&nbsp;
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
									<input class="form-control" type="text" name="the_memo" placeholder="신청, 입금 등 관련하여 따로 사무국에 전달할 내용이 있으면 입력"
										style="max-width:100%;">
								</dd>
							</dl>
						</div>
					</div> -->

					<?php if ($event_code == "C01") { //스키기선전이면 
					?>

						<div class="mb-3 row">
							<label for="html5-date-input" class="col-md-2 col-form-label">
								<h6 class="mb-0">장내 방송멘트</h6>
							</label>
							<div class="col-md-10">
								<dl>
									<dd>
										<textarea class="form-control" name="the_profile" id="" cols="30" rows="10"
											placeholder="경기장 장내방송에 사용될 본인소개를 입력해주세요. 이후에 내 행사신청관리 페이지에서 자유롭게 수정가능합니다."></textarea>
									</dd>
								</dl>
							</div>
						</div>
					<?php } ?>

					<hr style="margin-bottom:30px;">


					<div class="online_bt" style="float: right;">
						<input type="submit" class="btn btn-primary" id="btn_submit" value="등록하기">
						&nbsp;&nbsp;
						<a href="javascript:history.back()" class="btn btn-danger">취소</a>

					</div>
				</div>
			</div>
		</div>
	</div>

</form>

<!-- 유효할 경우 참가폼 생성 끝 -->


<script>
	//------------ 모달 컨트롤
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




	// 체크박스 클릭 이벤트------------------
	document.getElementById("on_41").addEventListener("change", function() { //필기면제
		const block = document.getElementById("exemptionBlock");
		const file1 = document.getElementById("formFile_1");
		const entry_info_4 = document.getElementById("entry_info_4");
		if (this.checked) {
			block.style.display = "block"; // 체크되면 보이기
		} else {
			block.style.display = "none"; // 체크 해제되면 숨기기  
			file1.value = "";
			entry_info_4.value = "";
		}
	});

	// 체크박스 클릭 이벤트
	document.getElementById("on_42").addEventListener("change", function() { //실기면제
		const block = document.getElementById("exemptionBlock2");
		const file2 = document.getElementById("formFile_2");
		const entry_info_6 = document.getElementById("entry_info_6");
		if (this.checked) {
			block.style.display = "block"; // 체크되면 보이기
		} else {
			block.style.display = "none"; // 체크 해제되면 숨기기
			file2.value = "";
			entry_info_6.value = "";
		}
	});
	//------------------------------------


	// 면제 체크 되어있을경우 면제사유 required 하기
	document.addEventListener('DOMContentLoaded', function() {
		// ✅ 필기면제
		const checkbox = document.getElementById('on_41');
		const selectBox = document.getElementById('entry_info_4'); // 면제사유
		const fileInput = document.getElementById('formFile_1'); // 파일

		function toggleRequired1() {

			// 자동면제 (checked + disabled) 인 경우 => 통과
			if (checkbox.checked && checkbox.disabled) {
				selectBox.removeAttribute('required');
				fileInput.removeAttribute('required');
				return;
			}

			// 일반 체크일 경우
			if (checkbox.checked) {
				selectBox.setAttribute('required', 'required');
				fileInput.setAttribute('required', 'required');
			} else {
				selectBox.removeAttribute('required');
				fileInput.removeAttribute('required');
				fileInput.value = ""; // 파일 초기화
			}
		}
		toggleRequired1();
		checkbox.addEventListener('change', toggleRequired1);

		// ✅ 실기면제
		const checkbox2 = document.getElementById('on_42');
		const selectBox2 = document.getElementById('entry_info_6'); // 면제사유
		const fileInput2 = document.getElementById('formFile_2'); // 파일

		function toggleRequired2() {

			// 자동면제 (checked + disabled) → required 제외
			if (checkbox2.checked && checkbox2.disabled) {
				selectBox2.removeAttribute('required');
				fileInput2.removeAttribute('required');
				return;
			}

			if (checkbox2.checked) {
				selectBox2.setAttribute('required', 'required');
				fileInput2.setAttribute('required', 'required');
			} else {
				selectBox2.removeAttribute('required');
				fileInput2.removeAttribute('required');
				fileInput2.value = ""; // 파일 초기화
			}
		}

		toggleRequired2();
		checkbox2.addEventListener('change', toggleRequired2);
	
	});
	//-----------------------------------


	function checkFile(f) {


		//files로 해당 파일정보 얻기
		var file = f.files;
		const MAX_SIZE_MB = 10; // 예: 10MB			
		const fileSizeInMB = file[0].size / (1024 * 1024); // 바이트를 MB로 변환


		if (!/\.(pdf|PDF|png|PNG|jpg|JPG|gif|GIF)$/i.test(file[0].name)) {
			alert('pdf,png,jpg.gif 파일만 선택해 주세요.\n\n현재 파일 : ' + file[0].name);
			f.outerHTML = f.outerHTML;
		}

		if (fileSizeInMB > MAX_SIZE_MB) {
			alert('파일 용량이 너무 큽니다. ' + MAX_SIZE_MB + 'MB 이하의 파일을 업로드해주세요.');

		} else return;

		// 체크를 통과했다면 종료.
		// 체크에 걸리면 선택된  내용 취소 처리를 해야함.
		// 파일선택 폼의 내용은 스크립트로 컨트롤 할 수 없습니다.
		// 그래서 그냥 새로 폼을 새로 써주는 방식으로 초기화 합니다.
		// 이렇게 하면 간단 !?
		f.outerHTML = f.outerHTML;
	}
//-----------------------------------------------------

	//면제 선택 시 하나 선택하면 다른 하나 disable 하기 (251017 대현)

	document.addEventListener('DOMContentLoaded', function() {
		const checkboxes = document.querySelectorAll('.exclusive');

		// 초기 상태: 이미 checked + disabled인게 있다면, 다른 것도 disabled 시킴
		const preDisabled = Array.from(checkboxes).find(chk => chk.checked && chk.disabled);
		if (preDisabled) {
			checkboxes.forEach(other => {
				if (other !== preDisabled) other.disabled = true;
			});
		}

		// 클릭 시 동작
		checkboxes.forEach(chk => {
			chk.addEventListener('change', function() {
				// disabled된건 무시
				if (this.disabled) return;

				const others = Array.from(checkboxes).filter(c => c !== this);

				if (this.checked) {
					// 내가 체크되면 나머지 비활성화
					others.forEach(o => o.disabled = true);
				} else {
					// 내가 해제되면 나머지 다시 활성화
					others.forEach(o => {
						// 단, 원래부터 disabled였던건 그대로 유지
						if (!o.hasAttribute('data-fixed-disabled')) {
							o.disabled = false;
						}
					});
				}
			});
		});

		// 원래부터 disabled인 항목 표시 (복구 시 구분용)
		checkboxes.forEach(chk => {
			if (chk.disabled && !chk.checked) {
				chk.setAttribute('data-fixed-disabled', '1');
			}
		});

	});
</script>