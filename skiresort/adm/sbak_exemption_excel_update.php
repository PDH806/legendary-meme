<?php

include_once('./_common.php');


?>

<section class="scontents">

<?php
if ($_POST['exemption'] == 'Y') {

    $sub_menu = '590800';
    $table = "SBAK_EXEMPTION_LIST";

} else {

    alert("비정상적인 접근입니다.", G5_URL);

}
use PhpOffice\PhpSpreadsheet\Spreadsheet; //처음 선언해야 함.
use PhpOffice\PhpSpreadsheet\Reader\Xls; //처음 선언해야 함.

error_reporting(E_ALL);
ini_set("display_errors", 1);

if (isset($_POST['ex_type']) && !$_POST['ex_type']) {
    alert("파일유형을 선택해주세요");
}

// 상품이 많을 경우 대비 설정변경
set_time_limit(0);
ini_set('memory_limit', '10M');

if (!$_FILES['excelfile']['tmp_name']) {
    alert("등록할 파일이 없습니다");
}


//엑셀파일만 등록되게 처리


if ($_FILES['excelfile']['tmp_name']) {

    $inputFileName = $_FILES['excelfile']['tmp_name'];

    require_once(G5_ADMIN_PATH . '/PhpOffice/Psr/autoloader.php'); //설치폴더 변경시 G5_THEME_PATH 수정요함
    require_once(G5_ADMIN_PATH . '/PhpOffice/PhpSpreadsheet/autoloader.php'); //설치폴더 변경시 G5_THEME_PATH 수정요함

    $reader = new PhpOffice\PhpSpreadsheet\Reader\Xls();

    $reader->setReadDataOnly(true); //데이터가 있는 행까지만 읽음

    $spreadsheet = $reader->load($inputFileName);

    $data = $spreadsheet->getSheet(0)->toArray(null, true, true, true); // >getSheet(0) 첫번째 시트 /  두번째는 getSheet(1)

    $Rows = $spreadsheet->getActiveSheet()->getHighestRow(); // 줄수 계산
    
    if ($Rows > 31) { // 제목줄을 제외하면, 30개까지만 있는지 체크
        alert("최대 30건 까지만 가능합니다. 엑셀 데이터를 30개 이하로 수정하세요.",$_SERVER['HTTP_REFERER']);
        exit;
    }
  }
            
  function time_convert($time)
  { //45563 날짜값을 날짜포맷변경

      $t = ($time - 25569) * 86400 - 60 * 60 * 9;
      $t = round($t * 10) / 10;
      $t = date('Y-m-d', $t);
      return $t;


  }
 
  $error_msg_4 = "빈값오류";
  $error_msg_6 = "구분오류";


  if (!empty($data)) {

    for ($i = 2; $i <= count($data); $i++) { //시작은 1부터.. 

        $set_no = $i - 1;
        $total_line = 1;

        if ($set_no > 30) { //30건을 넘어가면 반복문 탈출
            $set_no = $set_no - 1;
            break;
        }

        $chk_pass = "Y"; //문제없을 경우
        $error_no = 100;


        $mbname = $data[$i]['A']; //이름
        $birth_date = $data[$i]['B']; //생년월일
        $sports = $data[$i]['C']; //구분(종목)
        $EXEMPT_1 = $data[$i]['D']; //필기면제
        $EXEMPT_2 = $data[$i]['E']; //실기면제

        
        //빈칸있으면 에러처리
            
        if (empty($mbname) || empty($birth_date) || empty($sports)) {
        $chk_pass = "N";
        $error_no = 4;                                
            }



        if (is_numeric($birth_date)) { //엑셀에서 넘어올때 유효한 숫자로 넘어오는지  
            $birth_date = time_convert($data[$i]['B']); //생년월일
        } else {
            $chk_pass = "N";
            $error_no = 5;
           
        }
           

           //스키티칭2 또는 보드티칭2 또는 스키구조요원 가 아니면 에러처리
        if ($sports !== "B02" && $sports !== "B05" && $sports !== "B07") {
        $chk_pass = "N";
        $error_no = 6;
        }

        if (!empty($EXEMPT_1) && $EXEMPT_1 !== 'Y') {
        $chk_pass = "N";
        $error_no = 7;
        }

        if (!empty($EXEMPT_2) && $EXEMPT_2 !== 'Y') {
        $chk_pass = "N";
        $error_no = 8;
        }

           if ($chk_pass == "N") { //에러발생시 
            

            switch ($error_no) {

                case 4: //빈값 에러
                    echo "<script>
                 
                    alert('빈 값 을 확인해주세요.');
             
                    history.back();
             
                    </script>";
                    exit("빈 값 을 확인해주세요.");
                    break;
                    

                    case 5: //생년월일 에러
                        echo "<script>
                     
                        alert('생년월일 값 을 확인해주세요.');
                 
                        history.back();
                 
                        </script>";
                        exit("생년월일 값 을 확인해주세요.");
                        break;
                        
                        
                case 6: //구분값 에러
                    echo "<script>
                 
                    alert('구분 값 을 확인해주세요.');
             
                    history.back();
             
                    </script>";
                    exit("구분 값 을 확인해주세요.");
                    break;      
                                  
                case 7: //필기면제값 에러
                    echo "<script>
                 
                    alert('필기면제 값 을 확인해주세요.');
             
                    history.back();
             
                    </script>";
                    exit("필기면제 값 을 확인해주세요.");
                    break; 

                case 8: //실기면제값 에러
                    echo "<script>
                 
                    alert('실기면제 값 을 확인해주세요.');
             
                    history.back();
             
                    </script>";
                    exit("실기면제 값 을 확인해주세요.");
                    break; 

                default:
                    break;

            }
            }


                
                $sql= " insert into $table
                set K_NAME = '" . ($mbname) . "',
                    K_BIRTH = '" . ($birth_date) . "',
                    SPORTS = '" . ($sports) . "',
                    EXEMPT_1 = '" . ($EXEMPT_1) . "',
                    EXEMPT_2 = '" . ($EXEMPT_2) . "',
                    IS_DEL = 'N',
                    INSERT_DATE = '" . date("Y-m-d H:i:s") . "'
                    ";

                    
                if (sql_query($sql)){
        
                }else{
                    echo "{$set_no}번째 열에서 오류 발생<br>";    
        
                }
                
            
        }}
        

?>
<?php    

    echo "<script>
        alert('정상등록 되었습니다.');
        location.href = '" . G5_ADMIN_URL . "/sbak_event_exemption.php';
    </script>";
    exit;
// echo $sports;
// echo $table;


?>