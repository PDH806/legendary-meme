<html>
<meta charset="utf-8">

<?
$table = $_GET['table'];

$connect = mysql_connect ("dbserver","ski","!@ski!@");
$mysql = mysql_select_db ("ski", $connect); 

$query = "SELECT
TABLE_NAME, COLUMN_NAME, COLUMN_COMMENT
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = 'ski'";
$result = mysql_query ($query, $connect);
$numcol = mysql_num_fields($query);
$totalFields = mysql_num_fields($result);	
while($row = mysql_fetch_row($result))
		{
			for($i=0; $i<$totalFields; $i++){
				echo "'$row[$i]',";
				}
				echo "<br>";
		}
		mysql_close($connect);
	?>``
	
</html>