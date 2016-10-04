<?php
  $page = "My Activities";
  require_once 'page-t2.php';
  require_once("lib/activity.php"); 
  page_start();
?>
<div id="content">
<section>

<div class="section-header">
  <h2 class='profile-title'>My Activities</h2>
</div>
        <div class="section-body">
            <!-- BEGIN INTRO -->
             <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">


<?php
  $activities = $db->query('call get_my_activities(?);', [$account->nus_id]);
  
  $f = function ($a) {
    return "<tr>
        <td>$a[1]</td>
        <td>$a[2]</td>
      </tr>";
  };
  echo "<table class=\"table table-hover\">
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
</div></div></div>
</section>
</div>
<?php
  page_end();
?>
