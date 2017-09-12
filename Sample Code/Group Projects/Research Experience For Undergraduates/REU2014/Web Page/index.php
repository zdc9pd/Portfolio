<!doctype html>
<html>
<head>
	<?php
		session_start();
	?>
	<link rel="stylesheet" type="text/css" href="css/layout.css">
	
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script>
    $( document ).ready(function() {
        console.log( "document loaded" );
		$("#LoadDB").click(function() {
			//$("#DataBase").load("bandwidth.php");
			var selected_speed =$('input[name="speed"]:checked').val();			
			$.ajax ({
				type: "GET",
				url: "Get_Video.php",
				data : {
					quality: selected_speed
				},
				async: false,
				success: function(data) {
					obj = JSON.parse(data);
					console.log(obj.length);
					
					// Run through the object to create the video list (.mp4's are all even #'s)
					var h = 0 // use H as a counter to keep the video list array in order (otherwise it will skip count as K finds the right videos)
					for(k = 0; k < obj.length; k+=2) {
						videolist[h] = obj[k];
						//console.log(videolist[h]);
						h++;
					}
					
					// Run throught the object to create the Text List (.txt are all odd #'s)
					var h = 0;
					for (k = 1; k <obj.length; k+=2) {
						TextList[h] = obj[k];
						//console.log(TextList[h]);
						h++;
					}
					
				},
				
				error: function (request, status, error) {
					console.log(request);
					console.log(status);
					console.log(error);
				}
			});
		});
		
	});		

    $( window ).load(function() {
        console.log( "window loaded" );
    });	
	</script>

	
	
	<script>
	$( document ).ready(function() {
		function CheckBW() {
			// record start time
			var startTime = new Date();
			//size of sample file
			var FILE_SIZE = 185 * 8; //for KB -> Kb 
			$.ajax ({
					type: "GET",
					url: "http://reu.eldertech.missouri.edu/rewind/videos/3004_KD-08_14_2013-09_17_33_151.txt",
					async: false,
					success: function() {
						// record end time
						var endTime = new Date();
						// time difference in ms
						var timeDiff = endTime - startTime;
						var totalTime = timeDiff / 1000; //convert to seconds	
						var Kbps = FILE_SIZE / totalTime;
						var Mbps = Kbps / 1024; 
						console.log(Mbps);	
						DisplayBW(Mbps);
					},
					
					error: function (request, status, error) {
						console.log(request);
						console.log(status);
						console.log(error);
					}
				});
		}
		
		window.onload = CheckBW();
	});
	</script>
	
	<!-- VJS -->
	<link href="//vjs.zencdn.net/4.6/video-js.css" rel="stylesheet">
	<script src="//vjs.zencdn.net/4.6/video.js"></script>

	

</head>

<body>
	<div id="wrapper">
		<div id="left_wrapper">
			<div id="title_wrapper">
				<div id="video_title">
					<h5>Video Title:</h5>
					<p id="vidTitle">Low Quality Video</p>
				</div>
				<div id="video_id">
					<h5>ID</h5>
					<p id="IDtitle"></p>
				</div>
			</div>
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
			<div id="video_quality">
				<p>Select Quality</p>
				<input type="radio" id = "radio_0" name="speed" value= "16"><label for="1">Low    </label> <br />
				<input type="radio" id = "radio_1" name="speed" value= "128" checked = "checked"><label for="3">High   </label> <br />
			</div>

			<div id="videos">
				<button id="LoadDB">FIND VIDEOS</button>
				<p id="Speed_Display">Your connection speed will be displayed here:</p>
			</div>
			<div id="date_picker">
			
			</div>
			<div id="id_selector">
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
  // initialize video.js
  var video = videojs('example_video_1');
//console.log(video);
  //load the marker plugin
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
</html>