<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<?php
 include_once $_SERVER['DOCUMENT_ROOT'].'/common.php';
 
 if($_POST['mode']=='upload_file'){
     $tmp_file = $_FILES['photo_file']['tmp_name'];
     $filesize = $_FILES['photo_file']['size'];
     $filename  = $_FILES['photo_file']['name'];
     $filename  = get_safe_filename($filename);
     // 이미지파일 체크
     $timg = getimagesize($tmp_file);
        
     if (!preg_match("/\.(jpg|gif|png|bmp)$/i", $filename) || ($timg[2] > 16 || $timg[2] < 1) ){
         $error = array('name'=>'error1','desc'=>'이미지 파일이 아닙니다.');
         
     }
     
     // 파일용량 체크
     if($filename){
         if($_FILES['photo_file']['error']==1){
             $error = array('name'=>'error2','desc'=>'파일용량 초과입니다.');
        
         }else if($_FILES['photo_file']['error'] != 0){
             $error = array('name'=>'error3','desc'=>'파일이 정상적으로 업로드되지 않았습니다.');
      
         }else if($filesize > '512000'){
             $error = array('name'=>'error4','desc'=>'파일용량초과\n500KB 이하로 업로드 해 주세요.');
         
         }
             
     }
     
     if(is_uploaded_file($tmp_file)){
         $chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
         shuffle($chars_array);
         $shuffle = implode('', $chars_array);
         
         // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
         $filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);
         $filename = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);
         
         //echo G5_DATA_PATH.'/member/'.date('Y').'/'.date('m').'/'.date('d');exit;
         
         mkdir(G5_DATA_PATH.'/member/'.date('Y').'/'.date('m').'/'.date('d').'/', G5_DIR_PERMISSION, true);
         chmod(G5_DATA_PATH.'/member/'.date('Y').'/'.date('m').'/'.date('d').'/', G5_DIR_PERMISSION, true);
         
         $dest_file = G5_DATA_PATH.'/member/'.date('Y').'/'.date('m').'/'.date('d').'/'.$filename;
         $dUrlFile = '/data/member/'.date('Y').'/'.date('m').'/'.date('d').'/'.$filename; // 정보조회시 사진등록되는 부분
         $error = move_uploaded_file($tmp_file, $dest_file);
         if(!$error) $error = array('name'=>'error6','desc'=>'파일업로드가 실패했습니다.\n잠시 후 다시 시도해 주세요.');
         else{
          // 파일업로드 성공
          echo "
                  <script>
                    //$('table.accept_table', parent.document).find('tr.photo').html('<img src=\'".G5_DATA_URL."/member/".date('Y')."/".date('m').'/'.date('d').'/'.$filename."\' style=\'width:148px;height:194px\'/>');
                $('table.accept_table', parent.document).find('tr.photo >th').css({'background':'url(".G5_DATA_URL."/member/".date('Y')."/".date('m').'/'.date('d').'/'.$filename." ) no-repeat center top','background-size':'cover'}).find('a').css('opacity','0');
                    $('#popup, #popup div', parent.document).hide();
                    $('input[name=uploadPhoto]', parent.document).val('".$dUrlFile."'); 
                    //$('input[name=uploadPhoto]', parent.document).val('{$filename}');
                  </script>
          ";
          exit;
         }
     }else{
         $error = array('name'=>'error5','desc'=>'사진이 없거나 업로드 에러입니다.');
        
     }
     
     if(!empty($error)){
         echo "<script>alert('".$error['desc']."');</script>";
         exit;
     }
     
 }
?>