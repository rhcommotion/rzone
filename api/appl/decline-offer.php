<?php
	require_once('common.php');

  ensure_appl_open();
  ensure_phase('C');

	$activity_id = $_POST['i'];
	
	$db->execute('call decline_offer(?, ?);', 
		[$account->nus_id, $activity_id]
	);

?>