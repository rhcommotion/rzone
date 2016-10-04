<?php
	require_once '../../lib/db.php';
	require_once '../../lib/account.php';
	require_once('../../lib/activity.php');
	$account->get_info();
	
	if ($account->info['type'] !== 'jcrc') {
    throw new Exception('not jcrc. permission denied.');
  }
	
	$k = $_POST['k'];
	$v = $_POST['v'];
	
	$db->set_option($k, $v);
?>