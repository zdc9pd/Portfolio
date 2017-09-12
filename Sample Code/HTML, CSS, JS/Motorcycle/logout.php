<?php
	$title = 'Log out';
	session_start();
	$_SESSION['user'] == NULL;
	unset($_SESSION['user']);
	header( 'Location: index.php' );

?>