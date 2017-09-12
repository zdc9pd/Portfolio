<?php 
	//Need to include functions
	require 'functions.php';
	//Set the qualtiy to High or Low based on radio button input
	$quality = $_GET['quality'];	
	$start_date = $_GET['From'];
	$end_date = $_GET['To'];
	$User_ID = $_GET['ID'];
	// VideoDateTimeString
	//Start the DB connection
	$connection = connectDB();
	if($connection) { 
		if($start_date == NULL || $end_date == NULL) {
			$result = mysqli_query($connection,"SELECT * FROM reukinectvideos
			WHERE UserID= '". $User_ID ."'");
		}
		else {
			$result = mysqli_query($connection,"SELECT * FROM reukinectvideos WHERE UserID= '". $User_ID ."' AND VideoDateTimeString BETWEEN '".$start_date ."' AND '" .$end_date ."'");
		}
		$URLs = array();
		$txt = array();
		while ($row = $result->fetch_array()) {
			$txtURLs = ParseText($row);
			$vidURLs = ParseVideo($row, $quality);
		//	array_push($URLs,$vidURLs);
		//	array_push($txt,$txtURLs);
			$URLs[]= $vidURLs;
			$URLs[]= $txtURLs;
		}
		echo json_encode($URLs, JSON_UNESCAPED_SLASHES);
	}
?>