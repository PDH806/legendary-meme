<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
//2014-06-18 WEBsiting.co.kr

alert("정상적으로 접수되었습니다.");
?>
<script> location.href = "<?php echo G5_BBS_URL ?>/write.php?bo_table=<?php echo $bo_table ?>"; </script>
