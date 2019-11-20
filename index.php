<!DOCTYPE html>

<?php
	//headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');



	//database connection
	$host = '127.0.0.1';//DB的IP
	$user = 'root';//帳號名稱 通常就是root
	$password = '';//打密碼
	$db ='teamlab_practice';//打table名稱
	////建立連線
	$connection = mysqli_connect($host,$user,$password,$db);
	echo "<br>Establishing database connection...<br>";
	if($connection)//成功
	{
		echo "Connection success!<br>";
		$id = "00000000-0000-0000-0000-000000000001";
		$title = "test title";
		$description = "test description";
		$price = 999;
		$image_path = "test_path";	
		
		//Insert資料
		echo"Inserting new data into database...<br>";
		$sql = "INSERT INTO merchandise (id, title, description, price, image_path) VALUES ('$id', '$title', '$description', '$price', '$image_path')";
		if ($connection->query($sql) === TRUE)//成功
		{
   			echo "New record created successfully";
		}
		else//失敗
		{
		    echo "Error: " . $sql . "<br>" . $connection->error;
		}
	}
	else//失敗
	{
	   echo "db connection error because of".mysqli_connect_error()."<br>";
	}



	//GET return
	$post_arr = array();
	$post_arr['data'] = array();
	$count = 4;


	for ($i = 0; $i <= $count; $i++) {
		$post_item = array(
			'id' => 'always love gmin',
			'title' => 'always'
		);
		array_push($post_arr['data'], $post_item);
	}
	
	$post_arr['count'] = $count;
	echo json_encode($post_arr);






	//存入資料庫用參數
	//$title = $_GET['title'];
	//$description = $_GET['description'];
	//$price = $_GET['price'];
	//$image_path = $_GET['image_path'];

	
	?>