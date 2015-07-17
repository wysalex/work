function checkIsbn(myIsbn) {
	var number = /^([0-9]{3}\-[0-9]{3}\-[0-9]{3}\-[0-9]{1})|([0-9]{3}\-[0-9]{3}\-[0-9]{3}\-[0-9]{3}\-[0-9]{1})$/;
	if (number.test(myIsbn.value)) {
		return true;
	}
	alert("ISBN格式為: xxx-xxx-xxx-x or xxx-xxx-xxx-xxx-x");
	return false;
}
function checkPrice(myprice) {
	var price = /^[0-9]+$/;
	if (price.test(myprice.value)) {
		return true;
	}
	alert("請確認售價");
	return false;
}
function checkPublishdate(myPublishdate) {
	var date = /^(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/;
	if (date.test(myPublishdate.value)) {
		return true;
	}
	alert("請確認發行日期");
	return false;
}