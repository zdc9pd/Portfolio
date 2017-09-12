<?php
/*
	session_start();
	$DB_USERNAME = "kinectrewindmgr";
	$DB_PASSWORD = "8ke8SyAJ5ebW";
	$DB_HOSTNAME = "robby.cirl.missouri.edu";
	$DB_DBNAME = "smartamerica";
	$link = mysqli_connect($GLOBALS['DB_HOSTNAME'], $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_DBNAME']);
	include 'bandwidth.php';
	$speed = $_SESSION['speed'];
	*/
	if($link) { 
		$result = mysqli_query($link,"SELECT * FROM reukinectvideos");
		/*
		while ($row = $result->fetch_array()) {
			$VidPath = $row['VideoPath'];
			$VidPath = str_replace('.mp4', '', $VidPath) . '_8k.mp4';
			$url= 'http://reu.eldertech.missouri.edu/rewind' . $row['BaseVideoPath'] . $VidPath;
			echo $url;
			echo "<br />";
		}
		*/
		
		
		$vids = array();
		$movement = array();
		while ($row = $result->fetch_array()) {
			$VidPath = $row['VideoPath'];
			$text = $VidPath;
			$text = str_replace('.mp4', '.txt', $text);
			$text = str_replace('Small', '', $text);
			$VidPath = str_replace('.mp4', '', $VidPath) . '_128k.mp4';
			$url= 'http://reu.eldertech.missouri.edu/rewind' . $row['BaseVideoPath'] . $VidPath;
			$texturl = 'http://reu.eldertech.missouri.edu/rewind' . $row['BaseVideoPath'] . $text; 
			$movement[] = $texturl;
			$vids[] = $url;
			
		}
		$Vidtxt = json_encode($movement, JSON_UNESCAPED_SLASHES);
		$DBvid = json_encode($vids, JSON_UNESCAPED_SLASHES);
		echo $DBvid;
		//echo $Vidtxt;
	}
	else {
		echo "could not connect";
	}
?>


