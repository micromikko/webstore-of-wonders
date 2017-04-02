<?php
/**
 * Created by PhpStorm.
 * User: micromikko
 * Date: 17.3.2017
 * Time: 21.24
 */

require_once("SessionManager.php");
require_once("Database.php");
require_once("Login.php");
require_once("Store.php");
SessionManager::checkTimeout();
Login::checkLoginStatus();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Purchase successful</title>
	</head>
	<body align="center">
	<div>
		<?php
			echo "Transaction complete. The items you ordered will be delivered by donkey cart.";
			echo "<div><p>Money left: ".$_SESSION['MONEY']."</p></div>";
		?>
	</div>
		<form method="POST">
			<input type="hidden" name="backToStoreJuttu">
			<input type="Submit" value="Back to Store">
		</form>
		<?php
		if(isset($_POST['backToStoreJuttu'])) {
			Login::profileDirector($_SESSION['username']);
		}
		?>
	</body>
</html>