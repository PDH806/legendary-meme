<?php
    // ini_set( "display_errors", 1 );

    // ini_set('display_startup_errors', 1);

    // error_reporting(E_ALL);


include '../db_config.html';

$apply_no = $_GET["apply_no"];
if(!empty($_GET["apply_no"])) {

  $sql ="UPDATE 7G_Master_Apply SET BibYn = CASE WHEN BibYn = 'Y' THEN 'N' ELSE 'Y' END where apply_no=".$_GET["apply_no"];
  mysqli_query($link, $sql);
  
  $sql1 ="select BibYn from 7G_Master_Apply where apply_no=".$_GET["apply_no"];
  $result		= mysqli_query($link, $sql1);
  $PAY		= mysqli_fetch_array($result);

  $BibYn = $PAY["BibYn"];
  echo "<span class='text-success".$apply_no."'>".$BibYn."</span>";

}
?>


