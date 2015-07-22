<?php
require_once('class/db_class.php');

$db = new DB('test');

$sort = $_GET['uSort'];
$pageRow_records = 16;
$num_pages = 1;
//if trun the page then update $num_page
if (isset($_GET['page'])) {
	$num_pages = floor($_GET['page']);
}
if (isset($_GET['uSort'])) {
	$aSortBy = explode("_", $sort);
}
//start from x line
$startRow_records = ($num_pages -1) * $pageRow_records;
//default sort method
if (!$aSortBy) {
	$aSortBy[0] = 'id';
}

$query_RecBoard = "SELECT * FROM `library` ORDER BY `" . $aSortBy[0] . "` " . $aSortBy[1];
$db->bookQuery($query_RecBoard);
$total_records = $db->num_rows();
//calculate the total number of pages
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
			echo "document.location.href='index.php';";
			echo "</script>";
			exit;
			break;

		case 'exportAll':
			header('Content-type: text/x-csv');
			header("Content-Disposition: attachment; filename=$filename");
			$query_Library = "SELECT * FROM `library` ORDER BY `" . $aSortBy[0] . "` " . $aSortBy[1];
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
			header("Content-Disposition: attachment; filename=$filename");
			$query_Library = "SELECT * FROM `library` ORDER BY `" . $aSortBy[0] . "` " . $aSortBy[1] . " LIMIT " . $startRow_records . ", " . $pageRow_records;
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
			if (empty($_POST['checkbox'])) {
				echo "<script language=javascript>";
				echo "alert('請選擇需要的匯出項目!');";
				echo "document.location.href='index.php';";
				echo "</script>";
				exit;
			}
			$aSelect = $_POST['checkbox'];
			header('Content-type: text/x-csv');
			header("Content-Disposition: attachment; filename=$filename");
			echo chr(239) . chr(187) . chr(191);//BOM
			$select = join("' OR `id` = '", $aSelect);
			$query_Library = "SELECT * FROM `library` WHERE `id` = '" . $select . "' ORDER BY `" . $aSortBy[0] . "` " . $aSortBy[1];
			$db->bookQuery($query_Library);
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
	}
} elseif ($_REQUEST['sortBy']) {
	$sort = $_POST['sortBy'];
	header('location: ?uSort=' . $sort . '&page=1');
	exit;
} elseif ($_REQUEST['pageButton']) {
	if ($_GET['uSort']) {
		$sort = $_GET['uSort'];
		$page = floor($_POST['page']);
		if ($page > $total_pages||$page <= 0) {
			echo "<script language=javascript>";
			echo "alert('請輸入正確的數字!');";
			echo "document.location.href='index.php';";
			echo "</script>";
			exit;
		}
	header("location: ?uSort=" . $sort . "&page=" . $page);
	exit;
	}
	$page = floor($_POST['page']);
	if ($page > $total_pages||$page <= 0) {
		echo "<script language=javascript>";
		echo "alert('請輸入正確的數字!');";
		echo "document.location.href='index.php';";
		echo "</script>";
		exit;
	}
	header("location: ?page=" . $page);
	exit;
} elseif ($_REQUEST['deleteButton']) {
	$delete_Book = "DELETE FROM `library` WHERE `id` = " . $_POST['id'];
	$db->bookQuery($delete_Book);
	header('location: index.php');
	exit;
} else {
	//limit the number of display
	$query_limit_RecBoard = $query_RecBoard . " LIMIT " . $startRow_records . ", " . $pageRow_records;
	//$db->checkTable();
	$db->bookQuery($query_limit_RecBoard);
}
require_once('xhtml/list.html');
?>