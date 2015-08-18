<?php

//require_once("class/linkdb.php");
//
//$db = new DB("admin");
//
//$sql = "SELECT * FROM `manager`";
//$result = $db->rawQuery($sql);
//
//while ($row = $db->raw_fetch_assoc($result)) {
//	print_r($row);
//}
//phpinfo();
exec("top -b -n 1 c", $cpuinfo);
print_r($cpuinfo);