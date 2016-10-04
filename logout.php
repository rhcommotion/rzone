<?php 
require_once 'lib/account.php';

setcookie('token_str', '', 1, '/rzone/');

$account->goto_login();


?>