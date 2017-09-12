<!DOCTYPE HTML>
<html>

<head>
	<title>Registration</title>
	<!--ZDC9PD, 14151501, Zac Crane -->
</head>
<body>
	<form method="POST" action = "<?= $_SERVER['PHP_SELF'] ?>">
	Desired Username: <input type="text" name="username">
	Desired Password: <input type="password" name="password">
	<input type="submit" name = "submit" value="submit">
	</form>
	
	<?php
		// Make sure we have a secure connection
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'|| $_SERVER['SERVER_PORT'] == 443) {
			$security = true;
		}
		if ($security != true)
		{
			header("Location: https://babbage.cs.missouri.edu/~zdc9pd/cs3380/lab8/registration.php");
		}
		if (isset($_POST['submit'])) {
			$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=zdc9pd user=zdc9pd password=K4wzrUi5") or die('Error, could not connect: '.pg_last_error() . "\n");  
			$user = htmlspecialchars($_POST['username']);
			$ip = $_SERVER['REMOTE_ADDR'];
			/*
			$query = "SELECT username FROM lab8.authentication WHERE username = '$user'";
			$result = pg_query($query) or die (pg_last_error());
			*/
			$query = "SELECT username FROM lab8.authentication WHERE username = $1";
			pg_prepare($conn,"user_check",$query);
			$result = pg_execute($conn,"user_check",array($user)) or die(pg_last_error());
			
			$check = pg_num_rows($result);
			
			if ($check != 0) {
				die('Please try a different username! ' . '<a href="registration.php">Register</a>');
			}
			
			//Salt and Hash the password
			mt_srand();
			$salt = mt_rand();
			$password = htmlspecialchars($_POST['password']);
			$p_hash = sha1($salt . $password);
			
			//insert new user into User_info
			//$insert_1 = pg_query($conn, "INSERT INTO lab8.user_info (username, registration_date) (VALUES ('$user', DEFAULT))") or die ("insert_1 failed" . pg_last_error());
			
			$query = "INSERT INTO lab8.user_info (username) VALUES ($1)";
			pg_prepare($conn, "add_info",$query);
			pg_execute($conn, "add_info",array($user));
			
			//insert new user into authentication
			//$insert = pg_query($conn, "INSERT INTO lab8.authentication VALUES ('$user', '$p_hash', '$salt')") or die ("Please try again.");
			
			$query = "INSERT INTO lab8.authentication (username, password_hash, salt) VALUES ($1, $2, $3)";
			pg_prepare($conn,"add_auth",$query);
			pg_execute($conn,"add_auth",array($user,$p_hash,$salt));
			
			//insert registration into the log
			//$insert_3 = pg_query($conn, "INSERT INTO lab8.log VALUES (DEFAULT, '$user', '$ip', DEFAULT, 'registered')") or die (pg_last_error());
			$log = 'registered';
			$query = "INSERT INTO lab8.log (username, ip_address,action) VALUES ($1, $2, $3)";
			pg_prepare($conn,"store_reg",$query);
			pg_execute($conn,"store_reg",array($user,$ip,$log));
			
			//start up the session based on the new user
			session_start();
			$_SESSION['username'] = $user;
			
			header("Location: https://babbage.cs.missouri.edu/~zdc9pd/cs3380/lab8/home.php");
		}
	?>
</body>


</html>



