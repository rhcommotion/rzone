<?php
	require_once('common.php');
	require_once('../../lib/activity.php');
	
  ensure_appl_open();
  ensure_phase('B');

	$activity_id = $_GET['i'];
	ensure_activity_privl($activity_id, 'head');

	$appl_nus_id = $_GET['n'];

	$db->query('update activities_appl set appl_result = 0 where
    activity_id = ? and nus_id = ? and round = ?;', 
		array($activity_id, $appl_nus_id, $round)
  );
?>