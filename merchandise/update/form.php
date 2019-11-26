<!DOCTYPE html>
<html>
	<body>
		<form name="form" method="post" action="insert.php" enctype="multipart/form-data" >

		<h2>Update at ID:</h2>
		<input name="id"></input>
		<br/><br/>
		<h2>Update info:</h2>
		<p>Title</p>
		<input name="title"></input>
		<p>Description</p>
		<input name="description"></input>
		<p>Price</p>
		<input name="price"></input>
		<br/><br/>
		<input type="file" name="image" />
		<br/><br/>
		<input type="submit" name="submit" value="Update"/>
		</form>
	</body>
</html>

<?php
?>