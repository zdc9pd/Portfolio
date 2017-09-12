<html>
<head/>
<body>
<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
  <table border="1">
     <tr><td>Number of Rows:</td><td><input type="text" name="rows" /></td></tr>
     <tr><td>Number of Columns:</td><td><select name="columns">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="4">4</option>
    <option value="8">8</option>
    <option value="16">16</option>

  </select>
</td></tr>
   <tr><td>Operation:</td><td><input type="radio" name="operation" value="multiplication" checked="yes">Multiplication</input><br/>
  <input type="radio" name="operation" value="addition">Addition</input>
  </td></tr>
  </tr><td colspan="2" align="center"><input type="submit" name="submit" value="Generate" /></td></tr>
</table>
</form>

<?php
	//Create var to access data from the form
	$rows = $_POST["rows"];
	$columns = $_POST["columns"];
	$operation = $_POST["operation"];
	
	// Create functions to do our operation
	function addition($a, $b) {
		return ($a + $b);
	}
	
	function multiplication($a, $b) {
		return ($a * $b);
	}
	
	
	//filter data
	if (is_numeric($rows) && $rows >= 0) {
		echo "The " . $rows . " x " . $columns . " " . $operation . " table. <br /> <br />";
		echo "<table border = '1'>";
		
		for($x=0; $x <= $rows; $x++) {
			echo "<tr>\n";
			echo "<td style='font-weight:bold', align='center'>" . $x . "</td>\n";
			for ($y=1; $y <= $columns; $y++) {
				if($x == 0) {
					echo "<td style='font-weight:bold', align='center'>" . $y . "</td>";
				}
				else {
					echo "<td align='center'>" . $operation($x,$y) . "</td>\n";
				}
			}
			echo "</tr>\n";
		}
		
		
		echo "</table>";
		
	}
	else {
		if ($rows < 0) {
			echo "Please enter a positive integer for number of rows.";
		}
		else {
			echo "Supply Valid Input \n";
		}
	}
	
	
?>
</body>
</html>
