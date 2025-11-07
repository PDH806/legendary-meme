<?php

	// 회원정보 업데이트


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


		$query= "select * from 7G_T_Reserve where RS_BUYER_TEL <> '' and  RS_BUYER_PHOTO <> '' order by RS_BUYER_NAME limit 0, 1000";
		$result=mysqli_query($link, $query);
		$row=mysqli_fetch_array($result);
		$total_record = mysqli_num_rows($result);


		echo $total_record;
		
		
		// 페이징
		
		$page = ($_GET['page'])?$_GET['page']:1;
		if (!$list){$list = 100;}// 페이자당 목록수
		$show = 10; // 하단 페이지네이션 갯수

    	$db_start = ($page - 1) * $list;
		$db_end = $list;
		
		$max_page1 = floor($total_record / $list);
		$max_page2 = $total_record / $list;
		if ($max_page2 > $max_page1){$max_page = $max_page1 + 1;}else{$max_page = $max_page1;}
		if ($page>$max_page){$page = $max_page;}
		$previous = $page - 1;
		$next = $page + 1;
		if ($next>$max_page){$next = $max_page;}
		if ($previous<1){$previous = 1;}
		$page_start = (($page - 1) * $list );
		if ($page_start <= 0){$page_start = 0;}
		$page_end = $page_start + $list;
		
		
		echo "<table border='1'>";
		
		while($row){
  	 	
		// $my_server_img = 'http://images.askmen.com/galleries/cobie-smulders/picture-1-134686094208.jpg';
		// $img = imagecreatefromjpeg($my_server_img);
		// $path = 'images_saved/';
		// imagejpeg($img, $path);  	 	
  	 	
	 	$member_tel2 = align_tel($row[RS_BUYER_TEL]); 
	 	
		$i = $i + 1;
    	 echo "<tr>
     		<td>$i</td>
     		<td>$row[RS_BUYER_NAME]</td>
     		<td><img src = '$row[RS_BUYER_PHOTO]' width = 100px></td>
     		<td>$member_tel2</td>
     		<td>$row[LICENSE_NUM]</td>
     		<td>$row[LICENSE_TMP_NUM]</td>

			<tr>
		  ";	
		  
			$row=mysqli_fetch_array($result);
    	}

		echo "</table>";

?>



	<?

	echo "
			<br><br><br>  
			<a class='page-link' href='admin_member.html?category=$category&page=$previous&GENDER2=$Gender_search&PHOTO2=$Photo_search&list2=$list'>Previous</a>&nbsp;&nbsp;";
    	
$show_end_page = $page+$show;
$show_start_page = $page;

if ($show_end_page > $max_page){$show_end_page = $max_page + 1;}
if ($max_page <= $show){$show_start_page = 1;}
    	
for($i=$show_start_page; $i<$show_end_page; $i++)
	{
    	if($page == $i)
    		{
    			echo "<a class='page-link' href='admin_member.html?category=$category&page=$i&GENDER2=$Gender_search&PHOTO2=$Photo_search&list2=$list'>$i<span class='sr-only'>(current)</span><a>&nbsp;&nbsp;";
   			}
    
    	else
    	
    		{
    			echo "<a class='page-link' href='admin_member.html?category=$category&page=$i&GENDER2=$Gender_search&PHOTO2=$Photo_search&list2=$list'>$i</a>&nbsp;&nbsp;";
    		}

	}    
    echo "<a class='page-link' href='admin_member.html?category=$category&page=$next&GENDER2=$Gender_search&PHOTO2=$Photo_search&list2=$list'>Next</a>
    
  </ul>
  
</nav>
</div>
";
?>
