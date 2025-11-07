<!DOCTYPE html>
<html>

<head>

<?

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


	$category 	 = $_POST["category"];
	$member_name = $_POST["member_name"];
	$birth 		 = $_POST["birth"];
	$phone2   	 = align_tel($_POST['phone']);
	$phone 		 = $_POST["phone"];
	
	$main_title = '한국 스키장 경영협회';
	include 'db_config.html';
?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<link rel="shortcut icon" href="Myicon.png" type="image/x-icon">
    
    <title>
    	<?
    	echo "$main_title";    	
    	?>    
    </title>
    
		<!-- Custom styles for AUGMENT-SKI -->
			<? include 'link-files.html'; ?>
		<!-- end of Link -->
		
</head>



<body>

		<!-- Navigation for AUGMENT-SKI -->
			<? include 'main-nav.html'; ?>
		<!-- end of Navigation -->

<br><br><br><br>



<script>
function removeCheck() {

 if (confirm("정말 삭제하시겠습니까??") == true){    //확인

     document.removefrm.submit();

 }else{   //취소

     return false;

 }

}

</script>



<?
		
	if (!$category){$category = '1';}
		
	if ($category == '1'){$category_active1 = 'active';}
	if ($category == '2'){$category_active2 = 'active';}
	if ($category == '3'){$category_active3 = 'active';}
	if ($category == '4'){$category_active4 = 'active';}

				 
 
			// $connect=mysql_connect("localhost","skiresort","ll170505");
			// mysql_select_db( "skiresort",$connect);

 			$query= "select * from 7G_Skiresort_Member where MEMBER_NAME = '$member_name' and PHONE = '$phone2' " ;
 			$result=mysql_query($query,$connect );
 			$License=mysql_fetch_array($result);
			$total_record = mysql_num_rows($result);
			
			$member_name = mb_substr($License[MEMBER_NAME], 0, 2, 'utf-8')."*";

 			if ($License[PHOTO3]){$img = "<img src = 'data/$row[PHOTO3]' class = 'border border-dark img-thumbnail rounded-lg' width = 100px>";}
			if (!$License[PHOTO3]){$img = "<img src = 'data/no_image.jpg' class = 'border border-dark img-thumbnail rounded-lg' width = 100px>";}
			if ($License[image]){$img = "<img src = 'view3.html?id=$License[MEMBER_ID]' class = 'border border-dark img-thumbnail rounded-lg' width = 100px>";}

 
 
 ?>
 
 
	<div class="newsletter8 py-5">
		<div class="container">
			<div class="col-lg-12 ml-auto">


			<!-- Head -->
        		<div class="d-block d-md-flex text-uppercase">
          			<h3 class="no-shrink font-weight-medium align-self-center m-b-0"><? echo "한국스키장경영협회 $license 자격확인 (총 $total_record"; ?> 건 )</h3>
        		</div>
        		<br>

		<!-- Tap Menu -->

			<ul class="nav nav-tabs">
			
					
			
<?  


 if ($category == '1' or $category == '2' or $category == '3' or $category == '4')
 {
 
 echo "
 
		<!-- Tap Menu -->
				<table class = 'table table-striped' width = 100% >
  					<thead class='font16' style = 'background-color:#808080;color:white;'>
						<td><b>회원사진</b></td>
						<td><b>회원이름</b></td>
						<td><b>자격증</b></td>
   						<td><b>License No.</b></td>
   						<td><b>취득연도</b></td>
					</th>";
					
					
					if ($License[T1_LICENSE]){
					
						echo "
									
							<tr class = 'font16' style = 'background-color:#ffffff;color:black;' >
								<td>$img</td>
								<td>$member_name</td>
								<td>스키지도요원 티칭1</td>
								<td>$License[T1_LICENSE_No]</td>
								<td>$License[T1_YEAR]</td>
							</tr>";
					}
					
					
					if ($License[T2_LICENSE]){
					
						echo "
									
							<tr class = 'font16'style = 'background-color:#ffffff;color:black;' >
								<td>$img</td>
								<td>$member_name</td>
								<td>스키지도요원 티칭2</td>
								<td>$License[T2_LICENSE_No]</td>
								<td>$License[T2_YEAR]</td>
							</tr>";
					}
					
					if ($License[T3_LICENSE]){
					
						echo "
							<tr class = 'font16' style = 'background-color:#ffffff;color:black;' valign = 'middle'>
								<td>$img</td>
								<td>$member_name</td>
								<td>스키지도요원 티칭3</td>
								<td>$License[T3_LICENSE_No]</td>
								<td>$License[T3_YEAR]</td>
							</tr>";
					}
					

					if ($License[SBT1_LICENSE]){
					
						echo "
							<tr class = 'font16' style = 'background-color:#ffffff;color:black;' valign = 'middle'>
								<td>$img</td>
								<td>$member_name</td>
								<td>보드지도요원 티칭1</td>
								<td>$License[SBT1_LICENSE_No]</td>
								<td>$License[SBT1_YEAR]</td>
							</tr>";
					}


					if ($License[SBT2_LICENSE]){
					
						echo "
							<tr class = 'font16' style = 'background-color:#ffffff;color:black;' valign = 'middle'>
								<td>$img</td>
								<td>$member_name</td>
								<td>보드지도요원 티칭2</td>
								<td>$License[SBT2_LICENSE_No]</td>
								<td>$License[SBT2_YEAR]</td>
							</tr>";
					}


					if ($License[SBT3_LICENSE]){
					
						echo "
							<tr class = 'font16' style = 'background-color:#ffffff;color:black;' valign = 'middle'>
								<td>$img</td>
								<td>$member_name</td>
								<td>보드지도요원 티칭2</td>
								<td>$License[SBT3_LICENSE_No]</td>
								<td>$License[SBT3_YEAR]</td>
							</tr>";
					}

					if ($License[PATROL_LICENSE]){
					
						echo "
							<tr class = 'font16' style = 'background-color:#ffffff;color:black;' valign = 'middle'>
								<td>$img</td>
								<td>$member_name</td>
								<td>스키구조요원</td>
								<td>$License[PATROL_LICENSE_No]</td>
								<td>$License[PATROL_YEAR]</td>
							</tr>";
					}


				echo "					
				</table>
				";
 
 
 if (!$License[T1_LICENSE] and !$License[T2_LICENSE] and !$License[T3_LICENSE] and !$License[SBT1_LICENSE] and !$License[SBT2_LICENSE] and !$License[SBT3_LICENSE] and !$License[PATROL_LICENSE] )
 	{
 	
 			echo "
				   <div class='divTable'>
				<div class='divTableBody' style = ''>						
					<div class='divTableRow' style = 'height:400px;background-color:#ccfffe;'>
						<div class='divTableCell' style = 'font-size:24px;border: 1px solid #707070;'>자격증 보유현황이 없습니다.</div>
					</div>
				</div>
			</div>
			<br><br><br>
			
			";		
 	
 	}
 	
		
		} 		
		
 
 
 
 
 ?>
 
       </div>
        정보수정/자격증 출력/ID카드재발급은 회원가입 및 전화번호 인증을 완료한 경우만 가능합니다.

  </div>
</div>
 
 
 
     <!-- footer for AUGMENT-SKI -->
	<? include 'footer.html'; ?>
	<!-- end of footer -->
	
</body>

</html>