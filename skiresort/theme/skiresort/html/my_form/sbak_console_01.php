<?php

$this_title = "회원가입정보"; //커스텀페이지의 타이틀을 입력합니다.

include_once('./header_console.php'); //공통 상단을 연결합니다.


?>

<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><?php echo $this_title; ?><span class="text-muted fw-light"> / MEMBER INFO</span> </h4>

  <!-- Basic Layout -->
  <div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">기본정보</h5>
          <small class="text-muted float-end">Basic info</small>
        </div>


        <!-- 사진처리 시작 -->
        <div class="card-body">
          <div class="d-flex align-items-start align-items-sm-center gap-4">

            <?php if (file_exists($mb_img_path)) {  ?>
              <img src="<?php echo $mb_img_url ?>" class="d-block rounded" width=150 alt="회원이미지" id="uploadedAvatar">
            <?php } else { ?>
              <img src="<?php echo G5_THEME_IMG_URL ?>/sbak_logo.jpg" class="d-block rounded" width=150 alt="회원이미지" id="uploadedAvatar">
            <?php } ?>

            <?php
            if ($is_resort_manager < 1 || $is_admin) { //스키장 관리자가 아니거나, 관리자면 시작
            ?>

              <div class="button-wrapper">

                <button type="button" onClick="location.href='<?php echo G5_BBS_URL . '/member_confirm.php?url=' . G5_BBS_URL . '/register_form.php'; ?>'" class="btn btn-primary">회원정보 수정</button>

                <p class="text-muted mb-0">회원사진 변경은 회원정보 수정 페이지를 이용하세요.</p>

              </div>
            <?php } //스키장관리자가 아니면 처리 끝 
            ?>





          </div>
        </div>
        <hr class="my-0" />

        <!-- 사진처리 종료 -->

        <div class="card-body">

          <div class="mb-3">
            <label class="form-label" for="basic-icon-default-fullname" style="font-size: 1.0rem; font-weight: bold;">성명(NAME)</label>
            <div class="input-group input-group-merge">
              <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
              <input type="text" class="form-control" id="basic-default-fullname" value="  <?php echo $mb_name; ?>" readonly />
            </div>
          </div>


          <div class="mb-3">
            <label class="form-label" for="basic-default-company" style="font-size: 1.0rem; font-weight: bold;">아이디(ID)</label>
            <input type="text" class="form-control" id="basic-default-company" value="<?php echo $mb_id; ?>" readonly />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-email" style="font-size: 1.0rem; font-weight: bold;">성별</label>
            <?php
            if ($mb_gender == "남자" || $mb_gender == "여자") {
              $your_gender = $mb_gender;
            } else {
              $your_gender = "성별이 등록되어 있지 않습니다. 회원정보 수정 메뉴에서 성별을 등록해주세요.";
            }
            ?>
            <div class="input-group input-group-merge">
              <input
                type="text"
                id="basic-default-email"
                class="form-control"
                value="<?php echo $your_gender; ?>"
                aria-label="<?php echo $your_gender; ?>"
                aria-describedby="basic-default-email2" readonly />

            </div>

          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-phone" style="font-size: 1.0rem; font-weight: bold;">생년월일</label>
            <input
              type="text"
              id="basic-default-phone"
              class="form-control phone-mask" readonly
              value="<?php echo $mb_birth; ?>" />
            <div class="form-text">각종 행정은 생년월일 기준으로 연동됩니다.</div>
          </div>


        </div>
      </div>
    </div>
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">추가정보</h5>
          <small class="text-muted float-end">Extra info</small>
        </div>
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label" for="basic-icon-default-email" style="font-size: 1.0rem; font-weight: bold;">Email</label>
            <div class="input-group input-group-merge">
              <span class="input-group-text"><i class="bx bx-envelope"></i></span>
              <input
                type="text"
                id="basic-icon-default-email"
                class="form-control"
                value="  <?php echo $mb['mb_email']; ?>"
                aria-label="<?php echo $mb['mb_email']; ?>"
                aria-describedby="basic-icon-default-email2" readonly />

            </div>
            <div class="form-text">비밀번호 분실시 이메일 확인 후 재설정할 수 있습니다.</div>
          </div>

          <div class="mb-3">
            <label class="form-label" for="basic-icon-default-phone" style="font-size: 1.0rem; font-weight: bold;">Phone No</label>
            <div class="input-group input-group-merge">
              <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
              <input
                type="text"
                id="basic-icon-default-phone"
                class="form-control phone-mask"
                value="  <?php echo $mb['mb_hp']; ?>"
                aria-label="<?php echo $mb['mb_hp']; ?>"
                aria-describedby="basic-icon-default-phone2" readonly />
            </div>
          </div>

          <?php
          if ($is_resort_manager < 1 || $is_admin) { //스키장 관리자가 아니거나, 관리자면 시작
          ?>

            <div class="mb-3">
              <label class="form-label" for="basic-icon-default-phone" style="font-size: 1.0rem; font-weight: bold;">주소(address)</label>
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-book"></i></span>
                <input
                  type="text"
                  id="basic-icon-default-phone"
                  class="form-control phone-mask"
                  value="  <?php echo $mb['mb_addr1'] . '  ' . $mb['mb_addr2']; ?>"
                  aria-describedby="basic-icon-default-phone2" readonly />

              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="basic-icon-default-message" style="font-size: 1.0rem; font-weight: bold;">소개(profile)</label>
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-message2" class="input-group-text"><i class="bx bx-comment"></i></span>
                <textarea
                  id="basic-icon-default-message"
                  class="form-control"
                  value=""
                  aria-label="  <?php echo $mb_profile; ?>"
                  aria-describedby="basic-icon-default-message2" readonly>  <?php echo $mb_profile; ?></textarea>
              </div>
              <div class="form-text">티칭1 시험 지도자 찾기 등의 페이지에서, 위 내용으로 응시자에게 노출되며, 상시 수정 가능합니다.</div>

            </div>
            <button type="button" onClick="location.href='<?php echo G5_BBS_URL . '/member_confirm.php?url=' . G5_BBS_URL . '/register_form.php'; ?>'" class="btn btn-primary">회원정보 수정</button>
            <div class="form-text">각종 민원사무 및 온라인 신청을 정확하고 빠르게 처리하기 위해서, 회원정보를 최신정보로 유지해주세요.</div>


          <?php } //스키장관리자가 아니면 처리 끝 
          ?>

        </div>
      </div>
    </div>
  </div>
