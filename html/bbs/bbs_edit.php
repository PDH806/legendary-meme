<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
// Developer : (주)세븐게이트코리아  |  070-8065-2441  |  friday1968  |  friday1968@7gate.kr
// Title 	 : BBS Table Insert 모듈
// Udated	 : Ver.2.2 (2021.10.3)

include '../db_config.html';
include '../check_rank.html';

	$docu_no	  = $_GET['No'];

    //update

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

    $title        = addslashes($_POST['title']);
    // $sub_title    = addslashes($_POST['sub_title']);
    $contents     = addslashes($_POST['contents']);
    // $tag          = addslashes($_POST['tag']);
    $view         = 0;

    $category     = $_POST['category'];
    $today        = date("Y-m-d");

    if (!$link) {die("Connection failed: " . mysqli_connect_error());}

    $sql = "update bbs_Skiresort set title='$title',contents='$contents',update_date='$today',member_id='$Login_User_ID' where docu_no=$docu_no";
    // echo $bbs_insert;
    $title        = stripslashes($title);
    $sub_title    = stripslashes($sub_title);
    $contents     = stripslashes($contents);



    if (mysqli_query($link, $sql)) {echo "<script language='javascript'>alert('작성하신 문서가 정상적으로 수정되었습니다.');top.document.location.href = '../sb_notice_on.html?No=$docu_no'</script>";}
    else {echo "Error: " . $sql . "<br>" . mysqli_error($link);}
    

    mysqli_close($link);

?>