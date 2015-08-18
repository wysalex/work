function check_login() {
	if (document.loginForm.username.value.trim() == "") {
		alert("請輸入帳號");
		document.loginForm.username.focus();
		return false;
	}
	if (document.loginForm.username.value.trim() != "") {
		if (!check_length(document.loginForm.username.value.trim())) {
			document.loginForm.username.focus();
			alert("帳號長度有誤");
			return false;
		}
	}
	if (document.loginForm.passwd.value.trim() == "") {
		alert("請輸入密碼");
		document.loginForm.passwd.focus();
		return false;
	}
	if (document.loginForm.passwd.value.trim() != "") {
		if (!check_length(document.loginForm.passwd.value.trim())) {
			document.loginForm.passwd.focus();
			alert("密碼長度有誤");
			return false;
		}
	}
	return true;
}

function check_length(str) {
	if (str.length > 12) {
		return false;
	}
	return true;
}