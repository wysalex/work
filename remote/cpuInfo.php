<?php

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

$frequency = 60;
if ($_POST["frequency"]) {
	$frequency = $_POST["frequency"];
	header("refresh: " . $frequency . ";url='cpuInfo.php'");
} else {
	header("refresh: " . $frequency . ";url='cpuInfo.php'");
}

$aCpu_info = cpu_info();
$str = join("\t", $aCpu_info);
$str = $str . "\n";
write_in_file($str);

function cpu_info() {
	$aCpu_info = array();
	exec("top -d 1 -b -n 1 c", $cpuinfo);
//	print_r($cpuinfo);
	exec("uptime", $load_avg);
	$uptime = listStringSplit(trim($load_avg[0]));
	$aCpu_info["time"] = $uptime[0];
	$aCpu_info["oneMin"] = $uptime[7];
	$aCpu_info["fiveMin"] = $uptime[8];
	$aCpu_info["fifteenMin"] = $uptime[9];
//	$uptime = listStringSplit(trim($cpuinfo[0]));
//	print_r($uptime);
//	$aCpu_info["oneMin"] = $uptime[9];
//	$aCpu_info["fiveMin"] = $uptime[10];
//	$aCpu_info["fifteenMin"] = $uptime[11];
//	exec("ps aux | wc -l", $tasks_num);
//	$aCpu_info["totalTasks"] = $tasks_num[0] - 2;
//	exec("ps aux", $cpu_tasks);
//	foreach ($cpu_tasks as $cpu_task) {
//		$cputasks[] = listStringSplit(trim($cpu_task));
//	}
//	print_r($cputasks[50]);

	$cpu_tasks = listStringSplit(trim($cpuinfo[1]));
	$aCpu_info["totalTasks"] = $cpu_tasks[1];
	$aCpu_info["runTasks"] = $cpu_tasks[3];

//	exec("echo $((100 - $(vmstat|tail -1|awk '{print $15}')))", $cpu_usage);
//	$cpu_usage = trim($cpu_usage[0]);
//	$aCpu_info["cpuPercent"] = $cpu_usage[0];
	$cpu_percent = listStringSplit(trim($cpuinfo[2]));
	$aCpu_info["cpuPercent"] = 100 - trim(str_replace("%id", "", $cpu_percent[4]));
//	$aCpu_info["cpuPercent"] = 100 - trim($cpu_percent[7]);

	$top_three[] = listStringSplit(trim($cpuinfo[7]));
	$top_three[] = listStringSplit(trim($cpuinfo[8]));
	$top_three[] = listStringSplit(trim($cpuinfo[9]));
	$aCpu_info["topOnePid"] = $top_three[0][0];
	$aCpu_info["topOneComm"] = brackets_remove($top_three[0][11]);
	$aCpu_info["topTwoPid"] = $top_three[1][0];
	$aCpu_info["topTwoComm"] = brackets_remove($top_three[1][11]);
	$aCpu_info["topThreePid"] = $top_three[2][0];
	$aCpu_info["topThreeComm"] = brackets_remove($top_three[2][11]);
//print_r($aCpu_info);
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