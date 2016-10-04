<?php
	require_once("db.php");
	require_once('account.php');

	function get_router_priv() {
	global $db, $account;
		$priv = $db->query_get1('select priv from router where nus_id like ?', [$account->nus_id]);
	return $priv;
	}

	function get_router_model() {
	global $db, $account;
		$model = $db->query_get1('select model from router where nus_id like ?', [$account->nus_id]);
	return $model;
	}

	function get_router_status() {
	global $db, $account;
		$status = $db->query_get1('select status from router where nus_id like ?', [$account->nus_id]);
	return $status;
	}

	function get_router_mac() {
	global $db, $account;
		$mac = $db->query_get1('select mac from router where nus_id like ?', [$account->nus_id]);
	return $mac;
	}

	function get_room_number() {
	global $db, $account;
		$status = $db->query_get1("select concat(block, '-', room) from router where nus_id like ?", [$account->nus_id]);
	return $status;
	}



	function man_router_mac($id) {
	global $db;
		$mac = $db->query_get1('select mac from router where nus_id like ?', [$id]);
	return $mac;
	}

	function man_router_priv($id) {
	global $db;
		$priv = $db->query_get1('select priv from router where nus_id like ?', [$id]);
	return $priv;
	}

	function man_router_model($id) {
	global $db;
		$model = $db->query_get1('select model from router where nus_id like ?', [$id]);
	return $model;
	}

	function man_router_status($id) {
	global $db;
		$status = $db->query_get1('select status from router where nus_id like ?', [$id]);
	return $status;
	}

	function man_router_remark($id) {
	global $db;
		$remark = $db->query_get1('select remark from router where nus_id like ?', [$id]);
	return $remark;
	}

	function man_router_name($id) {
	global $db;
		$remark = $db->query_get1('select name from router where nus_id like ?', [$id]);
	return $remark;
	}



?>
