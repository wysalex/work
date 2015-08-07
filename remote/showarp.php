<?php
$aList = get_arptable();
$aEth_list = get_eth();
$eth_list = join(",", $aEth_list);

switch ($_POST["action"]) {
	case "setArp":
//		$eth_list = get_eth();
//		if (!in_array($_POST["setInterface"], $eth_list)) {
//			echo "<script language='javascript' type='text/javascript'>";
//			echo "alert('這個設備沒有" . $_POST['setInterface'] . "');";
//			echo "</script>";
////			$aList = get_arptable();
//			break;
//		}
		set_arp($_POST["setIP"], $_POST["setMac"], $_POST["setInterface"]);
		$aList = get_arptable();
		break;
	case "delArp":
		del_arp($_POST["delIP"], $_POST["delInterface"]);
		$aList = get_arptable();
		break;
//	default :
//		$aList = get_arptable();
//		break;
}

function get_arptable() {
	$cmd = "arp";
	exec($cmd, $aMsg);
	foreach ($aMsg as $msg) {
		if (strstr($msg, "Address") || strstr($msg, "incomplete"));
		else {
			$aList[] = listStringSplit($msg);
		}
	}
	return $aList;
}

function get_eth() {
	$cmd = "dmesg | grep -in eth";
	exec($cmd, $aMsg);
	foreach ($aMsg as $msg) {
		if (strstr($msg, "eth")) {
			$eth_list = listStringSplit(strstr($msg, "eth"));
			$aList[] = trim(str_replace(":", "", $eth_list[0]));
		}
	}
	$aList = array_unique($aList);
	return $aList;
}

function set_arp($ip, $mac, $interface) {
	$cmd = "arp -s " . $ip . " " . $mac . " -i " . $interface;
	exec($cmd);
	return;
}

function del_arp($ip, $dev) {
	$cmd = "ip n del " . $ip . " dev " . $dev;
	exec($cmd);
	return;
}

function listStringSplit($sList) {
	$aList = preg_split("/[\s]+/", $sList , -1, PREG_SPLIT_NO_EMPTY);
	return $aList;
}

require_once("xhtml/arptable.html");
?>