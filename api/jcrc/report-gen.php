<?php
require_once '../../lib/db.php';
require_once '../../lib/account.php';
$account->get_info();

if ($account->info['type'] !== 'jcrc') {
    throw new Exception('not jcrc. permission denied.');
}

$report_id = $_GET['id'];
if(!empty($_GET['var1']))
	$v1 = $_GET['var1'];
if(!empty($_GET['var2']))
	$v2 = $_GET['var2'];

$cmd = $db->query_get1('select cmd from jcrc_reports where id = ?', [$report_id]);
$filename = $db->query_get1('select filename from jcrc_reports where id = ?', [$report_id]);



if (isset($v1) && isset($v2)){
	$result = $db->query_assoc($cmd, [$v1, $v2]);
//	echo "v1v2";
}
elseif(isset($v1)){
	$result = $db->query_assoc($cmd, [$v1]);
//	echo "v1";
}
else{
	$result = $db->query_assoc($cmd);
//	echo "nov";
}


$fp = fopen('php://output', 'w');
if ($fp && $result) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    fputcsv($fp, ['RZone Report Generator', date('d/m/Y H:i:s')]);
    fputcsv($fp, array_keys($result['data'][0]));
    foreach ($result['data'] as $row) {
        fputcsv($fp, array_values($row));
    }
    die;
}
?>