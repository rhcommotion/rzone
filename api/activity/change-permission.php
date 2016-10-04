<?php
	require_once '../../lib/db.php';
	require_once '../../lib/account.php';
	require_once('../../lib/activity.php');
	$account->get_info();
	
	$i = $_POST['i'];
	
	$type = $db->query_get1('select privilege from activities_members 
				where (nus_id = ?) and (activity_id = ?);', 
				[$account->nus_id, $i]);
	if ($type !== 'jcrc') {
		throw new Exception('not jcrc.');
	}
	
	$n = $_POST['n'];
	$p = $_POST['p'];
		
	$db->execute('update activities_members set privilege = ? 
				where (activity_id = ?) and (nus_id = ?);', 
			[$p, $i, $n]);
?>