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
				echo "<a href='https://github.com/login/oauth/authorize?client_id=565ef42f78b3792a36cd'>Login with Github (OAuth)</a>";
			}
		?>
	</body>
</html>

<?php
	
?>