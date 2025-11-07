<?php
include "../../../../common.php";

if (G5_IS_MOBILE) {
  return;
}

?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" id="meta_viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10">
  <?php
  if (G5_IS_MOBILE) {
    echo '<meta name="viewport" id="meta_viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10">' . PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">' . PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">' . PHP_EOL;
  } else {
    echo '<meta http-equiv="imagetoolbar" content="no">' . PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">' . PHP_EOL;
  }

  if ($config['cf_add_meta'])
    echo $config['cf_add_meta'] . PHP_EOL;


  ?>

  <!-- Favicon -->
  <link rel="icon" href="<?php echo G5_URL; ?>/logo_favi/favicon-96x96.png" />
  <link rel="apple-touch-icon" href="<?php echo G5_URL; ?>/logo_favi/favicon-96x96.png" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />



  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="<?php echo G5_THEME_URL . "/html/my_form" ?>/sneat/assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?php echo G5_THEME_URL . "/html/my_form" ?>/sneat/assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="<?php echo G5_THEME_URL . "/html/my_form" ?>/sneat/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="<?php echo G5_THEME_URL . "/html/my_form" ?>/sneat/assets/css/demo.css" />


  <!-- 구글 한글폰트 로드_순진 (다른 폰트쓰려면 활성화) -->
  <link href="<?php echo G5_THEME_URL; ?>/html/css_js/font.css" rel="stylesheet" type="text/css">
  <style type="text/css">
    body {
      --bs-font-sans-serif: margin:0;
      padding: 0;
      font-size: 15px;
      line-height: 1.6;
      font-family: 'Noto Sans KR', 'Apple SD Gothic Neo', '돋움', Dotum, Arial, Sans-serif;
      color: #000;
      letter-spacing: -0.4px;
      -webkit-text-size-adjust: none;
      font-weight: normal;
    }


    /* 각종 접수화면 상단 처리 */
    .basic_info {
      display: inline-block;
      width: 50%;
      border-bottom-style: solid;
      border-width: 1px;
      border-color: #C8C7C7FF;
    }

    .basic_info dt {
      float: left;
      width: 25%;
    }

    .basic_info dd {
      text-align: left;
      margin-left: 3px;
    }

    /* 반응형 중간기기 768사이즈 이하 */
    @media screen and (max-width: 768px) {
      .basic_info {
        display: inline-block;
        width: 100%;
      }

      .basic_info dt {
        float: none;
        width: 25%;
      }

      .basic_info dd {
        text-align: left;
        margin-left: 0px;
      }
    }

    .custom-grade-badge {
      display: inline-block;
      font-size: 1.1rem;
      /* 기본보다 큼 */
      font-weight: bold;
      /* 두꺼운 숫자 */
      padding: 0.4em 0.6em;
      /* 안쪽 여백으로 배지 높이 증가 */
      line-height: 1.2;
      border-radius: 0.375rem;
      /* 부드러운 사각형 */
      background-color: #6f42c1;
      /* 딥 퍼플 (변경 가능) */
      color: white;
      vertical-align: middle;
    }
  </style>


  <!-- Helpers -->
  <script src="<?php echo G5_THEME_URL . "/html/my_form" ?>/sneat/assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="<?php echo G5_THEME_URL . "/html/my_form" ?>/sneat/assets/js/config.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>






<?php


if ($is_guest || !$is_member) {
  alert('회원만 이용하실 수 있습니다.', G5_BBS_URL . "/login.php");
  exit;
}

if ($member['mb_level'] < 2) {
  alert('이용 권한이 없습니다.', G5_URL);
  exit;
}



$mb_id = $member['mb_id'];
$mb = get_member($mb_id);
$mb_birth = $member['mb_2'];
$mb_name = $member['mb_name'];
$mb_gender = $member['mb_1'] ?? '';
$mb_level = $member['mb_level'] ?? 0;

