<?php

header('Content-type: text/html; charset=utf-8');

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
	insertNewProduct($row);
}

function insertNewProduct($row) {
	global $db;
	$dbh = $db->prepare("INSERT INTO Products (brand, product, type, price, remark) VALUES (?, ?, ?, ?, ?)");
	$dbh->bindParam(1, $row['brand'], PDO::PARAM_STR);
	$dbh->bindParam(2, $row['product'], PDO::PARAM_STR);
	$dbh->bindParam(3, $row['type'], PDO::PARAM_STR);
	$dbh->bindParam(4, $row['price'], PDO::PARAM_STR);
	$dbh->bindParam(5, $row['remark'], PDO::PARAM_STR);
	if ($dbh->execute()) {
		echo "<script language=javascript>";
		echo "alert('新增成功');";
		echo "document.location.href='products.php';";
		echo "</script>";
		exit;
	} else {
		echo "<script language=javascript>";
		echo "alert('新增失敗');";
		echo "document.location.href='newProduct.php';";
		echo "</script>";
		return false;
	}
}

include_once '/opt/lampp/htdocs/practicePHP/htmls/newProduct.html';
