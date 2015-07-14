<?php
require_once("db.php");

if (isset($_POST["action"]) && ($_POST["action"] == "update")) {

	$update_Contact = "UPDATE `contact` SET ";
	$update_Contact .= "`phone`='".$_POST["phone"]."',";
	$update_Contact .= "`birthday`='".$_POST["birthday"]."',";
	$update_Contact .= "`address`='".$_POST["address"]."',";
	$update_Contact .= "`email`='".$_POST["email"]."'";
	$update_Contact .= "WHERE `id`=".$_POST["id"];
        
        mysql_query($update_Contact);
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
	<title>Edit Contact</title>
	<h1 align="center">Edit Contact</h1>
<script language=javascript>
function checkForm() {
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
					姓名:<?php echo $row["name"];?></br>
					<?php $gender = $row["gender"];?>
					<?php if ($gender == 1) {
						$sex = "男";
					} elseif ($gender == 2) {
						$sex = "女";
					}?>
					性別:<?php echo $sex;?></br>
					電話:
					<input type="text" name="phone" id="phone" value="<?php echo $row["phone"];?>"/></br>
					生日:
					<input type="text" name="birthday" id="birthday" value="<?php echo $row["birthday"];?>"/></br>
					地址:
					<input type="text" name="address" id="address" size="50" value="<?php echo $row["address"];?>"/></br>
					email:
					<input type="text" name="email" id="email" size="25" value="<?php echo $row["email"];?>"/></br>
					<input type="hidden" name="id" id="id" value="<?php echo $row["id"];?>"/>
					<input type="hidden" name="action" id="action" value="update"/>
					<input type="submit" name="submit" value="update"/>
					<input type="button" name="button2" value="cancel" onClick="window.history.back();"/>
				</form>
			</td>
		</tr>
	</table>
</body>
</html>