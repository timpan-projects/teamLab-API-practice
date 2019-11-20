<!DOCTYPE html>
<html>
	<body>
		<form name="form" method="post" action="upload.php" enctype="multipart/form-data" >

		<h2>Create new item</h2>
		<p>Title</p>
		<input name="name"></input>
		<p>Description</p>
		<input name="value1"></input>
		<p>Price</p>
		<input name="value2"></input>

		<input type="file" name="my_file" />
		<br/>
		<br/>
		<input type="submit" name="submit" value="Upload"/>
		</form>
	</body>
</html>

<?php
	
?>