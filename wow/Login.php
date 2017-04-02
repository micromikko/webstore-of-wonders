<?php
/**
 * Created by PhpStorm.
 * User: micromikko
 * Date: 14.3.2017
 * Time: 19.34
 */

ob_start();
class Login {

    static function checkLoginStatus() {
	    if (isset($_SESSION['username']) && $_SESSION['ACCESLEVEL'] > '0') {
		    $_SESSION['name'] = $_SESSION['username'];
	    } else {
		    header('location: index.php');
	    }
    }

	static function checkLoginStatusAdmin() {
		if (isset($_SESSION['username']) && $_SESSION['ACCESLEVEL'] == '1') {
			$_SESSION['name'] = $_SESSION['username'];
			$_SESSION['MONEY'] = 100000000;
		} else {
			header('location: index.php');
		}
	}

	static function checkLoginStatusEmployee() {
		if (isset($_SESSION['username']) && $_SESSION['ACCESLEVEL'] == '3') {
			$_SESSION['name'] = $_SESSION['username'];
			$_SESSION['MONEY'] = 30000;
		} else {
			header('location: index.php');
		}
	}

	static function checkLoginStatusCustomer() {
		if (isset($_SESSION['username']) && $_SESSION['ACCESLEVEL'] == '5') {
			$_SESSION['name'] = $_SESSION['username'];
			$_SESSION['MONEY'] = 5000;
		} else {
			header('location: index.php');
		}
	}

    static function checkCredentials() {
		require_once("Database.php");
		$connection = Database::dbConnect();
        $username = $connection->real_escape_string($_POST['username']);
        //$username = $_POST['username'];
        $pw = $_POST['password'];
	    $sql = "SELECT * FROM users WHERE username='$username'";
	    $result = Database::dbQuery($sql);
	    $numOfResults = $result->num_rows;
	    if($numOfResults == 1) {
	    	$row = $result->fetch_assoc();
	    }
	    $rivipassu = $row['password'];
	    $rivial = $row['accessLevel'];
	    $checkIfOK = password_verify($pw, $rivipassu);
	    if($checkIfOK){
			$_SESSION['username'] = $username;
			//*** extra
			$_SESSION['ACCESLEVEL'] = $rivial;
			switch($rivial) {
				case 1:
					$_SESSION['MONEY'] = 10000000;
					break;
				case 3:
					$_SESSION['MONEY'] = 30000;
					break;
				case 5:
					$_SESSION['MONEY'] = 5000;
					break;
				default:
					$_SESSION['MONEY'] = 10;
			}
			Login::profileDirector($username);
			return true;
		} else {
		    header("location: dbError.php");
		    return false;
	    }
    }
	
	static function pwHasher($password) {
		return password_hash($password, PASSWORD_DEFAULT);
	}

    static function profileDirector($user) {
    	require_once("Database.php");
	    $connection = Database::dbConnect();
		$safeUser = $connection->real_escape_string($user);
    	$sql = "SELECT DISTINCT accessLevel FROM users WHERE username='$safeUser'";
		$result = Database::dbQuery($sql);
		$row = mysqli_fetch_array($result);

        switch ($row['accessLevel']) {
            case 1:
                header("location: storeAdmin.php");
                break;
            case 3:
                header("location: storeEmployee.php");
                break;
            case 5:
                header("location: storeCustomer.php");
                break;
            default:
                header("location: errorPage.php");
				return false;
        }
		return true;
    }

    static function displayLoginForm() {
    	echo "
			<form action='' method='post'>
				<div class='field'>
					<input type='text' name='username'>
				</div>
			
				<div class='field'>
					<input type='password' name='password'>
				</div>
				<br>
				<div class='field'>
					<input type=\"submit\" class=\"button\" name=\"checker\" value=\"Login\" />
				</div>
			</form>
		";
    }

	static function logout() {
    	require_once("Database.php");
		$cartSql = "TRUNCATE shoppingCart";
		$result = Database::dbQuery($cartSql);
    	require_once("SessionManager.php");
		SessionManager::sessionLogout();
		echo 'You have successfully logged out and will be redirected to the login page in 5 seconds.';
		header('Refresh: 5; location: index.php');
	}

	static function debuggah() {
    	echo $_POST['username'];
		echo $_POST['password'];
	}
}
?>



