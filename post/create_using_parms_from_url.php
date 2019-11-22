<?php
//Using parameters in url to upload record to databse.
	if ($_FILES["image"] != null) {
		$target_dir = "../uploads/guests/";
		if (!file_exists($target_dir)) {
    		mkdir($target_dir, 0777, true);
		}
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["image"]["tmp_name"]);
		    if($check !== false) {
		        echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
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
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}

	//存入資料庫用參數
	$id = getGUID();
	$title = $_POST['title'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$image_path = 'uploads/guests/' . basename( $_FILES["image"]["name"]);
	//round(microtime(true) * 1000); //use timestamp as image name, combine username after login control

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
		$sql = "INSERT INTO merchandise (id, title, description, price, image_path) VALUES ('$id', '$title', '$description', '$price', '$image_path')";
		if ($connection->query($sql) === TRUE)
		{
   			echo "New record created successfully";
		}
		else
		{
		    echo "Error: " . $sql . "<br>" . $connection->error;
		}
	}
	else
	{
	   echo "db connection error because of".mysqli_connect_error()."<br>";
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