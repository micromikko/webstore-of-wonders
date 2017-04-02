<?php

class Store {


	static function addProduct($id, $name, $category, $quantity, $price, $description) {
		if($id != "" && $name != "" && $category != "" && $price != "" && $quantity != "") {
			if($id < 1) {
				return false;
			}
			require_once("Database.php");
			$connection = Database::dbConnect();
			$safeID = $connection->real_escape_string($id);
			$safenam = $connection->real_escape_string($name);
			$safeasd = $connection->real_escape_string($category);
			$safedsa = $connection->real_escape_string($quantity);
			$safesasas = $connection->real_escape_string($price);
			$safeDESC = $connection->real_escape_string($description);
			$sql = "INSERT INTO products (id, name, category, quantity, price, description)
				VALUES ('$safeID', '$safenam', '$safeasd', '$safedsa', '$safesasas', '$safeDESC')";
			$result = Database::dbQuery($sql);
			if($result == true) {
				echo "<p>" . $id . "\t" . $name . "\t" . $category . "\t" . $quantity . "\t" . $price . "\t" . $description . "</p>";
			} else {
				header('location: dbError.php');
			}
		}
	}
	
	static function removeProduct($id) {
		if($id != "") {
			require_once("Database.php");
			$connection = Database::dbConnect();
			$safeID = $connection->real_escape_string($id);
			$sql = "DELETE FROM products WHERE id ='$safeID'";
			$result = Database::dbQuery($sql);
			if($result == true) {
				echo "<p>" . $id . "</p>";
			} else {
				header('location: dbError.php');
			}
		}
	}

	static function updateProductQuantity($id, $qty) {
		if($id != "" && $qty != "") {
			require_once("Database.php");
			$connection = Database::dbConnect();
			$safeID = $connection->real_escape_string($id);
			$safeQTY = $connection->real_escape_string($qty);
			$sql = "UPDATE products SET quantity='$safeQTY' WHERE id='$safeID'";
			$result = Database::dbQuery($sql);
			if($result == true) {
				echo "<p>" . $id . "\t" . $qty . "</p>";
			} else {
				header('location: dbError.php');
			}
		}
	}

	static function updateProductPrice($id, $price) {
		if($id != "" && $price != "") {
			require_once("Database.php");
			$connection = Database::dbConnect();
			$safeID = $connection->real_escape_string($id);
			$safePRICE = $connection->real_escape_string($price);
			$sql = "UPDATE products SET price='$safePRICE' WHERE id='$safeID'";
			$result = Database::dbQuery($sql);
			if($result == true) {
				echo "<p>" . $id . "\t" . $price . "</p>";
			} else {
				header('location: dbError.php');
			}
		}
	}

	static function updateProductDescription($id, $description) {
		if($id != "" && $description != "") {
			require_once("Database.php");
			$connection = Database::dbConnect();
			$safeID = $connection->real_escape_string($id);
			$safeDESC = $connection->real_escape_string($description);
			$sql = "UPDATE products SET description='$safeDESC' WHERE id='$safeID'";
			$result = Database::dbQuery($sql);
			if($result == true) {
				echo "<p>" . $id . "\t" . $description . "</p>";
			} else {
				header('location: dbError.php');
			}
		}
	}

	static function addToCart($id, $qty) {
		if($id != "" && $qty != "") {
			require_once("Database.php");
			$connection = Database::dbConnect();
			$safeID = $connection->real_escape_string($id);
			$safeqty = $connection->real_escape_string($qty);

			$sqlOld = "SELECT DISTINCT quantity FROM products WHERE id='$safeID'";
			$resultOld = Database::dbQuery($sqlOld);
			$numOfResults = $resultOld->num_rows;
			if($numOfResults == 1) {
				$row = $resultOld->fetch_assoc();
			}
			$rivimaara = $row['quantity'];
			if($rivimaara < $qty) {
				require_once("Login.php");
				Login::profileDirector($_SESSION['username']);
				return false;
			}

			$sql = "INSERT INTO shoppingCart SELECT * FROM products WHERE id ='$safeID'";
			$result = Database::dbQuery($sql);
			if($result == true) {
				$sql = "UPDATE shoppingCart SET quantity='$safeqty' WHERE id='$safeID'";
				$result = Database::dbQuery($sql);
				if($result == true) {
				} else {
					header('location: dbError.php');
				}
			} else {
				header('location: dbError.php');
			}
		}
	}

