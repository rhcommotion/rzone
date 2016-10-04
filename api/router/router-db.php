<?php
require_once '../../lib/db.php';
require_once '../../lib/account.php';
require_once '../../lib/router.php';
$account->get_info();

if (get_router_priv() == 1) {
  $cond = '';
}else{
  $cond = ' where LEFT(block, 1) =' .  get_router_priv();
}



if(!isset($_GET['action'])){
    $residents = $db->query_assoc("select nus_id, name,
          model, mac, status, config_ic, config_date, sharepoint_ic, sharepoint_date, remark from router" . $cond);

    echo(json_encode($residents));
  }
  elseif($_GET['action'] == 'list'){
    $activities = $db->query('call get_my_activities(?);', [$_GET['uid']]);
    echo(implode(', ', array_column($activities, 1)));
  } elseif($_GET['action'] == 'adminlist'){
    $activities = $db->query('call get_manageable_activities(?);', [$_GET['uid']]);
    echo(implode(', ', array_column($activities, 1)));
  } elseif($_GET['action'] == 'applist'){
    $activities = $db->query('call get_current_appl(?);', [$_GET['uid']]);
    echo(implode(', ', array_column($activities, 1)));
  }


  ?>
