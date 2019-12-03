<?php
//Using POST body to upload record to database
	//Get POST body
	$body = json_decode(file_get_contents('php://input'), true);
	$sql_var_update = "";
	//Check variable
	if (!isset($body['id']) || !isset($body['uploader']) || !isset($body['node_id'])) {
		$response_arr['error'] = "Variable 'id', 'uploader', and 'node_id' are needed to perform a merchandise update.";
		echo json_encode($response_arr);
	}
	else {
		$id = $body['id'];
		$uploader = $body['uploader'];
		$node_id = $body['node_id'];

		if (isset($body['title'])) {
			$title = $body['title'];
			$sql_var_update = $sql_var_update . "title = '$title'";
		}
		if (isset($body['description'])) {
			$description = $body['description'];
			$sql_var_update = $sql_var_update . ", description = '$description'";
		}
		if (isset($body['price'])) {
			$price = $body['price'];
			$sql_var_update = $sql_var_update . ", price = '$price'";
		}
		if (isset($body['image_path'])) {
			if (isset($body['uploader']) && $body['uploader'] != "") {
				$image_path = 'uploads/' . $body['uploader'] . "/" . $body['image_path'];
			}
			else {
				$image_path = 'uploads/guests/' . $body['image_path'];
			}
			$sql_var_update = $sql_var_update . ", image_path = '$image_path'";
		}

		//database connection
		$host = '127.0.0.1';
		$user = 'root';
		$password = '';
		$db ='teamlab_practice';
		
		$connection = mysqli_connect($host,$user,$password,$db);
		if($connection) {
			//Check uploader and node_id
			$query_check = "SELECT * FROM merchandise WHERE id = '$id'";
	
			if ($result = mysqli_query($connection, $query_check)) {
				$obj = mysqli_fetch_object($result);
				if ($obj->uploader ==  $uploader && $obj->node_id == $node_id) {
					//Check passed, upload record
					$sql = "UPDATE merchandise SET " . $sql_var_update ." WHERE id = '$id'";
					if ($connection->query($sql) === TRUE) {
   						$response_arr['result'] = "Record updated successfully";
						echo json_encode($response_arr);
					}
					else {
						$response_arr['error'] = "SQL error (" . $sql . "): " . $connection->error;
						echo json_encode($response_arr);
					}
				}
				else {
					$response_arr['error'] = "You cannot update merchandise uploaded by other users.";
					echo json_encode($response_arr);
				}
			}
			else {
				$response_arr['error'] = "SQL error (" . $query_check . "): " . $connection->error;
				echo json_encode($response_arr);
			}	
		}
		else
		{
		 	$response_arr['error'] = "Database connection error: ".mysqli_connect_error();
			echo json_encode($response_arr);
		}
	}
?>