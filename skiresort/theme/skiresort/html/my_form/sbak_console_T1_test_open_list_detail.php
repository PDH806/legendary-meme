<?php

$refer = $_SERVER['HTTP_REFERER'] ?? '';

include_once('./header_console.php'); //공통 상단을 연결합니다.

if (!$refer) {
    alert("비정상적인 접속입니다.", $_SERVER['HTTP_REFERER']);
}

$g5['title'] = "티칭1(심사위원)"; //커스텀페이지의 타이틀을 입력합니다.



$T_code = $_GET['t_code'] ?? '';
$sports = $_GET['sports'] ?? '';
$confirm_score = $_POST['confirm_score'] ?? '';


if (empty($confirm_score) || $confirm_score !== 'yes') {
    if (empty($T_code) || empty($sports)) {
        alert("비정상적인 접속입니다.", $refer);
    }
}


// 점수확정 접근시, 이미 확정 인지
$sql = "select exists (select * from {$Table_T1} where T_code = '{$T_code}' and (RESULT_DATE is not null and RESULT_DATE != '') limit 1) as CHK_EXIST";
$result3 = sql_fetch($sql);
if ($result3['CHK_EXIST'] > 0) {
    $confirm_result = 'Y';
} else {
    $confirm_result = 'N';
}


if ($confirm_score == 'yes') { //만일 전체 점수 등록확정 버튼에서 넘어오면

    $T_code = $_POST['t_code'] ?? '';
    $sports = $_POST['sports'] ?? '';

    if ($sports == 'ski') {
        $license_category = 'SK';
        $license_table = $Table_Ski_Member;
    } elseif ($sports == 'sb') {
        $license_category = 'SB';
        $license_table = $Table_Sb_Member;
    } else {
        alert('비정상적인 접근입니다.', $refer);
    }

    // 점수확정 접근시, 이미 확정 처리된 검정이면 에러처리
    $sql = "select exists (select * from {$Table_T1} where T_code = '{$T_code}' and (RESULT_DATE is not null and RESULT_DATE != '') limit 1) as CHK_EXIST";
    $result3 = sql_fetch($sql);
    if ($result3['CHK_EXIST'] > 0) {
        alert("해당 검정은 이미 모든 점수가 확정등록되었습니다.", "./sbak_console_T1_test_open_list.php?sports=" . $sports);
    }

    //응시자중에서, 납부되어 있고, 삭제상태가 아닌 응시자에만 평가정보 등록
    $sql = "select * from {$Table_T1_Apply} where T_code = '{$T_code}' and (PAYMENT_STATUS = 'Y') 
         and (T_status != '88' and T_status != '99') order by UID";
    $result_score = sql_query($sql);

    for ($i = 0; $row = sql_fetch_array($result_score); $i++) {

        $uid = $row['UID'];



        $AVERAGE = $row['AVERAGE'];



        if ($AVERAGE >= 70) { // 합격자 처리


            $query = "select exists (select K_LICENSE from {$license_table} where GUBUN = '{$test_season}' and K_GRADE = 'T1' and IS_DEL !='Y' limit 1) as CHK_EXIST";
            $row_exist = sql_fetch($query);
            if ($row_exist['CHK_EXIST'] < 1) {
                $code_start_num = 1;
                $code_start_num = sprintf('%04d', $code_start_num); // '0001' 형태로 숫자 자리수를 표시            
            } else {
                $query = "select max(right(K_LICENSE,4)) as HI_NUM from {$license_table} where GUBUN = '{$test_season}' and K_GRADE = 'T1' and IS_DEL !='Y'";
                $row_hi = sql_fetch($query);
                $code_start_num = ($row_hi['HI_NUM'] + 1);
                $code_start_num = sprintf('%04d', $code_start_num); // '0001' 형태로 숫자 자리수를 표시      


            }


            $license_no = "TⅠ" . $test_season .  $code_start_num;
            $query = "update {$Table_T1_Apply} set LICENSE_NO = '{$license_no}', AVERAGE = {$AVERAGE} where UID = {$uid}";
            sql_query($query);


            $member_id = $row['MEMBER_ID'] ?? '';
            $k_name = $row['MEMBER_NAME'] ?? '';
            $gubun = $test_season;
            $k_license = $license_no;
            $insert_date = date("Y-m-d H:i:s");
            $query = "select mb_2 from g5_member where mb_id like '{$member_id}'";
            $k_birth = sql_fetch($query);
            $k_birth = $k_birth['mb_2'] ?? '';

            $query = "insert into {$license_table} set MEMBER_ID = '{$member_id}', K_NAME = '{$k_name}', K_BIRTH = '{$k_birth}',
                GUBUN = {$gubun}, K_LICENSE = '{$k_license}', K_GRADE = 'T1', INSERT_DATE = '{$insert_date}'";
            sql_query($query);
        } else {
            $query = "update {$Table_T1_Apply} set AVERAGE = {$AVERAGE}, LICENSE_NO = '불합격' where UID = {$uid}";
            sql_query($query);
        }
    }



    $query = "select T_date,T_time from {$Table_T1} where T_code like '{$T_code}'";
    $row = sql_fetch($query);

    $regist_date = $row['T_date'] ?? '';
    $regist_time = $row['T_time'] ?? '';




    $update_date = date("Y-m-d"); //심사위원 테이블에 최종 점수등록 기록 삽입
    $update_time = date("H:i:s");
    $sql = " update {$Table_T1} set RESULT_DATE ='{$update_date}', RESULT_TIME = '{$update_time}' where T_code like '{$T_code}'";
    sql_query($sql);

    alert("점수등록이 완료되었습니다. 검정관리화면으로 이동합니다.", "./sbak_console_T1_test_open_list_detail.php?sports=" . $sports  . "&t_code=" . $T_code);
}



