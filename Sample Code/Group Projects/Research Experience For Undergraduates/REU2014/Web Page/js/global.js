// create counter variables for playback
var i = -1;
var j = 0;

//create an array for the videos
/*
var videolist = [
	"http://video-js.zencoder.com/oceans-clip.mp4" ,
	"http://clips.vorwaerts-gmbh.de/big_buck_bunny.mp4" ,
	"http://pdl.vimeocdn.com/89496/595/203684545.mp4?token2=1403640971_65e53a5e640f4cbea6602238e27748c3&aksessionid=3f582da4f519ea51"
];
*/

var videolist = [];
var TextList = [];


//create a variable to reference the player easier
var x = document.getElementById("example_video_1");

//create an array for the markers;
var Markers = [
	5,
	9,
	13,
	23
];
