<?php
	require_once('common.php');

  ensure_appl_open();
  ensure_phase('A');

	$activity_id = $_GET['i'];
	$remark = array_key_exists('r', $_GET) ? $_GET['r'] : '';
	$db->query('insert into activities_appl 
		(`activity_id`, `nus_id`, `round`, `appl_remark`) 
		values (?, ?, ?, ?)
		on duplicate key update appl_remark = ?;', 
		array($activity_id, $account->nus_id, $round, $remark, $remark)
	);
?>