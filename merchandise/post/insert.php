<?php
	session_start();
	if (isset($_SESSION['login']) && isset($_SESSION['node_id'])) {
		$login = $_SESSION['login'];
		$node_id = $_SESSION['node_id'];
		$target_dir = "../uploads/" . $_SESSION['login'] . "/";
	}
	else {
		$login = "";
		$node_id = "";
		$target_dir = "../uploads/guests/";
	}

	//Upload image
	if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
	    $image_file_basename = '';
	    //echo 'No image uploaded';
	}
	else {
		$image_file_basename = basename($_FILES["image"]["name"]);
		if (!file_exists($target_dir)) {
    		mkdir($target_dir, 0777, true);
		}

		$target_file = $target_dir . $image_file_basename;
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if (isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["image"]["tmp_name"]);

		    if ($check !== false) {
		        //echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    }
		    else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// Check file size
		if ($_FILES["image"]["size"] > 2000000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}

		if ($uploadOk == 0)
	    	echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		else {
		    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		        //echo "The file ". $image_file_basename . " has been uploaded.";
		    }
		    else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
	}

	//POST record to api
	$url = 'http://localhost:80/api/merchandise/post/post.php';
	//$url = 'https://b8bafcaa.ngrok.io/api/merchandise/post/post.php';
	$data = array(
		'title' => $_POST['title'],
		'description' => $_POST['description'],
		'price' => $_POST['price'],
		'image_path' => $image_file_basename,
		'uploader' => $login,
		'node_id' => $node_id
	);
	
	$data_string = json_encode($data);
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	$jwt_string = 'jwt:' . $_SESSION['jwt'];
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $jwt_string));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
	$result = curl_exec($ch);	
	curl_close($ch);	
	echo "$result";

	echo "<br/><br/><a href = 'http://localhost:80/api/merchandise/post/form.php'>Create another merchandise</a>";
	if (isset($_SESSION['login']) && isset($_SESSION['node_id'])) {
		echo "<br/><br/><a href = 'http://localhost:80/api/user/profile.php'>Return to profile page</a>";
	}
	else {
		echo "<br/><br/><a href = 'http://localhost:80/api/user/login.php'>Go to Login page</a>";
	}
	
?>