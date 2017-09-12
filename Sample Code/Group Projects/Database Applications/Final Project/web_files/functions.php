<?php
	include "../secure/database.php";


	function db_connect() {
		//Connect to Database using credentials
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD);
		return $conn
	}

	function delete_from_cart() {
	
	}
	
	function add_to_cart() {
	
	}
	
	function query_cart() {
	
	}
	//This function will query for pizza sizes
	function query_sizes() {
		$conn = db_connect;
		
		$query = "SELECT crust_size, size_price, topping_price FROM size_pizza";
		return $result = pg_query($conn,$query); // no user input, so pg_query is used
	}
	
	//This function will query the DB to request a list of toppings (18 total)
	function query_toppings() {
		$conn = db_connect;
		
		$query = "SELECT toppings FROM toppings";
		return $result = pg_query($conn,$query);
	}
	
	//This function will query for the specialty pizzas
	function query_specialties() {
		$conn = db_connect;
		
		$query = "SELECT name, description, pizzaSize, price FROM specialtyPizza ";
		return $result = pg_query($conn,$query);
	}
	
	//This function will query for sandwiches
	function query_sandwiches() {
		$conn = db_connect;
		
		$query = "SELECT name, description, price FROM sandwiches";
		return $result = pg_query($conn,$query);
	}
	
	//This function will query the sides
	function query_sides() {
		$conn = db_connect;
		
		$query = "SELECT name, price FROM sides ";
		return $result = pg_query($conn,$query);
	}
	
	//This function will query for salads
	function query_salads() {
		$conn = db_connect;
		
		$query = "SELECT name, description, saladSize, price FROM salads";
		return $result = pg_query($conn,$query);
	}
	
	//This function will query dinner specials
	function query_dinners() {
		$conn = db_connect;
		
		$query = "SELECT name, description, price FROM dinners";
		return $result = pg_query($conn,$query);
	}
	
	//This function will query the drinks
	function query_drinks() {
		$conn = db_connect;
		
		$query = "SELECT name, price FROM drinks";
		return $result = pg_query($conn,$query);
	}


?>