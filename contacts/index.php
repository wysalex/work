<?php
require_once("db.php");

$query_Contacts = "SELECT * FROM `contact` ORDER BY `id`";
$contacts = mysql_query($query_Contacts);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Contact List</title>
	<h1 align="center">Contact List</h1>
<script language=javascript>
function checkForm() {
	if (document.myform.condition.value == "phone") {
		if (!checkPhone(document.myform.text)) {
			document.myform.text.focus();
			return false;
		}
	}
	if (document.myform.condition.value == "birthday") {
		if (!checkBirthday(document.myform.text)) {
			document.myform.text.focus();
			return false;
		}
	}
	if (document.myform.condition.value == "email") {
		if (!checkEmail(document.myform.text)) {
			document.myform.text.focus();
			return false;
		}
	}
}
function checkPhone(myPhone) {
	var number = /^[0-9]{0,4}[\-]?[0-9]{0,8}$/;
	if (number.test(myPhone.value)) {
		return true;
	}
	alert("電話格式錯誤\n請輸入手機或市話");
	return false;
}
function checkBirthday(myBirthday) {
	var day = /^[0-9]{0,4}[\-]?(0[1-9]|1[012])?[\-]?(0[1-9]|[12][0-9]|3[01])?$/;
	if (day.test(myBirthday.value)) {
		return true;
	}
	alert("日期格式錯誤");
	return false;
}
function checkEmail(myEmail) {
	var email = /^[a-zA-Z0-9@_\.\-]*$/;
	if (email.test(myEmail.value)) {
		return true;
	}
	alert("請輸入email格式");
	return false;
}
</script>
</head>
<body>
<form align="center" action="search.php" method="POST" name="myform" onsubmit="return checkForm();">
	<select name="condition">
		<option value="name">Name</option>
		<option value="gender">Gender</option>
		<option value="phone">Phone</option>
		<option value="birthday">Birthday</option>
		<option value="address">Address</option>
		<option value="email">Email</option>
	</select>
	<input type="text" name="text" id="text">
	<input type="hidden" name="action" id="action" value="search"/>
	<input type="submit" name="submit" value="search">
</form>
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
	<?php if ($contacts) {?>
	<?php while ($row = mysql_fetch_assoc($contacts)) {?>
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
	<?php }?>
</table>
<form align="center">
	<input align="center" type ="button" onclick="javascript:location.href='insert.php'" value="Add new contact"></input>
</form>
</body>
</html>