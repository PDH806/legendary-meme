<?php
include_once('./header_console.php'); //공통 상단을 연결합니다.



$g5['title'] = "Teaching 1 Test"; //커스텀페이지의 타이틀을 입력합니다.     



$test_code = $_POST['test_code'] ?? '';

$apply_table_name = $Table_T1_Apply;
$host_table_name = $Table_T1;

if ($test_code == '') {
    alert("비정상적인 접근입니다.", $_SERVER['HTTP_REFERER']);
}

// 유효한 관리자인지 체크

$query = " select exists (select T_mb_id from {$host_table_name} where T_code = '{$test_code}' and T_mb_id ='{$member['mb_id']}' limit 1) as CHK_EXIST";
$result_chk = sql_fetch($query);

if (($result_chk['CHK_EXIST'] < 1) && ($member['mb_level'] < 10)) { //최고 관리자가 아니면서, 해당되는 레코드가 없으면 에러처리
    alert("이 페이지에 접근권한이 없습니다.", $_SERVER['HTTP_REFERER']);
}



$query = "select T_where,TYPE,T_date from {$host_table_name} where T_code = '{$test_code}'";
$result_1 = sql_fetch($query);

$the_resort_name = $result_1['T_where'] ?? '';
$the_type = $result_1['TYPE'] ?? '';
$test_date = $result_1['T_date'] ?? '';


if ($the_type == 'sb') {
    $the_sports = 'SNOWBOARD';
} else {
    $the_sports = 'SKI';
}





?>


