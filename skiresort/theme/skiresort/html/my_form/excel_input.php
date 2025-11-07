<?php

include_once('./header_console.php'); //공통 상단을 연결합니다.



$t_code = $_GET['t_code'] ?? '';
$refer =  $_SERVER['HTTP_REFERER'];
if (empty($t_code) && !$is_admin) {
    alert("정상적인 경로가 아닙니다.", $_SERVER['HTTP_REFERER']);
}




//아래의 T_status는 어떤 규정으로 진행할지 미리 계획
$query = " select exists (select T_code from {$Table_T1} where T_code = '{$t_code}' and (T_status != '88' and T_status != '99')  limit 1) as CHK_EXIST";
$result_chk = sql_fetch($query);

if ($result_chk['CHK_EXIST'] < 1) {
    alert("해당 티칭테스트는 존재하지 않습니다.", $refer);
} else {
    $query = " select exists (select T_mb_id from {$Table_T1} where T_code = '{$t_code}' and T_mb_id ='{$member['mb_id']}' limit 1) as CHK_EXIST";
    $result_chk = sql_fetch($query);
    if ($result_chk['CHK_EXIST'] < 1) {
        alert("해당 행사의 관리자가 아닙니다.", $refer);
    }
}


$query = "select T_where,TYPE,T_date from {$Table_T1} where T_code = '{$t_code}'";
$result_1 = sql_fetch($query);

$the_resort_name = $result_1['T_where'] ?? '';
$the_type = $result_1['TYPE'] ?? '';
$test_date = $result_1['T_date'] ?? '';

if ($the_type == '1') {
    $the_sports_kr = '스키';
} else {
    $the_sports_kr = '스노보드';
}



?>



<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">


                    <div class="bg_vline"></div>
                    <h4 class="fw-bold py-3 mb-4"><?php echo $the_sports_kr; ?> 티칭1 결과표 등록</h4>
                    <hr style="margin-bottom:30px;">

                    <h5 class="mb-2"><span class='text-dark'><i class='bx bx-caret-right'></i> 개최스키장 : </span><?php echo $the_resort_name; ?> </h5>

                    <h5 class="mb-2"><span class='text-dark'><i class='bx bx-caret-right'></i> 검정개최일 : </span><?php echo $test_date; ?> </h5>

                    <p class="text-danger mt-5 mb-3"> &#8251;일괄등록을 위해서는, 아래의 이용방법을 확인하세요.</p>



                    <div class="online_wrap">
                        <ul>
                            <li> 일괄등록을 하려면, 아래의 엑셀양식(파란글씨 링크)을 다운받아 사용하세요. 일괄 등록의 편의성을 제공하기 위해서는,
                                입력자료가 자료 형식에 맞게 정확해야 합니다.</li>
                            <li> 엑셀파일을 저장하실 때는 <strong>Excel 97 - 2003 통합문서 (*.xls)</strong> 로 저장하셔야 합니다. </li>
                            <li> 엑셀에 기 등록되어 있는 입력양식을 변형시, 등록되지 않습니다. 모든 입력칸은 빠짐없이 정보가 입력되어야 합니다. </li>
                            <li> 다운받은 자료의 연락처 정보를 수정해도 서버에는 반영되지 않습니다. 필요할 경우, 각 응시자 본인이 회원정보를 수정해야 합니다. </li>
                            <li> 아이디와 이름, 생년월일이 일치하지 않을 경우, 등록되지 않습니다. 사전에 미리, 정확히 응시자정보를 확인해주세요. </li>
                            <li> 한번에 최대 300명까지 등록할 수 있습니다. </li>
                            <li> 엑셀양식 입력 필드 중 점수는 반드시 숫자만 입력해야합니다. </li>
                            <li> 전체 리스트 중 하나의 데이터만 오류가 있어도, 전체 자료가 등록이 되지 않습니다. </li>
                            모든 자료가 정상등록되었다는 메세지를 화면에서 확인하지 못할 경우, 오류사항 수정해서 다시 시도해주시기 바랍니다. </li>
                            <li> 등록자료가 이상없이 등록되면, 각 검정 응시관리페이지에서 응시자의 점수가 등록된 걸 확인할 수 있습니다. 확인 후, '최종확정'버튼을 클릭해야
                                최종적으로 합격, 불합격 처리 및 자격번호가 발급됩니다. (최종확정 후에는 절대 수정 불가합니다.) </li>
                        </ul>

                    </div>



                    <style>
                        .new_excel {
                            border: 3px solid #ccc;
                            padding: 0 20px 20px 20px;
                            margin-top: 20px;
                        }

                        .new_excel h2 {
                            margin: 10px 0;
                        }
                    </style>

                    <div class="new_excel">

                        <h2><img src='type-excel.png' width='50px'>엑셀파일 등록</h2>

                        <div class="excel_info">

                            <p>
                                <?php
                                if ($the_type == '1') {
                                    $the_excel = G5_THEME_URL . "/sbak_files/register_t1_excel_sk_1.xls";
                                } else {
                                    $the_excel = G5_THEME_URL . "/sbak_files/register_t1_excel_sb_1.xls";
                                }

                                ?>
                                <a href="<?php echo $the_excel; ?>"> <i class="fa fa-file-excel-o"></i> 신규등록용 엑셀양식
                                    다운로드(Click)</a>.
                            </p>
                        </div>

                        <form name="fitemexcelup" id="fitemexcelup" class="row g-3" method="post"
                            action="./excel_input_go.php" enctype="MULTIPART/FORM-DATA" autocomplete="off">

                            <input type="hidden" name="the_type" value="<?php echo $the_type; ?>">
                            <input type="hidden" name="t_code" value="<?php echo $t_code; ?>">


                            <div class="col-auto">
                                <i class="fa fa-file-excel-o"></i>
                            </div>
                            <div class="col-auto">
                                <input type="hidden" name="ex_type" value="2">
                                <input class="form-control" required type="file" id="excelfile" name="excelfile" accept=".xls,.XLS" onchange="checkFile(this)">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-3" value="엑셀파일 등록">등록하기</button>

                            </div>

                            <div>

                                <small class='text-danger'>&#8251; 엑셀 파일의 크기는 10MB이내만 가능합니다. </small>

                            </div>

                        </form>

                    </div>


                </div>

            </div>
        </div>
    </div>


</div>
<script>
    function checkFile(f) {
        //files로 해당 파일정보 얻기
        var file = f.files;
        const MAX_SIZE_MB = 10; // 예: 10MB			
        const fileSizeInMB = file[0].size / (1024 * 1024); // 바이트를 MB로 변환
        if (!/\.(xls|XLS)$/i.test(file[0].name)) {
            alert('xls, XLS 파일만 선택해 주세요.\n\n현재 파일 : ' + file[0].name);
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
</script>


<?php
include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
?>