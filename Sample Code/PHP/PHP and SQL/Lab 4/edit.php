<?php
//connect to the DB
	$DBconn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=zdc9pd user=zdc9pd password=K4wzrUi5") or die('Error, could not connect: '.pg_last_error() . "\n"); 

	$table = $_POST['table'];
	$pkey = $_POST['primary_key'];
	
	switch($table) {
		case "country":
			$population = htmlspecialchars($_POST['population']);
			$life_expectancy = htmlspecialchars($_POST['life_expectancy']);
			$gnp = htmlspecialchars($_POST['gnp']);
			$head_of_state = htmlspecialchars($_POST['head_of_state']);

			$query = $query = 'UPDATE lab4.country SET population='.$population.', life_expectancy='.$life_expectancy.', gnp='.$gnp.', head_of_state=\''.$head_of_state.'\' WHERE (country_code = \''.$pkey.'\');';
		
			pg_prepare($DBconn, "update", $query);
			if (pg_execute($DBconn, "update", array())) {
				echo "Update successful <br\>";
				echo "<br> Return to <a href = 'index.php'>search page</a>\n";
			}
			else{
				echo "Update unsuccessful <br\>";
				echo "<br> Return to <a href = 'index.php'>search page</a>\n";
				return;
			}
			break;
		case "city":
			$population = htmlspecialchars($_POST['population']);
			$query = 'UPDATE lab4.city SET population = '.$population.' WHERE (id='.$pkey.');';
			pg_prepare($DBconn, "update", $query);
			if (pg_execute($DBconn, "update", array())) {
				echo "Update successful <br />";
				echo"<br> Return to <a href = 'index.php'>search page</a>\n";
				return;
			}
			else{
				echo "Update unsuccessful <br\>";
				echo "<br> Return to <a href = 'index.php'>search page</a>\n";
				return;
			}
			break;
		case "language":
			$language = $_POST['language'];
			$is_official = htmlspecialchars($_POST['is_official']);
			$percentage = htmlspecialchars($_POST['percentage']);
			$country_code = $_POST['pk1'];
		
			
			$query = 'UPDATE lab4.country_language SET is_official=\''.$is_official.'\', percentage = \''.$percentage. '\' WHERE (country_code = \''.$country_code.'\');';
			pg_prepare($DBconn, "update", $query);
			if (pg_execute($DBconn, "update", array())) {
				echo "Update successful <br/>";
				echo "<br> Return to <a href = 'index.php'>search page</a>\n";
			}
			else{
				echo "Update unsuccessful <br\>";
				echo "<br> Return to <a href = 'index.php'>search page</a>\n";
				return;
			}
			break;
			
	}

	
	pg_free_result($x);
	pg_close($DBconn);
?>