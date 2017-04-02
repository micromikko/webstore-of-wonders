<?php
/**
 * Created by PhpStorm.
 * User: micromikko
 * Date: 14.3.2017
 * Time: 17.18
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
		<title>Logout</title>
	</head>
	<body align="center">

	<h1>Webstore of Wonders</h1>
	<br>
	<?php
	$logoutSuccessful = SessionManager::sessionLogout();
	if($logoutSuccessful) {
		echo "<h2>You have logged out successfully!</h2>";
		header('Refresh: 5; location: index.php');
	} else {
		$newLogout = SessionManager::sessionLogout();
		if(!$newLogout) {
			header('location: errorPage.php');
		}
	}
	?>
	<br>
	<form method="POST">
		<input type="hidden" name="toLoginJuttu">
		<input type="Submit" value="Continue to login page">
	</form>
	<?php
	if(isset($_POST['logoutJuttu'])) {
		header('location: index.php');
	}
	?>
	</body>
</html>
