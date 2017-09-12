<?php
	require "functions.php";
	$conn = connectDB();
	$result = Find_IDs($conn);
	$ID_list = array();
	while ($row = $result->fetch_array()) {
		$ID_list[] = $row;
	}
	echo json_encode($ID_list);

?>