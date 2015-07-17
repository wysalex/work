<?php
require_once('class/db_class.php');

$db = new DB('test');

if (isset($_POST["action"]) && ($_POST["action"] == "add")) {
	$insert_Book = "INSERT INTO `library` (`isbn`, `publisher`,`book`, `author`, `price`, `publishdate`) ";
	$insert_Book .= "VALUES ( '" . trim($_POST["isbn"]) . "',";
	$insert_Book .= "'" . trim($_POST["publisher"]) . "',";
	$insert_Book .= "'" . trim($_POST["book"]) . "',";
	$insert_Book .= "'" . trim($_POST["author"]) . "',";
	$insert_Book .= "'" . trim($_POST["price"]) . "',";
	$insert_Book .= "'" . trim($_POST["publishdate"]) . "')";

	$db->checkTable();
	$db->bookQuery($insert_Book);
	$db->closeDB();
	header("Location: index.php");
	exit;
}
require_once('xhtml/insert.html');
?>