<!DOCTYPE html>
<html>
	<body>
		<form name="form" method="post" action="insert.php" enctype="multipart/form-data" >

		<h2>Create new item</h2>
		<p>Title</p>
		<input name="title" maxlength='100'></input>
		<p>Description</p>
		<input name="description" maxlength='500'></input>
		<p>Price</p>
		<input name="price" type="number" min="0"></input>
		<br/><br/>
		<input type="file" name="image" />
		<br/><br/>
		<input type="submit" name="submit" value="Create"/>
		</form>
	</body>
</html>

<?php
?>