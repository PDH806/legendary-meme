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

	include '../_db_connect.html';

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
$docu_date     = addslashes($_POST['docu_date']);
$category     = $_POST['category'];
$view         = $_POST['view'];
$tag          = $_POST['tag'];
$page         = $_POST['page'];
$count        = $_POST['count'];

$update_date  = date("Y-m-d");

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "update bbs set title='$title' , sub_title='$sub_title', category='$category', contents='$contents', docu_date = '$docu_date', update_date = '$update_date', tag = '$tag', count = $count, view = $view where docu_no = $docu_no";


if (mysqli_query($link, $sql)) {
    echo " <script>location.href='bbs_view.html?no=$docu_no&page=$page';</script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
}
mysqli_close($link);

?>

</body>

</html>
