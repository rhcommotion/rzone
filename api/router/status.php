<?php
require_once '../../lib/db.php';
require_once '../../lib/account.php';
require_once '../../lib/router.php';
$account->get_info();

	if (get_router_priv() == 1) {
	  $cond = '';
	}else{
	  $cond = ' and LEFT(block, 1) =' .  get_router_priv();
	}

	

	 $target_id = $_POST['n'];
	 $action = $_GET['action'];
	 $date = date('Y-m-d');

	 $residents = $db->query_get1("select count(*) from router where nus_id = ?" . $cond, [$target_id]);
	 if(!$residents)
		exit("Access Denied");

	if($action=='config'){
		$db->execute("update router set status='Configured', config_ic = ?, config_date = ? where nus_id = ?", [$account->nus_id, $date, $target_id]);
		echo "User marked as Configured.";
	}

	if($action=='sharepoint'){
		$db->execute("update router set status='Registered', sharepoint_ic = ?, sharepoint_date = ? where nus_id = ?", [$account->nus_id, $date, $target_id]);
		echo "User marked as Registered.";
	}

?>