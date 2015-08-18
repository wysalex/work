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

if (isset($_POST["frequency"])) {
	set_frequency($_POST["frequency"]);
	$raw_freq = $_POST["frequency"];
} else {
	$raw_freq = get_frequency();
	if (empty($raw_freq)) {
		set_frequency(1);
		$raw_freq = 1;
	}
}

header("refresh: 60;url='cpuInfo.php'");

$cpu_info_list = read_from_file();

$page_row_records = 20;
$num_pages = 1;
$total_lines = count($cpu_info_list);
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

function read_from_file() {
	exec("tac /HDD/STATUSLOG/cpuinfo.log", $aTmp);
	foreach ($aTmp as $str) {
		$cpu_info_list[] = explode("\t", $str);
	}
	return $cpu_info_list;
}

function get_frequency() {
	exec("cat /addpkg/conf/crontab | grep '/PDATA/apache/update_cpu_info'", $cpu_info_cron);
	if (!empty($cpu_info_cron)) {
		$cron = listStringSplit($cpu_info_cron[0]);
		$freq = str_replace("*/", "", $cron[0]);
	} else {
		return "";
	}
	return $freq;
}

function set_frequency($freq) {
	exec("cat -n /addpkg/conf/crontab | grep '/PDATA/apache/update_cpu_info'", $freq_conf);
	if (!empty($freq_conf)) {
		$line = listStringSplit($freq_conf[0]);
		exec("sed -i '$line[0] d' /addpkg/conf/crontab");
		$ins_line = $line[0] -1;
	} else {
		exec("echo '' >> /addpkg/conf/crontab");
		exec("wc -l /addpkg/conf/crontab", $log_line);
		$total_line = listStringSplit($log_line[0]);
		$ins_line = $total_line[0];
	}

	$cron_base = " * * * * root /PGRAM/php/bin/php -q /PDATA/apache/update_cpu_info.php' /addpkg/conf/crontab";
	switch ($freq) {
		case "1":
			$cmd1 = "sed -i ' " . $ins_line . " a */1" . $cron_base;
			exec($cmd1);
			break;
		case "3":
			$cmd3 = "sed -i ' " . $ins_line . " a */3" . $cron_base;
			exec($cmd3);
			break;
		case "5":
			$cmd5 = "sed -i ' " . $ins_line . " a */5" . $cron_base;
			exec($cmd5);
			break;
	}
	exec("/etc/init.d/cron restart");
	return;
}

function listStringSplit($sList) {
	$aList = preg_split("/[\s]+/", $sList, -1, PREG_SPLIT_NO_EMPTY);
	return $aList;
}

require_once "xhtml/cpuInfo.html";
?>