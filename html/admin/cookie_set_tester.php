<!DOCTYPE html>
<html>

<head>

<?

setcookie('Login_ID', $User_ID_Search, time() + 0,'/');
setcookie('rank', $rank, time() + 9, '/');

$User_ID_Search 	= $_GET["id"];
if (substr($User_ID_Search,0,6) == 'admin0'){$rank = 9;}
if (substr($User_ID_Search,0,5) == 'test0'){$rank = 9;}

setcookie('Login_ID', $User_ID_Search, time() + 600, '/');
setcookie('rank', $rank, time() + 600, '/');

if (substr($User_ID_Search,0,6) == 'admin0')
{
echo "
<script>
alert('관리자ID [$User_ID_Search] 로 로그인했습니다.')
location.href='cookie_set_manager.php';
</script>";
}

if (substr($User_ID_Search,0,5) == 'test0')
{
echo "
<script>
alert('테스트ID [$User_ID_Search] 로 로그인했습니다.')
location.href='cookie_set_tester.html';
</script>";
}

?>

