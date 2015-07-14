<?php
header('Content-type: text/html; charset=utf-8');

$link = @mysql_connect ("127.0.0.1", "root", "27050888") or die ("link error!");

if (mysql_num_rows(mysql_query("SHOW DATABASES LIKE 'test'")) == 1) {
	$database = @mysql_select_db(test, $link);
	if (mysql_num_rows( mysql_query("SHOW TABLES LIKE 'contact'")) == 0) {
		$create_Table = "CREATE TABLE contact (";
		$create_Table .= "id int(100) auto_increment PRIMARY KEY, ";
		$create_Table .= "name varchar(40) NOT NULL, ";
		$create_Table .= "gender int(1), ";
		$create_Table .= "phone char(20), ";
		$create_Table .= "birthday char(20), ";
		$create_Table .= "address varchar(100), ";
		$create_Table .= "email varchar(50) ";
		$create_Table .= "CHARACTER SET utf8 COLLATE utf8_general_ci)";
		mysql_query($create_Table);
	}
} else {
	$create_Database = "CREATE DATABASE `test` CHARACTER SET utf8 COLLATE utf8_general_ci";
	mysql_query($create_Database);
}
mysql_query("SET NAMES 'utf8'");
?>
