<?php
	include 'db_config.html';

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



$id 	= $_POST["id"];
$phone 	= $_POST["phone"];
$code 	= $_POST["code"];

$phone 	= align_tel($phone);

 	// $connect		= mysql_connect("dbserver", skiresort, ll170505);
 	// $link			= mysqli_connect("dbserver", skiresort, ll170505, skiresort);
 	// mysql_select_db(skiresort,$connect);



if(!empty($code))
	{
  		$sql 		= "SELECT * FROM 7G_Skiresort_Phone_Check WHERE id = '$id' and phone = '$phone' and code = '$code' order by no DESC limit 1";
  		$result		= mysqli_query($link, $sql);
  		$numrow 	= mysqli_num_rows($result);

  		if($numrow == 1) {
      		echo "<span class='text-success'>&nbsp;👍&nbsp;&nbsp;인증번호 6자리가 일치합니다.<br></span>";
      		
  		}else{
      		echo "<span class='text-danger'>&nbsp;👎&nbsp;&nbsp;인증번호 6자리가 불일치합니다.<br></span>";
  		}
}
?>