<?php
	$title = 'Login';
	$fail=0;
	if(isset($_POST['username']) && $_POST['username'] != '' &&  isset($_POST['password']) && $_POST['password'] != '') {
		if($_POST['username'] == 'test' && $_POST['password'] == 'pass') {
			session_start();
			$_SESSION['user'] = 'test';
			header( 'Location: cbr.php' );
		}
		$fail=1;
	}
	
	include 'header.php';
	
?>

	<div id="login">
		<form method = "POST" action = "#">
			Admin Login Below
			<br>
			UserName:<input type = "text" name = "username">
			<br>
			Password:<input type = "password" name = "password">
			<br>
			<input type = "submit" name = "submit" value = "submit">
		</form>
	</div>
	
<?php
	if($fail == 1) {
		echo '
			<div id="login">
				<p>Incorrect Login Info, please try again</p>
			</div>
		';
	}


?>