<?php 
	//Need to include functions
	require 'functions.php';
	//Set the qualtiy to High or Low based on radio button input
	$quality = $_GET['quality'];	
	
	//Start the DB connection
	$connection = connectDB();
	if($connection) { 
		$result = mysqli_query($connection,"SELECT * FROM reukinectvideos");
		
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
	//	$txt = json_encode($txt, JSON_UNESCAPED_SLASHES);
		
		/*$master = array(
			$URLs,
			$txt
		);
		//echo json_encode($master , JSON_FORCE_OBJECT | JSON_UNESCAPED_SLASHES);
		*/
	/*	print_r($URLs);
		print_r($txt);  */
		//print_r($master);
	}
	
?>


