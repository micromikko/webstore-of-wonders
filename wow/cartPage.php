<?php
/**
 * Created by PhpStorm.
 * User: micromikko
 * Date: 20.3.2017
 * Time: 21.24
 */

require_once("SessionManager.php");
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
		<title>Webstore of Wonders - Cart</title>
	</head>
		<body align="center">
			<style>
				.bordered {
					width: 20px;
					height: 10px;
					padding: 5px;
					border: 2px solid darkslateblue;
					border-radius: 2px;
				}
			</style>
			<div>
				<h1 align="center">Webstore of Wonders</h1>
				<br>
				<br>
				<h2>Your Cart</h2>
			</div>
			<hr width="40%" align="">
			<?php echo "<div><p>Wallet: ".$_SESSION['MONEY']."€</p></div>"; ?>
			<div>
				<?php Store::drawTableCart() ?>
			</div>
			<br>
			<br>
			<hr width="40%" align="">
			<br>
			<div>
				<?php Store::removeFromCart($_POST['remCartID']); ?>
				<form action='' method='post'>
					<div class='field'>
						<input type='text' name='remCartID' placeholder="Product ID">
					</div>
					<div class='field'>
						<input type="submit" class="button" name="addButton" value="Remove from Cart" />
					</div>
				</form>
			</div>
			<br>
			<div>
				<?php
				if(isset($_POST['payJuttu'])) {
					Store::payForStuff();
				}
				?>
				<form method="POST">
					<input type="hidden" name="payJuttu">
					<input type="Submit" value="Checkout">
				</form>
			</div>
			<br>
			<hr width="40%" align="">
			<br>
			<div>
				<form method="POST">
					<input type="hidden" name="backToStoreJuttu">
					<input type="Submit" value="Back to Store">
				</form>
				<?php
				if(isset($_POST['backToStoreJuttu'])) {
					Login::profileDirector($_SESSION['username']);
				}
				?>
			</div>
			<br>
			<br>
			<div>
				<form method="POST">
					<input type="hidden" name="logoutJuttu">
					<input type="Submit" value="Logout">
				</form>
				<?php
				if(isset($_POST['logoutJuttu'])) {
					header('location: logoutPage.php');
				}
				?>
		</div>
		<br>
		<br>
	</body>
</html>