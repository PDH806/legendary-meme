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

    <title>스키장경영자협회</title>

		<!-- Custom styles for 스키비디오티비 | SKI_VIDEO.TV -->
			<?php 
		    include 'db_config.html';
			include 'link-files.html';
			?>
		<!-- end of Link -->

</head>

<body>

		<!-- Navigation for 스키비디오티비 | SKI_VIDEO.TV -->
			<?php include 'main-nav.html'; 

 			if (!$Login_User_ID){echo " <script language='javascript'>top.document.location.href = 'member_login.html?case=1'</script>";}			
			?>
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

    function replace_string($content, $type="TEXT")
    { // $type를 대문자로전환 $type = strtoupper($type);
        if ($type=="TEXT") {
            $content = stripslashes($content);
            $content = htmlspecialchars($content);
            $content = preg_replace("\r\n", "\n", $content);
            $content = preg_replace("\n", "<br>", $content);
            $content = $this->autoLink($content);
        } elseif ($type=="HTML") {
            $content = stripslashes($content);
            $content = preg_replace("\"", "", $content);
            $content = preg_replace("'", "", $content);
            $content = preg_replace("<\?", "&lt;?", $content);
            $content = preg_replace("\?>", "?&gt;", $content);
            $content = preg_replace("<\%", "&lt;%", $content);
            $content = preg_replace("\%>", "%&gt;", $content);
            $content = preg_replace("<(SCRIPT)(^>]*)>", "&lt;\\1\\2&gt;", $content);
            $content = preg_replace("<\(SCRIPT)>", "&lt;/\\1&gt;", $content);
            $content = preg_replace("<(XMP)(^>]*)>", "&lt;\\1\\2&gt;", $content);
            $content = preg_replace("</(XMP)>", "&lt;/\\1&gt;", $content);
        } elseif ($type=="HTML+TEXT") {
            $content = stripslashes($content);
            $content = preg_replace("\r\n", "\n", $content);
            $content = preg_replace("\n", "<br>", $content);
            $content = preg_replace("\"", "", $content);
            $content = preg_replace("'", "", $content);
            $content = preg_replace("<\?", "&lt;?", $content);
            $content = preg_replace("\?>", "?&gt;", $content);
            $content = preg_replace("<\%", "&lt;%", $content);
            $content = preg_replace("\%>", "%&gt;", $content);
        }

        return $content;
    }


//--+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+-------+


$title        = addslashes($_POST['title']);
$sub_title    = addslashes($_POST['sub_title']);
$contents     = addslashes($_POST['contents']);
$category     = $_POST['category'];
$today        = date("Y-m-d H:i:s");

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO $bbs_name (
					title, sub_title, category, contents, docu_date, member_id
					)

			VALUES (
					'$title', '$sub_title', '$category', '$contents', '$today', '$Login_User_ID'
					)";


 $title        = stripslashes($title);
 $sub_title    = stripslashes($sub_title);
 $contents     = stripslashes($contents);


if (mysqli_query($link, $sql)) {
    echo "
<section id='contact'>
    <div class='container'>
      <div class='row'>
        <div class='col-12 col-lg-12 text-center'>
          <h2 class='section-heading text-uppercase'>BBS 등록내용</h2>
          <p class='text-success'>회원 등록</p>
        </div>
      </div>

    <div class='container'>
      <div class='row'>
        <div class='col col-lg-12'>
        	<table class = 'table table-striped' width = 80%>
  				<thead class='thead-dark'>
                <tr>
                  <th>제목</th><td class='text-success'>$title</td>
                </tr>

                <tr>
                  <th>부제목</th><td class='text-success'><pre>$sub_title</pre></td>
                </tr>

                <tr>
                  <th>목록</th><td class='text-success'><pre>$categoy</pre></td>
                </tr>



            		<tr>
            			<th>내용</th><td class='text-success'><pre>$contents</pre></td>
            		</tr>


         		</table>

         	<a href = 'bbs_write.html'>
			<button class='btn btn-success btn-sm text-uppercase' type='button'>확인</button></a>

        </div>
      </div>

</section>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
}
mysqli_close($link);

?>

<br><br><br><br>


<!-- footer for 스키비디오티비 | SKI_VIDEO.TV -->
	<?php include 'footer.html'; ?>
<!-- end of footer -->


</body>

</html>
