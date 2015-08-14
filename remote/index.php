<?php

header('Content-type: text/html; charset=utf-8');

session_start();

require_once("class/linkdb.php");

$db = new DB("admin");

if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
	if (isset($_POST["username"]) && isset($_POST["passwd"])) {
		$ins_username = cleanInput($_POST["username"]);
		$ins_passwd = cleanInput($_POST["passwd"]);
		if (!empty($ins_username) && !empty($ins_passwd)) {
			$serch_sql = "SELECT * FROM `manager` WHERE `username` = '" . $ins_username . "'";
			$result = $db->rawQuery($serch_sql);
			$row = $db->raw_fetch_assoc($result);
			if ($row["username"] == $ins_username) {
				if ($row["passwd"] == $ins_passwd) {
					$_SESSION["loginMember"] = $ins_username;
					echo "<script language=javascript>";
					echo "alert('Welcome');";
					echo "document.location.href='cpuInfo.php';";
					echo "</script>";
					exit;
				} else {
					echo "<script language=javascript>";
					echo "alert('帳號或密碼錯誤!!!');";
					echo "document.location.href='';";
					echo "</script>";
					exit;
				}
			} else {
				echo "<script language=javascript>";
				echo "alert('帳號或密碼錯誤!!!');";
				echo "document.location.href='';";
				echo "</script>";
				exit;
			}
		}
	}
} else {
	header("Location: cpuInfo.php");
	exit;
}

function cleanInput($input) {
	$clean = strtolower($input);
	$clean = preg_replace("/[^a-z0-9]/", "", $clean);
	$clean = substr($clean, 0, 12);
	return $clean;
}

require_once "xhtml/login.html";
?>