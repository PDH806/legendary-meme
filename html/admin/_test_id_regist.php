<?php
//--+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+
// 	코딩정보
//--+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+
//
//	+ 개발자 : friday1968
//  + 이메일 : developer@7gate.kr
//
//	+ 개발사 : (주)세븐게이트코리아
//  + 연락처 : 010-2889-1483
//
//  + 화면내용 : 회원정보 등록화면 (패스워드 암호)
//--+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+

	$servername	= "dbserver"; $username = "skiresort"; $password = "ll170505"; $dbname = "skiresort";
	$connect = mysql_connect($servername, $username, $password); $link = mysqli_connect($servername, $username, $password, $dbname); mysql_select_db($dbname,$connect);

    function align_tel($telNo)
    {
        $telNo = preg_replace('/[^\d\n]+/', '', $telNo);
        if (substr($telNo, 0, 1)!="0" && strlen($telNo)>8) {
            $telNo = "0".$telNo;
        }
        $Pn3 = substr($telNo, -4);
        if (substr($telNo, 0, 2)=="01") {
            $Pn1 =  substr($telNo, 0, 3);
        } elseif (substr($telNo, 0, 2)=="02") {
            $Pn1 =  substr($telNo, 0, 2);
        } elseif (substr($telNo, 0, 1)=="0") {
            $Pn1 =  substr($telNo, 0, 3);
        }
        $Pn2 = substr($telNo, strlen($Pn1), -4);
        if (!$Pn1) {
            return $Pn2."-".$Pn3;
        } else {
            return $Pn1."-".$Pn2."-".$Pn3;
        }
    }

	$member_name    = $_POST['member_name'];
	$member_id    	= $_POST['member_id'];
	$member_phone   = align_tel($_POST['member_phone']);
	$member_email	= $_POST['member_email'];
	$member_birth	= $_POST['member_birth'];
	$join_date      = date('Y-m-d');
	$pw_date      	= date('Y-m-d') + 180;
	
	$sql = "INSERT INTO 7G_Skiresort_Member (
					MEMBER_NAME,
					MEMBER_ID,
					PHONE,
					EMAIL,
					AGREEMENT_DATE
					)

					VALUES (
					'$member_name',
					'$member_id',
					'$member_phone',
					'$member_email',
					'$join_date'
					 )";



	if (mysqli_query($link, $sql)) {} else {echo "Error: " . $sql . "<br>" . mysqli_error($link);}

	mysqli_close($link);

?>

<br><br><br><br>


<!-- footer for $member_table -->
	<?php include 'footer.html'; ?>
<!-- end of footer -->


</body>

</html>
