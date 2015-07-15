<?php
require_once('class/db_link.php');
require_once('class/db_class.php');

$db = new DB();

if (isset($_POST["action"]) && ($_POST["action"] == "update")) {
	$update_Book = "UPDATE `library` SET ";
	$update_Book .= " `isbn` = '" . $_POST["isbn"] . "',";
	$update_Book .= " `publisher` = '" . $_POST["publisher"] . "',";
	$update_Book .= " `book` = '" . $_POST["book"] . "',";
	$update_Book .= " `author` = '" . $_POST["author"] . "',";
	$update_Book .= " `price` = '" . $_POST["price"] . "',";
	$update_Book .= " `publishdate` = '" . $_POST["publishdate"] . "'";
	$update_Book .= "WHERE `id` = " . $_POST["id"];

	$db->bookQuery($update_Book);
	$db->closeDB($link);
	//mysql_query($update_Book);
	header("Location: index.php");
}

if ($_GET["id"]) {
	$query_Book = "SELECT * FROM `library` WHERE `id` = " . $_GET["id"];
	$db->bookQuery($query_Book);
	$row = $db->fetch_array();
	$db->closeDB($link);
	//$book = mysql_query($query_Book);
	//$row = mysql_fetch_assoc($book);
} else {
	echo "<script language=javascript>";
	echo "alert('no data!');";
	echo "document.location.href='index.php';";
	echo "</script>";
}
require_once('xhtml/edit.html');
?>