
<!DOCTYPE html>
<html>
<head>
<meta charset=UTF-8>
<title>CS 3380 Lab 4</title>
<script>
function clickAction(form, pk, tbl, action)
{
  document.forms[form].elements['pk'].value = pk;
  document.forms[form].elements['action'].value = action;
  document.forms[form].elements['tbl'].value = tbl;
  document.getElementById(form).submit();
}
</script>
</head>
<body>

<form method="POST" action="/~zdc9pd/cs3380/lab4/index.php">
    Search for a :
    <input type="radio" name="search_by" checked="true" value="country"  />Country 
    <input type="radio" name="search_by" value="city"  />City
    <input type="radio" name="search_by" value="language"  />Language <br /><br />
    That begins with: <input type="text" name="query_string" value="" /> <br /><br />
    <input type="submit" name="submit" value="Submit" />
</form>
<hr />
Or insert a new city by clicking this <a href="lab4_insert.php">link</a>

<?PHP
	//ID the first letter
	$first_char = htmlspecialchars($_POST['query_string']);
	$first_char .= "%";
	//Figure out what table to search
	$table_query = $_POST['search_by'];
	
	//connect to the DB
	$DBconn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=zdc9pd user=zdc9pd password=K4wzrUi5") or die('Error, could not connect: '.pg_last_error() . "\n"); 
	
	if(isset($_POST['submit'])) {
		switch($table_query) {
			case "country":
				$statement = pg_prepare($DBconn, "country_search", 'SELECT country_code, name, continent, region, surface_area, indep_year, population, life_expectancy,gnp,gnp_old,local_name, government_form,head_of_state,capital,code2 FROM lab4.country WHERE (name ILIKE $1) ORDER BY name ASC'); 
				$result = pg_execute($DBconn, "country_search", array($first_char));
				break;
			case "city":
				$result = pg_prepare($DBconn, "city_search", 'SELECT id, name, country_code, district, population FROM lab4.city WHERE (name ILIKE $1) ORDER BY name ASC');
				$result = pg_execute($DBconn, "city_search", array($first_char));
				break;
			case "language":
				$result = pg_prepare($DBconn, "language_search", 'SELECT country_code,language,is_official, percentage FROM lab4.country_language WHERE (language ILIKE $1) ORDER BY language ASC');
				$result = pg_execute($DBconn, "language_search", array($first_char));
				break;
			default:
				echo "\t\t\tPlease select a radio button and try again.\n";
				exit();
				break;
		}
		
		$x = pg_numrows($result);
		if(!$result) { 
			echo "<br /> NO RESULTS!<br />";
		}
		else {  //query successful
			echo "<br />The Query returned " . $x . " Rows <br /> <br />";
			//echo "Success! <br />";
		}
		
		// Begin Printing section for the table
		// Grab the number of fields in order to print out the table head
		$max_fields = pg_num_fields($result);
		//echo $result . "<br />";
		echo "\t<table border = 1>\n";
		echo "\t<tr><th>Actions</th>\n"; //open first TR
		// cycle through all the TH fields
		for ($i = 0; $i < $max_fields; $i++) {
				$head_name = pg_field_name($result, $i); //grab the next head name
				echo "\t\t<th>$head_name</th>\n"; // print out the name to the TH
			}
		echo "\t</tr>\n"; // close TH TR
		
        while($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
            echo "\t<tr>\n"; //open next TR
			echo"\t\t\t<td>\n";
			?>
			<form method = "POST" action = "lab4_edit.php"> <!--Open the edit form  -->
				<input type="submit" name = "action" value="Edit"/> 
				<!-- Insert the Form for EDIT-->
				<?php 
					if ($table_query == 'country') {
						?>
						<input type ="hidden" name ="primary_key" value ="<?php echo $line['country_code'] ?>">
						<?php
					}	
					else if($table_query == 'city') {		
						?>
						<input type = "hidden" name ="primary_key" value = "<?php echo $line['id']?>">
						<?php
					}
					else{
						?>
						<input type = "hidden" name = "pk1" value = "<?php echo $line['country_code']?>">
						<input type = "hidden" name = "pk2" value ="<?php echo $line['language']?>">
						<?php
					}
					?>
					<input type="hidden" name="table" value ="<?php echo $table_query?>">
			</form> <!--Close the edit form -->
			<!-- REMOVE button-->
			<form method = "POST" action = "lab4_delete.php">
				<?php //assign the Primary Keys to the hidden input for later use
				if ($table_query == 'country') {
					?>
					<input type ="hidden" name ="primary_key" value ="<?php echo $line['country_code'] ?>">
					<?php
				}
				else if($table_query == 'city') {
					?>
					<input type = "hidden" name ="primary_key" value = "<?php echo $line['id']?>">
					<?php
				}
				else{
					?>
					<input type = "hidden" name = "pk1" value = "<?php echo $line['country_code']?>">
					<input type = "hidden" name = "pk2" value ="<?php echo $line['language']?>">
					<?php
				}
				?>
				
				<input type ="hidden" name = "table" value = "<?php echo $table_query?>">
				<input type= "submit" value="Remove"/>
			</form> 
			<!-- -->
			<?php
				echo"\t\t\t</td>\n";
				foreach ($line as $col_value) {
					echo"\t\t<td>$col_value</td>\n";
				}
				echo "\t</tr>\n";
        }
		echo "</table>\n";
		pg_free_result($result);
		pg_close($DBconn);
	}
?>

</body>
</html>