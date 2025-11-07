<?php

include_once ('./_common.php');

$refer = $_SERVER['HTTP_REFERER'];

if (!$refer) {

    alert("정상적으로 접속하세요.", $_SERVER['HTTP_REFERER']);
    exit;
}




if (empty($_GET['event_code']) || empty($_GET['event_year'])) {
    alert("비정상적인 접속입니다.", $_SERVER['HTTP_REFERER']);
    exit;
}

$event_code = $_GET['event_code'];
$event_year = $_GET['event_year'];



$sql_search = '';
$sql_common = " from SBAK_Master_Apply ";


if($event_code == "B03"){ // 기선전 + 티칭3은 C01(기선전) 에서 통합관리중

$sql_search = " where EVENT_CODE = 'C01' and EVENT_YEAR = {$event_year} and ENTRY_INFO_2 = 'Y' and PAYMENT_STATUS = 'Y'";

}elseif ($event_code == "C01"){

$sql_search = " where EVENT_CODE = '{$event_code}' and EVENT_YEAR = {$event_year} and ENTRY_INFO_2 = 'Y' and PAYMENT_STATUS = 'Y'";

}else{

$sql_search = " where EVENT_CODE = '{$event_code}' and EVENT_YEAR = {$event_year} and PAYMENT_STATUS = 'Y'";

}




$sql = " select * {$sql_common} {$sql_search}  order by UID asc  ";
$result = sql_query($sql);


$filename = $event_code . "_" . date("Ymd") .  date("his") .".xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . $filename);
header("Content-Description: PHP4 Generated Data");
// 엑셀에서 UTF-8 인식하도록 BOM 추가
echo "\xEF\xBB\xBF";

?>




<?php
if ($event_code == 'B02') {
    ?>



    <table border='1px'>

        <tr>
            <td> NO </td>
            <td> 성명 </td>
            <td> ID </td>
            <td> 동록일 </td>
            <td> 동록시간 </td>
            <td> 성별 </td>
            <td> 생년월일 </td>
            <td> 전화번호 </td>
            <td> 자격번호</td>
            <td> 결제수단</td>
            <td> 입금액 </td>
            <td> 입금확인 </td>

            <td> 필기면제 </td>
            <td> 필기면제 사유</td>
            <td> 실기면제 </td>
            <td> 실기면제 사유</td>
            <td> 메모 </td>

            
            <td> BIB </td>
        </tr>

        <?php

        for ($i = 0; $row = sql_fetch_array($result); $i++) {

            ?>


            <tr>
                <td style=mso-number-format:'\@';><?php echo $i + 1; ?></td>
                <td><?php echo $row['MB_NAME']; ?> </td>
                <td><?php echo $row['MB_ID']; ?> </td>
                <td style=mso-number-format:'\@';><?php echo $row['APPLY_DATE']; ?></td>
                <td style=mso-number-format:'\@';><?php echo $row['APPLY_TIME']; ?></td>
                <td><?php echo $row['THE_GENDER']; ?></td>
                <td><?php echo $row['THE_BIRTH']; ?></td>
                <td><?php echo $row['THE_TEL']; ?></td>
                <td><?php echo $row['MB_LICENSE_NO']; ?></td>
                <td><?php echo $row['PAY_METHOD']; ?></td>
                <td><?php echo $row['AMOUNT']; ?></td>
                <td>
                    <?php if ($row['PAYMENT_STATUS'] == 'Y') {
                        echo "결제완료";
                    } elseif ($row['PAYMENT_STATUS'] == 'C') {
                        echo "취소완료";
                    } else {
                        echo "대기";
                    }
                    ?></td>

                <td><?php echo $row['ENTRY_INFO_3']; ?></td>
                <td><?php echo $row['ENTRY_INFO_4']; ?></td>
                <td><?php echo $row['ENTRY_INFO_5']; ?></td>
                <td><?php echo $row['ENTRY_INFO_6']; ?></td>
                <td><?php echo $row['THE_MEMO']; ?></td>
                
                <td><?php echo $row['ENTRY_BIB']; ?></td>

            </tr>




        <?php } ?>


    </table>



<?php } ?>


