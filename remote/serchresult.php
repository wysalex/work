<?php

header('Content-type: text/html; charset=utf-8');

session_start();

if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
	header("Location: /");
	exit;
}
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
	unset($_SESSION["loginMember"]);
	header("Location: /");
	exit;
}

if (!empty($_POST["serchCondition"])) {
	$serch_condition = $_POST["serchCondition"];
} else {
	echo "<script language=javascript>";
	echo "alert('請輸入搜尋條件');";
	echo "document.location.href='cpuInfo.php';";
	echo "</script>";
	exit;
}

$serch_result = search_data($serch_condition);

$pageRow_records = 20;
$num_pages = 1;

exec("cat /HDD/STATUSLOG/cpuinfo.log | grep '" . $serch_condition . "'| wc -l", $log_line);
$total_lines = $log_line[0];
$total_pages = ceil($total_lines / $pageRow_records);

if (isset($_GET["page"])) {
	$num_pages = $_GET["page"];
}

$startRow_records = ($num_pages - 1) * $pageRow_records;
$endRow_records = $startRow_records + 20;

if (isset($_GET["page"])) {
	if ($_GET["page"] > $total_pages || $_GET["page"] <= 0) {
		header("location: cpuInfo.php");
		exit;
	}
}

function search_data($input) {
	$trim_clean = trim($input);
	exec("tac /HDD/STATUSLOG/cpuinfo.log | grep '" . $trim_clean . "'", $resault);
	foreach ($resault as $str) {
		$serch_result[] = listStringSplit($str);
	}
	return $serch_result;
}

function listStringSplit($sList) {
	$aList = preg_split("/[\s,]+/", $sList, -1, PREG_SPLIT_NO_EMPTY);
	return $aList;
}

require_once "xhtml/serchresult.html";
?>