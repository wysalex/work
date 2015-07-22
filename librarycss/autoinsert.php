<?php
header('Content-type: text/html; charset=utf-8');

$link = @mysql_connect ('127.0.0.1', 'root', '27050888') or die ('link error!');

$database = @mysql_select_db(test, $link);

mysql_query("SET NAMES utf8");

for ($i = 1; $i < 51; $i++) { 
	$sql = "INSERT INTO `library` (`isbn`, `publisher`,`book`, `author`, `price`, `publishdate`) ";
	$sql .= "VALUES ( '" . $i . "',";
	$sql .= "'" . $i*3 . "',";
	$sql .= "'" . $i*2 . "',";
	$sql .= "'" . $i . "',";
	$sql .= "'" . rand(200,1000) . "',";
	$sql .= "'2004-07-21')";

	mysql_query($sql);
}


echo "done" . "\n";