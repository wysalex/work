function checkForm() {
	if (document.myform.isbn.value == "") {
		alert("ISBN不可為空!");
		document.myform.isbn.focus();
		return false;
	}
	if (document.myform.isbn.value != "") {
		if (!checkIsbn(document.myform.isbn)) {
			document.myform.isbn.focus();
			return false;
		}
	}
	if (document.myform.publisher.value == "") {
		alert("出版社不可為空!");
		document.myform.publisher.focus();
		return false;
	}
	if (document.myform.book.value == "") {
		alert("書名不可為空!");
		document.myform.book.focus();
		return false;
	}
	if (document.myform.author.value == "") {
		alert("作者不可為空!");
		document.myform.author.focus();
		return false;
	}
	if (document.myform.price.value == "") {
		alert("售價不可為空!");
		document.myform.price.focus();
		return false;
	}
	if (document.myform.price.value != "") {
		if (!checkPrice(document.myform.price)) {
			document.myform.price.focus();
			return false;
		}
	}
	if (document.myform.publishdate.value == "") {
		alert("發行日不可為空!");
		document.myform.publishdate.focus();
		return false;
	}
	if (document.myform.publishdate.value != "") {
		if (!checkPublishdate(document.myform.publishdate)) {
			document.myform.publishdate.focus();
			return false;
		}
	}
	return confirm ("確認送出?");
}
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