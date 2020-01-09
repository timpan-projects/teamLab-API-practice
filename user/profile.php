<!DOCTYPE html>
<html>
	<body>
		<?php
			use ReallySimpleJWT\Token;
			session_start();
			if (!isset($_SESSION['my_access_token_accessToken'])) {
				echo "<h2>Please login first.</h2>";
				echo "<a href='http://localhost:80/api/user/login.php'>Link to the Login Page</a>";
				//echo "<br/><br/><a href='https://b8bafcaa.ngrok.io/api/user/login.php'>Link to the Login Page</a>";
			}
			else {
				echo "You are logged in.";
				echo "<br/><a href='http://localhost:80/api/user/logout.php'>Link to the Log Out Page</a>";
				//echo "<br/><br/><a href='https://b8bafcaa.ngrok.io/api/user/logout.php'>Link to the Log Out Page</a>";
				//echo "<br/><br/>Access token: " . $_SESSION['my_access_token_accessToken'] . "</br></br>";

				$url = 'https://api.github.com/user';
				$authHeader = "Authorization: token " . $_SESSION['my_access_token_accessToken'];
				$userAgentHeader = "User-Agent: teamLab API practice";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', $authHeader, $userAgentHeader));
				
				$result = curl_exec($ch);
				curl_close($ch);
				//echo "$result";

				$result = json_decode($result);

				//Variables to pass in session
				$_SESSION['login'] = $result->login;
				$_SESSION['node_id'] = $result->node_id;

				//Publish JWT token
				if ($result->login != null && $result->node_id != null) {
					
					require '../vendor/autoload.php';

					$userId = 12;
					$secret = file_get_contents('../jwt_secret.txt', FILE_USE_INCLUDE_PATH);
					$expiration = time() + 3600;
					$issuer = 'localhost';
					
					$token = Token::create($userId, $secret, $expiration, $issuer);
					$_SESSION['jwt'] = $token;
					echo "<br/>JWT token for testing: " . $token;
				}

				//Greet user
				$login = $result->login;
				echo "<h2>Welcome back! " . $login . "</h2>";

				//Show user profile photo
				$avatar_url = $result->avatar_url;
				echo "<h2>Profile Photo</h2>";
				echo "<img src=" . $avatar_url . " height='150' width='150'>";

				//Github page link
				$html_url = $result->html_url;
				echo "<p>(Check out your own Github Page: ";
				echo "<a href='" . $html_url . "'>Click here!</a>)</p>";

				//Create item page
				echo "<p>How about creating a new merchandise? ";
				echo "<a href='http://localhost:80/api/merchandise/post/form.php'>Click here!</a></p>";

				//GET merchandise list via API
				echo "<h2>Uploaded Merchandise</h2>";
				$factor = 'node_id';
				$value = $_SESSION['node_id'];
				$url = 'http://localhost:80/api/merchandise/get/general.php?factor=' . $factor . '&value=' . $value;

				$ch = curl_init($url);
				$jwt_string = 'jwt:' . $_SESSION['jwt'];
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $jwt_string));

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
				$list = curl_exec($ch);	
				curl_close($ch);	
				
				//echo "$list";
				$jObj = json_decode($list);
				for ($item_count = 0; $item_count < $jObj->count; $item_count++) {
					$item = $jObj->data[$item_count];
					echo "<p>======================================</p>";
					echo "<a href='http://localhost:80/api/merchandise/update/form.php?id=" . ($item->id) ."'>Edit Merchandise</a>";
					echo "<div><h3>Title: </h3>";
					echo "<p>" . ($item->title) . "</p>";
					echo "<h3>Merchandise ID: </h3>";
					echo "<p>" . ($item->id) . "</p>";
					echo "<h3>Description: </h3>";
					echo "<p>" . ($item->description) . "</p>";
					echo "<h3>Price: </h3>";
					echo "<p>" . ($item->price) . "</p>";
					echo "<h3>Upload time: </h3>";
					echo "<p>" . ($item->upload_time) . "</p>";
					echo "<h3>Last update time: </h3>";
					echo "<p>" . ($item->last_update) . "</p>";
					echo "<h3>Image:</h3>";
					if ($item->image_path != null)
						echo "<img width='300' src='http://localhost:80/api/merchandise/" . $item->image_path . "'/></div>";
					else
						echo "<p>[No Image]</p>";
					
				}				
				echo "<p>======================================</p>";
			}
		?>

	</body>
</html>

<?php
	
?>