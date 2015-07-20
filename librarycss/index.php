<?php
require_once('class/db_class.php');

$db = new DB('test');

//預設每頁筆數
$pageRow_records = 16;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
	$num_pages = $_GET['page'];
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages -1) * $pageRow_records;
$query_RecBoard = "SELECT * FROM `library` ORDER BY `id`";
$all_RecBoard = $db->bookQuery($query_RecBoard);
$total_records = $db->num_rows();
$total_pages = ceil($total_records/$pageRow_records);
/*
//預設每頁筆數
$pageRow_records = 16;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
	$num_pages = $_GET['page'];
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages -1) * $pageRow_records;
//未加限制顯示筆數的SQL敘述句
$query_RecBoard = "SELECT * FROM `library` ORDER BY `id`";
//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$query_limit_RecBoard = $query_RecBoard." LIMIT ".$startRow_records.", ".$pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecBoard 中
$RecBoard = mysql_query($query_limit_RecBoard);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecBoard 中
$all_RecBoard = mysql_query($query_RecBoard);
//計算總筆數
$total_records = mysql_num_rows($all_RecBoard);//echo $total_records;
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$total_pages = ceil($total_records/$pageRow_records);//echo $total_pages;
*/
if ($_REQUEST["export"]) {
	$filename="book_" . date("Y/m/d_H:i:s") . ".csv";
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
			$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["queryCondition"];
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
			$db->closeDB();
			exit;
			break;

		case 'exportPage':
			//$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["queryCondition"] . " LIMIT " . $_POST["start"] . ", " . $pageRow_records;echo $query_Library;exit;
			header("Content-type: text/x-csv");
			header("Content-Disposition: attachment; filename=$filename");
			$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["queryCondition"] . " LIMIT " . $_POST["start"] . ", " . $pageRow_records;
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
			$db->closeDB();
			exit;
			break;

		case 'exportSelect':
			$aSelect = $_POST['checkbox'];
			header("Content-type: text/x-csv");
			header("Content-Disposition: attachment; filename=$filename");
			echo chr(239) . chr(187) . chr(191);//BOM
			foreach ($aSelect as $select) {
				//echo $select;exit;
				$query_Library = "SELECT * FROM `library` WHERE `id` = " . $select;//echo $query_Library . "\n";
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
} elseif ($_REQUEST["sort"]) {
	if (!$_POST["condition"]) {
		echo "<script language=javascript>";
		echo "alert('請選擇正確的排序條件!');";
		echo "document.location.href=history.back();";
		echo "</script>";
		exit;
	}
	$queryCondition = $_POST["condition"];
	$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["condition"];
	$all_RecBoard = $db->bookQuery($query_Library);
	$total_records = $db->num_rows();
	$total_pages = ceil($total_records/$pageRow_records);
	//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
	$query_limit_RecBoard = $query_Library . " LIMIT " . $startRow_records . ", " . $pageRow_records;
	$db->checkTable();
	//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecBoard 中
	$db->bookQuery($query_limit_RecBoard);
	//close database
	$db->closeDB();
} elseif ($_REQUEST["pagebutton"]) {
	if ($_POST["page"] > $total_pages||$_POST["page"] <= 0) {
		echo "<script language=javascript>";
		echo "alert('請輸入正確的數字!');";
		echo "document.location.href=history.back();";
		echo "</script>";
		exit;
	}
	header("location: ?page=". $_POST["page"]);
	exit;
} elseif ($_REQUEST["deletebutton"]) {
	$delete_Book = "DELETE FROM `library` WHERE `id` = " . $_POST["id"];
	$db->bookQuery($delete_Book);
	$db->closeDB();
	header("location: index.php");
	exit;
} else {
	$queryCondition = "id`";
	$query_RecBoard = "SELECT * FROM `library` ORDER BY `id`";
	$all_RecBoard = $db->bookQuery($query_RecBoard);
	$total_records = $db->num_rows();
	$total_pages = ceil($total_records/$pageRow_records);
	//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
	$query_limit_RecBoard = $query_RecBoard . " LIMIT " . $startRow_records . ", " . $pageRow_records;//echo $query_limit_RecBoard;exit;
	$db->checkTable();
	//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecBoard 中
	$db->bookQuery($query_limit_RecBoard);
	//close database
	$db->closeDB();
}











/*
switch ($_POST["action"]) {
	//echo $_REQUEST["action"];exit;
	case 'delete':
		$delete_Book = "DELETE FROM `library` WHERE `id` = " . $_POST["id"];
		$db->bookQuery($delete_Book);
		$db->closeDB();
		header("location: index.php");
		exit;
		break;

	case 'export':
		//echo $_POST["method"];exit;
		$filename="book_" . date("Y/m/d_H:i:s") . ".csv";
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
				$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["queryCondition"];
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
				$db->closeDB();
				exit;
				break;

			case 'exportPage':
				//$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["queryCondition"] . " LIMIT " . $_POST["start"] . ", " . $pageRow_records;echo $query_Library;exit;
				header("Content-type: text/x-csv");
				header("Content-Disposition: attachment; filename=$filename");
				$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["queryCondition"] . " LIMIT " . $_POST["start"] . ", " . $pageRow_records;
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
				$db->closeDB();
				exit;
				break;

			case 'exportSelect':
				# code...
				break;
		}

		break;

	case 'sort':
		if (!$_POST["condition"]) {
			echo "<script language=javascript>";
			echo "alert('請選擇正確的排序條件!');";
			echo "document.location.href=history.back();";
			echo "</script>";
			exit;
		}
		$queryCondition = $_POST["condition"];
		$query_Library = "SELECT * FROM `library` ORDER BY `" . $_POST["condition"];
		$all_RecBoard = $db->bookQuery($query_Library);
		$total_records = $db->num_rows();
		$total_pages = ceil($total_records/$pageRow_records);
		//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
		$query_limit_RecBoard = $query_Library . " LIMIT " . $startRow_records . ", " . $pageRow_records;
		$db->checkTable();
		//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecBoard 中
		$db->bookQuery($query_limit_RecBoard);
		//close database
		$db->closeDB();
		break;

	case 'page':
		if ($_POST["page"] > $total_pages||$_POST["page"] <= 0) {
			echo "<script language=javascript>";
			echo "alert('請輸入正確的數字!');";
			echo "document.location.href=history.back();";
			echo "</script>";
			exit;
			break;
		}
		header("location: ?page=". $_POST["page"]);
		exit;
		break;

	case '':
		$queryCondition = "id`";
		$query_RecBoard = "SELECT * FROM `library` ORDER BY `id`";
		$all_RecBoard = $db->bookQuery($query_RecBoard);
		$total_records = $db->num_rows();
		$total_pages = ceil($total_records/$pageRow_records);
		//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
		$query_limit_RecBoard = $query_RecBoard . " LIMIT " . $startRow_records . ", " . $pageRow_records;//echo $query_limit_RecBoard;exit;
		$db->checkTable();
		//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecBoard 中
		$db->bookQuery($query_limit_RecBoard);
		//close database
		$db->closeDB();
		break;
}*/
require_once('xhtml/list.html');
?>