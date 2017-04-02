<?php
/**
 * Created by PhpStorm.
 * User: micromikko
 * Date: 18.3.2017
 * Time: 20.43
 */

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
		<h1>Database error! Please check your input or try again later.</h1>
		<br>
		<div>
			<form method="POST">
				<input type="hidden" name="adminStore">
				<input type="Submit" value="Back to store">
			</form>
			<?php
			if(isset($_POST['adminStore'])) {
				Login::profileDirector($_SESSION['username']);
			}
			?>
		</div>
	</body>
</html>