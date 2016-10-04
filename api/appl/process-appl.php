<?php
	require_once('common.php');

  ensure_appl_open();
  ensure_phase('B');

	$activity_id = $_POST['i'];
	$appl_nus_id = $_POST['n'];
	$result = $_POST['r'];
	
	  $is_head = $db->query_get1('select is_activity_head_of(?, ?);', [$account->info['nus_id'], $activity_id]);
	  if($is_head == 0){
	    throw new Exception('Access Denied. Violation has been recorded');
	  }


	$quota = $db->query_get1('select size from activities where id = ?', [$_POST['i']]);
	$num_member = intval($db->query_get1('select get_activity_member_count(?)', [$_POST['i']]));
	$num_offer = intval($db->query_get1('select count(*) from activities_appl where activity_id = ? and appl_result = 1 and round = ?', [$_POST['i'], $round]));
	$remain_quota = $quota - $num_member - $num_offer;

	if($result==1 && $remain_quota > 0){
		$db->execute('call process_appl(?, ?, ?, ?);', 
		[$account->nus_id, $activity_id, $appl_nus_id, $result]	);
		$num_offer = intval($db->query_get1('select count(*) from activities_appl where activity_id = ? and appl_result = 1 and round = ?', [$_POST['i'], $round]));
		$remain_quota = $quota - $num_member - $num_offer;
		echo "Success - Current Round: $num_offer Offered, you may issue $remain_quota more";
	}elseif($result==1){
		echo "Quota Exceeded - Current Round: $num_offer Offered, you may issue $remain_quota more";
	}
	else{
		$db->execute('call process_appl(?, ?, ?, ?);', 
		[$account->nus_id, $activity_id, $appl_nus_id, $result]	);
		$num_member = intval($db->query_get1('select get_activity_member_count(?)', [$_POST['i']]));
		$num_offer = intval($db->query_get1('select count(*) from activities_appl where activity_id = ? and appl_result = 1 and round = ?', [$_POST['i'], $round]));
		$remain_quota = $quota - $num_member - $num_offer;

		echo "Success - Current Round: $num_offer Offered, you may issue $remain_quota more";
	}

	

?>
