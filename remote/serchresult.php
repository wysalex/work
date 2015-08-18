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
if (isset($_GET["clear"]) && ($_GET["clear"] == "true")) {
	unset($_SESSION["serchCondition"]);
	header("Location: /cpuInfo.php");
	exit;
}

if (!empty($_POST["serchCondition"])) {
	$_SESSION["serchCondition"] = escapeshellcmd(trim($_POST["serchCondition"]));
}

if (empty($_SESSION["serchCondition"])) {
	echo "<script language=javascript>";
	echo "alert('請輸入搜尋條件');";
	echo "document.location.href='cpuInfo.php';";
	echo "</script>";
	exit;
}

$serch_result = search_data($_SESSION["serchCondition"]);

$page_row_records = 20;
$num_pages = 1;

$total_lines = count($serch_result);
$total_pages = ceil($total_lines / $page_row_records);

if (isset($_GET["page"])) {
	if ($_GET["page"] > $total_pages || $_GET["page"] <= 0) {
		echo "<script language=javascript>";
		echo "alert('請輸入正確的頁數');";
		echo "document.location.href='serchresult.php';";
		echo "</script>";
		exit;
	} else {
		$num_pages = $_GET["page"];
	}
}

$start_row_records = ($num_pages - 1) * $page_row_records;
$end_row_records = $start_row_records + 20;

function search_data($input) {
	$trim_clean = trim($input);
	exec("tac /HDD/STATUSLOG/cpuinfo.log | grep '" . $trim_clean . "'", $resault);
	foreach ($resault as $str) {
		$serch_result[] = explode("\t", $str);
	}
	return $serch_result;
}

function listStringSplit($sList) {
	$aList = preg_split("/[\s,]+/", $sList, -1, PREG_SPLIT_NO_EMPTY);
	return $aList;
}

require_once "xhtml/serchresult.html";
?>