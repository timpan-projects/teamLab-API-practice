<?php
	//存入資料庫用參數
	$id = getGUID();
	$title = $_POST['title'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$image_path = round(microtime(true) * 1000); //use timestamp as image name, combine username after login control
	//$image = $_POST['image'];

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