<?php

include_once('./_common.php');

if (empty($_POST['from_date']) || empty($_POST['to_date'])) {
    alert("엑셀다운을 위해서는 유효한 기간을 설정하세요.", $_SERVER['HTTP_REFERER']);
}

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];


$sql_search = '';
$sql_common = " from SBAK_T1_TEST_Apply A INNER JOIN SBAK_T1_TEST B ON A.T_code = B.T_code";

$sql_search = " WHERE  A.T_date BETWEEN '{$from_date}' and '{$to_date}'";


$sql = " select A.UID as UID, A.T_code as T_code,  B.TYPE as TYPE, B.T_date as T_date, 
        A.MEMBER_NAME as MEMBER_NAME, A.MEMBER_ID as MEMBER_ID, A.REGIST_DATE as REGIST_DATE, A.REGIST_TIME as REGIST_TIME, 
        B.T_where as T_where, A.PHONE as PHONE, A.T_status as T_status, A.PAYMENT_STATUS as PAYMENT_STATUS, 
        A.SCORE1_1 as SCORE1_1, A.SCORE1_2 as SCORE1_2, A.SCORE1_3 as SCORE1_3, 
        A.SCORE2_1 as SCORE2_1, A.SCORE2_2 as SCORE2_2, A.SCORE2_3 as SCORE2_3, 
        A.SCORE3_1 as SCORE3_1, A.SCORE3_2 as SCORE3_2, A.SCORE3_3 as SCORE3_3, 
        A.SCORE4_1 as SCORE4_1, A.SCORE4_2 as SCORE4_2, A.SCORE4_3 as SCORE4_3, 
        A.AVERAGE as AVERAGE, A.LICENSE_NO as LICENSE_NO, A.MEMO as MEMO
        {$sql_common} {$sql_search}  order by UID asc  ";
$result = sql_query($sql);







$filename = date("Ymd") . "_T1_TEST_Apply.xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Description: PHP4 Generated Data");
// 엑셀에서 UTF-8 인식하도록 BOM 추가
echo "\xEF\xBB\xBF";


?>




        <table border='1px'>

                <tr>
                    <td rowspan="2"> NO </td>
                    <td rowspan="2"> UID </td>
                    <td rowspan="2"> 검정코드 </td>
                    <td rowspan="2"> 종목 </td>
                    <td rowspan="2"> 검정일 </td>
                    <td rowspan="2"> 성명 </td>
                    <td rowspan="2"> 회원ID </td>
                    <td rowspan="2"> 등록일 </td>
                    <td rowspan="2"> 스키장 </td>
                    <td rowspan="2"> 연락처 </td>
                    <td rowspan="2"> 생년월일</td>
                    
                    <td rowspan="2"> 검정료납부 </td>
                    <td colspan="3"> 1종목 점수</td>  
                    <td colspan="3"> 2종목 점수</td>
                    <td colspan="3"> 3종목 점수</td>    
                    <td colspan="3"> 4종목 점수</td>                                                                          
                    <td rowspan="2"> 평균</td>   
                    <td rowspan="2"> 자격번호</td>  
                    <td rowspan="2"> 메모</td>                                                     
                   

                </tr>
                <tr>
                  <td>1심</td>
                  <td>2심</td>
                  <td>3심</td>
                  <td>1심</td>
                  <td>2심</td>
                  <td>3심</td>
                  <td>1심</td>
                  <td>2심</td>
                  <td>3심</td>
                  <td>1심</td>
                  <td>2심</td>
                  <td>3심</td>
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
                        <td><?php echo $row['MEMBER_NAME']; ?></td>
                        <td><?php echo $row['MEMBER_ID']; ?></td>
                        <td><?php echo $row['REGIST_DATE'] . " " . $row['REGIST_TIME'] ; ?></td>
                        <td><?php echo $row['T_where']; ?></td>
                        <td><?php echo $row['PHONE']; ?></td>
                        
                        <?php
                        
                        $MEMBER_ID = $row['MEMBER_ID'];

                        
                        $query = "select mb_2 from g5_member where mb_id like '{$MEMBER_ID}'";
                        $mem_birth = sql_fetch($query);
                        $THE_BIRTH = $mem_birth['mb_2'];

                        ?>
                        <td><?php echo $THE_BIRTH; ?></td>
                        
                       
                        

                        <td>
                            <?php 
                              
                              if ($row['PAYMENT_STATUS'] == 'Y') {
                                echo "결제완료";
                              } elseif ($row['PAYMENT_STATUS'] == 'C') {
                                echo "취소완료";
                              }
                            ?> 
                        </td>

                        <td><?php echo $row['SCORE1_1']; ?></td>
                        <td><?php echo $row['SCORE1_2']; ?></td>
                        <td><?php echo $row['SCORE1_3']; ?></td>
                        <td><?php echo $row['SCORE2_1']; ?></td>
                        <td><?php echo $row['SCORE2_2']; ?></td>
                        <td><?php echo $row['SCORE2_3']; ?></td>
                        <td><?php echo $row['SCORE3_1']; ?></td>
                        <td><?php echo $row['SCORE3_2']; ?></td>
                        <td><?php echo $row['SCORE3_3']; ?></td>
                        <td><?php echo $row['SCORE4_1']; ?></td>
                        <td><?php echo $row['SCORE4_2']; ?></td>
                        <td><?php echo $row['SCORE4_3']; ?></td>
                        <td><?php echo $row['AVERAGE']; ?></td>
                        <td><?php echo $row['LICENSE_NO']; ?></td>
                        <td><?php echo $row['MEMO']; ?></td>
                       


                        


                    </tr>




                <?php } ?>

         
        </table>






