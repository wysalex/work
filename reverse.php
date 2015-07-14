<form method="POST" action="reverse.php">
	<input type="text" name="string" /><br>
	<input type="submit" value="reverse" />
</form>
<?php
if (!empty($_POST)) {
	//get string length
	$length = strlen($_POST['string']);
	Recursive($length-1);
} else {
	echo "please insert string";
}
function Recursive($num) {
	$temp = $_POST['string'];
	echo $temp[$num];
	//if $num  <= 0 end recursive
	if ($num <= 0) {
		return;
	}
	//recursive call and minus one
	Recursive($num-1);
}
?>