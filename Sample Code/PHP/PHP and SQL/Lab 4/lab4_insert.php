<?php 
	//connect to the DB
	$DBconn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=zdc9pd user=zdc9pd password=K4wzrUi5") or die('Error, could not connect: '.pg_last_error() . "\n"); 

	echo "\tEnter data for the new city:\n";
	
	$query = 'SELECT country_code, name FROM lab4.country ORDER BY name ASC';
	$result = pg_prepare($DBconn, "country_search", $query);
	$result = pg_execute($DBconn, "country_search", array());
?>

<form method = "POST" action = "insert.php">
	<table border =1>
		<tr>
			<td>Name:</td>
			<td><input type = "text" name = "name"></td>
		</tr>
		<tr>
			<td>Country Code</td>
			<td>
				<select name = "code">
					<?php
					while ($x = pg_fetch_row($result)) {
							echo "<option value = '$x[0]'>$x[1]</option><br />";
					} 
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>District:</td>
			<td><input type = "text" name = "district"></td>
		</tr>
		<tr>
			<td>Population:</td>
			<td><input type = "text" name = "population"></td>
		</tr>
	</table>
	<input type = "submit" name = "submit" value = "Save">
</form>

<form method = "POST" action = "index.php">
	<input type = "submit" value = "Cancel">
</form>

<?php 
	pg_free_result($x);
	pg_close($DBconn);
?>

