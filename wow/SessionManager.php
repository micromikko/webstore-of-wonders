<?php

class SessionManager {
	
	static function startSession() {
		session_start();
	}
	
	static function sessionLogout() {
		SessionManager::startSession();
		session_unset();
		session_destroy();
		return true;
	}
	
	static function checkTimeout() {
		SessionManager::startSession();
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
			SessionManager::sessionLogout();
			header('location: logoutPage.php');
		}
		$_SESSION['LAST_ACTIVITY'] = time();
	}
}

?>