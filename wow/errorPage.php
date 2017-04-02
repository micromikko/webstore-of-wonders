<?php
require_once("SessionManager.php");
require_once("Login.php");
SessionManager::checkTimeout();
Login::checkLoginStatus();
?>



<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="mystyle.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Error</title>
	</head>
	<body>
		<h1>Webstore of Wonders</h1>
		<br>
		<p>An error has occurred. </p>

		<div>
			<form method="POST">
				<input type="hidden" name="asd">
				<input type="Submit" value="Back to store">
			</form>
			<?php
			if(isset($_POST['asd'])) {
				Login::profileDirector($_SESSION['username']);
			}
			?>
		</div>
	</body>
</html>