<?php
/**
 * Created by PhpStorm.
 * User: micromikko
 * Date: 20.3.2017
 * Time: 3.27
 */

require_once("SessionManager.php");
require_once("Store.php");
SessionManager::checkTimeout();
require_once("Store.php");

Store::payForStuff();

?>