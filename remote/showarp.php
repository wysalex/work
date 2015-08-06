<?php

$aList = get_arptable();

function get_arptable() {
	$cmd = 'arp';
	exec($cmd, $aMsg);
	foreach ($aMsg as $msg) {
		if (strstr($msg, 'Address'));
		else {
			$aList[] = listStringSplit($msg);
		}
	}
	return $aList;
}

function set_arp($ip, $mac, $interface) {
	$cmd = 'arp -s ' . $ip . ' ' . $mac . ' -i ' . $interface;
	exec($cmd);
	return;
}

function listStringSplit($sList) {
	$aList = preg_split("/[\s,]+/", $sList , -1, PREG_SPLIT_NO_EMPTY);
	return $aList;
}

require_once('xhtml/arptable.html');
?>