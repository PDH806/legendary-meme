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
exit;
*/

$data->read('./data/pg_20_02_21_20_02_21.xls'); 
for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
	for ($j = 1; $j <= 1; $j++) {
        //$sql = "select rs_seq from t_reserve where rs_seq='".$data->sheets[0]['cells'][$i][1]."' ";
	    $sql = "select rs_seq from t_payment where PM_TRANS_NO='".$data->sheets[0]['cells'][$i][2]."' ";
        
        //echo $sql.'<br>';
        $rs = sql_query($sql, true);
        if(!sql_num_rows($rs)){
            echo ++$k.' '.$data->sheets[0]['cells'][$i][1].'-->'.$data->sheets[0]['cells'][$i][2].'<br>';
        }
        
	}
}


exit;

//print_r($data);
//print_r($data->formatRecords);
?>
