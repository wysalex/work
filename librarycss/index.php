<?php
require_once('class/db_class.php');

session_start();

$db = new DB('test');

//查詢出版社資訊
$query_RecBoard = "SELECT * FROM `publisher`";
$publisher = $db->bookQuery($query_RecBoard);
$pageRow_records = 16;
$num_pages = 1;
//如果翻頁則更新頁數
if (isset($_GET['page'])) {
	$num_pages = $_GET['page'];
}
//從第X筆開始列出
$startRow_records = ($num_pages -1) * $pageRow_records;
//預設搜尋條件
if (empty($_SESSION["sSortBy"])) {
	$_SESSION["sSortBy"] = "id`";
}
/*
if ($_POST["condition"]) {
	$sortBy = $_POST["condition"];
}
*/
$query_RecBoard = "SELECT * FROM `library` ORDER BY `" . $_SESSION["sSortBy"];
$all_RecBoard = $db->bookQuery($query_RecBoard);
$total_records = $db->num_rows();
//計算總頁數
$total_pages = ceil($total_records/$pageRow_records);
if ($_GET["page"] > $total_pages || $_GET["page"] <= 0) {
	header("location: index.php?page=1");
	exit;
}
/*
if ($_POST["condition"]) {
	if (!$_POST["condition"]) {
		echo "<script language=javascript>";
		echo "alert('請選擇正確的排序條件!');";
		echo "document.location.href=history.back();";
		echo "</script>";
		exit;
	}
	$queryCondition = $_POST["condition"];
	$_SESSION["sSortBy"] = $_POST["condition"];
	$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["condition"];
	$all_RecBoard = $db->bookQuery($query_Library);
	$total_records = $db->num_rows();
	//計算總頁數
	$total_pages = ceil($total_records/$pageRow_records);
	//限制顯示筆數的SQL敘述句
	$query_limit_RecBoard = $query_Library . " LIMIT " . $startRow_records . ", " . $pageRow_records;
	$db->checkTable();
	$db->bookQuery($query_limit_RecBoard);
	header("location: index.php");
	exit;
}
*/
if ($_REQUEST["export"]) {
	$filename = "book_" . date("Y/m/d_H:i:s") . ".csv";
	switch ($_POST["method"]) {
		case '':
			echo "<script language=javascript>";
			echo "alert('請選擇正確的匯出條件!');";
			echo "document.location.href=history.back();";
			echo "</script>";
			exit;
			break;

		case 'exportAll':
			header("Content-type: text/x-csv");
			header("Content-Disposition: attachment; filename=$filename");
			$query_Library = "SELECT * FROM `library` ORDER BY `" . $_SESSION["sSortBy"];
			$db->bookQuery($query_Library);
			echo chr(239) . chr(187) . chr(191);//BOM
			while ($row = $db->fetch_assoc()) {
				echo $row["isbn"] . ",";
				echo $row["publisher"] . ",";
				echo $row["book"] . ",";
				echo $row["author"] . ",";
				echo $row["price"] . ",";
				echo $row["publishdate"] . "\r\n";
			}
			exit;
			break;

		case 'exportPage':
			header("Content-type: text/x-csv");
			header("Content-Disposition: attachment; filename=$filename");
			$query_Library = "SELECT * FROM `library` ORDER BY `" . $_SESSION["sSortBy"] . " LIMIT " . $startRow_records . ", " . $pageRow_records;
			$db->bookQuery($query_Library);
			echo chr(239) . chr(187) . chr(191);//BOM
			while ($row = $db->fetch_assoc()) {
				echo $row["isbn"] . ",";
				echo $row["publisher"] . ",";
				echo $row["book"] . ",";
				echo $row["author"] . ",";
				echo $row["price"] . ",";
				echo $row["publishdate"] . "\r\n";
			}
			exit;
			break;

		case 'exportSelect':
			$aSelect = $_POST['checkbox'];
			header("Content-type: text/x-csv");
			header("Content-Disposition: attachment; filename=$filename");
			echo chr(239) . chr(187) . chr(191);//BOM
			foreach ($aSelect as $select) {
				$query_Library = "SELECT * FROM `library` WHERE `id` = " . $select;
				$db->bookQuery($query_Library);
				while ($row = $db->fetch_assoc()) {
					echo $row["isbn"] . ",";
					echo $row["publisher"] . ",";
					echo $row["book"] . ",";
					echo $row["author"] . ",";
					echo $row["price"] . ",";
					echo $row["publishdate"] . "\r\n";
				}
			}
			exit;
			break;
	}
} elseif ($_REQUEST["condition"]) {
	$queryCondition = $_POST["condition"];
	$_SESSION["sSortBy"] = $_POST["condition"];
	$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["condition"];
	$all_RecBoard = $db->bookQuery($query_Library);
	$total_records = $db->num_rows();
	//計算總頁數
	$total_pages = ceil($total_records/$pageRow_records);
	//限制顯示筆數的SQL敘述句
	$query_limit_RecBoard = $query_Library . " LIMIT " . $startRow_records . ", " . $pageRow_records;
	$db->checkTable();
	$db->bookQuery($query_limit_RecBoard);
	header("location: index.php");
	exit;
} elseif ($_REQUEST["pagebutton"]) {
	if ($_POST["page"] > $total_pages||$_POST["page"] <= 0) {
		echo "<script language=javascript>";
		echo "alert('請輸入正確的數字!');";
		echo "document.location.href='index.php';";
		echo "</script>";
		exit;
	}
	header("location: ?page=". $_POST["page"]);
	exit;
} elseif ($_REQUEST["deletebutton"]) {
	$delete_Book = "DELETE FROM `library` WHERE `id` = " . $_POST["id"];
	$db->bookQuery($delete_Book);
	header("location: index.php");
	exit;
} else {
	$queryCondition = "id`";
	if (empty($_SESSION["sSortBy"])) {
		$_SESSION["sSortBy"] = $queryCondition;
	}
	$query_RecBoard = "SELECT * FROM `library` ORDER BY `" . $_SESSION["sSortBy"];
	$all_RecBoard = $db->bookQuery($query_RecBoard);
	$total_records = $db->num_rows();
	//計算總頁數
	$total_pages = ceil($total_records/$pageRow_records);
	//限制顯示筆數的SQL敘述句
	$query_limit_RecBoard = $query_RecBoard . " LIMIT " . $startRow_records . ", " . $pageRow_records;
	$db->checkTable();
	$db->bookQuery($query_limit_RecBoard);
}
require_once('xhtml/list.html');
?>