<?php

include_once('./_common.php');

if (empty($_POST['from_date']) || empty($_POST['to_date'])) {
    alert("엑셀다운을 위해서는 유효한 기간을 설정하세요.", $_SERVER['HTTP_REFERER']);
}


$the_sports = $_POST['to_sport'];

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];


$sql_search = '';
$sql_common = " from SBAK_T1_TEST ";


if ($the_sports == 'ski') {
$sql_search = " WHERE  T_date BETWEEN '{$from_date}' and '{$to_date}' and TYPE = '1'";
} elseif ($the_sports == 'sb'){
$sql_search = " WHERE  T_date BETWEEN '{$from_date}' and '{$to_date}' and TYPE = '2'";
} else {
$sql_search = " WHERE  T_date BETWEEN '{$from_date}' and '{$to_date}'";  
}



$sql = " select * {$sql_common} {$sql_search}  order by UID asc  ";
$result = sql_query($sql);



//티칭1 시험료 가져오기
$sql = " select Entry_fee from SBAK_OFFICE_CONF where Event_code = 'B01'";
$row = sql_fetch($sql);
$L1_fee = $row['Entry_fee'];





$filename = date("Ymd") . "_T1_TEST.xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Description: PHP4 Generated Data");

// 엑셀에서 UTF-8 인식하도록 BOM 추가
echo "\xEF\xBB\xBF";


?>




        <table border='1px'>

                <tr>
                    <td> NO </td>
                    <td> UID </td>
                    <td> 검정코드 </td>
                    <td> 종목 </td>
                    <td> 검정일 </td>
                    <td> 심사위원성명 </td>
                    <td> 심사위원ID </td>
                    <td> 등록일 </td>
                    <td> 스키장 </td>
                    <td> 연락처 </td>
                    <td> 진행상태 </td>
                    <td> 취소 </td>
                    <td> 응시인원(입금) </td>
                    <td> 응시료 </td>
                    
                    <td> 결과등록일 </td>       
                    <td> 메모</td>
                   

                </tr>

                <?php

                for ($i = 0; $row = sql_fetch_array($result); $i++) {

                    ?>


                    <tr>
                        <td style=mso-number-format:'\@';><?php echo $i+1; ?></td>
                        <td><?php echo $row['UID']; ?> </td>
                        <td><?php echo $row['T_code']; ?> </td>

                        <td>
                            <?php 
                              
                              if ($row['TYPE'] == '1') {
                                echo "SKI";
                              }elseif ($row['TYPE'] == '2'){
                                echo "SB";
                              }
                            ?> 
                        </td>
                        <td><?php echo $row['T_date']; ?></td>
                        <td><?php echo $row['T_name']; ?></td>
                        <td><?php echo $row['T_mb_id']; ?></td>
                        <td><?php echo $row['T_regis_date']; ?></td>
                        <td>
                          <?php 
                          $sql_where = "select RESORT_NAME from SBAK_SKI_RESORT where NO = {$row['T_skiresort']}";
                          $resort_name = sql_fetch($sql_where);
                          $resort_name = $resort_name['RESORT_NAME'];
                          
                          echo $resort_name; 
                          
                          ?>
                        </td>
                        <td><?php echo $row['T_tel']; ?></td>
                        
                        
                        <td>
                            <?php 
                              
                              if ($row['T_status'] == '88' || $row['T_status'] == '99') {
                                echo "삭제";
                              }elseif ($row['T_status'] == '77'){
                                echo "승인";
                              }
                            ?> 
                        </td>

                       

                        <?php


                             $query = "select count(*) as CNT from SBAK_T1_TEST_Apply where T_code = '{$row['T_code']}' and PAYMENT_STATUS = 'Y'";
                             $get_result = sql_fetch($query);
                             $student_cnt2 = $get_result['CNT'];
                             $valid_cnt = $student_cnt2;

                             $query = "select count(*) as CNT from SBAK_T1_TEST_Apply where T_code = '{$row['T_code']}' and (PAYMENT_STATUS = 'C')";
                             $get_result = sql_fetch($query);
                             $student_cnt3 = $get_result['CNT'];

                         
                            ?>
                           
                         <td><?php echo $student_cnt3; ?></td>
                         <td><?php echo $student_cnt2; ?></td>

                         <td><?php echo $row['PAYMENT_AMOUNT']; ?></td>

                        <td><?php echo $row['RESULT_DATE']; ?></td>
                        <td><?php echo $row['T_memo']; ?></td>
                        


                    </tr>




                <?php
                 } 
                ?>

         
        </table>






