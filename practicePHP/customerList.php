<?php

header('Content-type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
	header("Location: /practicePHP/");
	exit;
}
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
	unset($_SESSION["loginMember"]);
	unset($_SESSION['serchCustomer']);
	header("Location: /practicePHP/");
	exit;
}

$dsn = "mysql:host=127.0.0.1;dbname=Practice";
$user = "root";
$passwd = "27050888";
$db = new PDO($dsn, $user, $passwd);
$db->exec("set names utf8");

if ($_POST['serchCondition']) {
	$_SESSION['serchCustomer'] = $_POST['serchCondition'];
} elseif ($_POST['clearSearch'] == 1) {
	unset($_SESSION['serchCustomer']);
}

$pageRow = 20;
$nPages = 1;

if (isset($_SESSION['serchCustomer']) && !empty($_SESSION['serchCustomer'])) {
	$aAllCustomer = searchCustomer($_SESSION['serchCustomer']);
} else {
	$aAllCustomer = getAllCustomer();
}

$totalLines = count($aAllCustomer);
$totalPages = ceil($totalLines / $pageRow);

if (isset($_GET["page"])) {
	if ($_GET["page"] > $totalPages || $_GET["page"] <= 0) {
		echo "<script language=javascript>";
		echo "alert('請輸入正確的頁數');";
		echo "document.location.href='customerList.php';";
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
	$aDispData[] = $aAllCustomer[$i];
}

$sSearchPlaceHolder = "搜尋客戶姓名";
$aFields = array(
	array("size" => 100, "name" => "姓名"),
	array("size" => 120, "name" => "電話"),
	array("size" => 340, "name" => "地址"),
	array("size" => 340, "name" => "項目"),
	array("size" => 120, "name" => "備註"),
);
$aContents = array();
foreach ($aDispData as $aCustomer) {
	$aContents[] = array(
		$aCustomer['name'],
		$aCustomer['phone'],
		$aCustomer['address'],
		"項目",
		$aCustomer['remark'],
	);
}

include_once '/opt/lampp/htdocs/practicePHP/htmls/customerList.html';

function getAllCustomer() {
	global $db;
	$querySQL = "SELECT * FROM `Contact`";
	$result = $db->query($querySQL);

	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$aAllCustomer[] = $row;
	}
	return $aAllCustomer;
}

function searchCustomer($serchCondition) {
	global $db;
	$querySQL = "SELECT * FROM `Contact` WHERE `name` LIKE ";
	$querySQL .= "'%$serchCondition%'";
	$result = $db->query($querySQL);
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$aAllCustomer[] = $row;
	}
	return $aAllCustomer;
}

function listStringSplit($sList) {
	$aList = preg_split("/[\s]+/", $sList, -1, PREG_SPLIT_NO_EMPTY);
	return $aList;
}
