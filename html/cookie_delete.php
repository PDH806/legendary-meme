<!DOCTYPE html>
<html>

<head>

<?
$User_ID_Search = '';
$rank = '';

setcookie('Login_ID', $User_ID_Search, time() + 0,'/');
setcookie('Member_Rank', $rank, time() + 0, '/');

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
			
<br><br><br>

<?php

echo "
<div class = 'container'>

		   <div class='divTable'>
				<div class='divTableBody'>						
					<div class='divTableRow' style = 'height:100px;'>
						<div class='divTableCell' style = 'font-size:24px;'>테스트용 로그인 아웃 (관리자용)</div>
					</div>
				</div>
			</div>

        <table border=0 width = 100% style = 'border-bottom: 1px solid #d4d4d4;'>
            <div class='alert alert-primary' style = 'height:400px;text-align:center;font-size:18px;font-weight:700'>
			  사용중인 '테스트 사용자 & 관리자'의 로그인이 해제되었습니다.
			</div>      
		</table>
</div>";

?>
<br><br><br>

</body>

		<!-- Custom styles for AUGMENT-SKI -->
			<? include 'footer.html'; ?>
		<!-- end of Link -->
	
</body>		
</html>
