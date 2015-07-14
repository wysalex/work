<?php
header('Content-type: text/html; charset=utf-8');

if (isset($_POST["action"]) && ($_POST["action"] == "add")) {
	$book = $_POST["isbn"] . "," . $_POST["publisher"] . "," . $_POST["book"] . "," . $_POST["author"] . "," . $_POST["price"] . "," . $_POST["publishdate"] . "\r\n";
	file_put_contents("library.txt", stripslashes($book), FILE_APPEND);
	header("Location: index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>New Book</title>
	<h1 align="center">New Book</h1>
<script language=javascript>
function checkForm() {
	if (document.insertform.isbn.value == "") {
		alert("ISBN不可為空!");
		document.insertform.isbn.focus();
		return false;
	}
	if (document.insertform.isbn.value != "") {
		if (!checkIsbn(document.insertform.isbn)) {
			document.insertform.isbn.focus();
			return false;
		}
	}
	if (document.insertform.publisher.value == "") {
		alert("出版社不可為空!");
		document.insertform.publisher.focus();
		return false;
	}
	if (document.insertform.publisher.value != "") {
		if (!checkPublisher(document.insertform.publisher)) {
			document.insertform.publisher.focus();
			return false;
		}
	}
	if (document.insertform.book.value == "") {
		alert("書名不可為空!");
		document.insertform.book.focus();
		return false;
	}
	if (document.insertform.author.value == "") {
		alert("作者不可為空!");
		document.insertform.author.focus();
		return false;
	}
	if (document.insertform.author.value != "") {
		if (!checkAuthor(document.insertform.author)) {
			document.insertform.author.focus();
			return false;
		}
	}
	if (document.insertform.price.value == "") {
		alert("售價不可為空!");
		document.insertform.price.focus();
		return false;
	}
	if (document.insertform.price.value != "") {
		if (!checkPrice(document.insertform.price)) {
			document.insertform.price.focus();
			return false;
		}
	}
	if (document.insertform.publishdate.value == "") {
		alert("發行日不可為空!");
		document.insertform.publishdate.focus();
		return false;
	}
	if (document.insertform.publishdate.value != "") {
		if (!checkPublishdate(document.insertform.publishdate)) {
			document.insertform.publishdate.focus();
			return false;
		}
	}
	return confirm ("確認送出?");
}
function checkIsbn(myIsbn) {
	var number = /^(([0-9]{3}\-[0-9]{3}\-[0-9]{3}\-[0-9]{1})|([0-9]{3}\-[0-9]{3}\-[0-9]{3}\-[0-9]{3}\-[0-9]{1}))$/;
	if (number.test(myIsbn.value)) {
		return true;
	}
	alert("ISBN格式為: xxx-xxx-xxx-x or xxx-xxx-xxx-xxx-x");
	return false;
}
function checkPublisher(myPublisher) {
	var name = /^[\u4e00-\u9fa5A-Za-z0-9]+$/;
	if (name.test(myPublisher.value)) {
		return true;
	}
	alert("請確認出版社");
	return false;
}
function checkAuthor(myAuthor) {
	var nameAuthor = /^[\u4e00-\u9fa5A-Za-z\.]+$/;
	if (nameAuthor.test(myAuthor.value)) {
		return true;
	}
	alert("請確認作者");
	return false;
}
function checkPrice(myprice) {
	var price = /^[0-9]+$/;
	if (price.test(myprice.value)) {
		return true;
	}
	alert("請確認售價");
	return false;
}
function checkPublishdate(myPublishdate) {
	var date = /^(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/;
	if (date.test(myPublishdate.value)) {
		return true;
	}
	alert("請確認發行日期");
	return false;
}
</script>
</head>
<body>
<table align="center" width="500" border="1">
	<tr>
		<td>
			<form action="" method="POST" name="insertform" onsubmit="return checkForm();">
				ISBN:
				<input type="text" name="isbn" id="isbn" /></br>
				出版社:
				<input type="text" name="publisher" id="publisher" /></br>
				書名:
				<input type="text" name="book" id="book" /></br>
				作者:
				<input type="text" name="author" id="author" /></br>
				售價:
				<input type="text" name="price" id="price" /></br>
				發行日:
				<input type="date" name="publishdate" id="publishdate" /></br>
				<input type="hidden" name="action" id="action" value="add" />
				<input type="submit" name="submit" value="submit" />
				<input type="button" name="button" value="cancel" onclick="javascript:location.href='index.php'" />
			</form>
		</td>
	</tr>
</table>
</body>
</html>