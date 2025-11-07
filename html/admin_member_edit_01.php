<?
$the_No				= $_POST["NO"];
$RS_BUYER_NAME		= $_POST["RS_BUYER_NAME"];
$RS_BUYER_NAME_ENG	= $_POST["RS_BUYER_NAME_ENG"];
$GENDER				= $_POST["GENDER"];
$RS_BUYER_TEL		= $_POST["RS_BUYER_TEL"];
$ZIP_CODE			= $_POST["ZIP_CODE"];
$ADDR1				= $_POST["ADDR1"];
$ADDR2				= $_POST["ADDR2"];

$connect = mysql_connect("dbserver","skiresort","ll170505");
mysql_select_db( "skiresort",$connect);

$query="UPDATE 7G_T_Reserve_New SET RS_BUYER_NAME = '$RS_BUYER_NAME', 
									RS_BUYERS_NAME_ENG = '$RS_BUYER_NAME_ENG', 
									GENDER = '$GENDER', 
									RS_BUYER_TEL = '$RS_BUYER_TEL', 
                                    ZIP_CODE = '$ZIP_CODE',
                                    ADDR1 = '$ADDR1',
                                    ADDR2 = '$ADDR2' 

                                    where NO = '$the_No'";
 
$result=mysql_query($query,$connect);
  
echo "<script>location.href='license_search.html';</script>";

?>