<!doctype html>
<html>
<head>
	
	<link rel="stylesheet" type="text/css" href="css/layout.css">
	
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script>
    $( document ).ready(function() {
		//when the document loads, we want to populate the ID drop down menu and then check the bandwidth
		// checkBW is ran 2x to ensure accurate results (we are getting high Mbps when it is ran once)
		
		window.onload = Load_menu();
		window.onload = CheckBW();
		window.onload = CheckBW();
	});		

    $( window ).load(function() {
       // console.log( "window loaded" );
    });	
	</script>
	
	<!-- VJS  (link in for the video player)-->
	<link href="//vjs.zencdn.net/4.6/video-js.css" rel="stylesheet">
	<script src="//vjs.zencdn.net/4.6/video.js"></script>

<script>
	// Gary added this segment of code into the video player. It is getting the movement array loaded from the text file
	serviceURL = "/rewind/Video player/getMarkerArray.php";
	var chartData = [];
	var textArray = [];
	function getMarkerArray() {
		theChartURL = TextList[i];
		//console.log(theChartURL);
		$.ajax({
	        type: "POST",
	        url: serviceURL,
	        data:{
	        	file_path: theChartURL,
	        },		        
	        success: function(data) {
	        	//console.log("response: "+data);
	        	
	        	if(data){
		        	chartData = JSON.parse(data);
		        	Markers = chartData;
		        	console.log(chartData);
	        	}
	        	if(chartData==null){
		        	console.log("File not found or exception while reading: "+theChartURL);
		        }
	        },
	        error:function(){
	        	$.unblockUI;
	        }
	     });
	
		
	}
	</script>
	

</head>

<body>
	<div id="wrapper">
		<div id="left_wrapper">
			
			<div id="video_player">
				<video id="example_video_1" class="video-js vjs-default-skin"
					controls preload="auto" width="720" height="500"
					<source src="http://reu.eldertech.missouri.edu/rewind/videos/3004_KDSmall-08_14_2013-09_17_33_151_8k.mp4" type='video/mp4' />
					<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
				</video>
			</div>
			<div id="video_buttons">
				<button type="button" onclick="LastVid()" class="VidButton">Previous</button>
				<button type="button" onclick="PlayVid()" class ="VidButton">Play/Pause</button>
				<button type="button" onclick="NextVid()" class="VidButton">Next</button>
				<button type="button" onclick="SkipVid()">Skip to</button>
			</div>
		</div>
		<div id="right_wrapper">
			<div id="date_picker">
				<label for="Date_From" class="date_label">From:</label>
				<input class="datetimepicker" type="text" id="Date_From" >
				<br />
				<label for="Date_To" class="date_label"> To:</label>
				<input class="datetimepicker" type="text" id="Date_To" >
			</div>
			<div id="id_selector">
				<label for="ID_menu" class="id_label"> Select an ID:</label>
				<br />
				<select name="ID_menu" id="ID_select">
					<option>3004</option>
					<option>3012</option>
				</select>
			</div>
			<div id="vid_quality">
				<label for="speed">Select Quality</label>
				<br />
				<label for="LowQ" class="qual_label">Low: </label><input type="radio" id = "LowQ" name="speed" value= "16" onchange="search_videos()">
				<br />
				<label for="HighQ" class="qual_label">High: </label><input type="radio" id = "HighQ" name="speed" value= "128" checked = "checked" onchange="search_videos()">
				
			</div>
			<div id="video_search">
				<button id="LoadDB" onclick="search_videos()">FIND VIDEOS</button>
				
			</div>
			<div id="title_wrapper">
				<div id="video_title">
					<h5>Video Title:</h5>
					<p id="vidTitle"></p>
				</div>
				<div id="video_id">
					<h5>ID</h5>
					<p id="IDtitle"></p>
				</div>
			</div>
			<div id="download_vid">
				<!-- <h5>Bandwidth</h5>
				<p id="Speed_Display"></p>  -->
				<br />
				<br />
				<a href="" id="Download">Right click to Download</a>
			</div>
		
		</div>
	</div>
	
	
	
	<script type="text/javascript" src="js/global.js"></script>
	
	<script type="text/javascript" src="js/scripts.js"></script>
	
	
</body>

<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script src="http://vjs.zencdn.net/4.2/video.js"></script>
<link href="http://vjs.zencdn.net/4.2/video-js.css" rel="stylesheet">
<script src='source/videojs-markers-master/src/videojs.markers.js'></script>
<link href="source/videojs-markers-master/src/videojs.markers.css" rel="stylesheet">

<script>
	//default load set up for VJS markers
  var video = videojs('example_video_1');
  video.markers({
     setting: {
        markerTip:{
           default_text: "This is break"
        },
        breakOverlay:{
           display: false,
           display_time: 3,
           default_text: "This is a break overlay "
        }
     },
     //set break time
     marker_breaks:[9, 16, 23, 28, 36],
     marker_text:["1","2","3","4","5"]
  });

</script>

<link rel="stylesheet" type="text/css" href="datetimepicker-master/jquery.datetimepicker.css"/ >
<script src="datetimepicker-master/jquery.js"></script>
<script src="datetimepicker-master/jquery.datetimepicker.js"></script>

<script>
	//load the date time picker ui
	jQuery('.datetimepicker').datetimepicker();
	
</script>

</html>