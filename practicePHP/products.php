<?php

header('Content-type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
	header("Location: /practicePHP/");
	exit;
}
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
	unset($_SESSION["loginMember"]);
	unset($_SESSION['serchItems']);
	header("Location: /practicePHP/");
	exit;
}

$dsn = "mysql:host=127.0.0.1;dbname=Practice";
$user = "root";
$passwd = "27050888";
$db = new PDO($dsn, $user, $passwd);
$db->exec("set names utf8");

if ($_POST['serchCondition']) {
	$_SESSION['serchItems'] = $_POST['serchCondition'];
} elseif ($_POST['clearSearch'] == 1) {
	unset($_SESSION['serchItems']);
}

$pageRow = 20;
$nPages = 1;

if (isset($_SESSION['serchItems']) && !empty($_SESSION['serchItems'])) {
	$aAllItems = searchItems($_SESSION['serchItems']);
} else {
	$aAllItems = getAllItems();
}

$totalLines = count($aAllItems);
$totalPages = ceil($totalLines / $pageRow);

if (isset($_GET["page"])) {
	if ($_GET["page"] > $totalPages || $_GET["page"] <= 0) {
		echo "<script language=javascript>";
		echo "alert('請輸入正確的頁數');";
		echo "document.location.href='products.php';";
		echo "</script>";
		exit;
	} else {
		$nPages = $_GET["page"];
	}
}

$startRow = ($nPages - 1) * $pageRow;
$endRow = $startRow + $pageRow;

$aDispData = array();
for ($i = $startRow; $i < $endRow; $i++) {
	if ($i >= $totalLines) {
		break;
	}
	$aDispData[] = $aAllItems[$i];
}

$sSearchPlaceHolder = "搜尋商品";
$aFields = array(
	array("size" => 100, "name" => "品牌"),
	array("size" => 340, "name" => "商品名稱"),
	array("size" => 120, "name" => "商品類型"),
	array("size" => 100, "name" => "售價"),
	array("size" => 340, "name" => "備註"),
);
$aContents = array();
foreach ($aDispData as $aCustomer) {
	$aContents[] = array(
		$aCustomer['brand'],
		$aCustomer['product'],
		$aCustomer['type'],
		$aCustomer['price'],
		$aCustomer['remark'],
	);
}

include_once '/opt/lampp/htdocs/practicePHP/htmls/products.html';

function getAllItems() {
	global $db;
	$querySQL = "SELECT * FROM `Products`";
	$result = $db->query($querySQL);
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$aAllItems[] = $row;
	}
	return $aAllItems;
}

function searchItems($serchCondition) {
	global $db;
	$querySQL = "SELECT * FROM `Products` WHERE `product` LIKE ";
	$querySQL .= "'%$serchCondition%'";
	$result = $db->query($querySQL);
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$aAllItems[] = $row;
	}
	return $aAllItems;
}
