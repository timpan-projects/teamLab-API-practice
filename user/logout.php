<!DOCTYPE html>
<html>
	<body>
		<h2>You have successfully logged out.</h2>
		<a href='https://910a6259.ngrok.io/api/user/login.php'>Login with another account</a>
		<!--<a href='https://b8bafcaa.ngrok.io/api/user/login.php'>Login with another account</a>-->
		<br/><br/>
	</body>
</html>

<?php
	session_start();
	session_destroy();
?>