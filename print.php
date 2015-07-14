<?php
for ($i = 101; $i >= 0; $i -= 7) { 
	if ($i == 101) {
		echo $i;
		echo nl2br("\n");
	} elseif ($i == 94) {
		for ($j = 94; $j <= 114; $j += 10) { 
			echo $j . " ";
		}
		echo nl2br("\n");
	} elseif ($i == 87) {
		for ($j = 87; $j <= 127; $j += 10) { 
			echo $j . " ";
		}
		echo nl2br("\n");
	} elseif ($i == 80) {
		for ($j = 80; $j <= 140; $j += 10) { 
			echo $j . " ";
		}
		echo nl2br("\n");
	} elseif ($i == 73) {
		for ($j = 73; $j <= 153; $j += 10) { 
			echo $j . " ";
		}
		echo nl2br("\n");
		break;
	}
}
?>