<?php
header('Content-type: text/html; charset=utf-8');

class DB
{
	private $host = '127.0.0.1';
	private $username = 'root';
	private $password = '27050888';

	public $_dbConnect = 0;
	public $_queryResult = 0;

	function __construct($dbname) {
		$this->connect_db($dbname);
		$this->checkTable();
	}

	function connect_db($dbname){
		$dbconnect = @mysql_connect($this->host, $this->username, $this->password);
		if (!$dbconnect)
			die ('MySQL Link Error!');
		mysql_query("SET NAMES utf8");
		if (!mysql_select_db($dbname, $dbconnect)) {
			$create_Database = "CREATE DATABASE IF NOT EXISTS `" . $dbname . "` CHARACTER SET utf8 COLLATE utf8_general_ci";
			$result = mysql_query($create_Database);
		}
		$this->_dbConnect = $dbconnect;
		return true;
	}

	function checkTable() {
		$create_Table = "CREATE TABLE IF NOT EXISTS `library` (";
		$create_Table .= "id int(100) auto_increment PRIMARY KEY, ";
		$create_Table .= "isbn char(17) NOT NULL, ";
		$create_Table .= "publisher varchar(255) NOT NULL, ";
		$create_Table .= "book varchar(255) NOT NULL, ";
		$create_Table .= "author varchar(255) NOT NULL, ";
		$create_Table .= "price int(5) NOT NULL, ";
		$create_Table .= "publishdate date NOT NULL) ";
		$create_Table .= "CHARACTER SET utf8 COLLATE utf8_general_ci";
		return mysql_query($create_Table);
	}

	function bookQuery($sql) {
		return $this->_queryResult = mysql_query($sql);
	}

	function rawQuery($sql) {
		if (!mysql_query($sql)) {
			return false;
		}
		return mysql_query($sql);
	}

	function fetch_assoc() {
		if (!$this->_queryResult) {
			return false;
		}
		return mysql_fetch_assoc($this->_queryResult);
	}

	function raw_fetch_assoc($sql) {
		return mysql_fetch_assoc($sql);
	}

	function num_rows() {
		if (!$this->_queryResult) {
			return false;
		}
		return mysql_num_rows($this->_queryResult);
	}

	function closeDB() {
		mysql_close();
	}
}
?>