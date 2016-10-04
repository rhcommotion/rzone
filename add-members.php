<?php
require_once("lib/db.php");  
require_once("lib/activity.php");
require_once("lib/account.php");
    $account->get_info();
	
	$i = $_POST['i'];

	$type = $db->query_get1('select privilege from activities_members 
				where (nus_id = ?) and (activity_id = ?);', 
				[$account->nus_id, $i]);
	//echo("you're". $account->nus_id);
	if ($type !== 'jcrc' && $type !== 'admin') {
		throw new Exception("Access Denied (insufficient privilege)");
	}


	$ns = $_POST['ns'];
	
	try {
		$db->execute('insert into activities_members 
					(activity_id, nus_id) values (?, ?);', 
					[$i, $ns]);
		echo "Successfully added $ns.<br>";
	} catch (Exception $e) {
	echo "Error:" .  $e->getMessage() . "<br>";
	}
?>