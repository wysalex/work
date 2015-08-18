#!/PGRAM/php/bin/php -q
<?php

$aCpu_info = cpu_info();
$str = join("\t", $aCpu_info);
$str = $str . "\n";
write_in_file($str);

function cpu_info() {
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

	exec("top -b -n 1 c", $cpuinfo);
	$cpu_tasks = listStringSplit(trim($cpuinfo[1]));
	$aCpu_info["totalTasks"] = $cpu_tasks[1];
	$aCpu_info["runTasks"] = $cpu_tasks[3];

	$cpu_percent = listStringSplit(trim($cpuinfo[2]));
	$aCpu_info["cpuPercent"] = 100 - trim(str_replace("%id", "", $cpu_percent[4]));

	$top_three[] = listStringSplit(trim($cpuinfo[7]));
	$top_three[] = listStringSplit(trim($cpuinfo[8]));
	$top_three[] = listStringSplit(trim($cpuinfo[9]));
	$aCpu_info["topOnePid"] = $top_three[0][0];
	$aCpu_info["topTwoPid"] = $top_three[1][0];
	$aCpu_info["topThreePid"] = $top_three[2][0];

	$aCpu_info["topOneComm"] = query_comm($top_three[0][0]);
	$aCpu_info["topTwoComm"] = query_comm($top_three[1][0]);
	$aCpu_info["topThreeComm"] = query_comm($top_three[2][0]);

	return $aCpu_info;
}

function write_in_file($input) {
	exec("wc -l /HDD/STATUSLOG/cpuinfo.log", $log_line);
	$line = listStringSplit($log_line[0]);
	if ($line[0] == 3500) {
		exec("sed -i '1d' /HDD/STATUSLOG/cpuinfo.log");
	}
	file_put_contents("/HDD/STATUSLOG/cpuinfo.log", $input, FILE_APPEND);
	return;
}

function query_comm($input) {
	exec("ps " . $input . " | tail -1 | cut -b 28-", $comm);
	return $comm[0];
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

?>