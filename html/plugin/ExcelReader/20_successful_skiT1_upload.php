<?php
//exit;
// Test CVS
include_once "../../common.php";
require_once 'Excel/reader.php';

echo "<style>body{font-size:.9em}</style>";

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
*/
$data->read('./data/2020_sbT2_success.xls');

for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
	
	    
	    /*if($j==1) $sql_common .= "IDKEY='500031', GD_SEQ='GD4470', SD_SEQ='GD4470SD', RS_DATE='".G5_TIME_YMDHIS."' , RS_BUYER_NAME='".$data->sheets[0]['cells'][$i][$j]."'";
	    else if($j==2)  $sql_common .= ", RS_BUYER_IDKEY='".substr($data->sheets[0]['cells'][$i][$j],2)."' , INSERT_IDKEY='".substr($data->sheets[0]['cells'][$i][$j],2)."' ";
	    else if($j==3){
	        $sql_common .= ", RS_BUYER_TEL='".$data->sheets[0]['cells'][$i][$j]."'";
	    }
	    else if($j==4){
	        $sql_common .= ", RS_SEQ='".$data->sheets[0]['cells'][$i][$j]."', LICENSE_NUM='".$data->sheets[0]['cells'][$i][$j]."'";
	    }
	    */
        // GD4470 -> 스키티칭1, GD4475->보드티칭1
        // GD4503 -> 보드티칭2, GD4504-> 스키티칭3
	    $sql = "insert into t_reserve set 
                   idkey='500031' , gd_seq='GD4470'
                  , rs_seq='{$data->sheets[0]['cells'][$i][4]}', rs_date='".G5_TIME_YMDHIS."'
                  , rs_sd_date='".date('Ymd')."', rs_buyer_idkey='".substr($data->sheets[0]['cells'][$i][2],2)."' 
                  , rs_buyer_name='{$data->sheets[0]['cells'][$i][1]}', rs_buyer_tel='{$data->sheets[0]['cells'][$i][3]}'
                  , license_num='{$data->sheets[0]['cells'][$i][4]}', INSERT_DT='".G5_TIME_YMDHIS."', sosok='곤지암'
      
";
       echo $sql.'<br>';	  
	   //sql_query($sql,true);
	    
	
	//echo $sql.'<br>';
	/*$sql_common .= ", INSERT_DT='".G5_TIME_YMDHIS."' , sosok='곤지암' ";
	$sql = "insert into t_reserve set {$sql_common}";
	//echo $sql.'<p>';
	//sql_query($sql, true);
	$sql_common = '';
    */
}
exit;

//print_r($data);
//print_r($data->formatRecords);
?>
