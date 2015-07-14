<?php
header('Content-type: text/html; charset=utf-8');
//record user information
session_start();
//generates four no duplicate numbers
function GenerateAnswer() {
	$numberStack = range(0, 9);
	shuffle($numberStack);
	$answer = "";
	for ($i = 0; $i < 4; $i++) {
		$answer .= $numberStack[$i];
	}
	return $answer;
}
?>
<form method="POST" action="1a2b.php">
	<input type="text" name="answer" />
	<input type="submit" value="submit" />
</form>
<?php
//if answer is null generate an answer
if (empty($_SESSION['answer'])) {
	$_SESSION['answer'] = GenerateAnswer();
}
echo "Answer is " . $_SESSION['answer'];
echo nl2br("\n");

if (!empty($_POST['answer'])) {
	$reset = false;
	//if correct print answer and you guess how many times
	//if incorrect check the answer
	if ($_POST['answer'] == $_SESSION['answer']) {
	//reset answer and record
	$reset = true;
		echo "Correct!! Answer is  " . $_POST['answer'] . " you guess " . (count($_SESSION['history']) + 1) . " times";
	} else {
		$counterA = $counterB = 0;
		for ($i = 0; $i < 4; $i++) {
			if(substr($_POST['answer'], $i, 1) == substr($_SESSION['answer'], $i, 1)) {
				++$counterA;
			} elseif(FALSE !== strpos($_SESSION['answer'], substr($_POST['answer'], $i, 1))) {
				++$counterB;
			}
		}
		$_SESSION['history'][] = array($_POST['answer'], $counterA . 'A' . $counterB . 'B');
		echo "you are insert " . $_POST['answer'] . " ，result is " . $counterA . "A" . $counterB . "B<br>";
	}
	//print the record
	if (!empty($_SESSION['history'])) {
		echo "<ul>";
		foreach ($_SESSION['history'] as $value) {
			echo "<li>" . $value[0] . " => " . $value[1] . "</li>";
		}
		echo "</ul>";
	}
	// if $reset is true reset SESSION and answer
	if ($reset) {
		unset($_SESSION['history']);
		$_SESSION['answer'] = GenerateAnswer();
	}
} else {
	echo "please insert number";
	if (!empty($_SESSION['history'])) {
		echo "<ul>";
		foreach ($_SESSION['history'] as $value) {
			echo "<li>" . $value[0] . " => " . $value[1] . "</li>";
		}
		echo "</ul>";
	}
}
?>