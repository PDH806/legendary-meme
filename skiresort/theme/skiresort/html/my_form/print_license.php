<!DOCTYPE html>
<?php


include "../../../../common.php";
$refer = $_SERVER['HTTP_REFERER'] ?? '';
if ($is_guest || !$is_member) {
    alert('회원만 이용하실 수 있습니다.', $refer);
    exit;
}

if ($member['mb_level'] < 2) {
    alert('이용 권한이 없습니다.', $refer);
    exit;
}


if (empty($_POST['license']) or empty($_POST['category'])) {
    alert('정상적인 경로로 이용하세요.', $refer);
    exit;
}



$mb_id = $member['mb_id'] ?? '';
$License = $_POST['license'] ?? '';
$category = $_POST['category'] ?? '';



if ($category == 'ski') {
    $license_table = "SBAK_SKI_MEMBER";
    $license_title = "스키지도요원";
} elseif ($category == 'sb') {
    $license_table = "SBAK_SB_MEMBER";
    $license_title = "스노보드지도요원";
} elseif ($category == 'ptl') {
    $license_table = "SBAK_PATROL_MEMBER";
    $license_title = "스키구조요원";
} else {
    alert('정상적인 경로로 이용하세요.', $refer);
}



$sql = "select * from {$license_table} where K_LICENSE = '{$License}' and IS_DEL = 'N'  ";
$row = sql_fetch($sql);



$Grade = $row['K_GRADE'] ?? '';
$K_name = $row['K_NAME'] ?? '';
$Birth = $row['K_BIRTH'] ?? '';
$Gubun = $row['GUBUN'] ?? ''; //취득년도


if ($category == 'ptl') {
    $license_title = $license_title . " (PATROL) ";
} else {
    if ($Grade == 'T1') {
        $license_title = $license_title . " (Teaching Ⅰ)";
    }
    if ($Grade == 'T2') {
        $license_title = $license_title . " (Teaching Ⅱ)";
    }
    if ($Grade == 'T3') {
        $license_title = $license_title . " (Teaching Ⅲ)";
    }
}

$thisdate = date("Y") . "년 " . date("m") . "월 " . date("d") . "일"; //발행일
$Birth = substr($Birth, 0, 4) . "년 " . substr($Birth, 5, 2) . "월 " . substr($Birth, 8, 2) . "일";

// 로그 테이블에 기록 시작

$sql = "select max(UID) as MAX from SBAK_prn_log";
$row = sql_fetch($sql);

$start_no = $row['MAX'] + 1;
$the_docu_no = date("Y") . "-" . date("md") . $start_no;
$input_time = date('Y-m-d H:i:s');

$sql = "insert into SBAK_prn_log set UID = {$start_no}, the_docu_no = '{$the_docu_no}', the_date = '{$input_time}', the_license = '{$License}', the_id = '{$mb_id}', category = '{$category}'";

sql_query($sql);

// 로그 테이블에 기록 종료


?>


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
                                            <td valign="middle"><img src="../../sbak_imgs/stamp.jpg" width="100px">
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
    </div>



</body>

</html>