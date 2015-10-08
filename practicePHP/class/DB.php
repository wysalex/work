<?php

class DB {

	private $host = "127.0.0.1";
	private $user = "root";
	private $passwd = "27050888";
	private $dsn = "mysql:host=127.0.0.1;dbname=Practice";
	var $db;
	var $queryResult;

	function __construct() {
		$this->dbConn();
	}

	function dbConn() {
		$this->db = new PDO($this->dsn, $this->user, $this->passwd);
		return true;
	}

	function queryDB($sql) {
		$this->queryResult = $this->db->query($sql);
		if (!$this->queryResult) {
			return false;
		}
		return $this->queryResult;
	}

	function fetchAssoc($sql) {
		$result = $this->queryDB($sql);
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	function closeDB() {
		$this->db = null;
	}

}
