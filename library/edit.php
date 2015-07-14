<?php
header('Content-type: text/html; charset=utf-8');

if (isset($_POST["action"]) && ($_POST["action"] == "update")) {
	$book = $_POST["isbn"] . "," . $_POST["publisher"] . "," . $_POST["book"] . "," . $_POST["author"] . "," . $_POST["price"] . "," . $_POST["publishdate"] . "\r\n";

	$file_name = "library.txt";
	$LineArray = file($file_name);
	$lines = count($LineArray);
	$fp = fopen("library.txt", "w+");
	for ($i = 0; $i < $lines; $i++) {
		if ($i+1 == $_GET["id"]) {
			fwrite($fp, stripslashes($book));
		}
		else fwrite($fp, $LineArray[$i]);
	}
	fclose($fp);
	header("Location: index.php");
}

if ($_GET["id"]) {
	$fp = fopen("library.txt", "r+");
	if ($fp) {
		$i = 1;
		while (!feof($fp)) {
			if ($i == $_GET["id"]) {
				$txts = fgets($fp);
				break;
			}
			fgets($fp);
			$i++;
		}
	fclose($fp);
	}
} else {
	echo "<script language=javascript>";
	echo "alert('no data!');";
	echo "document.location.href='index.php';";
	echo "</script>";
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Book</title>
	<h1 align="center">Edit Book</h1>
<script language=javascript>
function checkForm() {
	if (document.editform.publisher.value == "") {
		alert("出版社不可為空!");
		document.editform.publisher.focus();
		return false;
	}
	if (document.editform.publisher.value != "") {
		if (!checkPublisher(document.editform.publisher)) {
			document.editform.publisher.focus();
			return false;
		}
	}
	if (document.editform.book.value == "") {
		alert("書名不可為空!");
		document.editform.book.focus();
		return false;
	}
	if (document.editform.author.value == "") {
		alert("作者不可為空!");
		document.editform.author.focus();
		return false;
	}
	if (document.editform.author.value != "") {
		if (!checkAuthor(document.editform.author)) {
			document.editform.author.focus();
			return false;
		}
	}
	if (document.editform.price.value == "") {
		alert("售價不可為空!");
		document.editform.price.focus();
		return false;
	}
	if (document.editform.price.value != "") {
		if (!checkPrice(document.editform.price)) {
			document.editform.price.focus();
			return false;
		}
	}
	if (document.editform.publishdate.value == "") {
		alert("發行日不可為空!");
		document.editform.publishdate.focus();
		return false;
	}
	if (document.editform.publishdate.value != "") {
		if (!checkPublishdate(document.editform.publishdate)) {
			document.editform.publishdate.focus();
			return false;
		}
	}
	return confirm ("確認送出?");
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
			<?php if ($txts) {?>
			<?php $aStr = explode(",", $txts);?>
			<form action="" method="POST" name="editform" onsubmit="return checkForm();">
				ISBN:<?php echo $aStr[0]?><input type="hidden" name="isbn" id="isbn" value="<?php echo $aStr[0];?>"/></br>
				出版社:
				<input type="text" name="publisher" id="publisher" value="<?php echo $aStr[1]?>" /></br>
				書名:
				<input type="text" name="book" id="book" value="<?php echo $aStr[2]?>" /></br>
				作者:
				<input type="text" name="author" id="author" value="<?php echo $aStr[3]?>" /></br>
				售價:
				<input type="text" name="price" id="price" value="<?php echo $aStr[4]?>" /></br>
				發行日:
				<input type="text" name="publishdate" id="publishdate" value="<?php echo $aStr[5]?>" /></br>
				<input type="hidden" name="action" id="action" value="update" />
				<input type="submit" name="submit" value="update" />
				<input type="button" name="button" value="cancel" onclick="javascript:location.href='index.php'" />
			</form>
			<?php }?>
		</td>
	</tr>
</table>
</body>
</html>