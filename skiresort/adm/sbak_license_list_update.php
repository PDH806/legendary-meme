<?php

if ($_POST['sports'] == 'ski') {

    $sub_menu = '800100';
    $table = "SBAK_SKI_MEMBER";
    $sports = "ski";
} elseif ($_POST['sports'] == 'sb') {

    $sub_menu = '800200';
    $table = "SBAK_SB_MEMBER";
    $sports = "sb";
} elseif ($_POST['sports'] == 'ptl') {

    $sub_menu = '800300';
    $table = "SBAK_PATROL_MEMBER";
    $sports = "ptl";
} else {

    alert("비정상적인 접근입니다.", G5_URL);

}

require_once './_common.php';

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';


if (!$post_count_chk) {
    alert($act_button . " 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();


if ($_POST['act_button'] == "선택수정") {
    for ($i = 0; $i < count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
        $p_UID = isset($_POST['UID'][$k]) ? (int) $_POST['UID'][$k] : 0;
        $p_K_NAME = is_array($_POST['K_NAME']) ? strip_tags(clean_xss_attributes($_POST['K_NAME'][$k])) : '';
        $p_MEMBER_ID = is_array($_POST['MEMBER_ID']) ? strip_tags(clean_xss_attributes($_POST['MEMBER_ID'][$k])) : '';
        $p_K_LICENSE = is_array($_POST['K_LICENSE']) ? strip_tags(clean_xss_attributes($_POST['K_LICENSE'][$k])) : '';
        $p_K_GRADE = is_array($_POST['K_GRADE']) ? strip_tags(clean_xss_attributes($_POST['K_GRADE'][$k])) : '';
        $p_K_MEMO = is_array($_POST['K_MEMO']) ? strip_tags(clean_xss_attributes($_POST['K_MEMO'][$k])) : '';
        $p_K_BIRTH = is_array($_POST['K_BIRTH']) ? strip_tags(clean_xss_attributes($_POST['K_BIRTH'][$k])) : '';
        $p_GUBUN = is_array($_POST['GUBUN']) ? strip_tags(clean_xss_attributes($_POST['GUBUN'][$k])) : '';
        $p_IS_DEL = is_array(isset($_POST['IS_DEL'])) ? strip_tags(clean_xss_attributes($_POST['IS_DEL'][$k])) : 'N';

        // 요기에...넘어오지 않은 필드에 대한 처리 삽입


        $sql = " update $table
                        set MEMBER_ID = '" . sql_real_escape_string($p_MEMBER_ID) . "',
                            K_NAME = '" . sql_real_escape_string($p_K_NAME) . "',
                            GUBUN = '" . sql_real_escape_string($p_GUBUN) . "',
                            K_BIRTH = '" . sql_real_escape_string($p_K_BIRTH) . "',
                            K_LICENSE = '" . sql_real_escape_string($p_K_LICENSE) . "',
                            K_GRADE = '" . sql_real_escape_string($p_K_GRADE) . "',
                            IS_DEL = '" . sql_real_escape_string($p_IS_DEL) . "',
                            UPDATE_DATE = '" . date("Y-m-d H:i:s") . "',
                            K_MEMO = '" . sql_real_escape_string($p_K_MEMO) . "'
                        where UID = '" . sql_real_escape_string($p_UID) . "' ";
        sql_query($sql);

    }




} elseif ($_POST['act_button'] == "선택인쇄") { ?>


    <html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>SBAK 자격확인서</title>
    <style type="text/css">
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font: 12pt "Tahoma";
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            margin: 10mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .subpage {
            padding: 1cm;

            height: 257mm;
            outline: 1.5cm #FFFFFF solid;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nanum+Myeongjo&family=Noto+Serif+KR&display=swap');
    </style>
</head>

    <body>
        <div class="book">


            <?php
            for ($i = 0; $i < count($_POST['chk']); $i++) {

                $mb_id = $member['mb_id'];
                $thisdate = date("Y") . "년 " . date("m") . "월" . date("d") . "일";



                // 실제 번호를 넘김
                $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
                $uid = isset($_POST['UID'][$k]) ? (int) $_POST['UID'][$k] : 0;



                $sql = "select * from $table where UID = {$uid}"; //로그인한 본인만 출력가능
                $row = sql_fetch($sql);


                $K_name = $row['K_NAME'];
                $Birth = $row['K_BIRTH'];
                $License = $row['K_LICENSE'];
                $Birth = substr($Birth, 0, 4) . "년 " . substr($Birth, 5, 2) . "월 " . substr($Birth, 8, 2) . "일";



                $sql = "select max(UID) as MAX from SBAK_prn_log";
                $row1 = sql_fetch($sql);

                $start_no = $row1['MAX'] + 1;

                $the_docu_no = date("Y") . "-" . date("md") . $start_no;

                $input_time = date('Y-m-d H:i:s');

                $sql = "insert into SBAK_prn_log set UID = {$start_no}, the_docu_no = '{$the_docu_no}', the_date = '{$input_time}', the_license = '{$License}', the_id = '{$mb_id}', is_jr =''";

                sql_query($sql);

                ?>


                        <div class="page">

            <div class="subpage">

                <div>
                    <div>
                        <div style="background-image:'imgs/ksia_logo.gif';">


                            <div style="font-family:Noto Serif KR,serif;font-weight:900;text-align:center;font-size:36pt;padding-top:20px;padding-bottom:50px">
                                확&nbsp;&nbsp;&nbsp;&nbsp;인&nbsp;&nbsp;&nbsp;&nbsp;서
                            </div>



                            <div>
                                <table
                                    style="font-family:Nanum Myeongjo,serif;font-weight:700;font-size:14pt;padding-bottom:80px">
                                    <tbody>
                                        <tr>
                                            <td width="2%"></td>
                                            <td width="22%">문서번호</td>
                                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                            <td>
                                                <?php echo $the_docu_no; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="letter-spacing:2px;">성&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;명</td>
                                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                            <td>
                                                <?php echo $K_name; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>생년월일</td>
                                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                            <td>
                                                <?php echo $Birth; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>자격번호</td>
                                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                            <td>
                                                <?php echo $License; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div style="font-family:Noto Serif KR,serif;text-align:justify;font-size:20pt;font-weight:700;line-height:50px;padding-bottom:60px;">
                                <table width="100%">
                                    <tbody>
                                        <tr>

                                            <td style="letter-spacing:1px;">&nbsp;위
                                                상기인은 체육시설의 설치·이용에 관한 법 제24조 및 동 시행규칙 제23조 [별표6] 안전·위생 기준에 의거
                                                사단법인 한국 스키장경영협회에서 시행한 <?php echo $Gubun; ?>년 <?php echo $license_title; ?> 자격을 취득하였음을 확인함.
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>

                            </div>

                            <div style='font-family:Nanum Myeongjo,serif;text-align:center;font-size:18pt;padding-bottom:40px;'>
                                <b><?php echo $thisdate; ?></b>
                            </div>

                            <div style="font-family:Noto Serif KR,serif;text-align:center;font-weight:700;padding-bottom:30px;">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td width="1%"></td>
                                            <td style="font-size:32px;font-weight:600;">사단법인 한국스키장경영협회</td>
                                            <td valign="middle"><img src="../theme/skiresort/sbak_imgs/stamp.jpg" width="100px">
                                            </td>
                                            <td width="1%"></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>



                            <div style="text-align:center;">

                                <span style="font-size:9pt;">주소 : 서울시 송파구 오금로 58, 1201호 / 전화 : 02)3473-1275,77 / FAX 02)3473-1278

                                </span>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>





                <?php

            }

            echo " </div></body> </html>";





} elseif ($_POST['act_button'] == "선택삭제") {




    alert('삭제기능은 데이터 보호를 위해 당분간 지원하지 않습니다. 데이터에 삭제체크표시기능을 이용해주세요.');


}

$post_chk = isset($post_chk) ? $post_chk : "";

run_event('admin_ksia_license_list_ski_update', $act_button, $post_chk, $qstr);


if ($_POST['act_button'] == "선택수정") {

    if ($_POST['sports'] == 'ski') {
        goto_url('./sbak_license_list_ski.php?' . $qstr);
    } elseif ($_POST['sports'] == 'sb') {
        goto_url('./sbak_license_list_sb.php?' . $qstr);
    } elseif ($_POST['sports'] == 'ptl') {
        goto_url('./sbak_license_list_ptl.php?' . $qstr);
    }
}