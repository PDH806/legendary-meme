<?php

	$REF_NO = $_POST["apply_no"];
	$connect = mysqli_connect("dbserver","skiresort","ll170505","skiresort");
	$sql="SELECT * FROM 7G_Master_Apply WHERE REF_NO = '$REF_NO' and PAYMENT_STATUS = 2";
	$result=mysqli_query($connect,$sql);
    $member = mysqli_num_rows($result);     

	if($member == 0)
		{
		}
		  		
	if($member >= 1)
		{
			echo "<script>alert('결제가 완료되었습니다.');</script>";
		}

?>