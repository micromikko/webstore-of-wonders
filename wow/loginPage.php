<?php
/**
 * Created by PhpStorm.
 * User: micromikko
 * Date: 14.3.2017
 * Time: 16.39
 */
require_once("SessionManager.php");
SessionManager::checkTimeout();
require_once("Login.php");

if(!empty($_POST['checker'])) {
	Login::debuggah();
	Login::checkCredentials();
} else {}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="mystyle.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Login</title>
	</head>
	<body align="center">
		<h1>Webstore of Wonders</h1>
		<br>
		<?php
		Login::displayLoginForm();
		?>
	</body>
</html>
