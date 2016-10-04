<?php
	require_once('common.php');

  ensure_appl_open();
  ensure_phase('A');

	$activity_id = $_POST['i'];
	
	$db->execute('call remove_appl(?, ?);', [$account->nus_id, $activity_id]);
?>