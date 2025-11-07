<html>
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

		$connect=mysql_connect("dbserver","skiresort","ll170505");
		mysql_select_db( "skiresort",$connect);

 		$query1= "SELECT * FROM 7G_T_Reserve_New WHERE LC_SKI3 = 'Y' order by RS_BUYER_NAME ASC" ;
 		$result1=mysql_query($query1,$connect );

 		$query= "SELECT * FROM 7G_T_Reserve_New WHERE LC_SKI3 = 'Y' order by RS_BUYER_NAME ASC" ;
 		$result=mysql_query($query,$connect);
 		$member_list=mysql_fetch_array($result);
		$total_record = mysql_num_rows($result1);
			
				
?>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<link rel="shortcut icon" href="Myicon.png" type="image/x-icon">
    
    <title>
    	<?
    	echo "$main_title";    	
    	?>    
    </title>
    

		
</head>

<body>

<?

echo $total_record;
echo "<table border='1'>";
for($i=0; $i<$total_record; $i++)
  	{
  	
  	 	$query3 = "SELECT * FROM 7G_T_Reserve_New WHERE LC_SKI2 = 'Y' and RS_BUYER_NAME = '$member_list[RS_BUYER_NAME]' " ;
 		$result3=mysql_query($query3,$connect);
 		$member_list3=mysql_fetch_array($result3);
		$total_record3 = mysql_num_rows($result3);

 	 if ($member_tel == '-'){$member_tel = '';}
 	
	 $member_tel2 = align_tel($member_list[RS_BUYER_TEL]); 

     echo "<tr>
     		<td>$i</td>
     		<td>$member_list[RS_BUYER_NAME]</td>
     		<td>$member_tel2</td>
     		<td>$total_record3</td>
			<tr>
		  ";	
		  
 		  $member_list = mysql_fetch_array($result);
    }

echo "</table>";

?>
	<!-- footer for AUGMENT-SKI -->
		<? include 'footer.html'; ?>
	<!-- end of footer -->
	
</body>

</html>