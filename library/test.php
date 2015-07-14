<?php
header('Content-type: text/html; charset=utf-8');

/*
header("Content-type: application/text");
header("Content-Disposition: attachment; filename=test.txt");
echo chr(239).chr(187). chr(191);exit;
*/

$fp = fopen("bom.txt", "r+");

$content = file_get_contents("bom.txt");
$BOM = SearchBOM($content);
if ($BOM) {
	$BOMBED[count($BOMBED)] = $fp;
	// 移出BOM信息
	$content = substr($content,3);
	// 寫回到原始文件
	file_put_contents("bom.txt", $content);
}
fclose($fp);
/*
$folder->close();
if (count($foundfolders) > 0) {
	foreach ($foundfolders as $folder) {
		RecursiveFolder($folder, $win32);
	}
}
*/

function SearchBOM($string) { 
if (substr($string,0,3) == pack("CCC",0xef,0xbb,0xbf)) return true;
return false; 
}