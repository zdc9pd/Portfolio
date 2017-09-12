<?php
//connect to the DB
	$DBconn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=zdc9pd user=zdc9pd password=K4wzrUi5") or die('Error, could not connect: '.pg_last_error() . "\n"); 
	
	$table = $_POST ['table'];
//Query preparation
	switch($table) {
		//Ran out of time to get my results to print to this, there is an error somewhere and i cannot find it
		case "country":  //Get results for the country, grab the row/ array and print the results out
			$p_key = $_POST['primary_key'];
			echo $p_key;
			$query = 'SELECT * FROM lab4.country WHERE (country_code = ' .$p_key . ')';
			$result = pg_prepare($DBconn, "country_search", $query);
			
			$result = pg_execute($DBconn, "country_search", array());
			//grab the rows
			$row = pg_fetch_row($result);
			//prepare to print the table
			echo"<table border = 1>\n";
			?>
			<form method = "POST" action ="edit.php">
				<tr>
					<td>country_code</td>
					<td><?php echo $row['country_code']?></td>
				</tr>
				<tr>
					<td>name</td>
					<td><?php echo $row['name']?></td>
				</tr>
				<tr>
					<td>continent</td>
					<td><?php echo $row['continent']?></td>
				</tr>
				<tr>
					<td>region</td>
					<td><?php echo $row['region']?></td>
				</tr>
				<tr>
					<td>surface_area</td>
					<td><?php echo $row['surface_area']?></td>
				</tr>
				<tr>
					<td>indep_year</td>
					<td><?php echo $row['indep_year']?></td>
				</tr>
				<tr>
					<td><strong>population</strong></td>
					<td><input type="text" name="population" value="<?php echo $row['population']?>" ></td>
				</tr>
				<tr>
					<td><strong>life_expectancy</strong></td>
					<td><input type="text" name="life_expectancy" value="<?php echo $row['life_expectancy']?>"></td>
				</tr>
				<tr>
					<td><strong>gnp</strong></td>
					<td><input type="text" name="gnp" value="<?php echo $row['gnp']?>"></td>
				</tr>
				<tr>
					<td>gnp_old</td>
					<td><?php echo $row['gnp_old']?></td>
				</tr>
				<tr>
					<td>local_name</td>
					<td><?php echo $row['local_name']?></td>
				</tr>
				<tr>
					<td>government_form</td>
					<td><?php echo $row['government_form']?></td>
				</tr>
				<tr>
					<td><strong>head_of_state</strong></td>
					<td><input type="text" name="head_of_state" value="<?php echo $row['head_of_state']?>"></td>
				</tr>
				<tr>
					<td>capital</td>
					<td><?php echo $row['capital']?></td
				></tr>
				<tr>
					<td>code2</td>
					<td><?php echo $row['code2']?></td>
				</tr>
				<input type = "hidden" name = "primary_key" value ="<?php echo $p_key?>">
				</table><br />			
				<input type = "hidden" name ="table" value ="<?php echo $table?>">
				<input type = "submit"  value = "Save">
			</form>
			<?php
			break;
		case "city":
			$p_key = $_POST['primary_key'];
			$result = pg_prepare($DBconn, "city_search", 'SELECT id, name, country_code, district, population FROM lab4.city WHERE (id=$1)');
			$result = pg_execute($DBconn, "city_search", array($p_key));
			$row = pg_fetch_array($result, null, PGSQL_ASSOC);
			
			echo"<table border = 1>\n";
			?>
			<form method = "POST" action = "edit.php">
				<tr>
					<td>id</td>
					<td><?php echo $row['id']?></td>
				</tr>
				<tr>
					<td>name</td>
					<td><?php echo $row['name']?></td>
				</tr>
				<tr>
					<td>country_code</td>
					<td><?php echo $row['country_code']?></td>
				</tr>
				<tr>
					<td>district</td>
					<td><?php echo $row['district']?></td>
				</tr>
				<tr>
					<td><strong>population</strong></td>
					<td><input type="text" name="population" value="<?php echo $row['population']?>" ></td>
				</tr>
				<input type = "hidden" name = "primary_key" value = "<?php echo $p_key?>">
				</table><br />
				<input type = "hidden" name ="table" value ="<?php echo $table?>">
				<input type = "submit"  value = "Save">
			</form>
			<?php
			break;
		case "language":
			$code = $_POST['pk1'];
			$language = $_POST['pk2'];
			$result = pg_prepare($DBconn, "language_search", 'SELECT country_code,language,is_official, percentage FROM lab4.country_language WHERE (country_code = $1) AND (language = $2)');
			$result = pg_execute($DBconn, "language_search", array($code, $language));
			$row = pg_fetch_array($result, null, PGSQL_ASSOC);
			
			echo"<table border = 1>\n";
			?>
			<form method = "POST" action = "edit.php">
				<tr>
					<td>country_code</td>
					<td><?php echo $row['country_code']?></td>
				</tr>
				<tr>
					<td>language</td>
					<td><?php echo $row['language']?></td>
				</tr>
				<tr>
					<td><strong>is_official</strong></td>
					<td><input type="text" name="is_official" value="<?php echo $row['is_official']?>" ></td>
				</tr>
				<tr>
					<td><strong>percentage</strong></td>
					<td><input type="text" name="percentage" value="<?php echo $row['percentage']?>"></td>
				</tr>
				<input type = "hidden" name = "pk1" value = "<?php echo $code?>">
				<input type = "hidden" name = "pk2" value = "<?php echo $language?>">
				
				</table><br />
				
				<input type = "hidden" name ="table" value ="<?php echo $table?>">
				<input type = "submit"  value = "Save">
			</form>
			<?php
			break;
		default:
			echo "\t\t\t Please try again.\n";
			exit();
			break;
	}
	
	?>
	<!--Cancel form to return to the index -->
	<form method = "POST" action = "index.php">
		<input type = "submit" name = "cancel" value = "Cancel">
	</form>

	<?php			
	pg_free_result($result);
	pg_close($DBconn);									   
?> 