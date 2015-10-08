function check_login() {
	if ($.trim($('#username').val()) == "") {
		alert("請輸入帳號");
		$('#username').focus();
		return false;
	}
	if ($.trim($('#username').val()) != "") {
		if (!check_length($.trim($('#username').val()))) {
			$('#username').focus();
			alert("帳號長度有誤");
			return false;
		}
	}
	if ($.trim($('#passwd').val()) == "") {
		alert("請輸入密碼");
		$('#passwd').focus();
		return false;
	}
	if ($.trim($('#passwd').val()) != "") {
		if (!check_length($.trim($('#passwd').val()))) {
			$('#passwd').focus();
			alert("密碼長度有誤");
			return false;
		}
	}
	return true;
}

function check_length(str) {
	if (str.length > 15) {
		return false;
	}
	return true;
}