<?php
header('Content-type: text/html; charset=utf-8');

if (isset($_POST["action"]) && ($_POST["action"] == "import")) {
	if ($_FILES['file']['error'] > 0) {
		echo "<script language=javascript>";
		echo "alert('請選擇一個txt檔!');";
		echo "document.location.href='index.php';";
		echo "</script>";
	}

	$txts = file_get_contents($_FILES['file']['tmp_name']);
	$txts = str_replace( '\r', "", $txts);
	$txts = preg_split('/\n/', $txts, -1, PREG_SPLIT_NO_EMPTY);

	$bom = searchBOM($txts[0]);
	if ($bom) {
		$txts[0] = substr($txts[0],3);
	}

	foreach ($txts as $txt) {
		$str = explode(",", $txt);
		$cleanStr = trimArray($str);
		$count = count($cleanStr);
		if ($count != 6) {
			echo "<script language=javascript>";
			echo "alert('請檢查輸入檔案的格式是否正確');";
			echo "document.location.href='index.php';";
			echo "</script>";
			exit;
		}
		$isbn = $cleanStr[0];
		$publisher = $cleanStr[1];
		$book = $cleanStr[2];
		$author = $cleanStr[3];
		$price = $cleanStr[4];
		$publishdate = $cleanStr[5];
		if (!preg_match("/^(([0-9]{3}\-[0-9]{3}\-[0-9]{3}\-[0-9]{1})|([0-9]{3}\-[0-9]{3}\-[0-9]{3}\-[0-9]{3}\-[0-9]{1}))$/", $isbn)) {
			echo "<script language=javascript>";
			echo "alert('ISBN格式為: xxx-xxx-xxx-x or xxx-xxx-xxx-xxx-x');";
			echo "document.location.href='index.php';";
			echo "</script>";
			exit;
		} elseif (!preg_match("/^[\x7f-\xffA-Za-z0-9]+$/", $publisher)) {
			echo "<script language=javascript>";
			echo "alert('請確認出版社的格式');";
			echo "document.location.href='index.php';";
			echo "</script>";
			exit;
		} elseif (!$book) {
			echo "<script language=javascript>";
			echo "alert('請輸入書名');";
			echo "document.location.href='index.php';";
			echo "</script>";
			exit;
		} elseif (!preg_match("/^[\x7f-\xffA-Za-z\.]+$/", $author)) {
			echo "<script language=javascript>";
			echo "alert('請確認作者');";
			echo "document.location.href='index.php';";
			echo "</script>";
			exit;
		} elseif (!preg_match("/^[0-9]+$/", $price)) {
			echo "<script language=javascript>";
			echo "alert('請確認售價');";
			echo "document.location.href='index.php';";
			echo "</script>";
			exit;
		} elseif (!preg_match("/^((19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01]))$/", $publishdate)) {
			echo "<script language=javascript>";
			echo "alert('請確認發行日期');";
			echo "document.location.href='index.php';";
			echo "</script>";
			exit;
		}
	}
	foreach ($txts as $txt) {
		$str = explode(",", $txt);
		$cleanStr = trimArray($str);

		$book = $cleanStr[0] . "," . $cleanStr[1] . "," . $cleanStr[2] . "," . $cleanStr[3] . "," . $cleanStr[4] . "," . $cleanStr[5] . "\r\n";
		file_put_contents("library.txt", stripslashes($book), FILE_APPEND);
	}
	header("Location: index.php");
}
if (isset($_POST["action"]) && ($_POST["action"] == "export")) {
	header("Content-type: application/text");
	header("Content-Disposition: attachment; filename=book.txt");

	$fp = fopen("library.txt", "r+");

	$txts = file("library.txt");
	foreach ($txts as $txt) {
		echo $txt;
	}
	fclose($fp);
	return;
}
if (isset($_POST["action"]) && ($_POST["action"] == "sort")) {
	$sortBy = $_POST["condition"] . $_POST["sort"];
	if (!$_POST["condition"] || !$_POST["sort"]) {
		echo "<script language=javascript>";
		echo "alert('請選擇搜尋條件!');";
		echo "document.location.href='index.php';";
		echo "</script>";
		exit;
	}
	if ($_POST["book"]) {
		$aBooks = array_chunk($_POST["book"], 6);
		usort($aBooks, $sortBy);
		$fp = fopen("library.txt", "w+");
		foreach ($aBooks as $book) {
			$bookStr = $book[0] . "," . $book[1] . "," . $book[2] . "," . $book[3] . "," . $book[4] . "," . $book[5] . "\r\n";
			file_put_contents("library.txt", stripslashes($bookStr), FILE_APPEND);
		}
		fclose($fp);

		$txts = file_get_contents("library.txt");
		$txts = str_replace( "\r", "", $txts);
		$txts = preg_split('/\n/', $txts, -1, PREG_SPLIT_NO_EMPTY);
	} else {
		echo "<script language=javascript>";
		echo "alert('沒有資料無法進行排序!');";
		echo "document.location.href='index.php';";
		echo "</script>";
		exit;
	}

} else {
	$fp = fopen("library.txt", "a+");

	$txts = file_get_contents("library.txt");
	$txts = str_replace( "\r", "", $txts);
	$txts = preg_split('/\n/', $txts, -1, PREG_SPLIT_NO_EMPTY);

	fclose($fp);
}