<div class="container-xxl flex-grow-1 container-p-y">



    <div class="bg_vline"></div>
    <p style='font-size:22px;font-weight:400;'><em>Teaching 1 TEST</em> 엑셀등록 진행결과</p><br>
    <p style='font-size:17px;font-weight:400;'>아래와 같이 진행되었습니다. <br> 등록에러가 생긴 경우, 내용을 잘 확인하고, 재시도 해주세요.</p>




    <div style="float:right;"><a href="#"
            style="color:red;">
            <i class="fa fa-cog fa-spin fa-fw"></i>
            엑셀 선택으로 돌아가기
        </a>
    </div>

    <div style="padding:20px 0 20px 0;margin-bottom:20px;margin-top:20px;border-top:1px solid #333;;border-bottom:1px solid #333; ">
        <?php
        echo "<p style='font-size:18px;font-weight:400;color:#666';'> <i class='fa fa-plus'></i> 스키장명 : <b>" . $the_resort_name . "</b> </p>";
        echo "<p style='font-size:18px;font-weight:400;color:#666';'> <i class='fa fa-plus'></i>종목 : <b>" . $the_resort_name . "</b></p>";
        echo "<p style='font-size:18px;font-weight:400;color:#666';'> <i class='fa fa-plus'></i>시행일 : <b>" . $test_date . "</b></p>";
        echo "<p style='font-size:18px;font-weight:400;color:#666';'> <i class='fa fa-plus'></i>등록자 : <b>" . $member['mb_name'] . "</b></p>";
        ?>
    </div>
    <div class="card">
        <style>
            .table-style-01 {
                font-size: 1.1em;
                width: 100%;
                border-top: 3px solid #666;
                border-bottom: 3px solid #666;
                border-collapse: collapse;
            }

            .table-style-01 th {
                text-align: right;
                padding: 10px;
                border-top: 1px solid black;
            }

            .table-style-01 td {
                text-align: left;
                padding: 10px;
                border-top: 1px solid black;
            }
        </style>


        <table class="table-style-01">


            <?php


            use PhpOffice\PhpSpreadsheet\Spreadsheet; //처음 선언해야 함.
            use PhpOffice\PhpSpreadsheet\Reader\Xls; //처음 선언해야 함.

            error_reporting(E_ALL);
            ini_set("display_errors", 1);

            if (isset($_POST['ex_type']) && !$_POST['ex_type']) {
                alert("파일유형을 선택해주세요");
            }

            // 상품이 많을 경우 대비 설정변경
            set_time_limit(0);
            ini_set('memory_limit', '10M');

            if (!$_FILES['excelfile']['tmp_name']) {
                alert("등록할 파일이 없습니다");
            }


            //엑셀파일만 등록되게 처리


            if ($_FILES['excelfile']['tmp_name']) {

                $inputFileName = $_FILES['excelfile']['tmp_name'];

                require_once(G5_THEME_PATH . '/html/excel_test/PhpOffice/Psr/autoloader.php'); //설치폴더 변경시 G5_THEME_PATH 수정요함
                require_once(G5_THEME_PATH . '/html/excel_test/PhpOffice/PhpSpreadsheet/autoloader.php'); //설치폴더 변경시 G5_THEME_PATH 수정요함

                $reader = new PhpOffice\PhpSpreadsheet\Reader\Xls();

                $reader->setReadDataOnly(true); //데이터가 있는 행까지만 읽음

                $spreadsheet = $reader->load($inputFileName);

                $data = $spreadsheet->getSheet(0)->toArray(null, true, true, true); // >getSheet(0) 첫번째 시트 /  두번째는 getSheet(1)

                $Rows = $spreadsheet->getActiveSheet()->getHighestRow(); // 줄수 계산

                if ($Rows > 102) { // 제목줄을 제외하면, 100개까지만 있는지 체크
                    alert("최대 100건 까지만 가능합니다. 엑셀 데이터를 100개 이하로 수정하세요.", $_SERVER['HTTP_REFERER']);
                }


                $total_line = 0; //건수 초기화 
                $dupcount = 0;
                $errorcount = 0;


                $error_msg_1 = "해당 아이디 및 이름과 일치하는 응시자는 없습니다. 가입된 아이디와 이름을 다시 확인하세요. ";
                $error_msg_2 = "각 종목별 점수는 0점 (미응시) ~ 79점 사이로 입력해주세요.";
                $error_msg_4 = "엑셀에 빈칸이 있습니다. 모든 칸을 빠짐없이 입력하세요.";
                $error_msg_5 = "점수는 2자리의 숫자로만 입력되어야 합니다. 엑셀자료를 확인해주세요.";
                $error_msg_7 = "이 ID의 응시자는 이미 결과가 등록되어 있어서, 추가할 수 없습니다. 사무국에 문의하세요.";

                echo "<tr style='background-color:#efefef;'><th scope='row'>레코드 구분</th><td></td><td> 에러내용 </td></tr>";

                if ($_POST['ex_type'] == "2") {

                    if (!empty($data)) {

                        for ($i = 3; $i <= count($data); $i++) { //시작은 1부터.. 

                            $set_no = $i - 2;

                            if ($set_no > 100) { //100건을 넘어가면 반복문 탈출
                                $set_no = $set_no - 1;
                                break;
                            }

                            $chk_pass = "Y"; //문제없을 경우
                            $error_no = 100;


                            $the_mb_id = trim($data[$i]['A']); //응시자 아이디

                            $score1 = $data[$i]['E'];
                            if (!is_numeric($score1)) { //엑셀에서 넘어올때 숫자가 아니면  
                                $chk_pass = "N";
                                $error_no = 5;
                            } else { //점수범위를 넘어서는지
                                if (intval($score1) < 0 || intval($score1) > 79) {
                                    $chk_pass = "N";
                                    $error_no = 2;
                                }
                            }



                            $score2 = $data[$i]['F'];
                            if (!is_numeric($score2)) { //엑셀에서 넘어올때 숫자가 아니면  
                                $chk_pass = "N";
                                $error_no = 5;
                            } else { //점수범위를 넘어서는지
                                if (intval($score2) < 0 || intval($score2) > 79) {
                                    $chk_pass = "N";
                                    $error_no = 2;
                                }
                            }


                            $score3 = $data[$i]['G'];
                            if (!is_numeric($score3)) { //엑셀에서 넘어올때 숫자가 아니면  
                                $chk_pass = "N";
                                $error_no = 5;
                            } else { //점수범위를 넘어서는지
                                if (intval($score3) < 0 || intval($score3) > 79) {
                                    $chk_pass = "N";
                                    $error_no = 2;
                                }
                            }


                            $score4 = $data[$i]['H'];
                            if (!is_numeric($score4)) { //엑셀에서 넘어올때 숫자가 아니면  
                                $chk_pass = "N";
                                $error_no = 5;
                            } else { //점수범위를 넘어서는지
                                if (intval($score4) < 0 || intval($score4) > 79) {
                                    $chk_pass = "N";
                                    $error_no = 2;
                                }
                            }



                            $the_mb_name =  trim($data[$i]['B']);
                            $birth_date =  $data[$i]['C'];
                            $the_tel =  trim($data[$i]['D']);


                            //빈칸있으면 에러처리

                            if (empty($the_mb_id) || empty($the_mb_name) || empty($birth_date) || empty($the_tel)) {
                                $chk_pass = "N";
                                $error_no = 4;
                            }
                            if (empty($data[$i]['I']) || empty($data[$i]['J']) || empty($data[$i]['K'])) {
                                $chk_pass = "N";
                                $error_no = 4;
                            }





                            if ($chk_pass == "N") { //에러발생시 

                                echo "<tr><th scope='row'><i class='fa fa-warning'></i>" . $set_no . "]  " . $the_mb_id . "</th><td> <i class='fa fa-times'></i></td><td> <span>";

                                switch ($error_no) {
                                    case 2: //점수범위 에러
                                        echo $error_msg_2;
                                        break;
                                    case 4: //빈값 에러
                                        echo $error_msg_4;
                                        break;
                                    case 5: //숫자형 에러
                                        echo $error_msg_5;
                                        break;
                                    case 8:
                                        echo $error_msg_8; //등급이 빈값이거나, 숫자가 아님
                                        break;


                                    default:
                                        break;
                                }
                                echo "</span></td></tr>";
                                $errorcount++;
                            } else { //기본 데이터 에러가 없으면


                                // 아래 부분은 테스트를 위해 변수 강제 설정, 실 운영시 삭제
                                // $test_code = 'HO2025-0202';
                                // $the_mb_id = 'sbakadmin';
                                // $the_mb_name = '서버관리자';


                                $sql = "select exists (select UID from {$apply_table_name} where T_code = '{$test_code}' and MEMBER_ID = '{$the_mb_id}' 
                                and MEMBER_NAME = '{$the_mb_name}' and PAYMENT_STATUS = 'Y' limit 1) as CHK_EXIST";


                                $chk_result = sql_fetch($sql);

                                if ($chk_result['CHK_EXIST'] < 1) { // 아이디, 이름, payment_status가 정상인 레코드가 없으면
                                    echo "<tr><th scope='row'><i class='fa fa-warning'></i>" . $set_no . "] " . $the_mb_id . "</th>
                                    <td> <i class='fa fa-warning'></i></td><td><span>해당 ID와 이름에 매칭되는 응시자가 없습니다.</span></td></tr>";
                                    $errorcount++;
                                } else { //유효한 응시자가 존재하면

                                    //이미 평가 완료된 레코드인지 확인
                                    $sql = "select UID,TOTAL_SCORE,FINAL_RESULT from {$apply_table_name} where T_code = '{$test_code}' and MEMBER_ID = '{$the_mb_id}' and PAYMENT_STATUS = 'Y'";
                                    $chk_result = sql_fetch($sql);
                                    if (!empty($chk_result['TOTAL_SCORE']) || !empty($chk_result['FINAL_RESULT'])) { //점수 및 결과 필드가 비어있지 않으면 
                                        echo "<tr><th scope='row'><i class='fa fa-warning'></i>" . $set_no . "]" . $the_mb_id . "</th><td> <i class='fa fa-times'></i></td>
                                        <td>이미 점수가 등록된 응시자이므로 재등록 할 수없습니다.</td></tr>";
                                        $errorcount++;
                                    } else { //정상 레코드 이면

                                        $target_uid = $chk_result['UID'];
                                        $total_score = $score1 + $score2 + $score3 + $score1;

                                        if ($total_score < 280) { //불합격이면
                                            $final_result = "불합격";
                                            $license_no = '';
                                        } else {
                                            $final_result = "합격";
                                            $license_no = "T122223333"; // 자격번호 생성, 자격증 테이블에서 가장 뒷자리 가져와서 +1
                                        }

                                        $score_date = date("Y-m-d");

                                        $query = "update {$apply_table_name} set SCORE1 = {$score1}, SCORE2 = {$score2}, SCORE3 = {$score3}, SCORE4 = {$score4},
                                                 SCORE1_DATE = '{$score_date}',SCORE2_DATE = '{$score_date}',SCORE3_DATE = '{$score_date}',SCORE4_DATE = '{$score_date}',
                                                  TOTAL_SCORE = {$total_score}, FINAL_RESULT = '{$final_result}', LICENSE_NO = '{$license_no}' where UID = {$target_uid} ";
                                        sql_query($query);
                                        // echo $query . "<br>";

                                        $total_line++;
                                    } //정상 등록 end
                                }
                            } //에러통과시 end



                        } //for end



                    } //data check

                } //file check

            } //upload file check




            ?>


        </table>

        <?php echo "<span style='font-size:18px'>총 시도 : " . $set_no . "건 | 에러 : " . $errorcount . "건 | 정상 : " . $total_line . "건</span><br><br>"; ?>

        <?php
        if ($set_no == $total_line) {
            echo "<p style='font-size:22px;font-weight:500;color:blue;'><i class='fa fa-thumbs-up'></i>모든 레코드가 정상 등록되었습니다.</p>";
        } else {
            echo "<p style='font-size:22px;font-weight:500;color:red'><i class='fa fa-exclamation'></i>일부 레코드에 에러가 있어서 등록에 실패했습니다. 엑셀 자료를 다시 한번 점검하고 재시도해주세요.</p>";
        }
        ?>


    </div>
</div>

<?php
include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
?>