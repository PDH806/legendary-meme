<?php

include_once('./_common.php');

$refer = $_SERVER['HTTP_REFERER'];

if (!$refer) {

    alert("정상적으로 접속하세요.", $_SERVER['HTTP_REFERER']);
    exit;
}




if (empty($_GET['sports'])) {
    alert("비정상적인 접속입니다.", $_SERVER['HTTP_REFERER']);
    exit;
}

$sports = $_GET['sports'];


if($sports == 'ski') {  
    $sql_common = " from SBAK_SKI_MEMBER ";
} elseif ($sports == 'sb') {
    $sql_common = " from SBAK_SB_MEMBER ";   
} else{
    $sql_common = " from SBAK_PATROL_MEMBER ";   
}


$sql_search = " where IS_DEL != 'Y' ";


$sql = " select * {$sql_common} {$sql_search}  order by UID asc  ";
$result = sql_query($sql);


$filename = $sports."_license.xls";

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
                    <td> 성명 </td>
                    <td> ID </td>
                    <td> 구분 </td>
                    <td> 생년월일 </td>
                    <td> 등급 </td>
                    <td> 자격번호 </td>
                    <td> 메모 </td>
                    <td> 삭제</td>
                    <td> 등록일</td>
                    <td> 수정일 </td>

                </tr>

                <?php

                for ($i = 0; $row = sql_fetch_array($result); $i++) {

                    ?>


                    <tr>
                        <td style=mso-number-format:'\@';><?php echo $i+1; ?></td>
                        <td><?php echo $row['UID']; ?> </td>
                        <td><?php echo $row['K_NAME']; ?> </td>
                        <td><?php echo $row['MEMBER_ID']; ?> </td>
                        <td><?php echo $row['GUBUN']; ?> </td>
                        <td><?php echo $row['K_BIRTH']; ?></td>
                        <td><?php echo $row['K_GRADE']; ?></td>
                        <td><?php echo $row['K_LICENSE']; ?></td>
                        <td><?php echo $row['K_MEMO']; ?></td>
                        <td><?php echo $row['IS_DEL']; ?></td>
                        <td style=mso-number-format:'\@';><?php echo $row['INSERT_DATE']; ?></td>
                        <td style=mso-number-format:'\@';><?php echo $row['UPDATE_TIME']; ?></td>
                        
                    </tr>




                <?php } ?>

         
        </table>






