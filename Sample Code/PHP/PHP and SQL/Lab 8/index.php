<!DOCTYPE HTML>
<html>
<head>
	<title>Lab8_Login</title>
	<!--ZDC9PD, 14151501, Zac Crane -->
</head>
<body>
	<form method = "POST" action = "<?= $_SERVER['PHP_SELF'] ?>">
		Please Login Below
		<br>
		Username:<input type = "text" name = "username">
		<br>
		Password:<input type = "password" name = "password">
		<br>
		<input type = "submit" name = "submit" value = "submit">
	</form>
	<br>
	<a href="registration.php">Click here to Register</a>

	<?php
		// Make sure we have a secure connection
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'|| $_SERVER['SERVER_PORT'] == 443) {
			$security = true;
		}
		if ($security != true)
		{
			header("Location: https://babbage.cs.missouri.edu/~zdc9pd/cs3380/lab8/registration.php");
		}
		session_start();
		if ($_SESSION['username'] <> NULL) {
		header ("Location: https://babbage.cs.missouri.edu/~zdc9pd/cs3380/lab8/home.php");
		}


		//connect to database
		$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=zdc9pd user=zdc9pd password=K4wzrUi5") or die('Error, could not connect: '.pg_last_error() . "\n");
		//runs when submit is pressed
		if (isset($_POST['submit'])) {

		//makes sure all fields are completed
		   if (!$_POST['username'] | !$_POST['password']) {
			  die('Please enter both a username and password.');
		   }

		//pass input to variables
		$user = htmlspecialchars($_POST['username']);
		$pass = htmlspecialchars($_POST['password']);

		//prepared statement for username auth
		$query = 'SELECT password_hash, salt FROM lab8.authentication WHERE (username = $1)';

		pg_prepare($conn, "authorization", $query) or die (pg_last_error());
		$result = pg_execute($conn, "authorization", array($user)) or die (pg_last_error());
		$row = pg_fetch_assoc($result) or die (pg_last_error());

		$x = str_replace(' ','', ($row['salt'] . $pass));
		$local_hash = sha1($x);

		if ($local_hash == $row['password_hash']) {
			$ip = $_SERVER['REMOTE_ADDR'];
			$log = 'logged in';
			
			$query = "INSERT INTO lab8.log (username, ip_address,action) VALUES ($1, $2, $3)";
			pg_prepare($conn,"log_login",$query);
			pg_execute($conn,"log_login",array($user,$ip,$log));
		
			$_SESSION['username'] = $user;
			header("Location: https://babbage.cs.missouri.edu/~zdc9pd/cs3380/lab8/home.php");
		}
		else
		{
		   echo "Authentication failed. Please try again.";
		}

		}

	?>
</body>
</html>
