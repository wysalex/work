<?php
header('Content-type: text/html; charset=utf-8');

if (isset($_POST["action"]) && ($_POST["action"] == "delete")) {

	$file_name = "library.txt";
	$LineArray = file($file_name);
	$lines = count($LineArray);
	$fp = fopen("library.txt", "w+");
	for ($i = 0; $i < $lines; $i++) {
		if ($i+1 == $_GET["id"]) {
			continue;
		}
		else fwrite($fp, $LineArray[$i]);
	}
	fclose($fp);
	header("location: index.php");
}

if ($_GET["id"]) {
	$fp = fopen("library.txt", "r+");
	if ($fp) {
		$i = 1;
		while (!feof($fp)) {
			if ($i == $_GET["id"]) {
				$txt = fgets($fp);
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
	<title>Delete Book</title>
	<h1 align="center">Delete Book</h1>
</head>
<body>
<table align="center" width="1000" border="1">
	<tr align="center">
		<td>ISBN</td>
		<td>出版社</td>
		<td>書名</td>
		<td>作者</td>
		<td>售價</td>
		<td>發行日</td>
	</tr>
	<?php if ($txt) {?>
	<?php $txt = trim($txt);?>
	<?php $aStr = explode(",", $txt);?>
	<tr align="center">
		<td><?php echo $aStr[0];?></td>
		<td><?php echo $aStr[1];?></td>
		<td><?php echo $aStr[2];?></td>
		<td><?php echo $aStr[3];?></td>
		<td><?php echo $aStr[4];?></td>
		<td><?php echo $aStr[5];?></td>
	</tr>
	<?php }?>
</table>
<table align="center" width="1000" >
	<tr>
		<td align="center">
	<form action="" method="POST" name="deleteform">
		<input type="hidden" name="isbn" id="isbn" value="<?php echo $aStr[0];?>"/>
		<input type="hidden" name="action" id="action" value="delete"/>
		<input type="submit" name="submit" value="delete"/>
		<input align="center" type ="button" value="cancel" onclick="javascript:location.href='index.php'" />
	</form>
		</td>
	</tr>
</table>
</body>
</html>