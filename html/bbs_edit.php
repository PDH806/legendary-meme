<!DOCTYPE html>
<html>

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
?>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	   <link rel="shortcut icon" href="Myicon.png" type="image/x-icon">

    <title>한솔섬유배 아름다운 스키 페스티벌</title>

		<!-- Custom styles for AUGMENT-SKI -->
			<?php include 'link-files.html';?>
		<!-- end of Link -->

</head>

<body>

<style>
img
{
  max-width: 100%;
  height: auto;
}
</style>




		<!-- Navigation for AUGMENT-SKI -->
			<?php include 'main-nav.html'; ?>
		<!-- end of Navigation -->

<br><br><br><br>



<?php


//--+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+
// 	PHP 함수
//--+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+

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


//--+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+

$docu_no      = $_POST['docu_no'];
$title        = addslashes($_POST['title']);
$sub_title    = addslashes($_POST['sub_title']);
$contents     = addslashes($_POST['contents']);
$category     = $_POST['category'];
$update_date  = date("Y-m-d");

$connect = mysqli_connect("dbserver", "ksports", "ll170505", "ksports");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "update bbs_hansoll set title='$title' ,category='$category', contents='$contents', update_date = '$update_date' where docu_no = '$docu_no'";


if (mysqli_query($connect, $sql)) {
    echo " <script>location.href='bbs_view.html?no=$docu_no';</script>
";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($connect);
}
mysqli_close($connect);

?>

<!-- footer for AUGMENT-SKI -->
	<?php include 'footer.html'; ?>
<!-- end of footer -->


</body>

</html>
