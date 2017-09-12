<!DOCTYPE html>
<!--
	Zac Crane
	14151501
 -->

<html>
<head>
<meta charset=UTF-8>
<title>CS 3380 Lab 6</title>
</head>
<body>
<form method="POST" action="/~zdc9pd/cs3380/lab6/lab6.php">
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
</select>
<input type="submit" name="submit" value="Execute" />
</form>

<br />
<hr />
<br />

<strong>Select a query from the above list</strong>
<br />

<?php 
	$query = $_POST["query"];  //get our input
	$DBconn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=zdc9pd user=zdc9pd password=K4wzrUi5"); //create our connection to the DB
	if (!$DBconn) {
		echo "Error.\n" . pg_last_error() . "\n";
		die; // kill the app if no connection
	}
	
	//Create a  switch for the case which will ID which query to run, fill a variable with the proper select statement, and then call a query function (which prints any results)
	switch($query) {
		case 1:
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT MIN(surface_area),MAX(surface_area), AVG(surface_area)
			FROM lab6.country;
			";
			query_table($DBconn,$query); // call our query function
			break;
		case 2:
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT region, SUM(population)AS toal_pop, SUM(surface_area) AS total_area, SUM(gnp)AS total_GNP 
			FROM lab6.country 
			GROUP BY region 
			ORDER BY SUM(gnp) DESC;
			";
			query_table($DBconn,$query);
			break;
		case 3:
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT government_form, COUNT(government_form), MAX(indep_year)as most_recent_indep_year 
			FROM lab6.country 
			WHERE indep_year IS NOT NULL 
			GROUP BY government_form 
			ORDER BY COUNT(government_form) DESC, most_recent_indep_year DESC;
			";
			query_table($DBconn,$query);
			break;
		case 4:
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT country.name, COUNT(city.name) 
			FROM lab6.country 
			INNER JOIN lab6.city 
			ON (country.country_code = city.country_code) 
			GROUP BY country.name 
			HAVING COUNT(city.name) > 100 
			ORDER BY COUNT(city.name) ASC;
			";
			query_table($DBconn,$query);
			break;
		case 5:
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT country.name, country.population AS country_pop, SUM(city.population) AS urban_pop, ROUND(((SUM(city.population)*100.0)/country.population),14) AS urban_pct 
			FROM lab6.country 
			INNER JOIN lab6.city 
			ON (country.country_code = city.country_code) 
			GROUP BY country.name,country.population 
			ORDER BY urban_pct ASC;
			";
			query_table($DBconn,$query);
			break;
		case 6:
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT country.name AS Country, city.name AS Largest_city, sub_query.max_population 
			FROM lab6.country 
			INNER JOIN lab6.city
			USING (country_code)
			INNER JOIN
			(SELECT country_code, MAX(city.population) AS max_population
			FROM lab6.city
			GROUP BY country_code
			) AS sub_query
			USING (country_code)
			WHERE (city.population = sub_query.max_population)
			ORDER BY sub_query.max_population DESC;
			";
			query_table($DBconn,$query);
			break;
		case 7:
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT country.name, COUNT(*) AS city_count 
			FROM lab6.country 
			INNER JOIN lab6.city
			ON (country.country_code = city.country_code)
			GROUP BY country.name
			ORDER BY city_count DESC,country.name ASC;
			";
			query_table($DBconn,$query);
			break;
		case 8:
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT country.name AS Name, city.name AS Capital, COUNT(lang.language) AS lang_count 
			FROM lab6.country 
			INNER JOIN lab6.country_language AS lang 
			USING (country_code) 
			INNER JOIN lab6.city
			ON (city.country_code = country.country_code) AND (city.id = country.capital) 
			GROUP BY country.name, city.name HAVING COUNT(lang.language) BETWEEN 8 AND 12 
			ORDER BY COUNT(lang.language) DESC, city.name DESC;
			";
			query_table($DBconn,$query);
			break;
		case 9:
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT country.name AS country, city.name AS city, city.population AS population, SUM(city.population) 
			OVER 
			(PARTITION BY country.name 
			ORDER BY SUM(city.population) DESC) AS running_total 
			FROM lab6.country 
			INNER JOIN lab6.city 
			USING (country_code) 
			GROUP BY country.name, city.name, city.population 
			ORDER BY country.name ASC, city.population DESC;
			";
			query_table($DBconn,$query);
			break;
		case 10:
			//echo "Query #: " . $query . "<br />";
			$query = "
			SELECT country.name, lang.language, RANK() 
			OVER 
			(PARTITION BY lang.country_code 
			ORDER BY lang.percentage DESC) AS popularity_rank 
			FROM lab6.country 
			INNER JOIN lab6.country_language AS lang 
			USING (country_code) 
			ORDER BY country.name ASC, (lang.percentage) DESC;
			";
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
