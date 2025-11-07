<?php
$User_ID_Search = '';
$rank = '';

setcookie('Login_ID', $User_ID_Search, time() + 0);
setcookie('Member_Rank', $rank, time() + 0);

echo "쿠키 삭제 완료";

echo "==================================<br><br>";
echo "쿠키 테스트 메뉴 <br>";
echo "==================================<br><br>";
echo "<a href = cookie_set.php>관리자_쿠키입력</a><br>";
echo "<a href = cookie_set_normal.php>일반회원_쿠키입력</a><br>";
echo "<a href = cookie_check.php>쿠키_체크</a><br>";
echo "<a href = cookie_delete.php>쿠키_삭제</a><br>";
?>