<?php
$fp = fopen("/HDD/STATUSLOG/cpuinfo.log", "w+");
for ($i = 0; $i < 3500; $i++) {
	$c = $i + 1;
	$t = $i % 60;
	$str = "2015-08-13\t15:$t\t0.16\t0.64\t0.96\t95\t1\t4\t1\tinit\t2\tkthreadd\t3\tmigration/0\t$c\n";
	fwrite ($fp, $str);
}
fclose($fp);

echo "done";