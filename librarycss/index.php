<?php
require_once('class/db_class.php');

session_start();

$db = new DB('test');

$pageRow_records = 16;
$num_pages = 1;
//如果翻頁則更新頁數
if (isset($_GET['page'])) {
	$num_pages = floor($_GET['page']);
}
//從第X筆開始列出
$startRow_records = ($num_pages -1) * $pageRow_records;
//預設搜尋條件
if (empty($_SESSION['sSortBy'])) {
	$_SESSION['sSortBy'] = 'id`';
}

$query_RecBoard = "SELECT * FROM `library` ORDER BY `" . $_SESSION['sSortBy'];
$db->bookQuery($query_RecBoard);
$total_records = $db->num_rows();
//計算總頁數
$total_pages = ceil($total_records/$pageRow_records);

if (isset($_GET['page'])) {
	if ($_GET['page'] > $total_pages || $_GET['page'] <= 0) {
	header('location: index.php');
	exit;
	}
}

if ($_REQUEST['export']) {
	$filename = 'book_' . date('Y/m/d_H:i:s') . '.csv';
	switch ($_POST['method']) {
		case '':
			echo "<script language=javascript>";
			echo "alert('請選擇正確的匯出條件!');";
			echo "document.location.href=history.back();";
			echo "</script>";
			exit;
			break;

		case 'exportAll':
			header('Content-type: text/x-csv');
			header('Content-Disposition: attachment; filename=$filename');
			$query_Library = "SELECT * FROM `library` ORDER BY `" . $_SESSION['sSortBy'];
			$db->bookQuery($query_Library);
			echo chr(239) . chr(187) . chr(191);//BOM
			while ($row = $db->fetch_assoc()) {
				echo $row['isbn'] . ',';
				echo $row['publisher'] . ',';
				echo $row['book'] . ',';
				echo $row['author'] . ',';
				echo $row['price'] . ',';
				echo $row['publishdate'] . "\r\n";
			}
			exit;
			break;

		case 'exportPage':
			header('Content-type: text/x-csv');
			header('Content-Disposition: attachment; filename=$filename');
			$query_Library = "SELECT * FROM `library` ORDER BY `" . $_SESSION['sSortBy'] . " LIMIT " . $startRow_records . ", " . $pageRow_records;
			$db->bookQuery($query_Library);
			echo chr(239) . chr(187) . chr(191);//BOM
			while ($row = $db->fetch_assoc()) {
				echo $row['isbn'] . ',';
				echo $row['publisher'] . ',';
				echo $row['book'] . ',';
				echo $row['author'] . ',';
				echo $row['price'] . ',';
				echo $row['publishdate'] . "\r\n";
			}
			exit;
			break;

		case 'exportSelect':
			$aSelect = $_POST['checkbox'];
			header('Content-type: text/x-csv');
			header('Content-Disposition: attachment; filename=$filename');
			echo chr(239) . chr(187) . chr(191);//BOM
			foreach ($aSelect as $select) {
				$query_Library = "SELECT * FROM `library` WHERE `id` = " . $select;
				$db->bookQuery($query_Library);
				while ($row = $db->fetch_assoc()) {
					echo $row['isbn'] . ',';
					echo $row['publisher'] . ',';
					echo $row['book'] . ',';
					echo $row['author'] . ',';
					echo $row['price'] . ',';
					echo $row['publishdate'] . "\r\n";
				}
			}
			exit;
			break;
	}
} elseif ($_REQUEST['sortBy']) {
	$_SESSION['sSortBy'] = $_POST['sortBy'];
	$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST['sortBy'];
	//限制顯示筆數的SQL敘述句
	$query_limit_RecBoard = $query_Library . " LIMIT " . $startRow_records . ", " . $pageRow_records;
	$db->checkTable();
	$db->bookQuery($query_limit_RecBoard);
	header('location: index.php');
	exit;
} elseif ($_REQUEST['pageButton']) {
	$page = floor($_POST['page']);
	if ($page > $total_pages||$page <= 0) {
		echo "<script language=javascript>";
		echo "alert('請輸入正確的數字!');";
		echo "document.location.href='index.php';";
		echo "</script>";
		exit;
	}
	header('location: ?page='. $page);
	exit;
} elseif ($_REQUEST['deleteButton']) {
	$delete_Book = "DELETE FROM `library` WHERE `id` = " . $_POST['id'];
	$db->bookQuery($delete_Book);
	unset($_SESSION['sSortBy']);
	header('location: index.php');
	exit;
} else {
	//限制顯示筆數的SQL敘述句
	$query_limit_RecBoard = $query_RecBoard . " LIMIT " . $startRow_records . ", " . $pageRow_records;
	$db->checkTable();
	$db->bookQuery($query_limit_RecBoard);
}
require_once('xhtml/list.html');
?>