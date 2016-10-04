<?php
global $db, $account, $page;
require_once 'lib/db.php';
require_once 'lib/account.php';
$account->
get_info();

if ($account->info['type'] !== 'jcrc') {
    throw new Exception('not jcrc. permission denied.');
}

if(!isset($_GET['action'])){
    $residents = $db->query_assoc('select nus_id, name, sex, block, room, 
          phone, email, course, year_of_study, birthday, shirt_size from members;');

    echo(json_encode($residents));
		

 	}
 	else if($_GET['action'] == 'list'){
 		$activities = $db->query('call get_my_activities(?);', [$_GET['uid']]);
 		echo(implode(', ', array_column($activities, 1)));
 	} else if($_GET['action'] == 'adminlist'){
 		$activities = $db->query('call get_manageable_activities(?);', [$_GET['uid']]);
 		echo(implode(', ', array_column($activities, 1)));
 	}


 	?>
