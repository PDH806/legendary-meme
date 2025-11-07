<?
	include '../db_config.html';

	// 관리자가 아니면 member_login.html 페이지로 이동
	if ($rank != 9){
	echo " <script>
	alert('잘못된 접근입니다.');
	top.document.location.href = '../member_login.html?MEMBER_ID=$User_ID_Search&Case=9';
	</script>";
	}

  	extract($_REQUEST);
 	if ($DELIVERY_AGENCY and $TRACKING_NO)
 		{
 		
 			if (!$DELIVERY_FEE or $DELIVERY_FEE == ''){$DELIVERY_FEE = 0;}
 			if (!$DELIVERY_DATE or $DELIVERY_DATE == ''){$DELIVERY_DATE = date("Y-m-d");}
			$query="UPDATE 7G_License_Renew SET DELIVERY_AGENCY = '$DELIVERY_AGENCY' , TRACKING_NO = '$TRACKING_NO', DELIVERY_FEE = $DELIVERY_FEE, DELIVERY_DATE = '$DELIVERY_DATE', TRAN_STATUS = 3  where NO = '$NO'";
			$result=mysql_query($query,$connect );
 		}



 	echo "<script>location.href='License_Renew.html'</script>";

?>

	<!-- footer for AUGMENT-SKI -->
		<? include 'footer.html'; ?>
	<!-- end of footer -->
	
</body>

</html>