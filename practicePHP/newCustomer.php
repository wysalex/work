<?php

session_start();

if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
	header("Location: /practicePHP/");
	exit;
}
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
	unset($_SESSION["loginMember"]);
	unset($_SESSION['serchName']);
	header("Location: /practicePHP/");
	exit;
}

$dsn = "mysql:host=127.0.0.1;dbname=Practice";
$user = "root";
$passwd = "27050888";
$db = new PDO($dsn, $user, $passwd);
$db->exec("set names utf8");

if (isset($_POST) && !empty($_POST)) {
	$row = $_POST;
	insertNewCustomer($row);
}

function insertNewCustomer($row) {
	global $db;
	$dbh = $db->prepare("INSERT INTO `Contact` (`name`, `phone`, `address`, `remark`) VALUES (?, ?, ?, ?)");
	$dbh->bindParam(1, $row['name'], PDO::PARAM_STR);
	$dbh->bindParam(2, $row['phone'], PDO::PARAM_STR);
	$dbh->bindParam(3, $row['address'], PDO::PARAM_STR);
	$dbh->bindParam(4, $row['remark'], PDO::PARAM_STR);
	$dbh->execute();
	if ($dbh->fetch()) {
		echo "<script language=javascript>";
		echo "alert('新增成功');";
		echo "document.location.href='CustomerList.php';";
		echo "</script>";
		exit;
	} else {
		echo "<script language=javascript>";
		echo "alert('新增失敗');";
		echo "document.location.href='CustomerList.php';";
		echo "</script>";
		return false;
	}
}

include_once '/opt/lampp/htdocs/practicePHP/htmls/newCustomer.html';