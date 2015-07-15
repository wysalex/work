<?php
require_once('class/db_config.php');
require_once('class/db_class.php');

$db = new DB();

if (isset($_POST["action"]) && ($_POST["action"] == "delete")) {
	$delete_Book = "DELETE FROM `library` WHERE `id` = " . $_POST["id"];
	$db->bookQuery($delete_Book);
	$db->closeDB($link);
	header("location: index.php");
}
if (isset($_POST["action"]) && ($_POST["action"] == "export")) {
	header("Content-type: text/x-csv");
	header("Content-Disposition: attachment; filename=book.csv");
	$db->bookQuery($_POST["query"]);
	while($row = $db->fetch_array()){
		echo $row["isbn"] . ",";
		echo $row["publisher"] . ",";
		echo $row["book"] . ",";
		echo $row["author"] . ",";
		echo $row["price"] . ",";
		echo $row["publishdate"] . "\r\n";
	}
	$db->closeDB($link);
	exit;
}
if (isset($_POST["action"]) && ($_POST["action"] == "sort")) {
	if (!$_POST["condition"] || !$_POST["sort"]) {
		echo "<script language=javascript>";
		echo "alert('請選擇搜尋條件!');";
		echo "document.location.href='index.php';";
		echo "</script>";
		exit;
	}
	$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["condition"] . "` " . $_POST["sort"];
	$db->bookQuery($query_Library);
	$db->closeDB($link);
} else {
	$query_Library = "SELECT * FROM `library` ORDER BY `id`";
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	//$db->checkTable();
	$db->bookQuery($query_Library);
	$db->closeDB();
}
function trimArray($input) {
	if (!is_array($input))
		return trim($input);
	return array_map('trimArray', $input);
}
require_once('xhtml/list.html');
?>