<?php
if ($event_code == 'B03') {
    ?>



    <table border='1px'>

        <tr>
            <td> NO </td>
            <td> 성명 </td>
            <td> ID </td>
            <td> 동록일 </td>
            <td> 동록시간 </td>
            <td> 성별 </td>
            <td> 생년월일 </td>
            <td> 전화번호 </td>
            <td> 자격번호</td>
            <td> 결제수단</td>
            <td> 입금액 </td>
            <td> 입금확인 </td>

            <td> 메모 </td>

            
            <td> BIB </td>
        </tr>

        <?php

        for ($i = 0; $row = sql_fetch_array($result); $i++) {

            ?>


            <tr>
                <td style=mso-number-format:'\@';><?php echo $i + 1; ?></td>
                <td><?php echo $row['MB_NAME']; ?> </td>
                <td><?php echo $row['MB_ID']; ?> </td>
                <td style=mso-number-format:'\@';><?php echo $row['APPLY_DATE']; ?></td>
                <td style=mso-number-format:'\@';><?php echo $row['APPLY_TIME']; ?></td>
                <td><?php echo $row['THE_GENDER']; ?></td>
                <td><?php echo $row['THE_BIRTH']; ?></td>
                <td><?php echo $row['THE_TEL']; ?></td>
                <td><?php echo $row['MB_LICENSE_NO']; ?></td>
                <td><?php echo $row['PAY_METHOD']; ?></td>
                <td><?php echo $row['AMOUNT']; ?></td>
                <td>
                    <?php if ($row['PAYMENT_STATUS'] == 'Y') {
                        echo "결제완료";
                    } elseif ($row['PAYMENT_STATUS'] == 'C') {
                        echo "취소완료";
                    } else {
                        echo "대기";
                    }
                    ?></td>

                <td><?php echo $row['THE_MEMO']; ?></td>
                
                <td><?php echo $row['ENTRY_BIB']; ?></td>

            </tr>




        <?php } ?>


    </table>



<?php } ?>


<?php
if ($event_code == 'B05') {
    ?>



    <table border='1px'>

        <tr>
            <td> NO </td>
            <td> 성명 </td>
            <td> ID </td>
            <td> 동록일 </td>
            <td> 동록시간 </td>
            <td> 성별 </td>
            <td> 생년월일 </td>
            <td> 전화번호 </td>
            <td> 자격번호</td>
            <td> 결제수단</td>

            <td> 입금액 </td>
            <td> 입금확인 </td>

            <td> 필기면제 </td>
            <td> 필기면제 사유</td>
            <td> 실기면제 </td>
            <td> 실기면제 사유</td>
            <td> 메모 </td>

            
            <td> BIB </td>
        </tr>

        <?php

        for ($i = 0; $row = sql_fetch_array($result); $i++) {

            ?>


            <tr>
                <td style=mso-number-format:'\@';><?php echo $i + 1; ?></td>
                <td><?php echo $row['MB_NAME']; ?> </td>
                <td><?php echo $row['MB_ID']; ?> </td>
                <td style=mso-number-format:'\@';><?php echo $row['APPLY_DATE']; ?></td>
                <td style=mso-number-format:'\@';><?php echo $row['APPLY_TIME']; ?></td>
                <td><?php echo $row['THE_GENDER']; ?></td>
                <td><?php echo $row['THE_BIRTH']; ?></td>
                <td><?php echo $row['THE_TEL']; ?></td>
                <td><?php echo $row['MB_LICENSE_NO']; ?></td>
                <td><?php echo $row['PAY_METHOD']; ?></td>

                <td><?php echo $row['BANK_AMOUNT']; ?></td>
                <td>
                    <?php if ($row['PAYMENT_STATUS'] == 'Y') {
                        echo "결제완료";
                    } elseif ($row['PAYMENT_STATUS'] == 'C') {
                        echo "취소완료";
                    } else {
                        echo "대기";
                    }
                    ?></td>

                <td><?php echo $row['ENTRY_INFO_3']; ?></td>
                <td><?php echo $row['ENTRY_INFO_4']; ?></td>
                <td><?php echo $row['ENTRY_INFO_5']; ?></td>
                <td><?php echo $row['ENTRY_INFO_6']; ?></td>
                <td><?php echo $row['THE_MEMO']; ?></td>
                
                <td><?php echo $row['ENTRY_BIB']; ?></td>

            </tr>




        <?php } ?>


    </table>



<?php } ?>


<?php
if ($event_code == 'B06') {
    ?>



    <table border='1px'>

        <tr>
            <td> NO </td>
            <td> 성명 </td>
            <td> ID </td>
            <td> 동록일 </td>
            <td> 동록시간 </td>
            <td> 성별 </td>
            <td> 생년월일 </td>
            <td> 전화번호 </td>
            <td> 자격번호</td>
            <td> 결제수단</td>

            <td> 입금액 </td>
            <td> 입금확인 </td>

            <td> 메모 </td>

            
            <td> BIB </td>
        </tr>

        <?php

        for ($i = 0; $row = sql_fetch_array($result); $i++) {

            ?>


            <tr>
                <td style=mso-number-format:'\@';><?php echo $i + 1; ?></td>
                <td><?php echo $row['MB_NAME']; ?> </td>
                <td><?php echo $row['MB_ID']; ?> </td>
                <td style=mso-number-format:'\@';><?php echo $row['APPLY_DATE']; ?></td>
                <td style=mso-number-format:'\@';><?php echo $row['APPLY_TIME']; ?></td>
                <td><?php echo $row['THE_GENDER']; ?></td>
                <td><?php echo $row['THE_BIRTH']; ?></td>
                <td><?php echo $row['THE_TEL']; ?></td>
                <td><?php echo $row['MB_LICENSE_NO']; ?></td>
                <td><?php echo $row['PAY_METHOD']; ?></td>

                <td><?php echo $row['AMOUNT']; ?></td>
                <td>
                    <?php if ($row['PAYMENT_STATUS'] == 'Y') {
                        echo "결제완료";
                    } elseif ($row['PAYMENT_STATUS'] == 'C') {
                        echo "취소완료";
                    } else {
                        echo "대기";
                    }
                    ?></td>

                <td><?php echo $row['THE_MEMO']; ?></td>
                
                <td><?php echo $row['ENTRY_BIB']; ?></td>

            </tr>




        <?php } ?>


    </table>



<?php } ?>


