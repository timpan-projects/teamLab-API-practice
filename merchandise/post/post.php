<?php
	//Get POST body
	$body = json_decode(file_get_contents('php://input'), true);

	if (!isset($body['title']) || $body['title'] == "") {
		$response_arr['error'] = "Merchandise title cannot be empty. Upload canceled.";
		echo json_encode($response_arr);
	}
	else {
		$id = getGUID();
		$title = $body['title'];
		$description = $body['description'];
		$price = $body['price'];
		$image_path = '';
		$uploader = $body['uploader'];
		$node_id = $body['node_id'];
		if ($body['image_path'] != null) {
			if ($body['uploader'] != null) {
				$image_path = 'uploads/' . $body['uploader'] . "/" . $body['image_path'];
			}
			else {
				$image_path = 'uploads/guests/' . $body['image_path'];
			}
		}
	
		//database connection
		$host = '127.0.0.1';
		$user = 'root';
		$password = '';
		$db ='teamlab_practice';
		
		$connection = mysqli_connect($host,$user,$password,$db);
		echo "<br>Establishing database connection...<br>";
		if($connection)
		{
			echo "Connection success!<br>";
			echo"Inserting new data into database...<br>";
			$sql = "INSERT INTO merchandise (id, title, description, price, image_path, uploader, node_id) VALUES ('$id', '$title', '$description', '$price', '$image_path', '$uploader', '$node_id')";
			if ($connection->query($sql) === TRUE) {
   				$response_arr['result'] = "New record created successfully";
				echo json_encode($response_arr);
			}
			else {
			    $response_arr['error'] = "SQL error (" . $sql . "): " . $connection->error;
				echo json_encode($response_arr);
			}
		}
		else {
		   	$response_arr['error'] = "Database connection error: ".mysqli_connect_error();
			echo json_encode($response_arr);
		}
	}

	function getGUID(){
	    if (function_exists('com_create_guid')){
	        return com_create_guid();
	    }
	    else {
	        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	        $charid = strtoupper(md5(uniqid(rand(), true)));
	        $hyphen = chr(45);// "-"
	        $uuid = ''
	            .substr($charid, 0, 8).$hyphen
	            .substr($charid, 8, 4).$hyphen
	            .substr($charid,12, 4).$hyphen
	            .substr($charid,16, 4).$hyphen
	            .substr($charid,20,12);
	        return $uuid;
	    }
	}
?>