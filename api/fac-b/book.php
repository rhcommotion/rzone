<?php

require_once "../../lib/db.php";
require_once "../../lib/account.php";
$account->get_info();

$venue = $_POST['v'];
$time_op = $_POST['s'];
$dur = intval($_POST['d']) * 60;

$db->execute('insert into facility_booking
                (fac_id, nus_id, time, duration)
                values (?, ?, ?, ?);', 
                [$venue, $account->nus_id, $time_op, $dur]);

?>