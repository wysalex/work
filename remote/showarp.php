<?php

if ($_POST["search"]) {
	$aArp = get_arptable();
	switch ($_POST["search"]) {
		case "IP":
			foreach ($aArp as $arp) {
				if ($arp[0] == $_POST["s_condition"]) {
					$aList = $arp;
					break;
				}
			}
			if (!is_double_array($aList)) {
				$aList_arp[0] = $aList;
			}
			break;
		case "MAC":
			foreach ($aArp as $arp) {
				if ($arp[2] == $_POST["s_condition"]) {
					$aList = $arp;
					break;
				}
			}
			if (!is_double_array($aList)) {
				$aList_arp[0] = $aList;
			}
			break;
		case "ETH":
			foreach ($aArp as $arp) {
				if ($arp[4] == $_POST["s_condition"]) {
					$aList[] = $arp;
				}
			}
			if (!is_double_array($aList)) {
				$aList_arp[0] = $aList;
			} else {
				$aList_arp = $aList;
			}
			break;
	}
} else {
	switch ($_POST["action"]) {
		case "setArp":
			set_arp($_POST["setIP"], $_POST["setMac"], $_POST["setInterface"]);
			$aList_arp = get_arptable();
			break;
		case "delArp":
			del_arp($_POST["delIP"], $_POST["delInterface"]);
			$aList_arp = get_arptable();
			break;
		default :
			$aList_arp = get_arptable();
	}
}

function get_arptable() {
	$cmd = "arp -n";
	exec($cmd, $aMsg);
	foreach ($aMsg as $msg) {
		if (strstr($msg, "Address") || strstr($msg, "incomplete"));
		else {
			$aList[] = listStringSplit($msg);
		}
	}
	return $aList;
}

function set_arp($ip, $mac, $interface) {
	$cmd = "/sbin/arp -s " . $ip . " " . $mac . " -i " . $interface;
	exec($cmd);
	return;
}

function del_arp($ip, $dev) {
	$cmd = "/sbin/ip n del " . $ip . " dev " . $dev;
	exec($cmd);
	return;
}

function listStringSplit($sList) {
	$aList = preg_split("/[\s]+/", $sList, -1, PREG_SPLIT_NO_EMPTY);
	return $aList;
}

function is_double_array($doubleArray) {
	foreach ($doubleArray as $array) {
		if (is_array($array)) {
			return true;
		} else {
			return false;
		}
	}
}

require_once("xhtml/arptable.html");
?>