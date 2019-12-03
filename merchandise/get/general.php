<?php
	//headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	//Check variables
	if (!isset($_GET['factor'])) {
		$response_arr['error'] = "Missing variable: 'factor'";
		echo json_encode($response_arr);
	}
	else if (!isset($_GET['value'])) {
		$response_arr['error'] = "Missing variable: 'value'";
		echo json_encode($response_arr);
	}
	else {
		//database connection
		$host = '127.0.0.1';
		$user = 'root';
		$password = '';
		$db ='teamlab_practice';
	
		$connection = mysqli_connect($host,$user,$password,$db);
		if($connection) {
			//GET return
			$factor = $_GET['factor'];
			$value = $_GET['value'];
			$query = "SELECT * FROM merchandise WHERE " . $factor . " = '$value'";
    		
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
				$response_arr['error'] = "SQL error (" . $query . "): " . $connection->error;
				echo json_encode($response_arr);
		}
		}
		else {
			$response_arr['error'] = "Database connection error: ".mysqli_connect_error();
			echo json_encode($response_arr);
		}
	
		mysqli_close($connection);
	}
?>