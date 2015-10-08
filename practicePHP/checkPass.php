<?php

header('Content-type: text/html; charset=utf-8');

$dsn = "mysql:host=127.0.0.1;dbname=Practice";
$user = "root";
$passwd = "27050888";

$db = new PDO($dsn, $user, $passwd);

$dbh = $db->prepare("SELECT * FROM `Account` WHERE `username` LIKE ? AND `passwd` LIKE ?");

session_start();

if (isset($_POST)) {
	strLengthCheck($_POST['passwd']);
	$dbh->bindParam(1, $_POST['username'], PDO::PARAM_STR);
	$dbh->bindParam(2, $_POST['passwd'], PDO::PARAM_STR);
	$dbh->execute();
	if ($dbh->fetch()) {
		$_SESSION["loginMember"] = $_POST['username'];
		echo "<script language=javascript>";
		echo "alert('進入系統');";
		echo "document.location.href='index.php';";
		echo "</script>";
		exit;
	} else {
		echo "<script language=javascript>";
		echo "alert('帳號或密碼錯誤');";
		echo "document.location.href='index.php';";
		echo "</script>";
		exit;
	}
}

function strLengthCheck($input) {
	if (strlen($input) == 12) {
		echo "<script language=javascript>";
		echo "alert('密碼長度有誤');";
		echo "document.location.href='';";
		echo "</script>";
		exit;
	}
	return $input;
}