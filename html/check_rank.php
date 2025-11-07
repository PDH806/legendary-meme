<?php
include 'db_config.html';

if($_COOKIE['rank'] !=9) {
  $_check = false;
}
else{
  $_check = true;
}

if($_check ==false) {
  echo "<script>alert('비정상적인 접근입니다.');history.back();</script>";
}

?>