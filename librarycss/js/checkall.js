function selectAll(input){
	var checkItem = document.getElementsByName("checkbox[]");
	for (var i = 0; i < checkItem.length; i++) {
		if (input.checked == true) {
			checkItem[i].checked = true;
		} else {
			checkItem[i].checked = false;
		}
	}
}