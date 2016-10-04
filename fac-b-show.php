<?php
require_once 'page-t.php';
require_once 'lib/db.php';

$activities = $db->query('call get_my_activities(?);', [$account->nus_id]);

$f = function ($a) {
  return "<tr>
      <td>$a[1]</td>
      <td>$a[2]</td>
    </tr>";
};
echo "<table class='activity-table'>
  <thead>
    <tr>
      <th>Activity</th>
      <th>Role</th>
    </tr>
  </thead>
  <tbody>"
    . join(array_map($f, $activities)) .
  "</tbody>
  </table>";

?>