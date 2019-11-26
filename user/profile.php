<!DOCTYPE html>
<html>
	<body>
		<?php
			session_start();
			$access_token = $_SESSION['my_access_token_accessToken'];
			if ($access_token == "") {
				echo "Please login first.";
				echo "<br/><a href='http://localhost:80/api/user/login.php'>Link to the Login Page</a>";
			}
			else {
				echo "Access token: " . $access_token . "</br></br>";
				$url = 'https://api.github.com/user';
				$authHeader = "Authorization: token " . $access_token;
				$userAgentHeader = "User-Agent: teamLab API practice";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', $authHeader, $userAgentHeader));
				
				$result = curl_exec($ch);
				curl_close($ch);
				echo "$result";
			}
		?>

	</body>
</html>

<?php

?>