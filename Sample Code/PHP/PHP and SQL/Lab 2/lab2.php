<!DOCTYPE html>
<html>
<head>
<meta charset=UTF-8>
<title>CS 3380 Lab 2</title>
</head>
<body>
<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
<select name="query">
	<option value="1" >Query 1</option>
	<option value="2" >Query 2</option>
	<option value="3" >Query 3</option>
	<option value="4" >Query 4</option>
	<option value="5" >Query 5</option>
	<option value="6" >Query 6</option>
	<option value="7" >Query 7</option>
	<option value="8" >Query 8</option>
	<option value="9" >Query 9</option>
	<option value="10" >Query 10</option>
	<option value="11" >Query 11</option>
	<option value="12" >Query 12</option>
</select>
<input type="submit" name="submit" value="Execute" />
</form>
<br />
<hr />
<strong>Select a query from the above list</strong>
<br />
<br />
<!-- PHP for queries -->
<?php 
	$query = $_POST["query"];  //get our input
	$DBconn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=zdc9pd user=zdc9pd password=K4wzrUi5"); //create our connection to the DB
	if (!$DBconn) {
		echo "Error.\n" . pg_last_error() . "\n";
		die; // kill the app if no connection
	}
	
	//Create a  switch for the case which will ID which query to run, fill a variable with the proper select statement, and then call a query function (which prints any results)
	switch($query) {
		case "1":
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT district, population 
			FROM lab2.city 
			WHERE name = 'Springfield' 
			ORDER BY population DESC;";
			query_table($DBconn,$query); // call our query function
			break;
		case "2":
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT name, district, population
			FROM lab2.city
			WHERE country_code = 'BRA'
			ORDER BY name ASC;";
			query_table($DBconn,$query);
			break;
		case "3":
			//echo "Query #: " . $query . "<br />";
			$query = "
			select name, continent, surface_area
			from lab2.country
			order by surface_area ASC
			limit 20;";
			query_table($DBconn,$query);
			break;
		case "4":
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT name, continent, government_form, gnp
			FROM lab2.country
			WHERE gnp > 200000
			ORDER BY name ASC;";
			query_table($DBconn,$query);
			break;
		case "5":
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT name, life_expectancy
			FROM lab2.country
			WHERE life_expectancy IS NOT NULL
			ORDER BY life_expectancy DESC
			LIMIT 10
			OFFSET 10;";
			query_table($DBconn,$query);
			break;
		case "6":
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT name
			FROM lab2.city
			WHERE name LIKE 'B%' and name LIKE '%s'
			ORDER BY population DESC;";
			query_table($DBconn,$query);
			break;
		case "7":
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT DISTINCT city.name AS city_name, country.name, city.population
			FROM lab2.city
			INNER JOIN lab2.country
			ON city.country_code = country.country_code
			WHERE city.population > 6000000
			ORDER BY city.population DESC;";
			query_table($DBconn,$query);
			break;
		case "8":
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT name, language.language, language.percentage 
			FROM lab2.country AS city 
			INNER JOIN lab2.country_language AS language 
			ON city.country_code = language.country_code 
			WHERE is_official = 'FALSE' AND city.population > 50000000 
			ORDER BY language.percentage DESC;";
			query_table($DBconn,$query);
			break;
		case "9":
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT country.name, country.indep_year, country.region
			FROM lab2.country
			INNER JOIN lab2.country_language ON country.country_code = country_language.country_code
			WHERE country_language.language = 'English'
			AND country_language.is_official = 'TRUE'
			ORDER BY country.region ASC, country.name ASC;";
			query_table($DBconn,$query);
			break;
		case "10":
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT city.name AS capital_name, country.name, FLOOR((cast(city.population AS Float)/cast(country.population AS Float)) *100) AS percentage
			FROM lab2.country
			INNER JOIN lab2.city
			ON country.capital = city.id
			ORDER BY percentage DESC;";
			query_table($DBconn,$query);
			break;
		case "11":
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT country.name,country_language.language AS language, FLOOR(((cast(country_language.percentage AS Float)) * (cast(country.population AS Float)))/100)as speakers
			FROM lab2.country
			INNER JOIN lab2.country_language
			ON country.country_code = country_language.country_code
			WHERE country_language.is_official = 'TRUE'
			ORDER BY speakers DESC;";
			query_table($DBconn,$query);
			break;
		case "12":
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT country.name, country.region, country.gnp, country.gnp_old,
			(((country.gnp)-(country.gnp_old))/(country.gnp_old)) AS real_change
			FROM lab2.country
			WHERE country.gnp IS NOT NULL AND country.gnp_old IS NOT NULL
			ORDER BY real_change DESC;";
			query_table($DBconn,$query);
			break;
	}
	//----------------------------------------------------------------------------------------------
	// Query our tables for results
	function query_table($DBconn,$q) {
		$result = pg_query($DBconn,$q);  //format the query for pg
		//echo $q . "<br />";
		if(!$result) { //if we have no results, tell them
			echo "NO RESULTS!<br />";
		}
		else {  //query successful
			$x = pg_numrows($result);
			echo "The Query returned " . $x . " Rows <br /> <br />";
			//echo "Success! <br />";
			print_table($result); //call print table to print results
		}
	}
	
	//-------------------------------------------------------------------------------------------
	//Print out the table for our results
	function print_table($result) {
		echo "<table border = '1'>";
		
		$row = pg_fetch_assoc($result); //fill the first row
        echo "\t<tr>\n"; //open first table row
        foreach ($row as $key => $value) {
            echo "\t\t<th>$key</th>\n";
        }
        echo "\t</tr>\n"; //close first table row
        echo "\t<tr>\n"; //open next row
        foreach ($row as $value) { //fill row with td 
                echo "\t\t<td>$value</td>\n";
        }
        echo "\t</tr>\n"; //close row
        //Print out whats left
        while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                echo "\t<tr>\n"; // start another table row
                foreach ($line as $col_value) {
					echo "\t\t<td>$col_value</td>\n";
                }
                echo "\t</tr>\n"; //close last table row
        }
        echo "</table>\n";
        //END PRINT TABLE SECTION//
	}
?>
</body>


</html>


<!-- K4wzrUi5
 -->