	static function removeFromCart($id) {
		if($id != "") {
			require_once("Database.php");
			$connection = Database::dbConnect();
			$safeID = $connection->real_escape_string($id);
			$sql = "DELETE FROM shoppingCart WHERE id ='$safeID'";
			$result = Database::dbQuery($sql);
			if($result == true) {
				echo "<p>" . $id . "</p>";
				header('location: cartPage.php');
			} else {
				header('location: dbError.php');
			}
		}
	}

	static function payForStuff() {
		require_once("Database.php");

		$cartSql = "SELECT * FROM shoppingCart";
		$result = Database::dbQuery($cartSql);
		$cartTable = array();

		while($cartRow = mysqli_fetch_array($result)) {
			$cartTable[] = $cartRow;
		}
		$numOfResults = $result->num_rows;
		if($numOfResults == 0) {
			echo "Your cart is empty!";
			return false;
		}
		$sumTotal = 0;
		foreach($cartTable as $cartRow){
			$itemTotal = stripslashes($cartRow['quantity']) * stripslashes($cartRow['price']);
			$sumTotal += $itemTotal;
		}
		echo "<p>Cart total: " . $sumTotal . "€</p>";
		if($sumTotal <= $_SESSION['MONEY']) {

			$prodSql = "SELECT * FROM products";
			$prodResult = Database::dbQuery($prodSql);

			$prodTable = array();
			while($prodRow = mysqli_fetch_array($prodResult)) {
				$prodTable[] = $prodRow;
			}

			foreach($cartTable as $cartRivi) {
				foreach($prodTable as $prodRow) {
					if($prodRow['id'] == $cartRivi['id']) {
						$newQTY = stripslashes($prodRow['quantity'] - $cartRow['quantity']);
						Store::updateProductQuantity($prodRow['id'], $newQTY);
					}
				}
			}

			$_SESSION['MONEY'] = $_SESSION['MONEY'] - $sumTotal;
			$cartSql = "TRUNCATE shoppingCart";
			$result = Database::dbQuery($cartSql);
			header('location: purchaseOKPage.php');
		} else {
			echo "NOT ENOUGH MONEY!!";
			echo "<div><p>Money left: ".$_SESSION['MONEY']."</p></div>";
		}
	}

	static function addUser($id, $al, $user, $pw) {
		if($al != "" && $user != "" && $pw != "") {
			require_once("Database.php");
			$connection = Database::dbConnect();
			$safeID = $connection->real_escape_string($id);
			$safeal = $connection->real_escape_string($al);
			$safeuser = $connection->real_escape_string($user);
			$hashedPW = password_hash($pw, PASSWORD_DEFAULT);
			$sql = "INSERT INTO users (userID, accessLevel, username, password) VALUES ('$safeID', '$safeal', '$safeuser', '$hashedPW')";
			$result = Database::dbQuery($sql);
			if ($result == true) {
				echo "<p>" . $id . "\t" . $al . "\t" . $user . "\t" . $pw . "</p>";
			} else {
				header('location: dbError.php');
			}
		}
	}

	static function deleteUser($userID) {
		if($userID != "" && $userID != "1") {
			require_once("Database.php");
			$connection = Database::dbConnect();
			$safeid = $connection->real_escape_string($userID);
			$sql = "DELETE FROM users WHERE userID ='$safeid'";
			$result = Database::dbQuery($sql);
			if($result == true) {
				echo "<p>" . $userID . " removed" . "</p>";
			} else {
				header('location: dbError.php');
			}
		}
	}

	static function updateUserAccessLevel($id, $newAL) {
		if($id != "" && $newAL != "") {
			if($id == 1) {
				return false;
			}
			require_once("Database.php");
			$connection = Database::dbConnect();
			$safeid = $connection->real_escape_string($id);
			$safeal = $connection->real_escape_string($newAL);
			$sql = "UPDATE users SET accessLevel='$safeal' WHERE userID='$safeid'";
			$result = Database::dbQuery($sql);
			if($result == true) {
				echo "<p>" . $id . "\t" . $newAL . "</p>";
			} else {
				header('location: dbError.php');
			}
		}
	}

	static function updateUserPassword($id, $pw) {
		if($id != "" && $pw != "") {
			if($id == 1 && $_SESSION['username'] != "admin") {
				return false;
			}
			require_once("Database.php");
			$connection = Database::dbConnect();
			$safeid = $connection->real_escape_string($id);
			$hashedPW = password_hash($pw, PASSWORD_DEFAULT);
			$sql = "UPDATE users SET password='$hashedPW' WHERE userID='$safeid'";
			$result = Database::dbQuery($sql);
			if($result == true) {
				echo "<p>" . $id . "\t" . $pw . "</p>";
			} else {
				header('location: dbError.php');
			}
		}
	}

