<?php
/**
 * Created by PhpStorm.
 * User: micromikko
 * Date: 14.3.2017
 * Time: 23.31
 */

class Database {

    static function dbConnect() {
        if(!isset($connection)) {
	        $config = parse_ini_file('./config/config.ini');

            $connection = new mysqli($config['host'],$config['username'],$config['password'],$config['dbname']);
        }
        if(!$connection) {
			header("location: errorPage.php");
        }
        return $connection;
    }

    static function dbQuery($myQuery) {
        $connection = Database::dbConnect();
        $queryResult = $connection->query($myQuery);
        return $queryResult;
    }

    static function dbSelect($myQuery) {
        $rowList = array();
        $queryResult = Database::dbQuery($myQuery);
        if(!$queryResult) {
            return false;
        }
        for($i = 0; $i < mysqli_num_rows($queryResult); ++$i) {
            $rowList[$i] = $queryResult->fetch_assoc();
        }
        return $rowList;
    }

    static function dbError() {
        $connection = Database::dbConnect();
        return $connection->error;
    }

}
?>
