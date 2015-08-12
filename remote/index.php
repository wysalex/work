<?php

session_start();

require_once("class/linkdb.php");

$db = new DB("admin");

$sql = "SELECT * FROM `manager`";
$result = $db->rawQuery($sql);
$row = $db->raw_fetch_assoc($result);
$username = $row["username"];
$passwd = $row["passwd"];

if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
	if (isset($_POST["username"]) && isset($_POST["passwd"])) {
		$insUsername = cleanInput($_POST["username"]);
		$insPasswd = cleanInput($_POST["passwd"]);
		if (($insUsername == $username) && ($insPasswd == $passwd)) {
			$_SESSION["loginMember"] = $username;
			header("Location: cpuInfo.php");
		} else {
			header("Location: index.php");
		}
	}
} else {
	header("Location: cpuInfo.php");
}

function cleanInput($input) {
	$clean = strtolower($input);
	$clean = preg_replace("/[^a-z]/", "", $clean);
	$clean = substr($clean, 0, 12);
	return $clean;
}

require_once "xhtml/login.html";
?>