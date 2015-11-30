<?php

header('Content-type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
	include_once '/opt/lampp/htdocs/practicePHP/htmls/login.html';
	exit;
}
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
	unset($_SESSION["loginMember"]);
	unset($_SESSION['serchName']);
	header("Location: /practicePHP/");
	exit;
}

include_once '/opt/lampp/htdocs/practicePHP/htmls/index.html';
