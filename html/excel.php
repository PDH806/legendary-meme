<?php 
 include_once './common.php';
 include_once G5_PLUGIN_PATH .'/ExcelReader/Excel/reader.php';
 $file = G5_PLUGIN_PATH.'/ExcelReader/bbs.xls';
 
 $data = new Spreadsheet_Excel_Reader();
 $data->setOutputEncoding('UTF-8');
 $data->read($file);
 error_reporting(E_ALL ^ E_NOTICE);
 
  
 
 
 for($i=1; $i<=$data->sheets[0]['numRows'];$i++){
     if($data->sheets[0]['cells'][$i][2]==1) $table='notice';
     else if($data->sheets[0]['cells'][$i][2]==2){
         $table='report'; $ca_name='회원사보도자료';
     }
     else if($data->sheets[0]['cells'][$i][2]==3){
         $table='report'; $ca_name='협회보도자료';
     }
     else if($data->sheets[0]['cells'][$i][2]==4){
         $table='gallery';
     }
     else if($data->sheets[0]['cells'][$i][2]==12){
         $table='qa';//자료실
     }
     else continue;
   
  $tmp = explode('/',$data->sheets[0]['cells'][$i][17]);
  $datetime = $tmp[2].'-'.$tmp[0].'-'.$tmp[1];
  $sql = "insert into g5_write_{$table} 
          set wr_id='".$data->sheets[0]['cells'][$i][1]."',
              wr_num='-".$data->sheets[0]['cells'][$i][1]."',
              wr_parent = '".$data->sheets[0]['cells'][$i][1]."',
              wr_is_comment='0',
              ca_name = '{$ca_name}',
              wr_subject = '".addslashes($data->sheets[0]['cells'][$i][8])."',
              wr_content = '".addslashes($data->sheets[0]['cells'][$i][9])."',
              wr_datetime = '{$datetime}',
              wr_hit = '".$data->sheets[0]['cells'][$i][19]."',
              wr_ip = '".$data->sheets[0]['cells'][$i][20]."'

 ";
  //echo $sql .'<p>';
  sql_query($sql, true);
  if($data->sheets[0]['cells'][$i][25]){
  $sql_file = "insert into g5_board_file
                set
                 bo_table='{$table}',
                 wr_id='".$data->sheets[0]['cells'][$i][1]."',
                 bf_no = '0',
                 bf_file='".$data->sheets[0]['cells'][$i][25]."'
  ";
  
  //echo $sql_file.'<p>';
  //sql_query($sql_file, true);
  }
  
  for($j=10;$j<15;$j++){
   if($data->sheets[0]['cells'][$i][$j]){
    $sql_file = "insert into g5_board_file
                set
                 bo_table='{$table}',
                 wr_id='".$data->sheets[0]['cells'][$i][1]."',
                 bf_no = '{$j}',
                 bf_file='".$data->sheets[0]['cells'][$i][$j]."'
    ";
    //sql_query($sql, true);
   }
  }
  //echo $sql_file.'<p>';
  //echo $sql.'<p>'; 
  $ca_name = '';
  
 }
 
 // 각 게시판 원글개수를 세어 g5_board의 bo_count_write 필드 업데이트
 
 
 
?>