?>

<script type='text/javascript'>
    function T1_cancel(e) {
        // 조건 검사
        if (confirm("최종 확정 시, 더 이상 수정이 불가능합니다. 응시자 명단 중 점수가 미입력된 경우에는 0점으로 처리됩니다. 정말 확정 하시겠습니까?") === false) {
            e.preventDefault(); // 기본 동작(폼 전송) 막기
            return false;
        }
        // 확인 시에는 폼이 정상 전송됨
        return true;
    }
</script>

<style>
    .table thead th {
        color: #fff !important;
        /* 글자 흰색 */
    }


    .score-btn {
        padding: 10px 16px;
        font-size: 16px;
        min-width: 120px;
        /* 버튼 폭 고정도 가능 */
    }



    @media (max-width: 768px) {

        .score-btn {
            padding: 6px 10px;
            font-size: 13px;
            min-width: auto;
        }

        .custom-table col:nth-child(3) {
            width: 120px;
            /* 검정장소 */
        }

        .custom-table col:nth-child(4) {
            width: 120px;
            /* 접수인원 */
        }

        .custom-table col:nth-child(5) {
            width: 80px;
            /* 진행현황 (좁게) */
        }

        .custom-table td {
            word-break: keep-all;
            white-space: normal;
        }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"> 티칭1 검정 응시자 관리<span class="text-muted fw-light"> / Teaching 1</span></h4>

    <div class="card">


        <?php

        $sql = "select exists (select * from {$Table_T1} where T_code = '{$T_code}' and T_mb_id like '{$mb_id}' limit 1) as CHK_EXIST"; // 로그인한 본인 아이디의 검정코드만 검색
        $result = sql_fetch($sql);

        if (!$is_admin) { // 최고관리자가 아닐 경우에만, 에러처리
            if ($result['CHK_EXIST'] < 1) {
                alert("로그인한 아이디와 검정코드가 일치하지 않습니다", $refer);
            }
        }


        $sql = "select * from {$Table_T1} where T_code = '{$T_code}'";
        $result = sql_fetch($sql);
        $judge_name = $result['T_where'] ?? '';
        $get_T_status = $result['T_status'] ?? '';

        $query = "select count(*) as CNT from {$Table_T1_Apply} where T_code = '{$T_code}' and PAYMENT_STATUS = 'Y' and (T_status != '88' and T_status != '99')";

        $row_cnt = sql_fetch($query);
        $total_cnt = $row_cnt['CNT']; //결제완료 등록자수



        echo "<h5 class='card-header'> 스키장 : <span class='badge border border-primary text-primary'>" . $judge_name . "</span>
        <small>
        <a href='" . G5_THEME_URL . "/html/my_form/sbak_console_T1_test_open_list.php?sports=" . $sports . "' style='color:red; padding-top:10px;float:right;'>
        <i class='bx bxs-cog bx-spin'></i> 티칭1 검정 리스트 보기</a> </small>
        </h5>";



        // 종목명 설정
        if ($sports == 'ski') {
            $sports_1 = "플루그보겐";
            $sports_2 = "슈템턴";
            $sports_3 = "스탠다드롱턴";
            $sports_4 = "스탠다드숏턴";
        } else {
            $sports_1 = "사이드슬립,펜듈럼";
            $sports_2 = "비기너턴";
            $sports_3 = "너비스턴";
            $sports_4 = "카빙롱턴";
        }


        $query2 = "select count(*) as COUNT from {$Table_T1_Apply} where T_code = '{$T_code}' and (T_status != '88' and T_status != '99')";
        $row_count = sql_fetch($query2);
        $total_count = $row_count['COUNT']; //총 등록자 수



        /* paging : 한 페이지 당 데이터 개수 */
        $list_num = 20;

        /* paging : 한 블럭 당 페이지 수 */
        $page_num = 5;

        /* paging : 현재 페이지 */
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;

        /* paging : 전체 페이지 수 = 전체 데이터 / 페이지당 데이터 개수 */
        $total_page = ceil($total_count / $list_num);
        // echo "전체 페이지 수 : ".$total_page;

        /* paging : 전체 블럭 수 = 전체 페이지 수 / 블럭 당 페이지 수 */
        $total_block = ceil($total_page / $page_num);

        /* paging : 현재 블럭 번호 = 현재 페이지 번호 / 블럭 당 페이지 수 */
        $now_block = ceil($page / $page_num);

        /* paging : 블럭 당 시작 페이지 번호 = (해당 글의 블럭번호 - 1) * 블럭당 페이지 수 + 1 */
        $s_pageNum = ($now_block - 1) * $page_num + 1;
        // 데이터가 0개인 경우
        if ($s_pageNum <= 0) {
            $s_pageNum = 1;
        };

        /* paging : 블럭 당 마지막 페이지 번호 = 현재 블럭 번호 * 블럭 당 페이지 수 */
        $e_pageNum = $now_block * $page_num;
        // 마지막 번호가 전체 페이지 수를 넘지 않도록
        if ($e_pageNum > $total_page) {
            $e_pageNum = $total_page;
        };

        /* paging : 시작 번호 = (현재 페이지 번호 - 1) * 페이지 당 보여질 데이터 수 */
        $start = ($page - 1) * $list_num;


        $rec_num = 1 + (($page - 1) * $list_num);


        ?>


        <div class="table-responsive">
            <table class="table mb-0 custom-table">

                <thead class="table table-dark">
                    <tr>

                        <th>검정코드/행사일</th>
                        <th>시간/장소/인원</th>
                        <th>상태</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td>
                            <?php
                            if ($result['TYPE'] == 1) {
                                echo "<span class='badge rounded-pill bg-primary'>SKI</span>";
                            } elseif ($result['TYPE'] == 2) {
                                echo "<span class='badge rounded-pill bg-danger'>SB</span>";
                            }
                            ?>

                            <?php echo $result['T_code']; ?>
                            <p class='badge p-2 border border-primary text-primary'><?php echo $result['T_date']; ?></p>
                        </td>


                        <td>
                            <?php
                            $resort_no = $result['T_skiresort'];
                            $query = "select RESORT_NAME from {$Table_Skiresort} where NO = {$resort_no}";
                            $resort_name = sql_fetch($query);
                            ?>

                            <li><?php echo $result['T_time']; ?></li>
                            <li><?php echo $result['T_meeting']; ?></li>
                            <li><?php echo "등록 : " . $total_cnt . "명 (최대 " . $result['limit_member'] . "명)"; ?></li>


                        </td>
                        <td>

                            <?php
                            if ($get_T_status == '77' and (empty($result['RESULT_DATE']))) {
                                echo "<span class='badge rounded-pill bg-primary'>승인</span>";
                            }
                            if ($result['T_date'] < date("Y-m-d")) {
                                echo "<span class='badge rounded-pill bg-primary'>일정경과</span>";
                            }

                            if ($get_T_status == '77' and (!empty($result['RESULT_DATE']))) {
                                echo "<span class='badge rounded-pill bg-dark'>심사완료(" . $result['RESULT_DATE'] . ")</span>";
                                $confirm_result = "Y";
                            }
                            ?>


                        </td>
                    </tr>
                </tbody>

            </table>

        </div>
    </div><br>

    <!------ 진행상태에 따라 화면에 메뉴 차별화  -->
    <div class="alert  alert-dark mb-0" role="alert">
        <?php

        if ($confirm_result == 'Y') {
            echo "&#8251; 현재 모든 점수가 최종확정된 상태로 조회만 가능합니다.";
        } else {

            if (date("Y-m-d") < $result['T_date']) {
                echo "&#8251; 검정행사 진행 이전입니다. 응시자정보를 확인하고, 엑셀 다운만 가능합니다.";
            } else {
                echo "&#8251; 현재 최종 점수 확정 이전입니다. 검정이 종료되었다면, 엑셀등록 후 최종확정 과정을 통해, 최종 결과를 등록해주세요.";
            }
        }
        ?>

    </div> <br>

    <style>
        .T1_result_info_pc {
            display: block;
        }

        .T1_result_info_m {
            display: none;
        }



        @media screen and (max-width: 768px) {
            .T1_result_info_pc {
                display: none;
            }

            .T1_result_info_m {
                display: block;
            }
        }
    </style>


    <div class="card">
        <h5 class='card-header'> 응시자 정보 <small class='text-danger'> (총 <?php echo $total_cnt; ?> 명)</small>

            <small style='color:red; float:right;'>

                <form name="frm_final" action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
                    <input type='hidden' name='confirm_score' value='yes'>
                    <input type='hidden' name='t_code' value='<?php echo $T_code; ?>'>
                    <input type='hidden' name='sports' value='<?php echo $sports; ?>'>
                    <?php
                    if ($result['TEST_YEAR'] >= 2024) { // 2025년 부터 가능하게 
                    ?>
                        <input type='button' name='score_down' onclick="location.href='./sbak_T1_photo_list.php?t_code=<?php echo $T_code; ?>&sports=<?php echo $sports; ?>'" value='사진대조'>
                        <input type='button' name='score_down' onclick="location.href='./excel_down.php?t_code=<?php echo $T_code; ?>&sports=<?php echo $sports; ?>'" value='응시자 다운'>
                        <input type='button' name='bib_regist' onclick="location.href='./excel_bib.php?t_code=<?php echo $T_code; ?>&sports=<?php echo $sports; ?>'" value='BIB 등록'>



                        <?php
                        if ($sports == 'ski') {
                            $the_excel = G5_THEME_URL . "/sbak_files/register_t1_excel_sk_1.xls";
                        } else {
                            $the_excel = G5_THEME_URL . "/sbak_files/register_t1_excel_sb_1.xls";
                        }

                        ?>

                        <input type='button' name='form_down' onclick="location.href='<?php echo $the_excel; ?>'" value='결과표 양식'>


                        <?php
                        if ($confirm_result !== 'Y' && (date("Y-m-d") >= $result['T_date'])) { //아직 최종 확정이전이고, 검정일 이후면  
                        ?>

                            <input type='button' name='score_input' onclick="location.href='./excel_input.php?t_code=<?php echo $T_code; ?>&sports=<?php echo $sports; ?>'" value='결과표 등록'>
                            <input type='submit' onclick="return T1_cancel(event)" value='최종 확정'>
                    <?php
                        }
                    }
                    ?>
                </form>

            </small>
        </h5>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="table table-dark">
                    <tr>
                        <th>응시자</th>
                        <th>상세</th>
                        <th>BIB</th>

                    </tr>
                </thead>
                <tbody>


                    <?php

                    $sql = "select * from {$Table_T1_Apply} where T_code = '{$T_code}' and (T_status != '88' and T_status != '99') order by MEMBER_NAME desc 
        limit {$start}, {$list_num}";
                    $result = sql_query($sql);

                    for ($i = 0; $row = sql_fetch_array($result); $i++) {

                        $uid = $row['UID'] ?? '';
                        $p_MB_ID = $row['MEMBER_ID'] ?? '';

                        $query = "select mb_2 from g5_member where mb_id = '{$p_MB_ID}'";
                        $result1 = sql_fetch($query);
                        $p_birth = substr($result1['mb_2'], 0, 4) ?? '';
                        $p_TEL = $row['PHONE'] ?? '';
                        $p_MB_NAME = $row['MEMBER_NAME'] ?? '';
                        $p_MB_ID = substr_replace($row['MEMBER_ID'], "****", 5) ?? '';


                        $member_payment_status = $row['PAYMENT_STATUS'] ?? '';

                        if ($member_payment_status == 'Y') {

                            $member_payment_status = "<span class='badge rounded-pill bg-primary my-1'>결제완료</span>";
                            $p_TEL = $row['PHONE'] ?? '';
                            $p_MB_NAME = $row['MEMBER_NAME'] ?? '';
                        } elseif ($member_payment_status == 'C') {

                            $member_payment_status = "<span class='badge rounded-pill bg-danger my-1'>취소완료</span>";

                            $p_birth = "****";

                            $p_TEL = substr_replace($row['PHONE'], "*********", 3);
                            $p_MB_NAME = mb_substr($row['MEMBER_NAME'], 0, 1, 'utf8') . "**";
                        }



                    ?>

                        <tr>
                            <td>
                                <?php
                                // 회원이미지 경로
                                $mb_img_path = G5_DATA_PATH . '/member_image/' . substr($row['MEMBER_ID'], 0, 2) . '/' . get_mb_icon_name($row['MEMBER_ID']) . '.jpg';
                                $mb_img_filemtile = (defined('G5_USE_MEMBER_IMAGE_FILETIME') && G5_USE_MEMBER_IMAGE_FILETIME && file_exists($mb_img_path)) ? '?' . filemtime($mb_img_path) : '';
                                $mb_img_url = G5_DATA_URL . '/member_image/' . substr($row['MEMBER_ID'], 0, 2) . '/' . get_mb_icon_name($row['MEMBER_ID']) . '.jpg' . $mb_img_filemtile;
                                ?>

                                <?php if (file_exists($mb_img_path)) {  ?>
                                    <img src="<?php echo $mb_img_url ?>" class="d-block rounded" width='120px' alt="회원이미지" id="uploadedAvatar">
                                <?php } ?>



                                <?php

                                echo "<p class='h6'>" . $p_MB_NAME . "</p>";

                                ?>
                                <ul>
                                    <li>
                                        (<?php echo $p_MB_ID; ?>)
                                    </li>
                                    <li>
                                        <?php echo $p_birth; ?> 년생
                                    </li>
                                    <li>
                                        <?php echo $p_TEL; ?>
                                    </li>
                                </ul>

                            </td>



                            <td>
                                <?php echo $member_payment_status; ?>

                                <?php

                                if ($row['PAYMENT_STATUS'] = 'Y') { //입금완료자만 처리
                                    echo "<div class='T1_result_info_pc'>"; //pc용
                                    if (!empty($row['LICENSE_NO'])) {
                                        if ($row['LICENSE_NO'] == '불합격') {
                                            echo "<h6> <span class='badge bg-warning'>불합격</span></h6>";
                                        } else {
                                            echo "<h6> <span class='badge border border-secondary text-secondary'> 자격번호 : " . $row['LICENSE_NO'] . "</span></h6>";
                                        }
                                    } else {
                                        echo "<h6> <span class='badge bg-warning'>미확정</span></h6>";
                                    }





                                    if (($row['AVERAGE'] > 0)) {
                                        echo "<span class='badge border border-info text-dark m-1'>" . $sports_1 . " <span class='text-info'>" . $row['SCORE1_1'] . " " . $row['SCORE1_2'] . " " . $row['SCORE1_3'] . "</span></span>";
                                        echo "<span class='badge border border-info text-dark m-1'>" . $sports_2 . " <span class='text-info'>" . $row['SCORE2_1'] . " " . $row['SCORE2_2'] . " " . $row['SCORE2_3'] . "</span></span>";
                                        echo "<span class='badge border border-info text-dark m-1'>" . $sports_3 . " <span class='text-info'>" . $row['SCORE3_1'] . " " . $row['SCORE3_2'] . " " . $row['SCORE3_3'] . "</span></span>";
                                        echo "<span class='badge border border-info text-dark m-1'>" . $sports_4 . " <span class='text-info'>" . $row['SCORE4_1'] . " " . $row['SCORE4_2'] . " " . $row['SCORE4_3'] . "</span></span>";
                                    }


                                    if (is_null($row['AVERAGE']) or $row['AVERAGE'] < 1) {
                                        echo " ";
                                    } else {
                                        echo "<span class='badge bg-primary m-1'>평균: " . $row['AVERAGE'] . "</span>";
                                    }

                                    echo "</div>";



                                    echo "<div class='T1_result_info_m'>"; //모바일용
                                    if (!empty($row['LICENSE_NO'])) {
                                        if ($row['LICENSE_NO'] == '불합격') {
                                            echo "<span class='badge bg-warning'>불합격</span>";
                                        } else {
                                            echo "<small class='badge border border-secondary text-secondary'>NO : " . $row['LICENSE_NO'] . "</small><br>";
                                        }
                                    } else {
                                        echo "<span class='badge bg-warning'>미확정</span>";
                                    }



                                    if (($row['AVERAGE'] > 0)) {
                                        echo "<span class='badge border border-info text-dark m-1'>" . $sports_1 . " <span class='text-info'>" . $row['SCORE1_1'] . " " . $row['SCORE1_2'] . " " . $row['SCORE1_3'] . "</span></span><br>";
                                        echo "<span class='badge border border-info text-dark m-1'>" . $sports_2 . " <span class='text-info'>" . $row['SCORE2_1'] . " " . $row['SCORE2_2'] . " " . $row['SCORE2_3'] . "</span></span><br>";
                                        echo "<span class='badge border border-info text-dark m-1'>" . $sports_3 . " <span class='text-info'>" . $row['SCORE3_1'] . " " . $row['SCORE3_2'] . " " . $row['SCORE3_3'] . "</span></span><br>";
                                        echo "<span class='badge border border-info text-dark m-1'>" . $sports_4 . " <span class='text-info'>" . $row['SCORE4_1'] . " " . $row['SCORE4_2'] . " " . $row['SCORE4_3'] . "</span></span><br>";
                                    }


                                    if (is_null($row['AVERAGE']) or $row['AVERAGE'] < 1) {
                                        echo " <span class='badge bg-info'>점수 미입력</span>";
                                    } else {
                                        echo "<span class='badge bg-primary m-1'>평균: " . $row['AVERAGE'] . "</span>";
                                    }

                                    echo "</div>";
                                }



                                ?>



                            </td>
                            <td>
                                <form name="frm_update_bib" method="post" action="update_bib.php">
                                    <input type="hidden" name="uid" value="<?php echo $row['UID']; ?>"> <!-- 어떤 행인지 구분용 -->
                                    <input type="text" name="BIB_NO"
                                        value="<?php echo $row['BIB_NO']; ?>"
                                        style="width:50px; text-align:center;"
                                        maxlength="3"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);"><br>
                                    <label>
                                        <input type="checkbox" name="BIB_YN" value="Y" <?php if ($row['BIB_YN'] == 'Y') echo 'checked'; ?>>
                                        수령
                                    </label><br>
                                    <input type="submit" value="수정">
                                </form>
                            </td>


                        </tr>


                    <?php } ?>


                </tbody>

            </table>

        </div>





        <!-- 줄 띠우고 -->
        <hr class="my-2" />

        <!-- 페이징 시작 -->

        <div class="d-flex justify-content-center mx-auto gap-3">
            <nav aria-label="Page navigation example">
                <div style="text-align:center;">
                    <ul class="pagination">

                        <?php $basename = basename($_SERVER["PHP_SELF"]); ?>
                        <li class='page-item'><a class='page-link'
                                href="<?php echo $basename . "?t_code=" . $T_code . "&sports=" . $sports; ?>" aria-label='전체'>
                                <span aria-hidden='true'>처음</span></a></li>

                        <?php

                        /* paging : 이전 페이지 */
                        if ($page <= 1) {
                        ?>
                            <li class='page-item'><a class='page-link'
                                    href="<?php echo $basename; ?>?page=1&sports=<?php echo $sports; ?>"
                                    aria-label='Previous'>
                                    <span aria-hidden='true'>&laquo;</span></a></li>
                        <?php } else { ?>
                            <li class='page-item'><a class='page-link'
                                    href="<?php echo $basename; ?>?t_code=<?php echo $T_code; ?>&page=<?php echo ($page - 1); ?>&sports=<?php echo $sports; ?>"
                                    aria-label='Previous'>
                                    <span aria-hidden='true'>&laquo;</span></a></li>
                        <?php }; ?>

                        <?php
                        /* pager : 페이지 번호 출력 */
                        for ($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++) {

                            if ($page == $print_page) {
                        ?>
                                <li class='page-item active' aria-current="page"><a class='page-link' href="#">
                                        <?php echo $print_page; ?>
                                    </a>
                                </li>
                            <?php } else { ?>

                                <li class='page-item'><a class='page-link'
                                        href="<?php echo $basename; ?>?t_code=<?php echo $T_code; ?>&page=<?php echo $print_page; ?>&sports=<?php echo $sports; ?>"><?php echo $print_page; ?></a></li>

                        <?php }
                        } ?>

                        <?php
                        /* paging : 다음 페이지 */
                        if ($page >= $total_page) {
                        ?>
                            <li class='page-item'><a class='page-link'
                                    href="<?php echo $basename; ?>?t_code=<?php echo $T_code; ?>&page=<?php echo $total_page; ?>&sports=<?php echo $sports; ?>"
                                    aria-label='Next'>
                                    <span aria-hidden='true'>&raquo;</span></a></li>
                        <?php } else { ?>
                            <li class='page-item'><a class='page-link'
                                    href="<?php echo $basename; ?>?t_code=<?php echo $T_code; ?>&page=<?php echo ($page + 1); ?>&sports=<?php echo $sports; ?>"
                                    aria-label='Next'>
                                    <span aria-hidden='true'>&raquo;</span></a></li>
                        <?php }; ?>


                        <li class='page-item'><a class='page-link'
                                href="<?php echo $basename; ?>?t_code=<?php echo $T_code; ?>&page=<?php echo $total_page; ?>&sports=<?php echo $sports; ?>"
                                aria-label='마지막'>
                                <span aria-hidden='true'>마지막</span></a></li>


                    </ul>

                </div>
            </nav>
        </div>


        <!-- 페이징 끝 -->
    </div>
</div>

<?php
include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
?>