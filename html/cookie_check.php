<!DOCTYPE html>
<html>

<head>

<?
$Login_ID = $_COOKIE["Login_ID"];
$rank = $_COOKIE["Member_Rank"];

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
			<? include 'main-nav.html'; 
				include 'header_sub_page.html';
			
			?>
		<!-- end of Navigation -->

<br><br><br>

<?php

echo "
<div class = 'container'>

		   <div class='divTable'>
				<div class='divTableBody'>						
					<div class='divTableRow' style = 'height:100px;'>
						<div class='divTableCell' style = 'font-size:24px;'>테스트 로그인 상태</div>
					</div>
				</div>
			</div>


        <div class='container'>
        <table border=0 width = 100% style = 'border-bottom: 1px solid #d4d4d4;'>
            <div class='alert alert-primary' style = 'height:400px;text-align:center;font-size:18px;font-weight:700'>
			  접속ID : $Login_ID <br> 회원등급 : $rank
			</div>      
		</table>
		</div>
";

echo "</div>";

?>

<br><br><br>

</body>

		<!-- Custom styles for AUGMENT-SKI -->
			<? include 'footer.html'; ?>
		<!-- end of Link -->
