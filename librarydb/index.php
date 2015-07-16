<?php
require_once('class/db_config.php');
require_once('class/db_class.php');

$db = new DB();

switch ($_POST["action"]) {
	case 'delete':
		$delete_Book = "DELETE FROM `library` WHERE `id` = " . $_POST["id"];
		$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
		$db->bookQuery($delete_Book);
		$db->closeDB();
		header("location: index.php");
		exit;
		break;
	
	case 'export':
		$filename="book_" . date("Y/m/d_H:i:s") . ".csv";
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=$filename");
		$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["query"];
		$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
		$db->bookQuery($query_Library);
		echo chr(239).chr(187). chr(191);//BOM
		while($row = $db->fetch_assoc()){
			echo $row["isbn"] . ",";
			echo $row["publisher"] . ",";
			echo $row["book"] . ",";
			echo $row["author"] . ",";
			echo $row["price"] . ",";
			echo $row["publishdate"] . "\r\n";
		}
		$db->closeDB();
		exit;
		break;
	case 'sort':
		if (!$_POST["condition"] || !$_POST["sort"]) {
			echo "<script language=javascript>";
			echo "alert('請選擇搜尋條件!');";
			echo "document.location.href='index.php';";
				echo "</script>";
			exit;
		}
		$query = $_POST["condition"] . "` " . $_POST["sort"];
		$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["condition"] . "` " . $_POST["sort"];
		$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
		$db->bookQuery($query_Library);
		$db->closeDB();
		break;
	default:
		$query_Library = "SELECT * FROM `library` ORDER BY `id`";
		$query = "id`";
		$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
		$db->checkTable($query_Library);
		$db->bookQuery($query_Library);
		$db->closeDB();
		break;
}
require_once('xhtml/list.html');
?>