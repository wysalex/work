<?php

class DB {
	private $db_host = ":/tmp/mysql.sock";
	private $db_username = "root";
	private $db_passwd = "l7fwmysql";

	function __construct($dbname) {
		$conn = $this->create_conn();
		$this->select_db($dbname, $conn);
		// $this->check_table();
		// $this->check_user();
	}

	function create_conn() {
		$link = mysql_connect($this->db_host, $this->db_username, $this->db_passwd);
		if (!$link) {
			die("MySQL Link Error!");
		} else {
			mysql_query("SET NAMES utf8");
		}
		return $link;
	}

	function select_db($dbname, $dbconnect) {
		// if (!mysql_select_db($dbname, $dbconnect)) {
		// 	$create_Database = "CREATE DATABASE IF NOT EXISTS `" . $dbname . "` CHARACTER SET utf8 COLLATE utf8_general_ci";
		// 	mysql_query($create_Database);
		// }
		// return true;
		return mysql_select_db($dbname, $dbconnect);
	}

	// function check_table() {
	// 	$create_Table = "CREATE TABLE IF NOT EXISTS `manager` (";
	// 	$create_Table .= "id int(100) auto_increment PRIMARY KEY, ";
	// 	$create_Table .= "username varchar(255) NOT NULL, ";
	// 	$create_Table .= "passwd varchar(255) NOT NULL) ";
	// 	$create_Table .= "CHARACTER SET utf8 COLLATE utf8_general_ci";
	// 	return mysql_query($create_Table);
	// }

//	function check_user() {
//		$insert = "REPLACE INTO `admin`.`manager`(`id`, `username`, `passwd`) VALUES ('1', 'admin', 'admin')";
//		mysql_query($insert);
//	}

	function rawQuery($sql) {
		$query = mysql_query($sql);
		if (!$query) {
			return false;
		}
		return $query;
	}

	function raw_fetch_assoc($sql) {
		$fetch = mysql_fetch_assoc($sql);
		if (!$fetch) {
			return false;
		}
		return $fetch;
	}
}

?>