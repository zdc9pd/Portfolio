<?php
session_start();
$html = '<!DOCTYPE html>
<html>
<head>
	<title>'.$title.'</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/Layout.css">
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

	<script>
		$(function() {
			$( "#dialog" ).dialog();
		});
	</script>

</head>
<body>
	<div id="wrapper">
		<div id="title">
			<h1>Motorcycles are cool!</h1>
		</div>
		
		<div id="mini_wrapper">
			
			<div id="header"> 
				';
	if($_SESSION['user'] == 'test') {
		$html .='
				<ul id="tabs">
				  <li><a href="cbr.php">CBR600F4I</a></li>
				  <li><a href="shadow.php">Shadow 1100</a></li>
 				  <li><a href="ruckus.php">Ruckus NPS50</a></li>
				  <li><a href="logout.php">LOG OUT</a></li>
				 </ul>
			';
				
	}
	else {
		$html .='	<div class="tabs">
						<a href="login.php">Login</a>
					</div>
					<div id="dialog" title="Login Notification">
						<p class="text_p">Please login. User:test  Password: pass</p>
					</div>';
		}
	$html .='	
			</div>';
echo $html;

?>
