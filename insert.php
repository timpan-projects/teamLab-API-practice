<!DOCTYPE html>
<html>
	<body>
		<form name="form" method="post" action="upload.php" enctype="multipart/form-data" >

		<h2>Create new item</h2>
		<p>Title</p>
		<input name="title"></input>
		<p>Description</p>
		<input name="description"></input>
		<p>Price</p>
		<input name="price"></input>

		<input type="file" name="image" />
		<br/>
		<br/>
		<input type="submit" name="submit" value="Upload"/>
		</form>
	</body>
</html>

<?php
	
?>