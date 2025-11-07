<?php

if ($_GET['exempt'] == 'Y') {

    $sub_menu = '590800';
    $table = "SBAK_EXEMPTION_LIST";

} else {

    alert("비정상적인 접근입니다.", G5_URL);

}


include_once('./_common.php');

add_stylesheet('<link rel="stylesheet" href="' . G5_URL . '/adm/css/sbak_css.css">', 0);


auth_check_menu($auth, $sub_menu, 'r');


    $g5['title'] = '자동면제자 대상자 추가';


include_once('./admin.head.php');


$colspan = 7;


?>


<form name="ksia_license_list" id="ksia_license_list" action="./sbak_exemption_add_update.php"
    onsubmit="return ksia_license_list_submit(this);" method="post">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="">
    <input type="hidden" name="exempt" value="Y">

    <div class="tbl_wrap tbl_head01">
        <table>
            <thead>
                <tr>
                    <th scope="col">
                        <label for="chkall" class="sound_only">그룹 전체</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>
                    <th scope="col">NO</th>
                    <th scope="col">이름(필수)</th>
                    <th scope="col">생년월일(필수)</th>
                    <th scope="col">구분(필수)</th>
                    <th scope="col">필기면제</th>
                    <th scope="col">실기면제</th>
                </tr>
            </thead>
            <tbody>
                <?php


                for ($i = 1; $i <= 15; $i++) {


                    $bg = 'bg' . ($i % 2); ?>


                    <tr class="<?php echo $bg; ?>">


                        <td class="td_chk">
                            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
                        </td>
                        <td>
                            <?php echo $i; ?>
                        </td>
                        <td>
                            <input type="text" name="K_NAME[<?php echo $i ?>]" class="tbl_input" size="10"
                                placeholder="이름을 입력">
                        </td>
                        <td>
                            <input type="date" name="K_BIRTH[<?php echo $i ?>]" class="ksia_input" placeholder="생년월일">
                        </td>
                        <td>
                            <input type='radio' name='SPORTS[<?php echo $i ?>]' value='B02'>스키티칭2
                            <input type='radio' name='SPORTS[<?php echo $i ?>]' value='B05'>보드티칭2
                            <input type='radio' name='SPORTS[<?php echo $i ?>]' value='B07'>스키구조요원
                        </td>
                        <td>
                            <input type="checkbox" name='EXEMPT_1[<?php echo $i ?>]' value="Y" class='tbl_input' size="8">
                        </td>
                        
                        <td>
                            <input type="checkbox" name='EXEMPT_2[<?php echo $i ?>]' value="Y" class='tbl_input' size="8">
                        </td>

                    </tr>


                <?php } ?>

            </tbody>
        </table>
    </div>


    <div class="btn_fixed_top">
        <input type="submit" name="act_button" value="선택등록" onclick="document.pressed=this.value" class="btn btn_02">
    </div>

</form>

<br>
<a href="#" class="btn btn_03" onClick="history.back();">취소(이전 화면으로 복귀)</a> <br>


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
        <h2>엑셀파일 등록</h2>

        <div class="excel_info">

            <p>
                <a href="<?php echo G5_THEME_URL; ?>/sbak_files/sbak_exemption_excel.xls"> <i class="fa fa-file-excel-o"></i> 신규등록용 엑셀양식
                    다운로드(Click)</a>.
            </p>
        </div><br>

        <form name="fitemexcelup" id="fitemexcelup" class="row g-3" method="post"
            action="sbak_exemption_excel_update.php" enctype="MULTIPART/FORM-DATA" autocomplete="off">
            <input type="hidden" name="exemption" value="Y">


            <div class="col-auto">
                <input type="hidden" name="ex_type" value="2">
                <input class="form-control" required type="file" id="excelfile" name="excelfile" accept=".xls,.XLS" onchange="checkFile(this)">
            </div><br>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3" value="엑셀파일 등록">등록하기</button>
            </div>

            <div>


            </div>

        </form>

    </div>
<script>
    function ksia_license_list_submit(f) {
        if (!is_checked("chk[]")) {
            alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
            return false;
        }

        return true;
    }

    function checkFile(f) {
//files로 해당 파일정보 얻기
 var file = f.files;
 if(!/\.(xls|XLS)$/i.test(file[0].name)) alert('xls, XLS 파일만 선택해 주세요.\n\n현재 파일 : ' + file[0].name);

	// 체크를 통과했다면 종료.
	else return;

	// 체크에 걸리면 선택된  내용 취소 처리를 해야함.
	// 파일선택 폼의 내용은 스크립트로 컨트롤 할 수 없습니다.
	// 그래서 그냥 새로 폼을 새로 써주는 방식으로 초기화 합니다.
	// 이렇게 하면 간단 !?
	f.outerHTML = f.outerHTML;
}



</script>

<?php
include_once('./admin.tail.php');