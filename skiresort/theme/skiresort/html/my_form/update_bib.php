<?php
include "../../../../common.php";

include_once('./console_common.php'); //공통 상단을 연결합니다.

$uid     = $_POST['uid'] ?? '';
$BIB_NO  = $_POST['BIB_NO'] ?? '';
$BIB_YN = $_POST['BIB_YN'] ?? 'N';
$_SERVER['HTTP_REFERER'] = $_SERVER['HTTP_REFERER'] ?? G5_URL;

if ($uid) {
   $sql = "UPDATE {$Table_T1_Apply} 
            SET BIB_NO = '{$BIB_NO}' , BIB_YN = '{$BIB_YN}'
            WHERE UID = '{$uid}'";
   //    echo $sql;
   sql_query($sql);
}

goto_url($_SERVER['HTTP_REFERER']); // 수정 후 원래 페이지로 돌아가기
