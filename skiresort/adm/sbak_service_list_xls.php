<?php

include_once('./_common.php');

$refer = $_SERVER['HTTP_REFERER'];

$down_condition = $_GET['TRAN_STATUS'] ?? '';



if (!$refer) {

    alert("정상적으로 접속하세요.", G5_URL);
}







$sql_common = " from SBAK_SERVICE_LIST ";


$sql_search = " where PAYMENT_STATUS = 'Y' ";


$sql = " select * {$sql_common} {$sql_search}  order by UID asc  ";
$result = sql_query($sql);


$filename = "service_list.xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . $filename);
header("Content-Description: PHP4 Generated Data");
// 엑셀에서 UTF-8 인식하도록 BOM 추가
echo "\xEF\xBB\xBF";

?>




<table border='1px'>

    <tr>
        <td> NO </td>
        <td> UID </td>
        <td> 구분 </td>
        <td> 성명 </td>
        <td> ID </td>
        <td> 전화번호 </td>
        <td> 이메일 </td>
        <td> 생년월일 </td>

        <td> 우편번호 </td>
        <td> 주소1 </td>
        <td> 주소2 </td>
        <td> 주소3 </td>

        <td> 결제수단 </td>
        <td> 결제금액 </td>
        <td> 결제상태 </td>

        <td> 메모 </td>

        <td> 신청일</td>
        <td> 신청시간</td>
        <td> 회원사진</td>


    </tr>

    <?php

    for ($i = 0; $row = sql_fetch_array($result); $i++) {

        $sql10 = "select mb_2 from g5_member where mb_id = '{$row['MEMBER_ID']}' ";
        $row10 = sql_fetch($sql10);
        $mb_birth = $row10['mb_2'];


        // 회원이미지 경로
        $mb_img_path = G5_DATA_PATH . '/member_image/' . substr($row['MEMBER_ID'], 0, 2) . '/' . get_mb_icon_name($row['MEMBER_ID']) . '.jpg';
        $mb_img_url = G5_DATA_URL . '/member_image/' . substr($row['MEMBER_ID'], 0, 2) . '/' . get_mb_icon_name($row['MEMBER_ID']) . '.jpg';


    ?>


        <tr>
            <td style=mso-number-format:'\@';><?php echo $i + 1; ?></td>
            <td><?php echo $row['UID']; ?> </td>
            <td><?php echo $row['PRODUCT_NAME']; ?> </td>
            <td><?php echo $row['MEMBER_NAME']; ?> </td>
            <td><?php echo $row['MEMBER_ID']; ?> </td>
            <td><?php echo $row['MEMBER_PHONE']; ?> </td>
            <td><?php echo $row['MEMBER_EMAIL']; ?></td>
            <td><?php echo $mb_birth; ?></td>

            <td><?php echo $row['ZIP']; ?></td>
            <td><?php echo $row['ADDR1']; ?></td>
            <td><?php echo $row['ADDR2']; ?></td>
            <td><?php echo $row['ADDR3']; ?></td>

            <td><?php echo $row['PAY_METHOD']; ?></td>
            <td><?php echo $row['AMOUNT']; ?></td>
            <td>
                <?php if ($row['PAYMENT_STATUS'] == 'Y') {

                    echo "결제완료";
                } elseif ($row['PAYMENT_STATUS'] == 'C') {

                    echo "취소완료";
                } ?>
            </td>

            <td><?php echo $row['MEMO1']; ?></td>

            <td style=mso-number-format:'\@';><?php echo $row['REGIS_DATE']; ?></td>
            <td style=mso-number-format:'\@';><?php echo $row['REGIS_TIME']; ?></td>
            <td>
                <?php if (file_exists($mb_img_path)) {
                    echo $mb_img_url;
                } ?>
            </td>

        </tr>




    <?php } ?>


</table>