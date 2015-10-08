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

include_once '/opt/lampp/htdocs/practicePHP/htmls/items.html';