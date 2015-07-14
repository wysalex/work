<?php
require_once("db.php");

if (isset($_POST["action"]) && ($_POST["action"] == "add")) {

	$insert_Contact = "INSERT INTO `contact` (`name`, `gender`, `phone`, `birthday`, `address`, `email`) VALUES (";
	$insert_Contact .= "'" . $_POST["name"] . "',";
	$insert_Contact .= "'" . $_POST["gender"] . "',";
	$insert_Contact .= "'" . $_POST["phone"] . "',";
	$insert_Contact .= "'" . $_POST["birthday"] . "',";
	$insert_Contact .= "'" . $_POST["address"] . "',";
	$insert_Contact .= "'" . $_POST["email"] . "')";

	mysql_query($insert_Contact);
	header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>New Contact</title>
	<h1 align="center">New Contact</h1>
<script language=javascript>
function checkForm() {
	if (document.myform.name.value == "") {
		alert("請輸入姓名!");
		document.myform.name.focus();
		return false;
	}
	if (document.myform.gender.value == "") {
		alert("請輸入性別!");
		return false;
	}
	if (document.myform.phone.value != "") {
		if (!checkPhone(document.myform.phone)) {
			document.myform.phone.focus();
			return false;
		}
	}
	if (document.myform.birthday.value != "") {
		if (!checkBirthday(document.myform.birthday)) {
			document.myform.birthday.focus();
			return false;
		}
	}
	if (document.myform.email.value != "") {
		if (!checkEmail(document.myform.email)) {
			document.myform.email.focus();
			return false;
		}
	}
	return confirm ("確認送出?");
}
function checkPhone(myPhone) {
	var number = /^([0][9][0-9]{2}-[0-9]{6})|([0][0-9]{1,2}-[0-9]{7,8})$/;
	if (number.test(myPhone.value)) {
		return true;
	}
	alert("電話格式錯誤\n請輸入手機或市話");
	return false;
}
function checkBirthday(myBirthday) {
	var day = /^(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/;
	if (day.test(myBirthday.value)) {
		return true;
	}
	alert("生日格式錯誤\n請填入西元年-月-日");
	return false;
}
function checkEmail(myEmail) {
	var filter = /^([a-zA-Z0-9_\.\-])+@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,4})+$/;
	if (filter.test(myEmail.value)) {
		return true;
	}
	alert("email格式錯誤");
	return false;
}
</script>
</head>
<body>
	<table align="center" width="500" border="1">
		<tr>
			<td>
				<form action="" method="POST" name="myform" onsubmit="return checkForm();">
					姓名:
					<input type="text" name="name" id="name" /></br>
					性別:
					<input type="radio" name="gender" id="gender" value="1" />男
					<input type="radio" name="gender" id="gender" value="2" />女</br>
					電話:
					<input type="text" name="phone" id="phone" /></br>
					生日:
					<input type="text" name="birthday" id="birthday" /></br>
					地址:
					<input type="text" name="address" id="address" size="50"/></br>
					email:
					<input type="text" name="email" id="email" size="25"/></br>
					<input type="hidden" name="action" id="action" value="add"/>
					<input type="submit" name="submit" value="submit"/>
					<input type="button" name="button2" value="cancel" onClick="window.history.back();"/>
				</form>
			</td>
		</tr>
	</table>
</body>
</html>