<?php
  // process both approve / reject
  // when approve, reject any other booking at the same time and place.
  
  require_once "../../lib/db.php";
  require_once "../../lib/account.php";
  $account->get_info();
  
  if ($account->info['type'] !== 'jcrc') {
    throw new Exception('no permission.');
  }

  $id = $_POST['i'];

  $db->execute("update facility_booking set status = 'approved' where id = ?;", 
    [$id]);

?>