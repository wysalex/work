<?php
class DB
{
	var $_dbConnect = 0;
	var $_queryResult = 0;
	function connect_db($host, $user, $pwd, $dbname){
		$dbconnect = @mysql_connect($host, $user, $pwd);
		if (!$dbconnect)
			die ("MySQL Link Error!");
		mysql_query("SET NAMES utf8");
		if (!mysql_select_db($dbname, $dbconnect)) {
			$create_Database = "CREATE DATABASE `test` CHARACTER SET utf8 COLLATE utf8_general_ci";
			$result = mysql_query($create_Database);
			mysql_free_result($result);
		}
		$create_Table = "CREATE TABLE IF NOT EXISTS library (";
		$create_Table .= "id int(100) auto_increment PRIMARY KEY, ";
		$create_Table .= "isbn char(17) NOT NULL, ";
		$create_Table .= "publisher varchar(255) NOT NULL, ";
		$create_Table .= "book varchar(255) NOT NULL, ";
		$create_Table .= "author varchar(255) NOT NULL, ";
		$create_Table .= "price int(5) NOT NULL, ";
		$create_Table .= "publishdate date NOT NULL) ";
		$create_Table .= "CHARACTER SET utf8 COLLATE utf8_general_ci";
		$result = mysql_query($create_Table);
		$this->_dbConnect = $dbconnect;
		return true;
	}
	/*function checkTable() {
		$create_Table = "CREATE TABLE IF NOT EXISTS library (";
		$create_Table .= "id int(100) auto_increment PRIMARY KEY, ";
		$create_Table .= "isbn char(17) NOT NULL, ";
		$create_Table .= "publisher varchar(255) NOT NULL, ";
		$create_Table .= "book varchar(255) NOT NULL, ";
		$create_Table .= "author varchar(255) NOT NULL, ";
		$create_Table .= "price int(5) NOT NULL, ";
		$create_Table .= "publishdate date NOT NULL) ";
		$create_Table .= "CHARACTER SET utf8 COLLATE utf8_general_ci";
		mysql_query($create_Table);
	}*/
	function bookQuery($sql) {
		if ($queryResult = mysql_query($sql))
			//die ("MySQL Query Error");
		$this->_queryResult = $queryResult;
		return $queryResult;
	}
	function fetch_array() {
		return mysql_fetch_assoc($this->_queryResult);
	}
	function fetch_row() {
		return mysql_fetch_row($this->_queryResult);
	}
	function closeDB() {
		mysql_close();
	}
}
?>