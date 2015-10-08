function checkAll() {
	if ($.trim($('#phone').val()) != "") {
		if (!checkPhone($.trim($('#phone').val()))) {
			$('#phone').focus();
			alert("電話輸入錯誤");
			return false;
		}
	}
}

function checkPhone(insPhone) {
	var phone = /^[0-9\-()+]{3,20}$/;
	if (phone.test(insPhone.value)) {
		return true;
	}
	alert("請確認發行日期");
	return false;
}