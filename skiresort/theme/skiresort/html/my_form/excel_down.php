<?php

include "../../../../common.php";




$refer = $_SERVER['HTTP_REFERER'];

if (!$refer) {

    alert("정상적으로 접속하세요.", $_SERVER['HTTP_REFERER']);
    exit;
}


if (isset($_GET['t_code'])) {
    $t_code = $_GET['t_code'];
} else {
    // t_code가 없을 때의 처리 (에러, 기본값 등)
    $t_code = '';
}

if (isset($_GET['sports'])) {
    $sports = $_GET['sports'];
} else {
    // sports가 없을 때의 처리 (에러, 기본값 등)
    $sports = '';
}





$sql_common = " from SBAK_T1_TEST_Apply ";


$sql_search = " where T_code = '{$t_code}' and PAYMENT_STATUS = 'Y' ";


$sql = " select * {$sql_common} {$sql_search}  order by UID asc  ";
$result = sql_query($sql);


$filename = "T1_list.xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Description: PHP4 Generated Data");
echo "\xEF\xBB\xBF"; // UTF-8 BOM

?>

<style>
    table {
        font-size: 11pt;   /* 전체 테이블 기본 글꼴 크기 */
    }
    table td {
        font-size: 11pt;   /* 각 셀도 11pt */
    }
</style>


        <table border='1px'>

                <tr>
                    <td rowspan="3" align="center" style="background-color:yellow; font-weight:bold;"> ID </td>
                    <td rowspan="3" align="center" style="background-color:yellow; font-weight:bold;"> 성명 </td>
                    <td rowspan="3" align="center" style="background-color:yellow; font-weight:bold;"> 생년월일 </td>
                    <td rowspan="3" align="center" style="background-color:yellow; font-weight:bold;"> 전화번호 </td>
                    <td rowspan="3" align="center" style="background-color:yellow; font-weight:bold;"> 성별 </td>

                </tr>
                <tr>

                </tr>

                <tr>

                </tr>

                <?php

                for ($i = 0; $row = sql_fetch_array($result); $i++) {

                    $sql2 = "SELECT mb_1,mb_2 FROM g5_member WHERE mb_id = '{$row['MEMBER_ID']}'";
                    $row2 = sql_fetch($sql2);



                    ?>


                    <tr>
                        <td><?php echo $row['MEMBER_ID']; ?> </td>
                        <td><?php echo $row['MEMBER_NAME']; ?> </td>
                        <td><?php echo $row2['mb_2']; ?></td>
                        <td><?php echo $row['PHONE']; ?></td>
                        <td><?php echo $row2['mb_1']; ?></td>

                        
                    </tr>




                <?php } ?>

         
        </table>






