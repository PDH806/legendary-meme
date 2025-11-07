<?php
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

$data->read('./data/19_ski_t2_exempt.xls');

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
function a($time){
    $t = ( $time-25569) * 86400 - 60*60*9;
    $t = round($t*10)/10;
    return $t;
}
error_reporting(E_ALL ^ E_NOTICE);
exit;
for ($i = 5; $i <= $data->sheets[0]['numRows']; $i++) {
	for ($j = 2; $j <= $data->sheets[0]['numCols']; $j++) {
		if($j==2) $sql_comm = " bib_num='{$data->sheets[0]['cells'][$i][$j]}'";
		else if($j==3) $sql_comm .= " and rs_buyer_name='{$data->sheets[0]['cells'][$i][$j]}'";
		else if($j==4) $sql_comm .= " and rs_buyer_idkey='".date('ymd',a($data->sheets[0]['cells'][$i][$j]))."'";
	}
    $sql = "select idkey, gd_seq, rs_seq, rs_buyer_name, rs_buyer_idkey from t_reserve where $sql_comm";
    $rs = sql_query($sql);
    if(!sql_num_rows($rs)) ;/*echo $sql;*/
    else{
     /*$r = sql_fetch_array($rs);
     $sql1 = "select * from t_reserve_add_info where idkey='{$r['idkey']}' and gd_seq='{$r['gd_seq']}' and rs_seq='{$r['rs_seq']}' ";
     $r1 = sql_query($sql1);
     if(!sql_num_rows($r1) || sql_num_rows($r1)>1){
         echo $sql1;
     }else{
         $sql = "update t_reserve_add_info set ADD_EXEMPT_TYPE='NOTES' where idkey='{$r['idkey']}' and gd_seq='{$r['gd_seq']}' and rs_seq='{$r['rs_seq']}'";
         sql_query($sql,true);
     }
     */
    }
    echo $sql.'<br>';
    $sql_comm = "";
	/*echo $sql_common;
	$sql = "insert into request_mgmt set {$sql_common}";
	sql_query($sql, true);
	$sql_common = '';
    */
}


//print_r($data);
//print_r($data->formatRecords);
?>