function trimArray($input) {
	if (!is_array($input))
		return trim($input);
	return array_map("trimArray", $input);
}
function searchBOM($string) { 
	if (substr($string,0,3) == pack("CCC",0xef,0xbb,0xbf)) return true;
	return false; 
}
function publisherASC($a, $b){
	if ($a[1] == $b[1]) return 0;
	return ($a[1] > $b[1]) ? 1 : -1;
}
function publisherDESC($a, $b){
	if ($a[1] == $b[1]) return 0;
	return ($a[1] < $b[1]) ? 1 : -1;
}
function bookASC($a, $b){
	if ($a[2] == $b[2]) return 0;
	return ($a[2] > $b[2]) ? 1 : -1;
}
function bookDESC($a, $b){
	if ($a[2] == $b[2]) return 0;
	return ($a[2] < $b[2]) ? 1 : -1;
}
function authorASC($a, $b){
	if ($a[3] == $b[3]) return 0;
	return ($a[3] > $b[3]) ? 1 : -1;
}
function authorDESC($a, $b){
	if ($a[3] == $b[3]) return 0;
	return ($a[3] < $b[3]) ? 1 : -1;
}
function priceASC($a, $b){
	if ($a[4] == $b[4]) return 0;
	return ($a[4] > $b[4]) ? 1 : -1;
}
function priceDESC($a, $b){
	if ($a[4] == $b[4]) return 0;
	return ($a[4] < $b[4]) ? 1 : -1;
}
function dateASC($a, $b){
	if ($a[5] == $b[5]) return 0;
	return ($a[5] > $b[5]) ? 1 : -1;
}
function dateDESC($a, $b){
	if ($a[5] == $b[5]) return 0;
	return ($a[5] < $b[5]) ? 1 : -1;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Lirbry</title>
	<h1 align="center">List</h1>
</head>
<body>
<table width="1000" align="center">
	<tr>
		<td>
			<form action="" method="POST" enctype="multipart/form-data">
				Choose File To Import Books: <input type="file" name="file" id="file" accept="text/*" />
				<input type="hidden" name="action" id="action" value="import" />
				<input type="submit" name="submit" id="submit" value="import" onclick="return confirm('確定匯入?')" /></br>
			</form>
		</td>
	</tr>
	<tr>
		<td>
			<form action="" method="POST" name="exportform" onclick="return confirm('確定匯出?')">
				Export All Of Books: <input type="hidden" name="action" id="action" value="export" />
				<input type="submit" name="submit" value="export"/>
			</form>
		</td>
	</tr>
	<tr>
		<td align="right">
			<form action="" method="POST" name="sortform">
			<?php if ($txts) {?>
			<?php foreach ($txts as $txt) {?>
			<?php $astring = explode(",", $txt);?>
			<?php $abook = array("isbn" => $astring[0], "publisher" => $astring[1], "book" => $astring[2], "author" => $astring[3], "price" => $astring[4], "publishdate" => $astring[5]);?>
				<input type="hidden" name="book[]" value="<?php echo $abook["isbn"]?>">
				<input type="hidden" name="book[]" value="<?php echo $abook["publisher"]?>">
				<input type="hidden" name="book[]" value="<?php echo $abook["book"]?>">
				<input type="hidden" name="book[]" value="<?php echo $abook["author"]?>">
				<input type="hidden" name="book[]" value="<?php echo $abook["price"]?>">
				<input type="hidden" name="book[]" value="<?php echo $abook["publishdate"]?>">
			<?php }?>
			<?php }?>
				排序
				<select name="condition">
					<option <selected="selected" value="">請選擇</option>
					<option <?php if ($_POST["condition"] == "publisher") echo 'selected="selected"';?> value="publisher">出版社</option>
					<option <?php if ($_POST["condition"] == "book") echo 'selected="selected"';?> value="book">書名</option>
					<option <?php if ($_POST["condition"] == "author") echo 'selected="selected"';?> value="author">作者</option>
					<option <?php if ($_POST["condition"] == "price") echo 'selected="selected"';?> value="price">售價</option>
					<option <?php if ($_POST["condition"] == "date") echo 'selected="selected"';?> value="date">發行日</option>
				</select>
				方向
				<select name="sort">
					<option <selected="selected" value="">請選擇</option>
					<option <?php if ($_POST["sort"] == "ASC") echo 'selected="selected"'?> value="ASC">ASC</option>
					<option <?php if ($_POST["sort"] == "DESC") echo 'selected="selected"'?> value="DESC">DESC</option>
				</select>
				<input type="hidden" name="action" id="action" value="sort"/>
				<input type="submit" name="submit" value="sort">
			</form>
		</td>
	</tr>
</table>
<table align="center" width="1000" border="1">
	<tr align="center">
		<td>ISBN</td>
		<td>出版社</td>
		<td>書名</td>
		<td>作者</td>
		<td>售價</td>
		<td>發行日</td>
		<td>編輯/刪除</td>
	</tr>
	<?php if ($txts) {?>
	<?php $c = 0;?>
	<?php foreach ($txts as $txt) {?>
	<?php $c = $c + 1;?>
	<?php $aStr = explode(",", $txt);?>
	<?php $aCleanStr = trimArray($aStr);?>
	<?php $aBook = array("isbn" => $aCleanStr[0], "publisher" => $aCleanStr[1], "book" => $aCleanStr[2], "author" => $aCleanStr[3], "price" => $aCleanStr[4], "publishdate" => $aCleanStr[5]);?>
	<tr align="center">
		<td><?php echo $aBook["isbn"];?></td>
		<td><?php echo $aBook["publisher"];?></td>
		<td><?php echo $aBook["book"];?></td>
		<td><?php echo $aBook["author"];?></td>
		<td><?php echo $aBook["price"];?></td>
		<td><?php echo $aBook["publishdate"];?></td>
		<td>
			<input type ="button" onclick="javascript:location.href='edit.php?id=<?php echo $c;?>'" value="Edit" />
			<input type ="button" onclick="javascript:location.href='delete.php?id=<?php echo $c;?>'" value="Delete" />
		</td>
	</tr>
	<?php }?>
	<?php }?>

</table>
<table align="center" width="1000">
	<tr>
		<td align="center">
			<form>
				<input type ="button" value="Add new book" onclick="javascript:location.href='insert.php'" />
			</form>
		</td>
	</tr>
</table>
</body>
</html>