<?php
header('Content-type: text/html; charset=utf-8');
?>
<form method="POST" action="matrix.php">
	<input type="text" name="size" /><br>
	<input type="submit" value="submit" />
</form>
<?php
if (!empty($_POST)) {
	$size = $_POST["size"];
	if ($size % 2 == 1) {
		$x = 0;
		$y = ($size + 1) / 2;
		for ($key = 1; $key <= $size * $size; $key++) {
			if ($key % $size == 1) {
				$x++;
			} else {
				$x--;
				$y++;
			}
			if ($x == 0) {
				$x = $size;
			}
			if ($y > $size) {
				$y = 1;
			}
			$asquare[$x][$y] = $key;
		}
		echo "<table border=1><tr>";
		for ($x = 1; $x <= $size; $x++) {
			for ($y = 1; $y <= $size; $y++) {
				echo "<td>" . $asquare[$x][$y] . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	} else {
		echo "請數入奇數";
		return;
	}
}
?>