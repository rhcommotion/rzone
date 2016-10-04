<?php
	require_once("db.php");
	require_once("account.php");

  function get_activity_privl($activity_id) {
    global $account, $db;
    $r = $db->query_get1('select privilege from activities_members
      where activity_id = ? and nus_id = ?;',
      [$activity_id, $account->nus_id]
    );
		/*
    if (!$r) {
      throw new Exception('Cannot retrieve privilege.');
    }
		*/
    return $r;
  }
  function get_activity_privl_level($p) {
    $dict = array('jcrc' => 100, 'head' => 10, 'member' => 1);
    return array_key_exists($p, $dict) ? $dict[$p] : 0;
  }

  function ensure_activity_privl($activity_id, $p) {
    $privl = get_activity_privl($activity_id);
    if (get_activity_privl_level($privl) < get_activity_privl_level($p)) {
      throw new Exception("p $p, pr $privl. " . 'Permission denied for this operation on activity.');
    }
  }

  function get_activities() {
    global $db, $account;
		$rows = $db->query('call get_available_activities(?);', [$account->nus_id]);
    return $rows;
  }
  function get_activities_cats() {
    $a = get_activities();
    $arr = array();
    $pos = 0;
    $len = count($a);
    for ($i = 0; $i < $len - 1; $i++) {
      if ($a[$i]['category'] != $a[$i + 1]['category']) {
        array_push($arr, array_slice($a, $pos, $i + 1 - $pos));
        $pos = $i + 1;
      }
    }
    array_push($arr, array_slice($a, $pos, $len - $pos));
    return $arr;
  }
  function default_gen_activity_row($a) {
    $name = $a[1];
    $desc = $a[3];
    $remark = $a[4];
    return "<tr activity_id='$a[0]'><td>$name</td><td>$desc &nbsp;</td><td>$remark &nbsp;</td></tr>";
  };
  function gen_activities_table($arr, $class, $gen_row) {
		$cat = $arr[0]['category'];
		if ($cat == "") {
			$cat = "Uncategorized";
		}
    return "<table class='$class' category='$cat'><tbody>" . join(array_map($gen_row, $arr)) . "</tbody></table>";
  }
  function gen_activity_cats_tables($class, $gen_row) {
    $arr = get_activities_cats();
    $f = function ($arr) use ($class, $gen_row) {
      $cat = $arr[0]['category'];
      if ($cat == "") {
        $cat = "Uncategorized";
      }
      return "<h4 class='activity-cat'>$cat</h4>" . gen_activities_table($arr, $class, $gen_row);
    };
    return join(array_map($f, $arr));
  }

  function get_enrolled_activities() {
    global $db, $account;
    $rows = $db->query('select a.id, a.name, m.role from activities_members as m
      inner join activities as a on m.activity_id = a.id
      where m.nus_id = ?;',
      array($account->nus_id)
    );
    return $rows;
  }
  function get_enrolled_activities_count() {
    global $db, $account;
    $r = $db->query_get1('select count(activity_id) from activities_members
      where nus_id = ?;',
      array($account->nus_id)
    );
    return intval($r);
  }

  function get_nonjcrc_enrolled_activities_count() {
    global $db, $account;
    $r = $db->query_get1('select count(activity_id) from activities_members
      where nus_id = ? and privilege <> "jcrc";',
      array($account->nus_id)
    );
    return intval($r);
  }

  class Activity {
	  public $id, $name, $remark;
	  public function __construct($id) {
		  global $db;
		  $r = $db->query('select name, remark from activities where id = ?;',
			  array($id)
		  )[0];
		  $this->id = $id;
		  $this->name = $r[0];
		  $this->remark = $r[1];
	  }
  }
?>
