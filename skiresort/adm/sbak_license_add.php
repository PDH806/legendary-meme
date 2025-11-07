<?php

if ($_GET['sports'] == 'ski') {

    $sub_menu = '800100';
    $table = "SBAK_SKI_MEMBER";
    $sports = "ski";
} elseif ($_GET['sports'] == 'sb') {

    $sub_menu = '800200';
    $table = "SBAK_SB_MEMBER";
    $sports = "sb";
} elseif ($_GET['sports'] == 'ptl') {

    $sub_menu = '800300';
    $table = "SBAK_PATROL_MEMBER";
    $sports = "ptl";

}

else{

    alert("비정상적인 접근입니다.", G5_URL);

}


include_once('./_common.php');

add_stylesheet('<link rel="stylesheet" href="' . G5_URL . '/adm/css/sbak_css.css">', 0);


auth_check_menu($auth, $sub_menu, 'r');

if ($_GET['sports'] == 'ski') {
    $g5['title'] = '스키티칭 대상자 추가';
} elseif ($_GET['sports'] == 'sb') {
    $g5['title'] = '스노보드티칭 대상자 추가';
} elseif ($_GET['sports' == 'ptl']) {
    $g5['title'] = '패트롤 대상자 추가';
}
include_once('./admin.head.php');


$colspan = 7;


?>


<form name="ksia_license_list" id="ksia_license_list" action="./sbak_license_add_update.php"
    onsubmit="return ksia_license_list_submit(this);" method="post">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="">
    <input type="hidden" name="sports" value="<?php echo $sports; ?>">

    <div class="tbl_wrap tbl_head01">
        <table>
            <thead>
                <tr>
                    <th scope="col">
                        <label for="chkall" class="sound_only">그룹 전체</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>
                    <th scope="col">NO</th>
                    <th scope="col">구분(년도)</th>
                    <th scope="col">회원ID</th>
                    <th scope="col">이름(필수)</th>
                    <th scope="col">생년월일(필수)</th>
                    <th scope="col">자격등급(필수)</th>
                    <th scope="col">자격번호(필수)</th>
                    <th scope="col">메모</th>
                </tr>
            </thead>
            <tbody>
                <?php


                for ($i = 1; $i <= 15; $i++) {



                    $bg = 'bg' . ($i % 2); ?>



                    <tr class="<?php echo $bg; ?>">


                        <td class="td_chk">

                            <label for="chk_<?php echo $i; ?>" class="sound_only">
                                자격증</label>
                            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">



                        </td>
                        <td>
                            <?php echo $i; ?>
                        </td>
                        <td width=70px>
                            <input type="text" name="GUBUN[<?php echo $i ?>]" class="ksia_input" maxlength=4
                                placeholder="0000"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </td>
                        <td>
                            <input type="text" name="MEMBER_ID[<?php echo $i ?>]" class="tbl_input" size="10"
                                placeholder="회원아이디">
                        </td>
                        <td>
                            <input type="text" name="K_NAME[<?php echo $i ?>]" class="tbl_input" size="10"
                                placeholder="이름을 입력">
                        </td>
                        <td>
                            <input type="date" name="K_BIRTH[<?php echo $i ?>]" class="ksia_input" placeholder="생년월일">
                        </td>
                        <td class="td_mbcert">
                            <?php if($sports == 'ptl'){?>
                            <input type='radio' name='K_GRADE[<?php echo $i ?>]' value='PTL'>PATROL
                             <?php }else{?>                           
                            <input type='radio' name='K_GRADE[<?php echo $i ?>]' value='T1'>T1
                            <input type='radio' name='K_GRADE[<?php echo $i ?>]' value='T2'>T2
                            <input type='radio' name='K_GRADE[<?php echo $i ?>]' value='T3'>T3
                             <?php }?>   
 
                            </td>
                        <td>
                            <input type="text" name="K_LICENSE[<?php echo $i ?>]" class="ksia_input" placeholder="자격번호">
                        </td>
                        <td>
                            <input type="text" name="K_MEMO[<?php echo $i ?>]" class="tbl_input" placeholder="메모사항">
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

   
<script>
    function ksia_license_list_submit(f) {
        if (!is_checked("chk[]")) {
            alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
            return false;
        }

        return true;
    }


</script>

<?php
include_once('./admin.tail.php');