<?php

require_once '../../lib/db.php';
require_once '../../lib/account.php';
$account->get_info();

$model = $_POST['model'];
$mac = $_POST['mac'];

$coop = isset($_POST['coop']);
$wpa = isset($_POST['wpa']);
$adminpw = isset($_POST['adminpw']);
$defaults = isset($_POST['defaults']);




$remark = '';
if($coop){
	$remark .= "[configured by coop]";
}
if($wpa){
	$remark .= "[wpa enabled]";
}
if($adminpw){
	$remark .= "[admin password changed]";
}
if($defaults){
	$remark .= "[default settigns]";
}

if(isset($_POST['target_id'])){
	$target_id = $_POST['target_id'];
	$status = $_POST['status'];
	$remark = $_POST['remark'];
	$db->execute("update router set model = ?, mac = ?, remark = ?, status=? where nus_id = ?", [$model, $mac, $remark, $status, $target_id]);

}else{

$db->execute("update router set model = ?, mac = ?, remark = ?, status='Pending' where nus_id = ?", [$model, $mac, $remark, $account->nus_id]);
}

?>
