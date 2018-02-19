<?php

$network = getNetwork();
printNetwork($network);

function getNetwork()
{
	$contents = trim(file_get_contents("/usr/local/bin/netlist/network.csv"));
	$rows = explode("\n", $contents);

	$network = array("ID" => "", "IP" => "");
	$net_cnt = count($rows);

	for ($i = 0; $i < $net_cnt; $i++) {
		$row_expld = explode(",", $rows[$i]);
		$network["ID"][$i] = $row_expld[0];
		$network["IP"][$i] = $row_expld[1];
	}

	return $network;
}

function isOnline($ip)
{
	exec(sprintf('ping -c 1 -W 1 %s', escapeshellarg($ip)), $res, $rval);
	return $rval === 0; // $rval = 0 if online
}

function printNetwork($network)
{
	$net_cnt = count($network["ID"]);
	for ($i = 0; $i < $net_cnt; $i++) {
		$id = $network["ID"][$i];
		$ip = $network["IP"][$i];
		$status = (isOnline($ip)) ? "Online" : "Offline";

		$content = $id . "\n";
		$content .= "    " . $ip . " $status" . "\n\n";
		echo $content;
	}

	return;
}
