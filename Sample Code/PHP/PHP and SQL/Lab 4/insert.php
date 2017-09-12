<?php
//connect to the DB
	$DBconn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=zdc9pd user=zdc9pd password=K4wzrUi5") or die('Error, could not connect: '.pg_last_error() . "\n"); 

//Get the input from the prev. form
	$name = htmlspecialchars($_POST['name']);
	$code = htmlspecialchars($_POST['code']);
	$district = htmlspecialchars($_POST['district']);
	$population = htmlspecialchars($_POST['population']);

	// Insert
	pg_prepare ($DBconn, "insert",'INSERT INTO lab4.city VALUES (default, $1,$2,$3,$4)');
	if(pg_execute ($DBconn, "insert", array($name, $code, $district, $population))){
		echo "Insert was successful\n";
		echo "<br>Return to <a href = 'index.php'>search page</a>\n";
	}
	else {
		echo "Unable to insert\n";
		echo "<br>Return to <a href = 'index.php'>search page</a>\n";
	}
	

	pg_close($DBconn);

?>