<!DOCTYPE HTML>
<html>

<head>
	<title>Home</title>
	<!--ZDC9PD, 14151501, Zac Crane -->
</head>
<body>
	<p>Account Home</p>
	<?php

		$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=zdc9pd user=zdc9pd password=K4wzrUi5") or die('Error, could not connect: '.pg_last_error() . "\n");
		session_start();

		if ($_SESSION['username'] == NULL) {
		   header("Location: https://babbage.cs.missouri.edu/~zdc9pd/cs3380/lab8/index.php");
		}

		$user = $_SESSION['username'];
		
		$query = "SELECT * FROM lab8.user_info WHERE username LIKE $1";		
		pg_prepare($conn,"user_desc",$query);
		$result = pg_execute($conn,"user_desc",array($user)) or die(pg_last_error());
		$result = pg_fetch_array($result);
		
		echo "Username: " . $result['username'] . '<br>';
		echo "Registration Date: " . $result['registration_date'] . '<br>';
		echo "Description: " . $result['description'] . '<br>';
		
		$query = "SELECT * FROM lab8.log WHERE username LIKE $1";		
		pg_prepare($conn,"ip_find",$query);
		$result = pg_execute($conn,"ip_find",array($user)) or die(pg_last_error());
		$result = pg_fetch_array($result);
		
		echo "Original IP address: " . $result['ip_address'] . '<br>';
		
		$query = "SELECT * FROM lab8.log WHERE username LIKE $1 ORDER BY log_id ASC";
		pg_prepare($conn,"select",$query);
		$result = pg_execute($conn,"select",array($user)) or die(pg_last_error());
		
		
		echo '<br>';

		//printing results in HTML

		$y = pg_num_fields($result);

			echo "\t<table border = 1>\n";
			echo "\t<tr>\n";
			for ($i = 0; $i < $y; $i++) {
				$field = pg_field_name($result, $i);
				echo "\t\t<th>$field</th>\n";
			}
			echo "\t</tr>\n";


		while($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		  echo "\t<tr>\n";
			  foreach ($line as $col_value) {
					echo"\t\t<td>$col_value</td>\n";
					}
			  echo "\t</tr>\n";
			}
		echo "</table>\n";

	?>
	<br />
	<a href="update.php">Update Account</a>
	<br />
	<br />
	<form method = "POST" action = "logout.php">
		<input type = "submit" name = "logout" value = "logout">
	</form>
</body>
</html>
