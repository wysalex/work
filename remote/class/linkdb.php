<?php

class DB {
	private $db_host = ":/tmp/mysql.sock";
	private $db_username = "root";
	private $db_passwd = "l7fwmysql";

	function __construct($dbname) {
		$conn = $this->create_conn();
		$this->select_db($dbname, $conn);
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
		return mysql_select_db($dbname, $dbconnect);
	}

	function escape_word($input) {
		return mysql_real_escape_string($input);
	}

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