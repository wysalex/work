function check_login() {
	if (document.loginForm.username.value.trim() == "") {
		alert("請輸入帳號");
		document.loginForm.username.focus();
		return false;
	}
	if (document.loginForm.passwd.value.trim() == "") {
		alert("請輸入密碼");
		document.loginForm.passwd.focus();
		return false;
	}
}