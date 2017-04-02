<?php
/**
 * Created by PhpStorm.
 * User: micromikko
 * Date: 17.3.2017
 * Time: 15.48
 */

require_once("SessionManager.php");
require_once("Database.php");
require_once("Login.php");
require_once("Store.php");
SessionManager::checkTimeout();
//Login::checkLoginStatusAdmin();
Login::checkLoginStatus();


?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Webstore of Wonders - Employee Toolbox</title>
	</head>
	<body align="center">
		<div>
			<h1>Webstore of Wonders</h1>
			<p>A message will be displayed if the operation is successful.</p>
			<p>Remember: the ID and name of the product must be unique.</p>
		</div>
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
		<hr width="40%" align="">
		<div>
			<h2>Update product quantity</h2>
			<?php Store::updateProductQuantity($_POST['updID'], $_POST['updQTY']); ?>
			<form action='' method='post'>
				<div class='field'>
					<input type='text' name='updID' placeholder="ID">
				</div>
				<div class='field'>
					<input type='text' name='updQTY' placeholder="Quantity">
				</div>
				<div class='field'>
					<input type="submit" class="button" name="addButton" value="Update product quantity" />
				</div>
			</form>
		</div>
		<hr width="40%" align="">
		<div>
			<h2>Update product description</h2>
			<?php Store::updateProductDescription($_POST['updeID'], $_POST['updeDES']); ?>
			<form action='' method='post'>
				<div class='field'>
					<input type='text' name='updeID' placeholder="ID">
				</div>
				<div class='field'>
					<input type='text' name='updeDES' placeholder="Decription">
				</div>
				<div class='field'>
					<input type="submit" class="button" name="addButton" value="Update product description" />
				</div>
			</form>
		</div>
		<hr width="40%" align="">
		<div>
			<h2>Change own password</h2>
			<?php Store::updateOwnPassword($_POST['cpwPW']); ?>
			<form action='' method='post'>
				<div class='field'>
					<input type='text' name='cpwPW' placeholder="Password">
				</div>
				<div class='field'>
					<input type="submit" class="button" name="addButton" value="Change password" />
				</div>
			</form>
		</div>
		<br>
		<hr width="40%" align="">
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
		<br>
		<br>
	</body>
</html>