</div>



<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">주요 메뉴 바로가기 /</span> HOT MENU</h4>

  <!-- 주요메뉴 시작 -->
  <div class="card mb-4">

    <div class="card-body">
      <div class="row gy-3">

        <!-- 우측 시작 -->


        <div class="row">
          <table class="small">
            <tbody>
              <tr>
                <th width="120px">공통</th>
                <td>
                  | <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_05.php">나의 민원사무 신청내역</a> |
                  <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_04.php">나의 행사 신청내역</a> |
                  <!--a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_refund.php">나의 환불 신청내역</a> |
                  <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_refund.php">각종 환불 신청</a> |
                  <a href="<?php echo G5_URL; ?>/bbs/qalist.php">1대1 문의</a> |
                  <a href="<?php echo G5_URL; ?>/bbs/faq.php">자주하는 질문과 답변</a-->

                </td>

              </tr>

              <tr>

                <th width="120px">티칭1 시험 (응시자용)</th>
                <td>
                  | <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_T1_test.php?sports=ski">내 스키티칭1 응시신청 목록</a> |
                  <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_T1_test_apply.php?sports=ski">스키티칭1 응시신청</a> |
                  <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_T1_test.php?sports=sb">내 스노보드티칭1 응시신청 목록</a> |
                  <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_T1_test_apply.php?sports=sb">스노보드티칭1 응시신청</a> |
                </td>

              </tr>

              <?php
              if ($is_resort_manager > 0) { //스키장 관리자 시작
              ?>

                <tr>

                  <th width="120px">티칭1 시험 </th>
                  <td>
                    | <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_T1_test_open_list.php?sports=ski">스키티칭1 개최관리</a> |
                    <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_T1_test_open_list.php?sports=sb">스노보드티칭1 개최관리</a> |
                    <span class="badge bg-label-success">스키장 관리자 전용</span>
                  </td>

                </tr>

              <?php } //스키장관리자 종료 
              ?>

              <tr>
                <th width="120px">스키지도요원</th>
                <td>
                  <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_02.php">| 자격 조회 | 자격증 신청 | 자격증 인쇄 | 모바일자격증 |</a>
                </td>

              </tr>

              <tr>
                <th width="120px">스노보드지도요원</th>
                <td>
                  <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_02.php">| 자격 조회 | 자격증 신청 | 자격증 인쇄 | 모바일자격증 |</a>
                </td>

              </tr>

              <tr>
                <th width="120px">스키구조요원</th>
                <td>
                  <a href="<?php echo G5_THEME_URL; ?>/html/my_form/sbak_console_02.php">| 자격 조회 | 자격증 신청 | 자격증 인쇄 | 모바일자격증 |</a>
                </td>

              </tr>

            </tbody>
          </table>
        </div>


      </div>
    </div>
    <hr class="m-0" />

  </div>
  <!--/ 주요메뉴 끝 -->
</div>

<?php

include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.

?>