<?php
$ethinfo = get_ethinfo();

function get_ethinfo() {
	if (is_file("/ram/tmp/wanstatus")) {
		$wanstatus = file("/ram/tmp/wanstatus");
	} else {
		$wanstatus = array(
			0 => "WAN1=OFF=OFF",
			1 => "WAN2=OFF=OFF",
			2 => "WAN3=OFF=OFF",
			3 => "WAN4=OFF=OFF",
			4 => "WAN5=OFF=OFF"
		);
	}
	$dev = array("eth0" , "eth1" , "eth2" , "eth3");
	$msg0 = array();
	for ($i = 0; $i < count($dev); $i++) {
		if ($dev[$i] == "eth0") {
			$info[$i]['dev'] = $dev[$i];
			$dev_ip = get_landev($dev[$i]);
			$info[$i]['ip'] = $dev_ip[ip];
			$info[$i]['mask'] = get_maskdev($dev[$i]);
			$xx = get_ethlink($dev[$i]);
			$info[$i]['connect'] = ($xx == "yes") ? "up" : "down";
			$info[$i]['link'] = $xx;
			$ethFlow = fetchRxTx($dev[$i]);
			$info[$i]['tx_packets'] = $ethFlow['TxPack'];
			$info[$i]['rx_packets'] = $ethFlow['RxPack'];
			$info[$i]['tx_flow'] = $ethFlow['TxFlow'];
			$info[$i]['rx_flow'] = $ethFlow['RxFlow'];
			$info[$i]['tx_error'] = $ethFlow['TxError'];
			$info[$i]['rx_error'] = $ethFlow['RxError'];
		} elseif ($dev[$i] == "eth1") {
			$info[$i]['dev'] = $dev[$i];
			$dev_ip = get_landev($dev[$i]);
			$info[$i]['ip'] = $dev_ip[ip];
			$info[$i]['mask'] = get_maskdev($dev[$i]);
			$xx = get_ethlink($dev[$i]);
			$info[$i]['connect'] = ($xx == "yes") ? "up" : "down";
			$info[$i]['link'] = $xx;
			$ethFlow = fetchRxTx($dev[$i]);
			$info[$i]['tx_packets'] = $ethFlow['TxPack'];
			$info[$i]['rx_packets'] = $ethFlow['RxPack'];
			$info[$i]['tx_flow'] = $ethFlow['TxFlow'];
			$info[$i]['rx_flow'] = $ethFlow['RxFlow'];
			$info[$i]['tx_error'] = $ethFlow['TxError'];
			$info[$i]['rx_error'] = $ethFlow['RxError'];
		} elseif ($dev[$i] == "eth2") {
			$info[$i]['dev'] = $dev[$i];
			$dev_ip = get_landev($dev[$i]);
			$info[$i]['ip'] = $dev_ip[ip];
			$info[$i]['mask'] = get_maskdev($dev[$i]);
			$xx = get_ethlink($dev[$i]);
			$info[$i]['connect'] = ($xx == "yes") ? "up" : "down";
			$info[$i]['link'] = $xx;
			$ethFlow = fetchRxTx($dev[$i]);
			$info[$i]['tx_packets'] = $ethFlow['TxPack'];
			$info[$i]['rx_packets'] = $ethFlow['RxPack'];
			$info[$i]['tx_flow'] = $ethFlow['TxFlow'];
			$info[$i]['rx_flow'] = $ethFlow['RxFlow'];
			$info[$i]['tx_error'] = $ethFlow['TxError'];
			$info[$i]['rx_error'] = $ethFlow['RxError'];
		} elseif ($dev[$i] == "eth3") {
			$info[$i]['dev'] = $dev[$i];
			$dev_ip = get_landev($dev[$i]);
			$info[$i]['ip'] = $dev_ip[ip];
			$info[$i]['mask'] = get_maskdev($dev[$i]);
			$xx = get_ethlink($dev[$i]);
			$info[$i]['connect'] = ($xx == "yes") ? "up" : "down";
			$info[$i]['link'] = $xx;
			$ethFlow = fetchRxTx($dev[$i]);
			$info[$i]['tx_packets'] = $ethFlow['TxPack'];
			$info[$i]['rx_packets'] = $ethFlow['RxPack'];
			$info[$i]['tx_flow'] = $ethFlow['TxFlow'];
			$info[$i]['rx_flow'] = $ethFlow['RxFlow'];
			$info[$i]['tx_error'] = $ethFlow['TxError'];
			$info[$i]['rx_error'] = $ethFlow['RxError'];
		}
	}
	return $info;
}

function get_landev($device) {
	$cmd1 = 'cat /etc/sysconfig/network-devices/ifconfig.'.$device.'/ipv4';
	$cmd2 = 'ifconfig '.$device;
	exec($cmd1, $msg1);
	exec($cmd2, $msg2);
	$info["onboot"] = trim(str_replace('ONBOOT=','',$msg1[0]));
	$devip = trim(str_replace('IP=','',$msg1[2]));//echo $devip;
	if ($devip == null || $devip == '#') {
		$info['ip'] = 'OFF';
	} else {
		$info['ip'] = $devip;
	}
	return $info;
}

function get_maskdev($device) {
	$cmd = 'ifconfig '.$device;
	exec($cmd, $msg);
	$str = trim(strstr_array($msg, 'Mask'));
	$str_mask = strstr($str, 'Mask');
	$acolli = explode(':', $str_mask);
	return $acolli[1];
}

function get_connect() {

}

function get_ethlink($dev) {//Network cable
	exec('/bin/cat /sys/class/net/' . $dev . '/carrier', $retCont, $retCode);
	if ($retCode == 0 && $retCont[0] == '1') {
		return "yes";
	} else {
		return "no";
	}
}

function fetchRxTx($dev) {
	exec('/sbin/ip -s link show ' . $dev, $ret);

	$arx = listStringSplit(trim($ret[3]));
	$rxflow = trim($arx[0]);
	$rxpack = trim($arx[1]);
	$rxerror = trim($arx[2]);

	$atx = listStringSplit(trim($ret[5]));
	$txflow = trim($atx[0]);
	$txpack = trim($atx[1]);
	$txerror = trim($arx[2]);

	$totalRxTx = array('RxPack' => $rxpack, 'TxPack' => $txpack, 'RxFlow' => $rxflow, 'TxFlow' => $txflow, 'RxError' => $rxerror, 'TxError' => $txerror,);

	return $totalRxTx;
}

function strstr_array($haystack, $needle) {
	if (!is_array($haystack)) {
		return false;
	}
	foreach ($haystack as $element) {
		if (strstr($element, $needle)) {
			return $element;
		}
	}
}

function listStringSplit($sList) {
	$aList = preg_split("/[\s,]+/", $sList , -1, PREG_SPLIT_NO_EMPTY);
	return $aList;
}

require_once('xhtml/interface.html');
?>