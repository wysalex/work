<?php
require_once('class/db_link.php');
require_once('class/db_class.php');

$db = new DB();

if (isset($_POST["action"]) && ($_POST["action"] == "add")) {
	$insert_Book = "INSERT INTO `library` (`isbn`, `publisher`,`book`, `author`, `price`, `publishdate`) ";
	$insert_Book .= "VALUES ( '" . $_POST["isbn"] . "',";
	$insert_Book .= "'" . $_POST["publisher"] . "',";
	$insert_Book .= "'" . $_POST["book"] . "',";
	$insert_Book .= "'" . $_POST["author"] . "',";
	$insert_Book .= "'" . $_POST["price"] . "',";
	$insert_Book .= "'" . $_POST["publishdate"] . "')";
	
	$db->bookQuery($insert_Book);
	$db->closeDB($link);
	header("Location: index.php");
}
require_once('xhtml/insert.html');
?>