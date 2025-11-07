<?php

include_once('./_common.php');

$refer = $_SERVER['HTTP_REFERER'];

if (!$refer) {

    alert("정상적으로 접속하세요.", $_SERVER['HTTP_REFERER']);
    exit;
}




if (empty($_GET['exemption'])) {
    alert("비정상적인 접속입니다.", $_SERVER['HTTP_REFERER']);
    exit;
}




    $sql_common = " from SBAK_EXEMPTION_LIST ";



$sql_search = " where IS_DEL != 'Y' ";


$sql = " select * {$sql_common} {$sql_search}  order by UID asc  ";
$result = sql_query($sql);


$filename = "sbak_exemption.xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Description: PHP4 Generated Data");
// 엑셀에서 UTF-8 인식하도록 BOM 추가
echo "\xEF\xBB\xBF";

?>




        <table border='1px'>

                <tr>
                    <td> UID </td>
                    <td> 성명 </td>
                    <td> 생년월일 </td>
                    <td> 구분 </td>
                    <td> 필기면제 </td>
                    <td> 실기면제 </td>
                    <td> 등록일</td>
                    <td> 수정일 </td>

                </tr>

                <?php

                for ($i = 0; $row = sql_fetch_array($result); $i++) {

                    ?>


                    <tr>
                        <td><?php echo $row['UID']; ?> </td>
                        <td><?php echo $row['K_NAME']; ?> </td>
                        <td><?php echo $row['K_BIRTH']; ?></td>
                        <td>
                            <?php if ($row['SPORTS'] == 'B02') {
                                $sports = '스키티칭2';
                            }elseif ($row['SPORTS'] == 'B05') {
                                $sports = '보드티칭2';
                            }elseif ($row['SPORTS'] == 'B07') {
                                $sports = '스키구조요원';
                            }
                            echo $sports;
                            ?> 
                          </td>
                        <td><?php echo $row['EXEMPT_1']; ?></td>
                        <td><?php echo $row['EXEMPT_2']; ?></td>
                        <td style=mso-number-format:'\@';><?php echo $row['INSERT_DATE']; ?></td>
                        <td style=mso-number-format:'\@';><?php echo $row['UPDATE_TIME']; ?></td>
                        
                    </tr>




                <?php } ?>

         
        </table>






