<!DOCTYPE html>
<html>
	<body>
		<a href='http://localhost:80/api/user/login.php'>Login</a>
		<!--<a href='http://localhost:80/api/user/login.php'>Login</a>-->
		<br/>
		<br/>
		<?php
			session_start();
			$access_token = $_SESSION['my_access_token_accessToken'];
			if ($access_token == "") {
				echo "Please login first.";
			}
			else {
				$url = 'https://api.github.com/user';
				$authHeader = "Authorization: token " . $access_token;
				$userAgentHeader = "User-Agent: Demo";
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

	$code = $_GET['code'];
	if ($code == "") {
		header('Location: http://localhost:80/api/user/login.php');
		//header('Location: https://b8bafcaa.ngrok.io/api/user/login.php');
		exit;
	}

	$url = 'https://github.com/login/oauth/access_token';
	$data = array(
		'client_id' => '565ef42f78b3792a36cd',
		'client_secret' => '81849421fe923edef483c78b2f32e3a9b4c906f8',
		'code' => $code,
	);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
	
	$result = curl_exec($ch);

	curl_close($ch);	
	echo "$result";

	$result = json_decode($result);

	if ($result->access_token != "") {
		session_start();
		$_SESSION['my_access_token_accessToken'] = $result->access_token;
		header('Location: http://localhost:80/api/user/profile.php');
		//header('Location: https://b8bafcaa.ngrok.io/api/user/profile.php');
		exit;
	}

?>