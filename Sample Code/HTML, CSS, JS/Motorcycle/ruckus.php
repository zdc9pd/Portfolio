<?php
	$title = 'Ruckus';
	include 'security.php';
	include 'header.php';
?>


	<script src="ajax.js"></script>
	<script>
	count = 2;
	function updateInfo() {
		var xmlHttp = xmlHttpObjCreate();
		if (!xmlHttp) {
			alert("The browser doesn't support this action.");
			return;
		}
		
		xmlHttp.onreadystatechange=function() {
			if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
				elemObj = document.getElementById('image');
				elemObj.innerHTML = xmlHttp.responseText;
			  }
		}
		
		// Append GET data to identify which bike we want
		var reqURL = "updateRuckus.php?num=" + count;
		xmlHttp.open("GET", reqURL, true);
		xmlHttp.send();
		count++;
		if(count > 4){
			count = 1;
		}
	}

	</script>
			
			<div id="tab_menu">
				<div id="tab3">
					<h1>2007 Honda Ruckus</h1>
					<p class="text_p">This is my daily rider to and from campus! It may seem odd to take a scooter to and from campus but the benefits FAR outweigh the cons. For example, I do not have to register it, insure it, and I can park it at bicycle racks!</p>
					<br />
					<p class="text_p">Please use the button below to view photos of the Ruckus:</p>
					<br />
					<input type="button" value="Next Pic" onclick="updateInfo();">
				</div>
			</div>
			
			<div id="images"> 
				<div id="image">
					<img src="images/ruckus1.jpg" alt="No more pics" id="pic">
				</div>
			</div>
		</div>

	</div>
</body>
</html>