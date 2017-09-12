<?php
//Need to include functions
require 'functions.php';
//Check if pawprint or last name, first name search

//-------------------------------------------Variables--------------------------------------------------------
//track the type of query
$qtype = $_GET['query_type']
//Start the DB connection
$conn = db_connect();
// This will be the query for the db
$q
//query results
//Need to edit the assignment of $result in order to make the query work;
//$result = postgresql query;
$result = null;

//---------------------------------------------LOGIC----------------------------------------------------
//Ensure a connection
if($conn) {
    //Check search type
   if($qtype == 'pawprint') {
       $q = 'pawprint123' ;
   }
   else { // force the variable in the event of an error, assume it is lname search
        $q = 'lname, fname';       
   }    
    //build an array of the results
   while ($row = $result->fetch_array()) {
        $stu_info = $row;
        $all_stu[]= $stu_info;
   }
   //echo the array of arrays as a json object
   echo json_encode($all_stu, JSON_UNESCAPED_SLASHES);
}
?>