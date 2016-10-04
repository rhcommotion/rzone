<?php
	require_once('common.php');

  ensure_appl_open();
  ensure_phase('C');

	$activity_id = $_POST['i'];

	$c = get_enrolled_activities_count();
	$lim = intval($db->get_option('max_activities'));

	if ($c >= $lim) {
		throw new Exception('Activity limit exceeded.');
	}

	$db->execute('call accept_offer(?, ?);',
		[$account->nus_id, $activity_id]
	);

?>
