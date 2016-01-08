<?php

$servername = "localhost";
$username = "csguest";
$password = "cspassword";

$dbconnection = new mysqli($servername, $username, $password);

if($dbconnection->connect_error){
	die("Could not connect to the database!");
}

?>
