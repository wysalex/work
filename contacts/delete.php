<?php
require_once("db.php");

if (isset($_POST["action"]) && ($_POST["action"] == "delete")) {
	
	$delete_Contact = "DELETE FROM `contact` WHERE `id`=" . $_GET["id"];

	mysql_query($delete_Contact);
	header("Location: index.php");
}
if ($_GET["id"]) {
	$query_Contact = "SELECT * FROM `contact` WHERE `id`=" . $_GET["id"];
	$contact = mysql_query($query_Contact);
	$row = mysql_fetch_assoc($contact);
} else {
	echo "<script language=javascript>";
	echo "alert('no data!');";
	echo "document.location.href='index.php';";
	echo "</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Delete Contact</title>
	<h1 align="center">Delete Contact</h1>
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
	</tr>
	<form align="center">
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
		</tr>
	</form>
</table>
<form align="center" action="" method="POST" name="myform">
	<input type="hidden" name="id" id="id" value="<?php echo $row["id"];?>"/>
	<input type="hidden" name="action" id="action" value="delete"/>
	<input type="submit" name="submit" value="delete"/>
	<input type="button" name="button2" value="cancel" onClick="window.history.back();"/>
</form>
</body>
</html>