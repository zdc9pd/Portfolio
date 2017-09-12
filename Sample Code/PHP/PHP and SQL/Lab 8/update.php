<!DOCTYPE HTML>
<html>

<head>
	<title>Update</title>
	<!--ZDC9PD, 14151501, Zac Crane -->
</head>
<body>
	<p> Update Account Info </p>
	
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
	
		echo "Username is: " . $result['username'] . '<br>';
		echo "Description is : " . $result['description'] . '<br>'; 
			
	?>

	<form method = "POST" action ="<?= $_SERVER['PHP_SELF'] ?>">
		Update Description<input type = "text" name = "desc_update">
		<input type = "submit" name = "submit" value = "submit">
	</form>

	<?php
		if(isset($_POST['submit'])) {	
			$new_description = htmlspecialchars($_POST['desc_update']);
			$log = 'update desc';
			$ip = $_SERVER['REMOTE_ADDR'];
			
			$query = "UPDATE lab8.user_info SET description = $1 WHERE username LIKE $2";		
			pg_prepare($conn,"update",$query);
			$result = pg_execute($conn,"update",array($new_description,$user)) or die(pg_last_error());
			
			$query = "INSERT INTO lab8.log (username, ip_address,action) VALUES ($1, $2, $3)";
			pg_prepare($conn,"log_login",$query);
			pg_execute($conn,"log_login",array($user,$ip,$log));
			
			header ("Location: https://babbage.cs.missouri.edu/~zdc9pd/cs3380/lab8/home.php");
		}
	?>
	<a href = "home.php">Go Back to Home </a>
</body>
</html>