if ($mb_gender != '남자' && $mb_gender != '여자') {
  alert("회원정보에 성별이 등록되지 않았습니다. 다음 페이지에서 성별을 등록해주세요.", G5_THEME_URL . "/pages/check_gender.php");
}


$mb_profile = $mb['mb_profile'] ? conv_content($mb['mb_profile'], 0) : '소개 내용이 없습니다.';

include "console_common.php";  //자주쓰는 변수 함수



// 모바일 인지 체크해서 결제 api 경로 지정해주기
function mobile_check()
{
  $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
  $MobileArray = array(
    "iphone",
    "ipod",
    "ipad",
    "lgtelecom",
    "skt",
    "mobile",
    "samsung",
    "nokia",
    "blackberry",
    "android",
    "sony",
    "phone"
  );

  foreach ($MobileArray as $device) {
    if (preg_match("/" . preg_quote($device, "/") . "/", $user_agent)) {
      return "Mobile";
    }
  }
  return "PC";
}

if (mobile_check() == "Mobile") {
  // 모바일 접속일 때
  $READY_API_URL = G5_THEME_URL . "/html/my_form/mainpay_api/mobile/_2_ready.php";
  $SCRIPT_API_URL = "mainpay.mobile-1.0.js";
} else {
  // PC 접속일 때
  $READY_API_URL = G5_THEME_URL . "/html/my_form/mainpay_api/pc/_2_ready.php";
  $SCRIPT_API_URL = "mainpay.pc-1.1.js";
}

?>

