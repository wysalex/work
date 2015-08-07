function checkForm() {
	if (document.setForm.setIP.value == "") {
		alert("請輸入IP");
		document.setForm.setIP.focus();
		return false;
	}
	if (document.setForm.setIP.value != "") {
		if (!check_ip(document.setForm.setIP)) {
			document.setForm.setIP.focus();
			return false;
		}
	}
	if (document.setForm.setMac.value == "") {
		alert("請輸入MAC");
		document.setForm.setMac.focus();
		return false;
	}
	if (document.setForm.setMac.value != "") {
		if (!check_mac(document.setForm.setMac)) {
			document.setForm.setMac.focus();
			return false;
		}
	}
	if (document.setForm.setInterface.value == "") {
		alert("請輸入Interface");
		document.setForm.setInterface.focus();
		return false;
	}
	if (document.setForm.setInterface.value != "") {
		if (!check_eth(document.setForm.setInterface)) {
			document.setForm.setInterface.focus();
			return false;
		}
	}
}

function check_ip(ip_str) {
	var ipCheck = /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/;
	var num = ip_str.value.match(/[0-9]+/g);
	if (!ipCheck.test(ip_str.value)) {
		alert("IP格式錯誤");
		return false;
	} else if (num[0] > 255 || num[2] > 255 || num[3] > 255 || num[4] > 255) {
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

function check_eth(eth_str) {
	var aDevEth = document.setForm.devInterface.value.split(",");
//	document.write(devEth);
	var flag = aDevEth.some(function (value) {
		return value == eth_str.value ? true : false;
	});
	alert("沒有這個設備");
	return flag;
//var arr = ["jack", "john", "may", "su", "Ada"];
//var flag = arr.some(function (value, index, array) {
//return value == "may" ? true : false;
//});
//  flag 為 true
}