<?php
	include "functions.php";
	$resultArray = array();
	$file_path=$_POST['file_path'];
	$temp = -2;
	$first = TRUE;
	$start = TRUE;
	$orig;

	if (($handle = fopen ( $file_path, "r" )) !== FALSE) {
		while ( ($data = fgetcsv ( $handle, 30, "\t" )) !== FALSE ) {
			if($first){
				$orig = round($data[1]);
				$first = FALSE;
			}
			$newRecord = array (
					(round($data [1]) - $orig),
					$data [2] 
			);
			if($newRecord[0] != $temp && $newRecord[1] == 1 && $start){
				array_push ( $resultArray, $newRecord[0] );
				$start = FALSE;
			}
			elseif ($newRecord[1] == 0){
				$start = TRUE;
			}
			$temp = $newRecord[0];
		}
		fclose ( $file );
	}
	else {
		print_r("no file".$file_path);
	}
	fclose ( $handle );	

	print_r(json_encode($resultArray));
	

?>