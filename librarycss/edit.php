<?php
require_once('class/db_class.php');

$db = new DB('test');

if (isset($_POST['action']) && ($_POST['action'] == 'update')) {
	$update_Book = "UPDATE `library` SET ";
	$update_Book .= " `publisher` = '" . trim($_POST["publisher"]) . "',";
	$update_Book .= " `book` = '" . trim($_POST["book"]) . "',";
	$update_Book .= " `author` = '" . trim($_POST["author"]) . "',";
	$update_Book .= " `price` = '" . trim($_POST["price"]) . "',";
	$update_Book .= " `publishdate` = '" . trim($_POST["publishdate"]) . "'";
	$update_Book .= "WHERE `id` = " . trim($_POST["id"]);

	$db->bookQuery($update_Book);
	$db->closeDB();
	header('Location: index.php');
	exit;
}

if ($_GET['id']) {
	$query_Book = "SELECT * FROM `library` WHERE `id` = " . $_GET['id'];
	$db->bookQuery($query_Book);
	$row = $db->fetch_assoc();
	$db->closeDB();
} else {
	echo "<script language=javascript>";
	echo "alert('no data!');";
	echo "document.location.href='index.php';";
	echo "</script>";
	exit;
}
require_once('xhtml/edit.html');
?>