<?
	include '../db_config.html';
	$query= "SELECT * FROM 7G_Skiresort_Member WHERE image IS NOT NULL and image <> ''" ;
	$result=mysql_query($query,$connect );
	$row=mysql_fetch_array($result);
	$total_record = mysql_num_rows($result);
	
	echo $total_record."<br>";
	
	while ($row)
	{
	copy("https://skiresort.or.kr/view3.html?id=$row[MEMBER_ID]", "../member_imgs/$row[MEMBER_ID].jpg");
	echo "$row[MEMBER_ID]<br><img src = '../member_imgs/$row[MEMBER_ID].jpg'><br><br>";
	
    $row=mysql_fetch_array($result);
	
	}

?>