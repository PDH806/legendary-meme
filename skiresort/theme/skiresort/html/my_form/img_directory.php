<?php


include "../../../../common.php";
   

include_once(G5_THEME_PATH.'/head.php'); //그누보드의 공통 상단을 연결합니다.
include_once('header.php'); // 공통 상단을 연결합니다.


$filelist = glob('/home/asiaski/public_html/skiresort/test/*');
$dirpath = "/home/asiaski/public_html/skiresort/test";



// 다량사진을 회원이미지에 폴더별도 넣기 위한 소스

foreach ($filelist as $filename) {
    if(is_file($filename)) {
    
       $without_extension = pathinfo($filename,PATHINFO_FILENAME);
        echo "<br>filename :";
        echo $filename;
        echo "<br>without_extension:";
        echo $without_extension;
    
    
       $img_size = getimagesize($filename); //이미지 사이즈 갖고와서, 400보다 크면 비례대로 줄이기

        echo "<br>가로 :".$img_size[0]."  세로 : " .$img_size[1];

            if ($img_size[0] > 400) {
                $set_width = 400;
                $set_height = (($img_size[1] / $img_size[0]) * $set_width);
            } else {
                $set_width = $img_size[0];
                $set_height = $img_size[1];
            }

            $dirname = substr($without_extension,0,2);
            echo "<br>dirname :";
            echo $dirname;

            $makedir = mkdir($dirpath.$dirname,G5_DIR_PERMISSION);

          
            $mb_dir = $dirpath.substr($without_extension,0,2);




      $tofile = $mb_dir."/".$without_extension.".jpg";
   
      echo "<br>tofile:".$tofile;
    
       echo resize_image($filename, $tofile, $set_width, $set_height);
    }
 

}

//이미지 리사이즈 함수
//폴더에 권한 꼭 주셔야합니다. chmod 707

//사용은 아래와 같이 하면 됩니다.


function resize_image($file, $newfile, $w, $h)
{
        list($width, $height) = getimagesize($file);
        if(strpos(strtolower($file), ".jpg"))
        $src = imagecreatefromjpeg($file);
        else if(strpos(strtolower($file), ".png"))
        $src = imagecreatefrompng($file);
        else if(strpos(strtolower($file), ".gif"))
        $src = imagecreatefromgif($file);
        $dst = imagecreatetruecolor($w, $h);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
        if(strpos(strtolower($newfile), ".jpg")) imagejpeg($dst, $newfile);
        else if(strpos(strtolower($newfile), ".png")) imagepng($dst, $newfile);
        else if(strpos(strtolower($newfile), ".gif")) imagegif($dst, $newfile);
}


//resize_image("org/model.jpg", "new/model200.jpg", 200, 100); // 알아서 jpg 유형의 파일 생성 
//resize_image("org/model.jpg", "new/model200.png", 200, 100); // 알아서 png 유형의 파일 생성 
//resize_image("org/model.jpg", "new/model200.gif", 200, 100); // 알아서 gif 유형의 파일 생성


?>


<!--폼 전송후 이전 페이지로 돌아가기 -->
<script>location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";</script>





<?php 
   include_once('tail.php'); // 공통 하단을 연결합니다.
   include_once(G5_THEME_PATH.'/tail.php'); //그누보드의 공통 상단을 연결합니다.
?>
