<?php

$this_title = "각종 자격 종합민원"; //커스텀페이지의 타이틀을 입력합니다.

include_once('./header_console.php'); //공통 상단을 연결합니다.



$print_sbak_mobile_form_url = "./mobile_license.php";
$print_sbak_form_url = "./print_license.php";

?>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><?php echo $this_title; ?><span class="text-muted fw-light"> / INSTRUCTOR'S PAGE</span></h4>
    <div class="alert  alert-dark mb-0" role="alert">
        <ul>
            <li> 각종 자격과 관련된 각종 행정(자격증 조회 및 신청, 출력 등)은 본 메뉴에서 처리가능합니다.
                아래에서 본인이 보유한 각 자격을 확인하시고, 필요한 서비스를 이용하세요. </li>
            <li> 회원사진은, 각종 시험 신청 서류, 자격증 등에 연동됩니다. 여권사진 형태의 정규 신분증 규격으로 등록해주세요.
                회원가입정보에서 사진을 등록할 수 있으며, 부적합한 사진은 사무국에서 정기적으로 임의삭제합니다. </li>
        </ul>

    </div> <br>

    <!-- 기본정보 -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">기본정보</h5>
                    <small class="text-muted float-end">Personal info</small>
                </div>


                <!-- 사진처리 시작 -->


                <div class="card-body">

                    <div class="col-md">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-2">


                                    <?php if (file_exists($mb_img_path)) {  ?>
                                        <img src="<?php echo $mb_img_url ?>" class="d-block rounded" width=200 alt="회원이미지" id="uploadedAvatar">
                                    <?php } else { ?>
                                        <img src="<?php echo G5_THEME_IMG_URL ?>/sbak_logo.jpg" class="d-block rounded" width=200 alt="회원이미지" id="uploadedAvatar">
                                    <?php } ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $mb_name; ?> <small class="text-muted"> 님의 프로필 </small></h4>
                                        <p class="card-text">
                                            <?php echo $mb_profile = isset($mb_profile) ? $mb_profile : "프로필 미등록"; ?>
                                        </p>
                                        <p class="card-text"><small class="text-muted">기술선수권대회 참가시, 위 내용으로 장내방송멘트가 운영되며, 상시 수정 가능합니다.</small></p>
                                        <button type="button" onClick="location.href='<?php echo G5_BBS_URL . '/member_confirm.php?url=' . G5_BBS_URL . '/register_form.php'; ?>'" class="btn btn-primary">회원정보 수정</button>
                                        <div class="form-text">각종 민원사무 및 온라인 신청을 정확하고 빠르게 처리하기 위해서, 회원정보를 최신정보로 유지해주세요.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                <hr class="my-0" />

                <!-- 사진처리 종료 -->

                <div class="card-body">

                    <form class="row g-3">
                        <div class="col-md-4">
                            <label for="input_name" class="form-label" style="font-size: 1.0rem; font-weight: bold;">성명</label>
                            <div style="border:1px solid black;font-size:1.2em;border-radius:5px;padding:5px;text-align:center;"><?php echo $mb_name; ?></div>
                        </div>
                        <div class="col-md-4">
                            <label for="input_birth" class="form-label" style="font-size: 1.0rem; font-weight: bold;">생년월일</label>
                            <div style="border:1px solid black;font-size:1.2em;border-radius:5px;padding:5px;text-align:center;"><?php echo $mb_birth; ?></div>
                        </div>
                        <div class="col-md-4">
                            <label for="input_id" class="form-label" style="font-size: 1.0rem; font-weight: bold;">ID</label>
                            <div style="border:1px solid black;font-size:1.2em;border-radius:5px;padding:5px;text-align:center;"><?php echo $mb_id; ?></div>
                        </div>
                    </form>


                </div>

            </div>

        </div>
    </div>


    <style>
        .license_display_01 {
            border-radius: 10px;
            color: #fff;
            text-align: center;
            padding: 10px;
            background-color: #3C5A91;
        }

        .license_display_01_tit {
            font-size: 1.0rem;
            font-weight: 600;
            color: #3C3C8C;
            padding-bottom: 10px;
            padding-top: 10px;
            margin-top: 20px;
            border-top: 1px solid black;
        }
    </style>




    <!-- 자격정보 -->
    <div class="row">
        <!--스키자격증 -->
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">스키 자격증</h5>
                    <small class="text-muted float-end">Ski certification</small>
                </div>
                <div class="card-body">



                    <?php //종목별 등급별로 자격정보 및 필요메뉴 생성하는 함수 시작

                    function display_license()
                    {

                        global $sports_table;
                        global $the_level;
                        global $the_frm_id;
                        global $sports;
                        global $mb_id;
                        global $mb_name;
                        global $mb_birth;
                        global $print_sbak_form_url;
                        global $print_sbak_mobile_form_url;
                        global $sports_type;
                        global $gubun;

                        $sql = "select * from {$sports_table} where MEMBER_ID = trim('{$mb_id}') and IS_DEL != 'Y' and K_GRADE = '{$the_level}'";
                        $result = sql_query($sql);
                        $result1 = sql_fetch($sql);


                        if (empty($result1['K_LICENSE'])) { // 자격증이 없다면 연동하도록 안내
                            echo "<form name='chk_license' method='post' action='./sbak_console_license_chk_it.php'>";
                            echo "<input type='hidden' name='chk_code' value='ksia_code_3307'>";
                            echo "<input type='hidden' name='sports_table' value='" . $sports_table . "'>";
                            echo "<input type='hidden' name='the_level' value='" . $the_level . "'>";
                    ?>
                            <input type='hidden' name='the_mb_name' value='<?php echo $mb_name; ?>'>
                            <input type='hidden' name='the_sports' value='<?php echo $sports_type; ?>'>
                            <input type='hidden' name='the_mb_birth' value='<?php echo $mb_birth; ?>'>


                            <!-- Modal -->
                            <!-- <div class="modal fade" id="ask_syncro_Modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">연회비 연동</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            입력된 이름과 생년월일을 이용하여 자격 DB에 등록합니다. 본인 자격이 아닌데도 연동시, 타인 자격 무단이용에 대한 법적 책임이 따릅니다.
                                            연동하시겠습니까?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                                            <button type="submit" class="btn btn-primary" onclick="form.submit()">연동하기</button>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- Modal -->




                            <div class="form-text text-danger" style='padding-bottom:20px;'>
                                <span class='icon-base bx bx-error  me-1'></span>
                                해당 자격증이 없습니다. 취득하셨다면
                                연동 확인을 해주세요. 한번 확인된 이후에는 자동으로 갱신됩니다.
                            </div>




                            <form class="row g-3">

                                <div class='col'>
                                    <input type='hidden' class='form-control' id='input_name33' aria-describedby='floatingInputHelp'
                                        name='the_name' value='<?php echo $mb_name; ?>' readonly>
                                </div>

                                <?php
                                if (empty($mb_birth)) {
                                    echo "생년월일 : <span class='tf-icons bx bx-error me-1'></span><span class='text-danger'>회원정보에 생년월일이 등록되어 있지 않아서 연동이 불가능합니다. 연동하시려면
                                                         회원탈퇴 후 재가입 해주세요.</span>";
                                } else {
                                    echo " <div class='col'>
                                                     <input type='hidden' class='form-control' id='input_birth33' aria-describedby='floatingInputHelp' name='the_birth'  value='" . $mb_birth . "' readonly></div>";
                                    echo "<button type='button' class='btn rounded-pill btn-secondary' onclick='form.submit()'> 연동하기 </button>";
                                }

                                ?>

                            </form>

                    <?php
                        } else { // 자격증 정보가 있다면

                            for ($i = 0; $row = sql_fetch_array($result); $i++) {



                                echo "<form name='fvisit' method='post' id='" . $the_frm_id . "' action='" . $print_sbak_form_url . "'>";

                                //echo "<input type=\"text\" class=\"form-control\" readonly> [NO] " . $row['K_LICENSE'] . "<br>";
                                echo "<h5 class='license_display_01'>" . $row['K_LICENSE'] . "</h5>";
                                echo "<div class='demo-inline-spacing'>";
                                echo "<button type=\"button\" class=\"btn btn-outline-primary\"	onclick=document.getElementById('" . $the_frm_id . "').submit(); >자격확인서(한글) 출력</button> ";
                                echo "<button type=\"button\" class=\"btn btn-outline-primary\">자격확인서(영문) 준비중</button> ";
                                $to_mobile_url = $print_sbak_mobile_form_url . "?category=" . $sports_type . "&license=" . $row['K_LICENSE'];
                                echo "<button type=\"button\" class=\"btn btn-outline-primary\"	onclick=\"location.href='" . $to_mobile_url . "'\">모바일자격증</button> ";

                                echo "<button type=\"button\" class=\"btn btn-outline-primary\" 	onclick=\"location.href='sbak_console_service.php?category_sort=A01&license=" . $row['K_LICENSE'] . "'\"> 자격증 신청(A4)</button>";
                                echo "<button type=\"button\" class=\"btn btn-outline-primary\" 	onclick=\"location.href='sbak_console_service.php?category_sort=A02&license=" . $row['K_LICENSE'] . "'\"> 자격증 신청(ID카드)</button>";
                                echo "<button type=\"button\" class=\"btn btn-outline-primary\" 	onclick=\"location.href='sbak_console_service.php?category_sort=A03&license=" . $row['K_LICENSE'] . "'\"> 자격증 신청(A4 + ID카드)</button>";

                                echo "</div>";



                                echo "<input type='hidden' name='level' value='" . $row['K_GRADE'] . "'>";
                                echo "<input type='hidden' name='license' value='" . $row['K_LICENSE'] . "'>";
                                echo "<input type='hidden' name='K_name' value='" . $mb_name . "'>";
                                echo "<input type='hidden' name='K_birth' value='" . $row['K_BIRTH'] . "'>";
                                echo "<input type='hidden' name='sports' value='" . $sports . "'>";
                                echo "<input type='hidden' name='gubun' value='" . $row['GUBUN'] . "'>";
                                echo "<input type='hidden' name='category' value='" . $sports_type . "'>";

                                echo "</form>";
                            }
                        }
                    }


                    // 함수끝

                    ?>




                    <div class="mb-3">
                        <p class="license_display_01_tit"><i class='bx  bx-certification'></i> 스키티칭1</p>
                        <div class="table">
                            <?php

                            $sports_table = $Table_Ski_Member;
                            $the_level = "T1";
                            $the_frm_id = "frm_sk1";
                            $sports = "스키 티칭1";
                            $sports_type = "ski";

                            display_license();
                            ?>
                        </div>
                    </div>



                    <div class="mb-3">
                        <p class="license_display_01_tit"><i class='bx  bx-certification'></i> 스키티칭2</p>
                        <div class="table">
                            <?php

                            $sports_table = $Table_Ski_Member;
                            $the_level = "T2";
                            $the_frm_id = "frm_sk2";
                            $sports = "스키 티칭2";
                            $sports_type = "ski";

                            display_license();
                            ?>
                        </div>
                    </div>


                    <div class="mb-3">
                        <p class="license_display_01_tit"><i class='bx  bx-certification'></i> 스키티칭3</p>
                        <div class="table">
                            <?php

                            $sports_table = $Table_Ski_Member;
                            $the_level = "T3";
                            $the_frm_id = "frm_sk3";
                            $sports = "스키 티칭3";
                            $sports_type = "ski";

                            display_license();
                            ?>
                        </div>
                    </div>



                </div>

            </div>

        </div>



        <!--스노보드 자격증-->
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">스노보드 자격증</h5>
                    <small class="text-muted float-end">Snowboard certification</small>
                </div>
                <div class="card-body">


                    <div class="mb-3">
                        <p class="license_display_01_tit"><i class='bx  bx-certification'></i> 스노보드티칭1</p>
                        <div class="table">
                            <?php

                            $sports_table = $Table_Sb_Member;
                            $the_level = "T1";
                            $the_frm_id = "frm_sb1";
                            $sports = "스노보드 티칭1";
                            $sports_type = "sb";

                            display_license();
                            ?>
                        </div>
                    </div>


                    <div class="mb-3">
                        <p class="license_display_01_tit"><i class='bx  bx-certification'></i> 스노보드티칭2</p>
                        <div class="table">
                            <?php

                            $sports_table = $Table_Sb_Member;
                            $the_level = "T2";
                            $the_frm_id = "frm_sb2";
                            $sports = "스노보드 티칭2";
                            $sports_type = "sb";

                            display_license();
                            ?>
                        </div>
                    </div>



                    <div class="mb-3">
                        <p class="license_display_01_tit"><i class='bx  bx-certification'></i> 스노보드티칭3</p>
                        <div class="table">
                            <?php

                            $sports_table = $Table_Ski_Member;
                            $the_level = "T3";
                            $the_frm_id = "frm_sb3";
                            $sports = "스노보드 티칭3";
                            $sports_type = "sb";

                            display_license();
                            ?>
                        </div>
                    </div>



                </div>

            </div>

        </div>

        <!--스키구조요원 자격증-->
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">스키구조요원 자격증</h5>
                    <small class="text-muted float-end">Ski Patrol certification</small>
                </div>
                <div class="card-body">


                    <div class="mb-3">
                        <p class="license_display_01_tit"><i class='bx  bx-certification'></i> 스키구조요원</p>
                        <div class="table">
                            <?php

                            $sports_table = $Table_Patrol_Member;
                            $the_level = "PTL";
                            $the_frm_id = "frm_ptl";
                            $sports = "스키구조요원";
                            $sports_type = "ptl";

                            display_license();
                            ?>
                        </div>
                    </div>








                </div>

            </div>

        </div>


    </div>

    <!-- 자격정보 끝 -->



</div>
</div>




<?php


include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.

?>