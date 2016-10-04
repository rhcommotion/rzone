<?php
	require_once('common.php');

  ensure_appl_open();
  ensure_phase('C');

	$activity_id = $_GET['i'];
	
	$stmt = $db->query('update activities_appl set offer_status = 1 where
		activity_id = ? and nus_id = ? and round = ? and appl_result = 1
		and offer_status is null;', 
		array($activity_id, $account->nus_id, $round)
	);
	if ($stmt->rowCount() == 0) {
    throw new Exception('Cannot accept offer.');
  }
  // insert into member table
  $db->query('insert into activities_members (`activity_id`, `nus_id`) values
    (?, ?);', 
    array($activity_id, $account->nus_id)
  );
?>