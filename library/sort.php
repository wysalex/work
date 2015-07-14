<?php
header('Content-type: text/html; charset=utf-8');
?>
<pre>
<?php
$sortBy = $_POST["condition"] . $_POST["sort"];var_dump($_POST["book"]);exit;
$abooks = array_chunk($_POST["book"], 6);
uasort($abooks, $sortBy);

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
</pre>
<!DOCTYPE html>
<html>
<head>
	<title>Sort Result</title>
	<h1 align="center">Sort Result</h1>
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
	<?php if ($abooks) {?>
	<?php foreach ($abooks as $abook) {?>
	<tr align="center">
		<td><?php echo $abook[0];?></td>
		<td><?php echo $abook[1];?></td>
		<td><?php echo $abook[2];?></td>
		<td><?php echo $abook[3];?></td>
		<td><?php echo $abook[4];?></td>
		<td><?php echo $abook[5];?></td>
	</tr>
	<?php }?>
	<?php }?>
</table>
<form align="center">
	<input align="center" type ="button" value="back" onclick="javascript:location.href='index.php'" />
</form>
</body>
</html>