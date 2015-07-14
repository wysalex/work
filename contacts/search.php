<?php
require_once("db.php");

$search = trim($_POST["text"]);
if ($search == null) {
	echo "<script language=javascript>";
	echo "alert('please enter correct condition!!');";
	echo "document.location.href='index.php';";
	echo "</script>";
}
if ($search == "男") {
	$text = 1;
} elseif ($search == "女") {
	$text = 2;
} else {
	$text = $search;
}
$search_Contacts = "SELECT * FROM `contact` WHERE `" . $_POST["condition"] . "` LIKE '%" . $text . "%'";
$search = mysql_query($search_Contacts);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search Result</title>
	<h1 align="center">Search Result</h1>
</head>
<body>
<table width="1000" border="1" align="center">
	<tr align="center">
		<td>Id</td>
		<td>Name</td>
		<td>Gender</td>
		<td>Phone</td>
		<td>Birthday</td>
		<td>Address</td>
		<td>E-mail</td>
		<td>Edit/Delete</td>
	</tr>
	<?php while ($row = mysql_fetch_assoc($search)) {?>
	<tr align="center">
		<td><?php echo $row["id"];?></td>
		<td><?php echo $row["name"];?></td>
		<td>
			<?php $gender = $row["gender"];?>
			<?php if ($gender == 1) {?>
				<?php echo "男";?>
			<?php } elseif ($gender == 2) {?>
				<?php echo "女";?>
			<?php }?>
		</td>
		<td><?php echo $row["phone"];?></td>
		<td><?php echo $row["birthday"];?></td>
		<td><?php echo $row["address"];?></td>
		<td><?php echo $row["email"];?></td>
		<td>
			<input type ="button" onclick="javascript:location.href='edit.php?id=<?php echo $row["id"];?>'" value="Edit"></input>
			<input type ="button" onclick="javascript:location.href='delete.php?id=<?php echo $row["id"];?>'" value="Delete"></input>
		</td>
	</tr>
	<?php }?>
</table>
<form align="center">
	<input type="button" name="button2" value="back" onClick="window.history.back();"/>
</form>
</body>
</html>