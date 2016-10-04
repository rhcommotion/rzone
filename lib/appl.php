<?php
	require_once('db.php');
	require_once('account.php');
	require_once('activity.php');

  // TODO: in sql: use schedule table to determine the current round.
	$round = intval($db->query_get1('select get_appl_round();'));
	$phase = $db->query_get1('select get_appl_phase();');

	function ensure_appl_open() {
    global $round;
    if ($round < 0) {
      throw new Exception('Activity enrollment is not open.');
    }
  }
  function ensure_phase($p) {
    global $phase;
  	if ($phase != $p) {
      throw new Exception('This operation cannot be done in the current phase.');
    }
  }
	function get_appl_max_num() {
    global $db, $account, $round;
    $max = intval($db->get_option('max_appl_per_round'));
    //$hard_lim = intval($db->get_option('max_activities'));
    $count = get_nonjcrc_enrolled_activities_count();
    $appl_count = $db->query_get1('select count(activity_id) from activities_appl
      where nus_id = ? and round = ?;',
      array($account->nus_id, $round)
    );
    $count += intval($appl_count);
    return max(0, $max - $count);
  }

  function get_current_appl() {
    global $db, $account, $round;
		$rows = $db->query('call get_current_appl(?);', [$account->nus_id]);
    return $rows;
  }
?>
