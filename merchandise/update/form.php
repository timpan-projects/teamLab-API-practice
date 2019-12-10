<!DOCTYPE html>
<html>
	<body>
		<form name="form" method="post" action="insert.php" enctype="multipart/form-data" >
		<?php
			if (isset($_GET['id'])) {
				$url = 'http://localhost:80/api/merchandise/get/single.php?id=' . $_GET['id'];
	
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));	
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
				$list = curl_exec($ch);	
				curl_close($ch);	
				$jObj = json_decode($list);
				$item = $jObj->data[0];
			}
		?>
		<h2>Update at ID:</h2>
		<input name="id" maxlength='64' value='<?php if (isset($_GET['id'])) echo $_GET['id'] ?>'></input>
		<br/><br/>
		<h2>Update info:</h2>
		<p>Title</p>
		<input name="title" maxlength='100' value='<?php if (isset($_GET['id'])) echo $item->title ?>'></input>
		<p>Description</p>
		<input name="description" maxlength='500' value='<?php if (isset($_GET['id'])) echo $item->description ?>'></input>
		<p>Price</p>
		<input name="price" type="number" min="0" value='<?php if (isset($_GET['id'])) echo $item->price ?>'></input>
		<br/><br/>
		<div style='<?php if (isset($_GET['id'])) echo "visibility: visible;"; else echo "visibility: hidden;"; ?>'>
			<input type="checkbox" name="keep" value="keep" <?php if (isset($_GET['id'])) echo "checked"; ?>>Keep original image</input>
		</div>
		<br/>
		<input type="file" name="image" />
		<br/><br/>
		<input type="submit" name="submit" value="Update"/>
		<p>*Please note that Update function is only available for logged-in users to modify their own merchandise.</p>
		</form>
	</body>
</html>

<?php
	
?>