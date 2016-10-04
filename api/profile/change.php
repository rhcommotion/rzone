<?php

require_once '../../lib/db.php';
require_once '../../lib/account.php';
$account->get_info();

$dict = ['', '', 'phone', 'email', 'birthday', 'course', 'year_of_study',
'shirt_size'];

$index = $_POST['i'];
$val = $_POST['v'];

// check
switch ($index) {
    case 2:
    // phone
    if (!preg_match('/^\+?[0-9\-]{7,}/', $val)) {
      throw new Exception('phone number invalid.');
    }
    break;
    case 3:
    // email
    if (!preg_match('/@/', $val)) {
      throw new Exception('email invalid.');
    }
    break;
    case 4:
    // date
    if (!preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}/', $val)) {
      throw new Exception('date invalid.');
    }
    $val = new DateTime($val);
    $val = $val->format("Y-m-d");
    break;
}

$db->execute('update members set ' . $dict[$index] . ' = ? where nus_id = ?;',
[$val, $account->nus_id]);

?>