	static function updateOwnPassword($pw) {
		if($pw != "") {
			require_once("Database.php");

			$uuname = $_SESSION['username'];
			$hashedPW = password_hash($pw, PASSWORD_DEFAULT);
			$sql = "UPDATE users SET password='$hashedPW' WHERE username='$uuname'";
			$result = Database::dbQuery($sql);
			if($result == true) {
				echo "<p>" . $uuname . "\t" . $pw . "</p>";
			} else {
				header('location: dbError.php');
			}
		}
	}

	static function drawOrderedTable($order) {
		//$jaska = "description";
		require_once("Database.php");

		$connection = Database::dbConnect();
		$safeorder = $connection->real_escape_string($order);
		$sql = "SELECT * FROM products ORDER BY ".$safeorder." ASC;";
		$result = Database::dbQuery($sql);
		$table = array();
		
		while($row = mysqli_fetch_array($result)) {
			$table[] = $row;
		}

		echo "<table width=\"100%\" align=\"center\" class=\"bordered\" border=\"1\">
				<tr>
					<th>ID</th>
					<th>NAME</th>
					<th>CATEGORY</th>
					<th>QUANTITY</th>
					<th>PRICE</th>
					<th>DESCRIPTION</th>
				</tr>
		";

		foreach($table as $row){ 
			$productID = stripslashes($row['id']);
			$productName = stripslashes($row['name']);
			$productCategory = stripslashes($row['category']);
			$productQuantity = stripslashes($row['quantity']);
			$productPrice = stripslashes($row['price']);
			$productDescription = stripslashes($row['description']);
			$_POST['latestID'] = $productID;
			echo "
				<tr>
					<th>$productID</th>
					<th>$productName</th>
					<th>$productCategory</th>
					<th>$productQuantity</th>
					<th>".$productPrice."€</th>
					<th>$productDescription</th>
				</tr>
			";
		}
		echo "</table>";
	}

	static function drawTableUsers() {
		require_once("Database.php");
		$sql = "SELECT * FROM users ORDER BY userID ASC;";
		$result = Database::dbQuery($sql);
		$table = array();

		while($row = mysqli_fetch_array($result)) {
			$table[] = $row;
		}

		echo "<table width=\"100%\" align=\"center\" class=\"bordered\" border=\"1\">
				<tr>
					<th>User ID</th>
					<th>Access Level</th>
					<th>Username</th>
					
				</tr>
		";

		foreach($table as $row){
			$userID = stripslashes($row['userID']);
			$accessLevel = stripslashes($row['accessLevel']);
			$username = stripslashes($row['username']);

			echo "
				<tr>
					<th>$userID</th>
					<th>$accessLevel</th>
					<th>$username</th>
				</tr>
			";
		}
		echo "</table>";
	}

	static function drawTableCart() {
		require_once("Database.php");

		$sql = "SELECT * FROM shoppingCart ORDER BY id ASC;";
		$result = Database::dbQuery($sql);
		$table = array();

		while($row = mysqli_fetch_array($result)) {
			$table[] = $row;
		}
		if(count($table) == 0) {
			echo "<p>Cart is empty</p>";
			return false;
		}

		echo "<table width=\"100%\" align=\"center\" class=\"bordered\" border=\"1\">
				<tr>
					<th>ID</th>
					<th>NAME</th>
					<th>CATEGORY</th>
					<th>QUANTITY</th>
					<th>PRICE</th>
					<th>DESCRIPTION</th>
				</tr>
		";

		foreach($table as $row){
			$productID = stripslashes($row['id']);
			$productName = stripslashes($row['name']);
			$productCategory = stripslashes($row['category']);
			$productQuantity = stripslashes($row['quantity']);
			$productPrice = stripslashes($row['price']);
			$productDescription = stripslashes($row['description']);
			$_POST['latestID'] = $productID;
			echo "
				<tr>
					<th>$productID</th>
					<th>$productName</th>
					<th>$productCategory</th>
					<th>$productQuantity</th>
					<th>".$productPrice."€</th>
					<th>$productDescription</th>
				</tr>
			";
		}
		echo "</table>";
	}
}

?>
