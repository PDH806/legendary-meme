<?php
exit;
// Test CVS
include_once "../../common.php";
require_once 'Excel/reader.php';


// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();


// Set output Encoding.
$data->setOutputEncoding('utf-8');

/***
* if you want you can change 'iconv' to mb_convert_encoding:
* $data->setUTFEncoder('mb');
*
**/

/***
* By default rows & cols indeces start with 1
* For change initial index use:
* $data->setRowColOffset(0);
*
**/



/***
*  Some function for formatting output.
* $data->setDefaultFormat('%.2f');
* setDefaultFormat - set format for columns with unknown formatting
*
* $data->setColumnFormat(4, '%.3f');
* setColumnFormat - set format for column (apply only to number fields)
*
**/

$data->read('./data/20_sbT2_note_exempt.xls');
//$data->read('./data/ski_01.xls');

/*


 $data->sheets[0]['numRows'] - count rows
 $data->sheets[0]['numCols'] - count columns
 $data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column

 $data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell
    
    $data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
        if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
    $data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format 
    $data->sheets[0]['cellsInfo'][$i][$j]['colspan'] 
    $data->sheets[0]['cellsInfo'][$i][$j]['rowspan'] 
*/

error_reporting(E_ALL ^ E_NOTICE);


/*echo 'numRows :'.$data->sheets[0]['numRows'];
echo '<br>numCols : '.$data->sheets[0]['numCols'];
exit;
*/

/*
for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
    for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
        echo $data->sheets[0]['cells'][$i][$j] . ' || ';
    }
    echo "<br>";
}
*/

$seq01=1;

for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
 $sql_common = " bib_num='{$data->sheets[0]['cells'][$i][1]}' and  rs_buyer_name='{$data->sheets[0]['cells'][$i][2]}' and rs_buyer_tel='{$data->sheets[0]['cells'][$i][4]}'";
 $sql = "select *  from t_reserve where  {$sql_common}";
 $rs = sql_query($sql, true);
 if(sql_num_rows($rs)>1){
     echo $sql.'<br>';
     exit;
 }else{
     $r = sql_fetch_array($rs);
     $sql = "select count(*) cnt from t_reserve_add_info where rs_seq='{$r['RS_SEQ']}'";
     $cnt = sql_fetch($sql);
     if($cnt['cnt']>1){
      echo ++$seq;exit;
     }else{
      /*$sql = "update t_reserve_add_info set add_exempt_type='NOTES' where rs_seq='{$r['RS_SEQ']}'";
      sql_query($sql,true);
      */
      echo $sql.'<br>';
     }
 }
 $sql_common = '';
}
exit;

?>
