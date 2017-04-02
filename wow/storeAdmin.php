<?php
/**
 * Created by PhpStorm.
 * User: micromikko
 * Date: 17.3.2017
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
		<title>Webstore of Wonders - Admin</title>
		<script>
            function showProducts(asd) {
                if (asd == "") {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                } else {
                    if (window.XMLHttpRequest) {
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("txtHint").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET","call_drawOrderedTable.php?q="+asd,true);
                    xmlhttp.send();
                }
            }
		</script>
		<style>
			.bordered {
				width: 20px;
				height: 10px;
				padding: 5px;
				border: 2px solid darkslateblue;
				border-radius: 2px;
			}
		</style>
	</head>
	<body align="center">
		<div>
			<h1 align="center">Webstore of Wonders</h1>
			<br>
			<br>
			<h2>Admin page</h2>
			<h2>You are logged in as user: <?php echo $_SESSION['username'] ?></h2>
		</div>
		<div align="">
		<div>
			<form method="POST">
				<input type="hidden" name="adminToolsAdmin">
				<input type="Submit" value="Administrative Tools">
			</form>
			<?php
			if(isset($_POST['adminToolsAdmin'])) {
				header('location: storeEditAdmin.php');
			}
			?>
		</div>
		<div>
			<br>
			<hr width="40%" align="">
			<br>
			<?php echo "<div><p>Wallet: ".$_SESSION['MONEY']."€</p></div>"; ?>
		</div>
		<div>
			<form>
				<select id="orderSelect" name="orderSelect" onchange="showProducts(this.value)">
					<option value="">Select display order</option>
					<option value="1">id</option>
					<option value="2">name</option>
					<option value="3">category</option>
					<option value="4">price</option>
					<option value="5">user list</option>
				</select>
			</form>
			<br>
			<div id="txtHint"><b>Please select the order in which to display the table.</b></div>
		</div>
		<br>
		<br>
		<hr width="40%" align="">
		<div>
			<div>
				<h2>Add to Your Cart</h2>
				<?php Store::addToCart($_POST['addCartID'], $_POST['addCartQTY']); ?>
				<form action='' method='post'>
					<div class='field'>
						<input type='text' name='addCartID' placeholder="Product ID">
					</div>
					<div class='field'>
						<input type='text' name='addCartQTY' placeholder="Quantity">
					</div>
					<div class='field'>
						<input type="submit" class="button" name="addCartButton" value="Add to Cart" />
					</div>
				</form>
			</div>
		</div>
		<br>
		<div>
			<form method="POST">
				<input type="hidden" name="cartPageAdmin">
				<input type="Submit" value="Inspect Cart">
			</form>
			<?php
			if(isset($_POST['cartPageAdmin'])) {
				header('location: cartPage.php');
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
		</div>
		<br>
		<br>
	</body>
</html>