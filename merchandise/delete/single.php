<?php
	use ReallySimpleJWT\Token;
	require '../../vendor/autoload.php';
	$secret = file_get_contents('../../jwt_secret.txt', FILE_USE_INCLUDE_PATH);

	//headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	//Check variables
	if (!isset($_SERVER['HTTP_JWT']) || $_SERVER['HTTP_JWT'] == "") {
		$response_arr['error'] = "Missing JWT token";
		echo json_encode($response_arr);
	}
	else {
		$tokenValidation = Token::validate($_SERVER['HTTP_JWT'], $secret);

		if (!$tokenValidation) {
			$response_arr['error'] = "JWT token illegal or outdated";
			echo json_encode($response_arr);
		}
		else {
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
						$response_arr['result'] = "Successfully deleted item with id: " . $_GET['id'];;
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
		}
	}
?>