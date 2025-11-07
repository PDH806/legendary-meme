<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/common.php';
require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';

$filepath = "data/ski_gido_t1-1.xls";

$filetype = PHPExcel_IOFactory::identify($filepath);
$reader = PHPExcel_IOFactory::createReader($filetype);
$php_excel = $reader->load($filepath);

$sheet = $php_excel->getSheet(0);           // 첫번째 시트
$maxRow = $sheet->getHighestRow();          // 마지막 라인
$maxColumn = $sheet->getHighestColumn();    // 마지막 칼럼

$target = "A"."1".":"."$maxColumn"."$maxRow";
$lines = $sheet->rangeToArray($target, NULL, TRUE, FALSE);

// 라인수 만큼 루프
$seq = 0;
foreach ($lines as $key => $line) {
    $seq++;
    $col = 0;
    $item = array(
        "A"=>addslashes($line[$col++]),   // 첫번째 칼럼
        "B"=>addslashes($line[$col++]),   // 두번쨰 칼럼
        "C"=>addslashes($line[$col++]),"D"=>addslashes($line[$col++]),"E"=>addslashes($line[$col++]),"F"=>addslashes($line[$col++]),"G"=>addslashes($line[$col++]),
        "H"=>addslashes($line[$col++]),"I"=>addslashes($line[$col++])
    );

    $sql = "insert into t_reserve set 
             idkey='500046', gd_seq='GD4495', sd_seq='sd{$seq}', rs_seq='rs{$seq}',
             license_num='{$item['A']}', rs_buyer_name='{$item['B']}' ,     
             rs_buyer_idkey='{$item['C']}' , insert_idkey='{$item['C']}', /*,  sosok='{$item['E']}' ,*/
             rs_buyer_tel='{$item['D']}' /* , etc='{$item['I']}'*/ 
    ";
   echo $sql.'<br>';
   //sql_query($sql,true);
   // print_r($item["A"] .",". $item["B"].$item["C"] .",". $item["D"] .$item["E"] .",". $item["F"].$item["G"] .",". $item["H"].",".$item["I"]."<br/>");
}
?>