<?php
if ($event_code == 'B07') {
    ?>



    <table border='1px'>

        <tr>
            <td> NO </td>
            <td> 성명 </td>
            <td> ID </td>
            <td> 동록일 </td>
            <td> 동록시간 </td>
            <td> 성별 </td>
            <td> 생년월일 </td>
            <td> 전화번호 </td>
            <td> 자격번호</td>
            <td> 결제수단</td>

            <td> 입금액 </td>
            <td> 입금확인 </td>

            <td> 필기면제 </td>
            <td> 필기면제 사유</td>
            <td> 메모 </td>

            
            <td> BIB </td>
        </tr>

        <?php

        for ($i = 0; $row = sql_fetch_array($result); $i++) {

            ?>


            <tr>
                <td style=mso-number-format:'\@';><?php echo $i + 1; ?></td>
                <td><?php echo $row['MB_NAME']; ?> </td>
                <td><?php echo $row['MB_ID']; ?> </td>
                <td style=mso-number-format:'\@';><?php echo $row['APPLY_DATE']; ?></td>
                <td style=mso-number-format:'\@';><?php echo $row['APPLY_TIME']; ?></td>
                <td><?php echo $row['THE_GENDER']; ?></td>
                <td><?php echo $row['THE_BIRTH']; ?></td>
                <td><?php echo $row['THE_TEL']; ?></td>
                <td><?php echo $row['MB_LICENSE_NO']; ?></td>
                <td><?php echo $row['PAY_METHOD']; ?></td>

                <td><?php echo $row['AMOUNT']; ?></td>
                <td>
                    <?php if ($row['PAYMENT_STATUS'] == 'Y') {
                        echo "결제완료";
                    } elseif ($row['PAYMENT_STATUS'] == 'C') {
                        echo "취소완료";
                    } else {
                        echo "대기";
                    }
                    ?></td>

                <td><?php echo $row['ENTRY_INFO_3']; ?></td>
                <td><?php echo $row['ENTRY_INFO_4']; ?></td>
                <td><?php echo $row['THE_MEMO']; ?></td>
                
                <td><?php echo $row['ENTRY_BIB']; ?></td>

            </tr>




        <?php } ?>


    </table>



<?php } ?>


<?php
if ($event_code == 'C01') {
    ?>



    <table border='1px'>

        <tr>
            <td> NO </td>
            <td> 성명 </td>
            <td> ID </td>
            <td> 동록일 </td>
            <td> 동록시간 </td>
            <td> 성별 </td>
            <td> 생년월일 </td>
            <td> 전화번호 </td>
            <td> 자격번호</td>
            <td> 결제수단</td>

            <td> 입금액 </td>
            <td> 입금확인 </td>

            <td> 프로필 </td>
            <td> 메모 </td>

            
            <td> BIB </td>
        </tr>

        <?php

        for ($i = 0; $row = sql_fetch_array($result); $i++) {

            ?>


            <tr>
                <td style=mso-number-format:'\@';><?php echo $i + 1; ?></td>
                <td><?php echo $row['MB_NAME']; ?> </td>
                <td><?php echo $row['MB_ID']; ?> </td>
                <td style=mso-number-format:'\@';><?php echo $row['APPLY_DATE']; ?></td>
                <td style=mso-number-format:'\@';><?php echo $row['APPLY_TIME']; ?></td>
                <td><?php echo $row['THE_GENDER']; ?></td>
                <td><?php echo $row['THE_BIRTH']; ?></td>
                <td><?php echo $row['THE_TEL']; ?></td>
                <td><?php echo $row['MB_LICENSE_NO']; ?></td>
                <td><?php echo $row['PAY_METHOD']; ?></td>

                <td><?php echo $row['AMOUNT']; ?></td>
                <td>
                    <?php if ($row['PAYMENT_STATUS'] == 'Y') {
                        echo "결제완료";
                    } elseif ($row['PAYMENT_STATUS'] == 'C') {
                        echo "취소완료";
                    } else {
                        echo "대기";
                    }
                    ?></td>
                <td><?php echo $row['THE_PROFILE']; ?></td>
                <td><?php echo $row['THE_MEMO']; ?></td>
                
                <td><?php echo $row['ENTRY_BIB']; ?></td>

            </tr>




        <?php } ?>


    </table>



<?php } ?>