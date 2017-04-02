<?php
/**
 * Created by PhpStorm.
 * User: micromikko
 * Date: 19.3.2017
 * Time: 15.48
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
		<title>Webstore of Wonders - Admin Toolbox</title>
	</head>
	<body align="center">
		<div>
			<h1>Webstore of Wonders</h1>
			<p>A message will be displayed if the operation is successful.</p>
			<p>Please note: the ID and name of a product and a user must be unique.</p>
			<p>Please note: the decimal separator in the 'price' column must be '.' NOT ',' .</p>
			<p>Please note: the admin account is untouchable.</p>
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
			<h2>Add new product to store</h2>
			<?php Store::addProduct($_POST['addID'], $_POST['addNAME'], $_POST['addCAT'], $_POST['addQTY'], $_POST['addPRICE'], $_POST['addDESCR']); ?>
			<form action='' method='post'>
				<div class='field'>
					<input type='text' name='addID' placeholder="ID">
				</div>
				<div class='field'>
					<input type='text' name='addNAME' placeholder="Name">
				</div>
				<div class='field'>
					<input type='text' name='addCAT' placeholder="Category">
				</div>
				<div class='field'>
					<input type='text' name='addQTY' placeholder="Quantity">
				</div>
				<div class='field'>
					<input type='text' name='addPRICE' placeholder="Price">
				</div>
				<div class='field'>
					<input type='text' name='addDESCR' placeholder="Description">
				</div>
				<div class='field'>
					<input type="submit" class="button" name="addButton" value="Add product to store" />
				</div>
			</form>
		</div>
		<hr width="40%" align="">
		<div>
			<h2>Delete product from store</h2>
			<?php Store::removeProduct($_POST['remID']); ?>
			<form action='' method='post'>
				<div class='field'>
					<input type='text' name='remID' placeholder="ID">
				</div>
				<div class='field'>
					<input type="submit" class="button" name="addButton" value="Remove product from store" />
				</div>
			</form>
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
			<h2>Update product price</h2>
			<?php Store::updateProductPrice($_POST['updpID'], $_POST['updpPrice']); ?>
			<form action='' method='post'>
				<div class='field'>
					<input type='text' name='updpID' placeholder="ID">
				</div>
				<div class='field'>
					<input type='text' name='updpPrice' placeholder="Price">
				</div>
				<div class='field'>
					<input type="submit" class="button" name="addButton" value="Update product price" />
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
			<h2>Add user</h2>
			<?php Store::addUser($_POST['adduid'], $_POST['adduAL'], $_POST['adduUSER'], $_POST['adduPW'])?>
			<form action='' method='post'>
				<div class='field'>
					<input type='text' name='adduid' placeholder="ID">
				</div>
				<div class='field'>
					<input type='text' name='adduAL' placeholder="Access Level (1, 3, 5)">
				</div>
				<div class='field'>
					<input type='text' name='adduUSER' placeholder="Username">
				</div>
				<div class='field'>
					<input type='text' name='adduPW' placeholder="Password">
				</div>
				<div class='field'>
					<input type="submit" class="button" name="addButton" value="Add User" />
				</div>
			</form>
		</div>
		<hr width="40%" align="">
		<div>
			<h2>Delete user</h2>
			<?php Store::deleteUser($_POST['delUSER'])?>
			<form action='' method='post'>
				<div class='field'>
					<input type='text' name='delUSER' placeholder="ID">
				</div>
				<div class='field'>
					<input type="submit" class="button" name="addButton" value="Delete user" />
				</div>
			</form>
		</div>
		<hr width="40%" align="">
		<div>
			<h2>Change user access level</h2>
			<?php Store::updateUserAccessLevel($_POST['calID'], $_POST['calAL']); ?>
			<form action='' method='post'>
				<div class='field'>
					<input type='text' name='calID' placeholder="ID">
				</div>
				<div class='field'>
					<input type='text' name='calAL' placeholder="Access level (1, 3, 5)">
				</div>
				<div class='field'>
					<input type="submit" class="button" name="addButton" value="Change access level" />
				</div>
			</form>
		</div>
		<hr width="40%" align="">
		<div>
			<h2>Change user password</h2>
			<?php Store::updateUserPassword($_POST['cpwID'], $_POST['cpwPW']); ?>
			<form action='' method='post'>
				<div class='field'>
					<input type='text' name='cpwID' placeholder="ID">
				</div>
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