<?php

//2023.01.24

	include '../db_config.html';
    if (!$Login_User_ID) {echo " <script language='javascript'>top.document.location.href = '../member_login.html'</script>";}
	
	extract($_REQUEST);

	$today = date("Ymd H:i:m");

	if($MID){
		// $query="UPDATE 7G_Master_Apply SET TRAN_STATUS = 2, CANCLE_DATE = '$today' where Apply_No = $MID";
   	//  	$result=mysqli_query($link, $query);
	}

	echo "
		<script>
			//alert('선택하신 티칭검정 참가신청이 취소되었습니다. 감사합니다.');
			//top.document.location.href = 'admin_master_apply_list.html'
		</script>
	";

?>