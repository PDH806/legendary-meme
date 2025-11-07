<?php
$dir = 'upload_images/';

// 디렉토리 패스 체크
if (!is_dir($dir)) {
    echo '"' . $dir . '" is not directory. Check the directory path.';
}

// 디렉토리 열기
$dir_obj = opendir($dir);
// 디렉토리내에 파일명을 배열에 저장
$files = array();
while (($file = readdir($dir_obj)) != false) {
    // 리눅스에서만 보이는 .와 ..와 디렉토리를 제거한 나머지를 배열에 저장합니다.
    if ($file != '.' && $file != '..' && !is_dir($dir . $file)) {
        array_push($files, $file);
    }
}

foreach ($files as $file) {
    $path = $dir . $file;

    $file_path_info = pathinfo($path);
    $file_name = $file_path_info['filename'];
    $file_extension = $file_path_info['extension'];

    // 업로드된 이미지파일 정보를 가져옵니다
    $img = getimagesize($path);
    // 저용량 jpg 파일을 생성합니다
    if ($img['mime'] == 'image/png') {
        $image = imagecreatefrompng($path);
    } elseif ($img['mime'] == 'image/gif') {
        $image = imagecreatefromgif($path);
    } elseif ($img['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($path);
    } else {
        $image = null;
    }

    // 파일 압축 및 업로드
    if (isset($image)) {
        $thumb_path = 'upload_images/thumbnail/' . $file_name . '.jpg';
        imagejpeg($image, $thumb_path, 60);
        echo 'Complete resize image: ' . $thumb_path . '';
    }
}

// 디렉토리 닫기
closedir($dir);
