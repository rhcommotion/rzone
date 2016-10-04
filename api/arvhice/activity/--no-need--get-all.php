<?php
	//require_once("lib/lib_only.php");
	require_once("../lib/account.php");
	require_once('../lib/LightOpenID-1.2.0-no-yadis.php');

	function format_nus_id($str) {
		if (preg_match('/^([A-Za-z][0-9]+)/', $str, $arr)) {
			$str = $arr[0];
		}
		return strtolower($str);
	}

	$openid = new LightOpenID('raffles.nus.edu.sg');
	if (!$openid->mode) {
		// user tries to login
		$nus_id = $_GET['n'];
		if (!$nus_id) {
			exit(1);
		}
		$nus_id = format_nus_id($nus_id);
		$openid->identity = 'https://openid.nus.edu.sg/' . $nus_id;
		//$openid->identity = 'http://specs.openid.net/auth/2.0/identifier_select';
		header('Location:' . $openid->authUrl());
	} else {
		// openid server replies
		try {
			if ($openid->mode == 'cancel' || !($openid->validate()))
				throw new Exception('Cannot validate OpenID.');
			$nus_id = $openid->identity;
			$prefix = 'https://openid.nus.edu.sg/';
			if (0 != strcmp($prefix, substr($nus_id, 0, strlen($prefix))))
				throw new Exception('Invalid NUS OpenID.');
			$nus_id = substr($nus_id, strlen($prefix));
			$account->login($nus_id);
			header("Location: //raffles.nus.edu.sg/rzone/");
			echo "Successfully login.";
		} catch (Exception $e) {
			header('Location: //raffles.nus.edu.sg/rzone/login.html');
			echo "Failed to login.\n";
		}
	}
?>
