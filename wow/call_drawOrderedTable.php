<?php
/**
 * Created by PhpStorm.
 * User: micromikko
 * Date: 19.3.2017
 * Time: 13.03
 */
require_once("SessionManager.php");
require_once("Store.php");
SessionManager::checkTimeout();
$q = intval($_GET['q']);

switch($q) {
	case 0:
		Store::drawOrderedTable("id");
		break;
	case 1:
		Store::drawOrderedTable("id");
		break;
	case 2:
		Store::drawOrderedTable("name");
		break;
	case 3:
		Store::drawOrderedTable("category");
		break;
	case 4:
		Store::drawOrderedTable("price");
		break;
	case 5:
		Store::drawTableUsers();
		break;
	default:
		Store::drawTableOrderID();

}

?>