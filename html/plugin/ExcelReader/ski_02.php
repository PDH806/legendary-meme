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

$data->read('./data/ski_02.xls');

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

for ($i = 3; $i <= $data->sheets[0]['numRows']; $i++) {
	for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
		
	    if($j==1){
	        $tsql = "select id from request_mgmt where name='{$data->sheets[0]['cells'][$i][$j]}' ";
	        $trs = sql_fetch($tsql);
	        if(!$trs['id']) continue;
	        $sql_common .= "pid='{$trs['id']}', ";
	    }
	   
		else if($j==2)  $sql_common .= "rank='{$data->sheets[0]['cells'][$i][$j]}', ";
		else if($j==3)  $sql_common .= "id='{$data->sheets[0]['cells'][$i][$j]}', ";
		else if($j==4)  $sql_common .= "name='{$data->sheets[0]['cells'][$i][$j]}', ";
		else if($j==5)  $sql_common .= "cost='".str_replace(',','',$data->sheets[0]['cells'][$i][$j])."', ";
		else if($j==6)  $sql_common .= "off_cost='".str_replace(',','',$data->sheets[0]['cells'][$i][$j])."', ";
		else if($j==7)  $sql_common .= "status='{$data->sheets[0]['cells'][$i][$j]}' ";
		
	}
	//echo $sql_common.'<p><p>';
	$sql = "insert into request_mgmt_sub set {$sql_common}";
	sql_query($sql, true);
	$sql_common = '';

}


//print_r($data);
//print_r($data->formatRecords);
?>
