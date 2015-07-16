<?php
require_once('class/db_config.php');
require_once('class/db_class.php');

$db = new DB();

$query_Library = "SELECT * FROM `library` ORDER BY `id`";
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$db->checkTable($query_Library);
$db->closeDB();
if (isset($_POST["action"]) && ($_POST["action"] == "add")) {
	$insert_Book = "INSERT INTO `library` (`isbn`, `publisher`,`book`, `author`, `price`, `publishdate`) ";
	$insert_Book .= "VALUES ( '" . trim($_POST["isbn"]) . "',";
	$insert_Book .= "'" . trim($_POST["publisher"]) . "',";
	$insert_Book .= "'" . trim($_POST["book"]) . "',";
	$insert_Book .= "'" . trim($_POST["author"]) . "',";
	$insert_Book .= "'" . trim($_POST["price"]) . "',";
	$insert_Book .= "'" . trim($_POST["publishdate"]) . "')";
	
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$db->bookQuery($insert_Book);
	$db->closeDB();
	header("Location: index.php");
}
require_once('xhtml/insert.html');
?>