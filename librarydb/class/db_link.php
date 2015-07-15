<?php
header('Content-type: text/html; charset=utf-8');

$link = @mysql_connect ("127.0.0.1", "root", "27050888") or die ("link error!");

if (mysql_num_rows(mysql_query("SHOW DATABASES LIKE 'test'")) == 1) {
	$database = @mysql_select_db(test, $link);
	if (mysql_num_rows( mysql_query("SHOW TABLES LIKE 'library'")) == 0) {
		$create_Table = "CREATE TABLE library (";
		$create_Table .= "id int(100) auto_increment PRIMARY KEY, ";
		$create_Table .= "isbn char(17) NOT NULL, ";
		$create_Table .= "publisher varchar(255) NOT NULL, ";
		$create_Table .= "book varchar(255) NOT NULL, ";
		$create_Table .= "author varchar(255) NOT NULL, ";
		$create_Table .= "price int(5) NOT NULL, ";
		$create_Table .= "publishdate date NOT NULL) ";
		$create_Table .= "CHARACTER SET utf8 COLLATE utf8_general_ci";
		mysql_query($create_Table);
	}
} else {
	$create_Database = "CREATE DATABASE `test` CHARACTER SET utf8 COLLATE utf8_general_ci";
	mysql_query($create_Database);
}
mysql_query("SET NAMES 'utf8'");
?>