<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo" style="justify-content:center;height:100px;">
          <a href="<?php echo G5_URL; ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
              <svg
                width="200"
                viewBox="0 0 100 100"
                version="1.1">
                <rect x="100" y="100" width="100" height="50"></rect>
              </svg>
            </span>
            <img src="<?php echo G5_THEME_IMG_URL ?>/sbak_logo.jpg" style="vertical-align: middle;" width="180px;">
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
          <!-- consoleboard -->
          <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'console_01.php') {
                                  echo "active open";
                                } ?>">
            <a href="<?php echo G5_THEME_URL . "/html/my_form/sbak_console_01.php"; ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-user-circle"></i>
              <div data-i18n="Analytics">회원가입정보</div>
            </a>
          </li>

          <!-- Layouts -->
          <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'console_02.php' || basename($_SERVER['PHP_SELF']) === 'console_03.php') {
                                  echo "active open";
                                } ?>">
            <a href="<?php echo G5_THEME_URL . "/html/my_form/sbak_console_02.php"; ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-layout"></i>
              <div data-i18n="Layouts">지도자종합정보</div>
            </a>
          </li>

          <li class="menu-header small text-uppercase">
            <span class="menu-header-text">공통메뉴</span>
          </li>


          <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_05.php') {
                                  echo "active";
                                } ?>">
            <a href="<?php echo G5_THEME_URL . "/html/my_form/sbak_console_05.php"; ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-star"></i>
              <div data-i18n="Account">자격증 재발급 신청내역</div>
            </a>
          </li>
          <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_04.php') {
                                  echo "active";
                                } ?>">
            <a href="<?php echo G5_THEME_URL . "/html/my_form/sbak_console_04.php"; ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-star"></i>
              <div data-i18n="Notifications">행사 신청내역</div>
            </a>
          </li>



          <!-- <li class="menu-item">
            <a href="<?php echo G5_BBS_URL . "/qalist.php"; ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-message-rounded-detail"></i>
              <div data-i18n="Analytics">1대1 문의</div>

            </a>
          </li> -->
          <li class="menu-item">
            <a href="<?php echo G5_BBS_URL . "/faq.php"; ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-star"></i>
              <div data-i18n="Analytics">자주하는 질문과 답</div>

            </a>
          </li>
          <!-- <li class="menu-item">
            <a href="#" class="menu-link">
              <i class="menu-icon tf-icons bx bx-envelope-open"></i>
              <div data-i18n="Analytics">쪽지함 관리</div>

            </a>
          </li> -->
          <!-- Components -->
          <li class="menu-header small text-uppercase"><span class="menu-header-text">업무별 바로가기</span></li>
          <!-- Cards -->


          <li class="menu-item  <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_T1_test.php' || basename($_SERVER['PHP_SELF']) === 'sbak_console_T1_test_open_list.php') {
                                  echo "active open";
                                } ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-box"></i>
              <div data-i18n="Authentications">티칭1 시험</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_T1_test.php' && $_GET['sports'] === 'ski') {
                                      echo "active";
                                    } ?>">
                <a href=" <?php echo G5_THEME_URL . "/html/my_form/sbak_console_T1_test.php?sports=ski"; ?>" class="menu-link">
                  <div data-i18n="Basic">응시자 신청 및 진행관리 (스키)</div>
                </a>
              </li>
              <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_T1_test.php' && $_GET['sports'] === 'sb') {
                                      echo "active";
                                    } ?>">
                <a href=" <?php echo G5_THEME_URL . "/html/my_form/sbak_console_T1_test.php?sports=sb"; ?>" class="menu-link">
                  <div data-i18n="Basic">응시자 신청 및 진행관리 (스노보드)</div>
                </a>
              </li>

              <?php
              if ($is_resort_manager > 0) { //스키장 관리자 시작
                if ($resort_judge_gubun == 'SK') {
              ?>

                  <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_T1_test_open_list.php' && $_GET['sports'] === 'ski') {
                                          echo "active";
                                        } ?>">
                    <a href="<?php echo G5_THEME_URL . "/html/my_form/sbak_console_T1_test_open_list.php?sports=ski"; ?>" class="menu-link">
                      <div data-i18n="Basic">스키티칭1 개최관리 (스키장관리자용)</div>
                    </a>
                  </li>

                <?php } else { ?>

                  <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_T1_test_open_list.php' && $_GET['sports'] === 'sb') {
                                          echo "active";
                                        } ?>">
                    <a href="<?php echo G5_THEME_URL . "/html/my_form/sbak_console_T1_test_open_list.php?sports=sb"; ?>" class="menu-link">
                      <div data-i18n="Basic">스노보드티칭1 개최관리 (스키장관리자용)</div>
                    </a>
                  </li>

              <?php }
              } //스키장관리자 종료 
              ?>

            </ul>
          </li>


          <!-- User interface -->



          <li class="menu-item">
            <a href="<?php echo G5_THEME_URL . "/html/my_form/sbak_console_02.php"; ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-box"></i>
              <div data-i18n="Accordion">자격 조회</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php echo G5_THEME_URL . "/html/my_form/sbak_console_02.php"; ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-box"></i>
              <div data-i18n="Buttons">자격증 신청</div>
            </a>
          </li>



          <!-- 각종 대회 신청 -->
          <li class="menu-item <?php if (
                                  basename($_SERVER['PHP_SELF']) === 'sbak_console_10.php' && isset($_GET['event_sort']) &&
                                  in_array($_GET['event_sort'], ['C01', 'B02', 'B03', 'B05', 'B06', 'B07'])
                                ) {
                                  echo "active open";
                                } ?>">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-copy"></i>
              <div data-i18n="Extended UI">각종 대회신청</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_10.php' && $_GET['event_sort'] === 'C01' && $_GET['sub_sort'] === 'default') {
                                      echo "active";
                                    } ?>">
                <a href=" <?php echo G5_THEME_URL . "/html/my_form/sbak_console_10.php?event_sort=C01&sub_sort=default"; ?>" class="menu-link">
                  <div data-i18n="Dropdowns">스키기술선수권</div>
                </a>
              </li>
              <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_10.php' && $_GET['event_sort'] === 'C01' && $_GET['sub_sort'] === 'T3') {
                                      echo "active";
                                    } ?>">
                <a href=" <?php echo G5_THEME_URL . "/html/my_form/sbak_console_10.php?event_sort=C01&sub_sort=T3"; ?>" class="menu-link">
                  <div data-i18n="Text Divider">스키기술선수권 + 티칭3 </div>
                </a>
              </li>

              <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_10.php' && $_GET['event_sort'] === 'B02') {
                                      echo "active";
                                    } ?>">
                <a href=" <?php echo G5_THEME_URL . "/html/my_form/sbak_console_10.php?event_sort=B02"; ?>" class="menu-link">
                  <div data-i18n="Perfect Scrollbar">스키티칭2 시험</div>
                </a>
              </li>


              <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_10.php' && $_GET['event_sort'] === 'B05') {
                                      echo "active";
                                    } ?>">
                <a href=" <?php echo G5_THEME_URL . "/html/my_form/sbak_console_10.php?event_sort=B05"; ?>" class="menu-link">
                  <div data-i18n="Dropdowns">스노보드티칭2 시험</div>
                </a>
              </li>
              <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_10.php' && $_GET['event_sort'] === 'B06') {
                                      echo "active";
                                    } ?>">
                <a href=" <?php echo G5_THEME_URL . "/html/my_form/sbak_console_10.php?event_sort=B06"; ?>" class="menu-link">
                  <div data-i18n="Dropdowns">스노보드티칭3 시험</div>
                </a>
              </li>
              <li class="menu-item <?php if (basename($_SERVER['PHP_SELF']) === 'sbak_console_10.php' && $_GET['event_sort'] === 'B07') {
                                      echo "active";
                                    } ?>">
                <a href=" <?php echo G5_THEME_URL . "/html/my_form/sbak_console_10.php?event_sort=B07"; ?>" class="menu-link">
                  <div data-i18n="Dropdowns">스키구조요원 시험</div>
                </a>
              </li>
            </ul>
          </li>



          <!-- 사무국 전용 (필요시에만 노출) -->
          <?php if ($is_admin) { ?>
            <li class="menu-header small text-uppercase"><span class="menu-header-text">사무국 전용</span></li>
            <li class="menu-item">
              <a href="<?php echo G5_ADMIN_URL; ?>" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons bx bx-server"></i>
                <div data-i18n="Support">관리자페이지</div>
              </a>
            </li>
            <!-- <li class="menu-item">
              <a href="#" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons bx bx-archive"></i>
                <div data-i18n="Documentation">사무국게시판</div>
              </a>
            </li> -->
          <?php } ?>
        </ul>


      </aside>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->

        <nav
          class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
          id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- 상단 -->
            <div class="navbar-nav align-items-center">
              <div class="nav-item d-flex align-items-center">
                <span class="app-brand-text demo menu-text fw-bolder ms-2">SBAK SERVICE</span>
              </div>
            </div>
            <!-- /상단 -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">


              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <?php if (file_exists($mb_img_path)) {  ?>
                      <img src="<?php echo $mb_img_url ?>" class="w-px-40 h-auto rounded-circle" alt>
                    <?php } else { ?>
                      <img src="<?php echo G5_THEME_IMG_URL ?>/sbak_logo.jpg" class="w-px-40 h-auto rounded-circle" alt>
                    <?php } ?>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">


                            <?php if (file_exists($mb_img_path)) {  ?>
                              <img src="<?php echo $mb_img_url ?>" class="w-px-40 h-auto rounded-circle" alt>
                            <?php } else { ?>
                              <img src="<?php echo G5_THEME_IMG_URL ?>/sbak_logo.jpg" class="w-px-40 h-auto rounded-circle" alt>
                            <?php } ?>

                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-semibold d-block"><?php echo $mb_name; ?></span>
                          <small class="text-muted"><?php echo $mb_id; ?></small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="./console_01.php">
                      <i class="bx bx-user me-2"></i>
                      <span class="align-middle">Member info</span>
                    </a>
                  </li>

                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="<?php echo G5_BBS_URL . '/logout.php'; ?>">
                      <i class="bx bx-power-off me-2"></i>
                      <span class="align-middle">Log Out</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/ User -->
            </ul>
          </div>
        </nav>

        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">

          <!-- Content -->