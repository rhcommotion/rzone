<?php
require_once 'lib/db.php';
require_once 'lib/account.php';
$account->get_info();
$activity_id = $_GET['i'];
$is_head = $db->query_get1('select is_activity_head_of(?, ?);', [$account->info['nus_id'], $activity_id]);
if($is_head == 0){
  throw new Exception('Access Denied. Violation has been recorded');
}


$result = $db->query_assoc('call get_activity_members_detailed(?)', [$activity_id]);
$filename = "activity_" . $activity_id . "_export.csv";




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