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

	//GET return
	$id = $_GET['id'];
	$query = "SELECT * FROM merchandise WHERE id = '$id'";

	if ($result = mysqli_query($connection, $query)) {
		$post_arr = array();
		$post_arr['data'] = array();

		while($obj = mysqli_fetch_object($result)) {

			array_push($post_arr['data'], $obj);
		
		}

		$post_arr['count'] = mysqli_num_rows($result);
		echo json_encode($post_arr);
		mysqli_free_result($result);
	}

	else {
		echo "SQL error (" . $query . "): " . $connection->error;
	}

	mysqli_close($connection);
?>