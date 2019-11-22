<?php
	//headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	//database connection
	$host = '127.0.0.1';
	$user = 'root';
	$password = '';
	$db ='teamlab_practice';

	$connection = mysqli_connect($host,$user,$password,$db);
	//echo "<br>Establishing database connection...<br>";
	if($connection) {
		//echo "Connection success!<br>";
	}
	else {
	   echo "Database connection error: ".mysqli_connect_error()."<br>";
	}

	//DELETE return
	$id = $_GET['id'];
	$query = "DELETE FROM merchandise WHERE id = '$id'";

	if ($result = mysqli_query($connection, $query)) {
		echo "Successfully deleted item with id: " . $_GET['id'];
	}

	else {
		echo "SQL error (" . $query . "): " . $connection->error;
	}

	mysqli_close($connection);
?>