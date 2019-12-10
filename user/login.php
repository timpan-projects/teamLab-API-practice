<!DOCTYPE html>
<html>
	<body>
		<h2>Login Page</h2>
		<?php
			session_start();
			if (isset($_SESSION['my_access_token_accessToken'])) {
				header('Location: http://localhost:80/api/user/profile.php');
				//header('Location: https://b8bafcaa.ngrok.io/api/user/profile.php');
				exit;
			}
			else {
				echo "<a>Login with Google (Not available)</a>";
				echo "<br/><br/>";
				echo "<a>Login with Facebook (Not available)</a>";
				echo "<br/><br/>";
				echo "<a href='https://github.com/login/oauth/authorize?client_id=565ef42f78b3792a36cd'>Login with Github (Recommended)</a>";
				echo "<br/><br/>";
				echo "<a href='http://localhost:80/api/merchandise/post/form.php'>Create a new merchandise as Guest</a>";
				echo "<br/><br/>";
			}
		?>
	</body>
</html>

<?php
	
?>