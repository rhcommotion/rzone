<?php
	require_once('common.php');

	ensure_appl_open();
	ensure_phase('A');
	
	/*
	$quota = get_appl_max_num();
	if ($quota < 1) {
    throw new Exception('Exceeded the limit of activity applications in one round.');
  }
	*/

	$activity_id = $_POST['i'];
	$remark = array_key_exists('r', $_POST) ? $_POST['r'] : '';
	
	$db->execute('call add_appl(?, ?, ?);', [$account->nus_id, $activity_id, htmlspecialchars($remark)]);
?>
