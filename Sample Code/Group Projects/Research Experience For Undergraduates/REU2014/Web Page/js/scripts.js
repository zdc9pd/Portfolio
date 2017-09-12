
function PlayVid() {
	//var x = document.getElementById("example_video_1");
	if (x.paused) {
		x.play();
		
	}
	else {
		x.pause();
		
	}
}

function NextVid() {

	if( i >= videolist.length - 1) {
		i = 0;
		x.src = videolist[i];
		DisplayTitle();
		UpdateDL();
		return;
	}
	else {
		i++;
		x.src = videolist[i];
		DisplayTitle();
		UpdateDL();
		return;
	}
}

function LastVid() {
	
	if (i <= 0) {
		i = videolist.length - 1;
		x.src = videolist[i];
		DisplayTitle();
		UpdateDL();
		return;
	}
	else {
		i--;
		x.src = videolist[i];
		DisplayTitle();
		UpdateDL();
		return;
	}
	
	
}

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

function DisplayTitle() {
	var ele = document.getElementById("vidTitle");
	var source = ParseTitle(x.src);
	ele.innerHTML = source;
	DisplayID();
	return;
}

function DisplayID() {
	var ele = document.getElementById("IDtitle");
	var source = ParseID(x.src);
	ele.innerHTML = source;
	return;
}

function ParseID(str) {
	str = str.replace("http://reu.eldertech.missouri.edu/rewind/videos/","");
	str = str.slice(0,4);
	return str;
}

function ParseTitle(str) {
	str = str.replace("http://reu.eldertech.missouri.edu/rewind/videos/","");
	str = str.replace(".mp4","");
	str = str.slice(5);
	return str;
}

function DisplayBW(speed) {
	var display = document.getElementById("Speed_Display");
	display.innerHTML = speed + " Mbps";
}

function UpdateDL() {
	console.log(x.src);
	document.getElementById("Download").href = x.src;
}