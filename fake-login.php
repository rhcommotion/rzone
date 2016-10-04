<?php
	//require_once("lib/lib_only.php");
	require_once("lib/account.php");

	function format_nus_id($str) {
		if (preg_match('/^([A-Za-z][0-9]+)/', $str, $arr)) {
			$str = $arr[0];
		}
		return strtolower($str);
	}

	$nus_id = format_nus_id($_GET['n']);
	$account->login($nus_id);
	header("Location: /rzone/");
	echo "Successfully login.";
?>
