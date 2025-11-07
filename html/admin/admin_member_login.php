<?

	include 'db_config.html';
$User_ID_Search = trim($_POST["MID"]);

if ($User_ID_Search){

include '../_db_connect.html';
$sql      = "SELECT * FROM 7G_Skiresort_Member WHERE MEMBER_ID = '$User_ID_Search' limit 1";
$result	  = mysqli_query($link, $sql);
$member   = mysqli_fetch_array($result);

if(!$member){echo "<script>alert('회원정보가 존재하지 않습니다.');location.href='../_member/member_login.html'</script>";}
else {
	setcookie('Login_ID', $member[MEMBER_ID], time() + 600, '/');
	setcookie('rank', $member[RANK], time() + 600, '/');
		
		//echo $User_ID_Search;
		if($member['RANK'] > 9){echo "<script>location.href='../_admin'</script>";} else { echo "<script>location.href='../_mypage'</script>";}
	}
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><? echo $page_title; ?></title>

        <!-- Prevent the demo from appearing in search engines -->
        <meta name="robots" content="noindex">

        <!-- Perfect Scrollbar -->
        <link type="text/css" href="assets/vendor/perfect-scrollbar.css" rel="stylesheet">

        <!-- App CSS -->
        <link type="text/css" href="assets/css/app.css" rel="stylesheet">
        <link type="text/css" href="assets/css/app.rtl.css" rel="stylesheet">

        <!-- Material Design Icons -->
        <link type="text/css" href="assets/css/vendor-material-icons.css" rel="stylesheet">
        <link type="text/css" href="assets/css/vendor-material-icons.rtl.css" rel="stylesheet">

        <!-- Font Awesome FREE Icons -->
        <link type="text/css" href="assets/css/vendor-fontawesome-free.css" rel="stylesheet">
        <link type="text/css" href="assets/css/vendor-fontawesome-free.rtl.css" rel="stylesheet">

        <style> .card-img-top { width: 100%; height: 300px; object-fit: cover; } </style>


    </head>

    <body class="layout-default">

<?
     include '_header.html';

     // 페이지 Mid-Nav

       echo "
       <div class='container-fluid page__heading-container'>
           <div class='page__heading'>
               <nav aria-label='breadcrumb'>
                   <ol class='breadcrumb mb-0'>
                       <li class='breadcrumb-item'><a href='#'><i class='material-icons icon-20pt'>home</i></a></li>
                       <li class='breadcrumb-item'>Admin</li>
                       <li class='breadcrumb-item active'
                           aria-current='page'>테스트모드</li>
                   </ol>
               </nav>
               <h1 class='m-0'>테스트 로그인</h1>
           </div>
       </div>";


       echo "<br><br>
       <form action='admin_member_login.php' method='POST' enctype='multipart/form-data'>

           <div class='form-group' >
                   <div class='input-group'>
                         <div class='input-group-prepend'>
                           <button class='btn btn-primary light border-primary' type='button' style = 'width:130px;'>접수번호</button>
                         </div>
                         <input class='form-control'  type='text' name='MID' value = '$User_ID_Search'  $style_primary_readonly>
                 </div>											
           </div>

           <div class='form-group text-right'>
               &nbsp;<input type = 'submit' class='btn light btn-primary text-uppercase border-primary' type='button' value='로그인' onclick='submit()';>
           </div>
       </form>";

?>

     <? 
	 	include '_left_menu.html';
    	include '_footer.html';
     ?>


    </body>

</html>