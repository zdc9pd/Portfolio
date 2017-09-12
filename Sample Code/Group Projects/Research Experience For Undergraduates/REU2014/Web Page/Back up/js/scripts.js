// This function plays or pause the video player
function PlayVid() {
	//var x = document.getElementById("example_video_1");
	if (x.paused) {
		x.play();
	}
	else {
		x.pause();
	}
}

// Function that will skip to the next video in the list
function NextVid() {
	//console.log(i);
	if( i >= videolist.length - 1) {
		i = 0;
	}
	else {
		i++;
	}
	x.src = videolist[i];  // set the source to the current index of global array videolist
	CheckBW();				// check the bandwdith again
	DisplayTitle();			// update the title and ID
	DisplayID();
	UpdateDL();				//update the DL <a> tag
	getMarkerArray();		// update the marker array
	return;
}

//same as nextvid, except for the previous vid
function LastVid() {
	
	if (i <= 0) {
		i = videolist.length - 1;
	}
	else {
		i--;
	}
	x.src = videolist[i];
	CheckBW();
	DisplayTitle();
	DisplayID();
	UpdateDL();
	getMarkerArray();
	return;
}

//function to skip to movement locations based on the getMarkerArray()
function SkipVid() {
		
	if( j >= Markers.length) {
		j = 0;
		x.currentTime = Markers[j];
		return;
	}
	else {
		x.currentTime = Markers[j];
		j++;
		return;
	}

	
}

//display the video title, do this by calling ParseTitle
function DisplayTitle() {
	var ele = document.getElementById("vidTitle");
	var source = ParseTitle(x.src);
	ele.innerHTML = source;
	DisplayID();
	return;
}

//update the ID, do this by calling ParseID
function DisplayID() {
	var ele = document.getElementById("IDtitle");
	var source = ParseID(x.src);
	ele.innerHTML = source;
	return;
}

//Slice the video list into the 4 digit user ID and return it to the calling function
function ParseID(str) {
	str = str.replace("http://reu.eldertech.missouri.edu/rewind/videos/","");
	str = str.slice(0,4);
	return str;
}

//Parse the title into the approriate length, then return it
function ParseTitle(str) {
	str = str.replace("http://reu.eldertech.missouri.edu/rewind/videos/","");
	str = str.replace(".mp4","");
	str = str.slice(5);
	str = str.slice(8);
	str = str.slice(0,10);
	return str;
}

//Function to round the BW and display it. The function also automatically selects the video quality
function DisplayBW(speed) {
	speed = (Math.round(speed * 100)/100);
	//var display = document.getElementById("Speed_Display");
	//display.innerHTML = speed + " Mbps";
	if(speed <= "1.5") {
		document.getElementById("LowQ").checked = true;
	}
	else {
		document.getElementById("HighQ").checked=true;
	}
}

//update the <a> tag
function UpdateDL() {
	console.log(x.src);
	document.getElementById("Download").href = x.src;
}

// AJAX call to search the DB for the videos based on user input
function search_videos() {
	var selected_speed =$('input[name="speed"]:checked').val();	
	var to_date = $('#Date_To').val();
	var from_date = $('#Date_From').val();
	var search_ID = document.getElementById("ID_select").value;				
	
	console.log(to_date);
	console.log(from_date);
	console.log(search_ID);

	$.ajax ({
		type: "GET",
		url: "Search_Videos.php",
		data : {
			quality: selected_speed,
			From: from_date,
			To: to_date,
			ID: search_ID,
		},
		async: false,
		success: function(data) {
			//console.log(data);
			obj = JSON.parse(data);
			//need to clear the previous vid list and text list;
			
			clear_array(videolist);
			clear_array(TextList);
			
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
			Update_src();
			getMarkerArray();
		},
		
		error: function (request, status, error) {
			console.log(request);
			console.log(status);
			console.log(error);
		}
	});
	
};

// Function to check the bandwidth.
function CheckBW() {
	// record start time
	var startTime = new Date();
	//size of sample file
	var FILE_SIZE = 185 * 8; //for KB -> Kb 
	$.ajax ({
			type: "GET",
			url: "http://reu.eldertech.missouri.edu/rewind/videos/3004_KDSmall-08_14_2013-09_17_33_151_16k.mp4",
			async: false,
			success: function() {
				// record end time
				var endTime = new Date();
				// time difference in ms
				var timeDiff = endTime - startTime;
				var totalTime = timeDiff / 1000; //convert to seconds	
				var Kbps = FILE_SIZE / totalTime;
				var Mbps = Kbps / 1024; 
				//console.log(Mbps);	
				DisplayBW(Mbps);
			},
			
			error: function (request, status, error) {
				console.log(request);
				console.log(status);
				console.log(error);
			}
		});
}

// Ajax call that gets executed on load to load the ID menu
function Load_menu() {
	$.ajax ({
		type: "GET",
		url: "Populate_Menu.php",
		async: false,
		success: function(data) {
			obj = JSON.parse(data);
			//console.log(obj.length);
			$("#ID_select option").remove();
			for(k = 0; k < obj.length; k++) {
				$("#ID_select").append(
					$("<option></option>").text(obj[k].UserID)					
				);
			};			
		},
		error: function (request, status, error) {
			console.log(request);
			console.log(status);
			console.log(error);
		}
	});
};

//clear out the old array in order to allow the new array to be loaded correctly
// This is done so we can dynamically switch video quality without loosing the current video index
// as well as to over right a longer array with a shorter one
function clear_array(A) {
	//console.log(A);
	while(A.length > 0) {
		A.pop();
	}
	//console.log(A);
}

// Updates the video players source
function Update_src() {
	if (i >= videolist.length - 1) {
		i = 0;
	}
	x.src = videolist[i];
	UpdateDL();
	DisplayTitle();
	DisplayID();
}



