<html>
<meta charset="utf-8">

<?
$table = $_GET['table'];

$connect = mysql_connect ("dbserver","ski","!@ski!@");
$mysql = mysql_select_db ("ski", $connect); 

$query = "select * from $table";
$result = mysql_query ($query, $connect);
$numcol = mysql_num_fields($query);
$totalFields = mysql_num_fields($result);	
echo "전체필드수:" .$totalFields;	
	while($row = mysql_fetch_row($result))
		{
			for($i=0; $i<$totalFields; $i++){
				echo "'$row[$i]',";
				}
				echo "<br>";
		}
		mysql_close($connect);
	?>
	
</html>