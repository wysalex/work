function checkForm() {
	if (document.setForm.setIP.value.trim() === "") {
		alert("請輸入IP");
		document.setForm.setIP.focus();
		return false;
	}
	if (document.setForm.setIP.value.trim() !== "") {
		if (!check_ip(document.setForm.setIP)) {
			document.setForm.setIP.focus();
			return false;
		}
	}
	if (document.setForm.setMac.value.trim() === "") {
		alert("請輸入MAC");
		document.setForm.setMac.focus();
		return false;
	}
	if (document.setForm.setMac.value.trim() !== "") {
		if (!check_mac(document.setForm.setMac)) {
			document.setForm.setMac.focus();
			return false;
		}
	}
	if (document.setForm.setInterface.value === "") {
		alert("請選擇Interface");
		document.setForm.setInterface.focus();
		return false;
	}
}

function check_ip(ip_str) {
	var ipCheck = /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/;
	var num = ip_str.value.match(/[0-9]+/g);
	if (!ipCheck.test(ip_str.value)) {
		alert("IP格式錯誤");
		return false;
	} else if (num[0] > 254 || num[1] > 254 || num[2] > 254 || num[3] > 254 || "0.0.0.0" === ip_str.value) {
		alert("IP位址錯誤");
		return false;
	}
	return true;
}

function check_mac(mac_str) {
	var macCheck = /^(([a-fA-F0-9]{2}\:){5})[a-fA-F0-9]{2}$/;
	var legalMac = /^([a-fA-F0-9][cC048])(\:)/;
	if (!macCheck.test(mac_str.value)) {
		alert("MAC格式錯誤");
		return false;
	} else if (!legalMac.test(mac_str.value)) {
		alert("MAC首碼錯誤");
		return false;
	}
	return true;
}