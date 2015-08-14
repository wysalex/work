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

$frequency = 1;
if (isset($_GET["freq"])) {
	$frequency = $_GET["freq"];
}

header("refresh: 60;url='cpuInfo.php?freq=" . $frequency . "'");

$aCpu_info = cpu_info();
if ($aCpu_info) {
	$str = join("\t", $aCpu_info);
	$str = $str . "\n";
	write_in_file($str);
}
$cpu_info_list = read_from_file();

$pageRow_records = 20;
$num_pages = 1;

exec("cat /HDD/STATUSLOG/cpuinfo.log | wc -l", $log_line);
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

function cpu_info() {
	global $frequency;

	$timestamp = time();
	exec("cat /HDD/STATUSLOG/cpuinfo.log | tail -1", $tmp);
	$aTmp = listStringSplit($tmp[0]);
	$last_time = "$aTmp[0]_$aTmp[1]";
	$datatime = date("Y-m-d_H:i", $timestamp);
	if ($datatime == $last_time) {
		return FALSE;
	}

	switch ($frequency) {
		case "1":
			$min = date("i", $timestamp);
			if (intval($min) % 1 != 0) {
				return FALSE;
			}
			break;
		case "3":
			$min = date("i", $timestamp);
			if (intval($min) % 3 != 0) {
				return FALSE;
			}
			break;
		case "5":
			$min = date("i", $timestamp);
			if (intval($min) % 5 != 0) {
				return FALSE;
			}
			break;
	}

	$aCpu_info = array();
	exec("date +'%Y-%m-%d\t%H:%M'", $time);
	$date_time = listStringSplit(trim($time[0]));
	$aCpu_info["date"] = trim($date_time[0]);
	$aCpu_info["time"] = trim($date_time[1]);

	exec("cat /proc/loadavg", $load_avg);
	$loadavg = listStringSplit(trim($load_avg[0]));
	$aCpu_info["oneMin"] = $loadavg[0];
	$aCpu_info["fiveMin"] = $loadavg[1];
	$aCpu_info["fifteenMin"] = $loadavg[2];

	exec("top -d 1 -b -n 1 c", $cpuinfo);
	$cpu_tasks = listStringSplit(trim($cpuinfo[1]));
	$aCpu_info["totalTasks"] = $cpu_tasks[1];
	$aCpu_info["runTasks"] = $cpu_tasks[3];

	$cpu_percent = listStringSplit(trim($cpuinfo[2]));
	$aCpu_info["cpuPercent"] = 100 - trim(str_replace("%id", "", $cpu_percent[4]));

	$top_three[] = listStringSplit(trim($cpuinfo[7]));
	$top_three[] = listStringSplit(trim($cpuinfo[8]));
	$top_three[] = listStringSplit(trim($cpuinfo[9]));
	$aCpu_info["topOnePid"] = $top_three[0][0];
	$aCpu_info["topOneComm"] = brackets_remove($top_three[0][11]);
	$aCpu_info["topTwoPid"] = $top_three[1][0];
	$aCpu_info["topTwoComm"] = brackets_remove($top_three[1][11]);
	$aCpu_info["topThreePid"] = $top_three[2][0];
	$aCpu_info["topThreeComm"] = brackets_remove($top_three[2][11]);

	return $aCpu_info;
}

function write_in_file($input) {
	exec("cat /HDD/STATUSLOG/cpuinfo.log | wc -l", $log_line);
	if ($log_line[0] == 3500) {
		exec("cat /HDD/STATUSLOG/cpuinfo.log | tail -3499", $aTmp);
		$fp = fopen("/HDD/STATUSLOG/cpuinfo.log", "w+");
		foreach ($aTmp as $str) {
			$str = $str . "\n";
			fwrite($fp, $str);
		}
		fclose($fp);
	}
	file_put_contents("/HDD/STATUSLOG/cpuinfo.log", $input, FILE_APPEND);
	return;
}

function read_from_file() {
	exec("tac /HDD/STATUSLOG/cpuinfo.log", $aTmp);
	foreach ($aTmp as $str) {
		$cpu_info_list[] = listStringSplit($str);
	}
	return $cpu_info_list;
}

function listStringSplit($sList) {
	$aList = preg_split("/[\s,]+/", $sList, -1, PREG_SPLIT_NO_EMPTY);
	return $aList;
}

function brackets_remove($string) {
	$left = str_replace("[", "", $string);
	$right = str_replace("]", "", $left);
	return $right;
}

require_once "xhtml/cpuInfo.html";
?>