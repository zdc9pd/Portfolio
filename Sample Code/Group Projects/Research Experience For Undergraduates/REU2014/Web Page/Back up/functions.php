<?php
	// Function to connect to the DB
	function connectDB() {
		$DB_USERNAME = "";
		$DB_PASSWORD = "";
		$DB_HOSTNAME = "";
		$DB_DBNAME = "";
		return $link = mysqli_connect($DB_HOSTNAME, $DB_USERNAME, $DB_PASSWORD, $DB_DBNAME);
	}
	//Function to query the DB
	function QueryDB($link, $search) {
		if ($search == "") {
			$search = '*';
			mysqli_query($link,"SELECT" . $search . "FROM reukinectvideos");
			return;
		}
		else {
			//mysqli_query($link,"SELECT" . $search . "FROM reukinectvideos");
		}
	}
	//function to parse the video into a URL
	function ParseVideo($row, $quality) {
		$VidPath = $row['VideoPath'];
		$VidPath = str_replace('.mp4', '', $VidPath) . '_' . $quality.'k.mp4';							//parse the info into the URL for the video
		return $url = '' . $row['BaseVideoPath'] . $VidPath;	//create a woring URL for the text file
	}
	//function to parse the text file into a URL
	function ParseText($row) {
		/*
		$text = $row['VideoPath'];
		$text = str_replace('.mp4', '.txt', $text);     //replace the mp4 with .txt
		$text = str_replace('Small', '', $text);		//parse out the small from the video path name
		return $url = 'http://reu.eldertech.missouri.edu/rewind' . $row['BaseVideoPath'] . $text; //create a working URL for the text file
		*/
		$text = $row['VideoPath'];
		$text = str_replace('.mp4', '.txt', $text);     //replace the mp4 with .txt
		$text = str_replace('Small', '', $text);		//parse out the small from the video path name
		return $url = '..' . $row['BaseVideoPath'] . $text; //create a working URL for the text file
	}


	//function to find each user ID on the table (in order to populate the select menu)
	function Find_IDs($link) {
		return $results = mysqli_query($link, "SELECT DISTINCT UserID FROM reukinectvideos");

	}

?>
