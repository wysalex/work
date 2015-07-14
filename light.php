<?php
//send a raw HTTP header to the browser
header('Content-type: text/html; charset=utf-8');
?>
<form method="POST" action="light.php">
	<input type="text" name="light" />盞燈<br>
	<input type="text" name="people" />個人<br>
	<input type="submit" value="submit" />
</form>
<?php
if (!empty($_POST)) {
	$light = $_POST['light'];
	$people = $_POST['people'];
	$alamps = array();
	//preset lamps status
	for ($i = 1; $i <= $light; $i++) {
		$alamps[$i] = -1;
	}

	for ($i = 1; $i <= $people; $i++) {
		//operates on j lamps
		for ($j = 1; $j <= $light; $j++) {
			if ($j%$i == 0) {
				$alamps[$j] = $alamps[$j] * (-1);
			}
		}
	}
	//print result
	for ($i=1; $i <= $light; $i++) { 
		if ($alamps[$i] == 1) {
			echo " " . $i;
		}
	}
}
?>