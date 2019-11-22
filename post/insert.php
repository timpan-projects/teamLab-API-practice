<?php
//Upload image
	$target_dir = "../uploads/guests/";
	if ($_FILES["image"] != null) {

		if (!file_exists($target_dir)) {
    		mkdir($target_dir, 0777, true);
		}

		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if (isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["image"]["tmp_name"]);

		    if ($check !== false) {
		        echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    }
		    else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
	}

	if ($uploadOk == 0)
    	echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	else {
	    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
	    }
	    else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}

//POST record to api
	$url = 'http://localhost/api/post/post.php';
	$data = array(
		'title' => $_POST['title'],
		'description' => $_POST['description'],
		'price' => $_POST['price'],
		'image_path' => basename($_FILES["image"]["name"])
	);
	
	$data_string = json_encode($data);
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
	$result = curl_exec($ch);	
	curl_close($ch);	
	echo "$result";
?>