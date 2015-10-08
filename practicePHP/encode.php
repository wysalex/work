<?php

$time_start = microtime(true);
echo $key = md5("Alexhelloworldsuperman");

echo " <br>\n";

$str = "passwd";

echo $encode = encrypt($str, $key);
echo " <br>\n";
echo $decode = decrypt($encode, $key);
echo " <br>\n";
$time_end = microtime(true);
$time = $time_end - $time_start;
echo $time;
echo " <br>\n";

function encrypt($str, $key) {
	return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $str, MCRYPT_MODE_ECB));
}

function decrypt($str, $key) {
	return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($str), MCRYPT_MODE_ECB);
}
