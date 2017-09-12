<?php
//connect to the DB
	$DBconn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=zdc9pd user=zdc9pd password=K4wzrUi5") or die('Error, could not connect: '.pg_last_error() . "\n"); 

	$table = $_POST['table'];
	$pkey = $_POST['primary_key'];
	switch($table) {
		case "country":
			$query = 'DELETE FROM lab4.country WHERE (country_code = \''.$pkey.'\');';
			break;
		case "language":
			$p_key1 = $_POST['pk1'];
			$p_key2 = $_POST['pk2'];
			$query = 'DELETE FROM lab4.country_language WHERE (country_code = \''.$p_key1.'\') AND (language=\''.$p_key2.'\');';
			break;
		case "city":
			$query = 'DELETE FROM lab4.city WHERE (id = '.$pkey.')';
			break;
	}
	pg_prepare($DBconn,"delete",$query);
	
	if(pg_execute($DBconn,"delete",array())) {
		echo "Record deleted.\n";
		echo"<br> Return to <a href = 'index.php'>search page</a>\n";
	}
	else {
		echo "Delete Failed <br />";
		echo"<br> Return to <a href = 'index.php'>search page</a>\n";
	}
	
	
	pg_free_result($x);
	pg_close($DBconn);
?>
