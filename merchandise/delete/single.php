<?php
	//headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	//Check variables
	if (!isset($_GET['id'])) {
		$response_arr['error'] = "Missing variable: 'id";
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
			//DELETE return
			$id = $_GET['id'];
			$query = "DELETE FROM merchandise WHERE id = '$id'";
		
			if ($result = mysqli_query($connection, $query)) {
				$response_arr['error'] = "Successfully deleted item with id: " . $_GET['id'];;
				echo json_encode($response_arr);
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