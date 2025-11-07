<?php

include "../../../../common.php";

$refer = $_SERVER['HTTP_REFERER'];

if (!$refer) {

    alert("정상적으로 접속하세요.", $_SERVER['HTTP_REFERER']);
    exit;
}


$sql_common = " from SBAK_T1_TEST_Apply ";


$sql_search = " where PAYMENT_STATUS = 'Y' ";


$sql = " select * {$sql_common} {$sql_search}  order by UID asc  ";
$result = sql_query($sql);


$filename = "T1_list.xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Description: PHP4 Generated Data");
?>


        <table border='1px'>

                <tr>
                    <td> NO </td>
                    <td> ID </td>
                    <td> 성명 </td>
                    <td> 생년월일 </td>
                    <td> 전화번호 </td>

                </tr>

                <?php

                for ($i = 0; $row = sql_fetch_array($result); $i++) {

                    ?>


                    <tr>
                        <td style=mso-number-format:'\@';><?php echo $i+1; ?></td>
                        <td><?php echo $row['MEMBER_ID']; ?> </td>
                        <td><?php echo $row['MEMBER_NAME']; ?> </td>
                        <td><?php echo $mb_birth; ?></td>
                        <td><?php echo $row['PHONE']; ?></td>
                        
                    </tr>




                <?php } ?>

         
        </table>






