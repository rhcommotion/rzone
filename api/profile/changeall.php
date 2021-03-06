<?php

require_once '../../lib/db.php';
require_once '../../lib/account.php';
$account->get_info();

$phone = $_POST['phone'];
$email = $_POST['email'];
$birthday = $_POST['birthday'];
$course = $_POST['course'];
$year_of_study = $_POST['year_of_study'];
$shirt_size = $_POST['shirt_size'];



if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  throw new Exception('Invalid Email.');
}

if (!preg_match('/^\+?[0-9\-]{7,}/', $phone)) {
  throw new Exception('phone number invalid.');
}

list($dd,$mm,$yyyy) = explode('/',$birthday);
if (!checkdate($mm,$dd,$yyyy)) {
    throw new Exception('Date Invalid.');
}

$course = implode(',',$course);
$birthday = "$yyyy-$mm-$dd";


$db->execute("update members set phone = ?, email = ?, birthday = ?, course = ?, year_of_study = ?, shirt_size = ?  where nus_id = ?;", [$phone, $email, $birthday, $course, $year_of_study, $shirt_size, $nus_id]);

?>
