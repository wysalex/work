<?php

session_start();

if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
	header("Location: /practicePHP/");
	exit;
}
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
	unset($_SESSION["loginMember"]);
	unset($_SESSION['serchName']);
	header("Location: /practicePHP/");
	exit;
}

$dsn = "mysql:host=127.0.0.1;dbname=Practice";
$user = "root";
$passwd = "27050888";
$db = new PDO($dsn, $user, $passwd);
$db->exec("set names utf8");

if ($_POST['serchName']) {
	$_SESSION['serchName'] = $_POST['serchName'];
} elseif ($_POST['clearSearch'] == 1) {
	unset($_SESSION['serchName']);
}
if (isset($_SESSION['serchName']) && !empty($_SESSION['serchName'])) {
	$aAllCustomer = searchCustomer($_SESSION['serchName']);
} else {
	$aAllCustomer = getAllCustomer();
}

$page_row_records = 20;
$num_pages = 1;
$total_lines = count($aAllCustomer);
$total_pages = ceil($total_lines / $page_row_records);

if (isset($_GET["page"])) {
	if ($_GET["page"] > $total_pages || $_GET["page"] <= 0) {
		echo "<script language=javascript>";
		echo "alert('請輸入正確的頁數');";
		echo "document.location.href='cpuInfo.php';";
		echo "</script>";
		exit;
	} else {
		$num_pages = $_GET["page"];
	}
}

$start_row_records = ($num_pages - 1) * $page_row_records;
$end_row_records = $start_row_records + 20;

function getAllCustomer() {
	global $db;
	$querySQL = "SELECT * FROM `Contact`";
	$result = $db->query($querySQL);

	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$aAllCustomer[] = $row;
	}
	return $aAllCustomer;
}

function searchCustomer($serchName) {
	global $db;
	$dbh = $db->prepare("SELECT * FROM `Contact` WHERE `name` = ?");
	$dbh->bindParam(1, $serchName, PDO::PARAM_STR);
	$dbh->execute();
	if ($result = $dbh->fetchAll()) {
		return $result;
	} else{
		return false;
	}
}

function listStringSplit($sList) {
	$aList = preg_split("/[\s]+/", $sList, -1, PREG_SPLIT_NO_EMPTY);
	return $aList;
}

include_once '/opt/lampp/htdocs/practicePHP/htmls/CustomerList.html';