<?php
  $page="Application History";
  require_once 'page-t2.php';
  require_once("lib/activity.php");
  require_once("lib/appl.php");
  page_start();
?>
<div id="content">
<section>

<div class="section-header">
  <h2 class='profile-title'>Past Applications</h2>
</div>
        <div class="section-body">
            <!-- BEGIN INTRO -->
             <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

<style>
.appl-table td:first-child {
  width: 9em;
}
.appl-table tr[appl_result=''] > .td-appl-result::before {
  content: "Pending";
}
.appl-table tr[offer_status=''] > .td-offer-status::before {
  content: 'N/A';
}
.appl-table tr[appl_result='1'] > .td-appl-result::before {
  color: green;
  content: 'Successful';
}
.appl-table tr[appl_result='0'] > .td-appl-result::before {
  color: red;
  content: 'Unsuccessful';
}
.appl-table tr[offer_status='1'] > .td-offer-status::before {
  color: green;
  content: 'Accepted';
}
.appl-table tr[offer_status='0'] > .td-offer-status::before {
  color: red;
  content: 'Declined';
}

.appl-remark {
  pointer-events: none;
  background: #f0f0f0;
}
</style>

<?php
  function gen_appl_table($arr, $class, $gen_row) {
    global $round, $phase;
    return "<table class=\"$class\" appl_round=\"$round\" appl_phase=\"$phase\"><thead><tr>
    <th>Round</th>
    <th>Activity Name</th>
    <th>Application Remarks</th>
    <th>Application Result</th>
    <th>Offer Status</th>
    </tr></thead>
    <tbody>" . join(array_map($gen_row, $arr)) . "</tbody></table>";
  }
  $f = function ($a) {
    return "<tr appl_result=\"$a[2]\" offer_status=\"$a[3]\">
      <td>$a[0]</td>
      <td>$a[1]</td>
      <td><textarea class=\"appl-remark\">$a[4]</textarea></td>
      <td class=\"td-appl-result\"></td>
      <td class=\"td-offer-status\"></td>
    </tr>";
  };
  if($phase=='C')
   $rows = $db->query('select aa.round, a.name, aa.appl_result,
        aa.offer_status, aa.appl_remark
      from activities_appl as aa
      inner join activities as a
        on a.id = aa.activity_id
        where aa.nus_id = ? and (aa.round <= ?);',
      [[$account->nus_id][0],$round]);
  else
    $rows = $db->query('select aa.round, a.name, aa.appl_result,
        aa.offer_status, aa.appl_remark
      from activities_appl as aa
      inner join activities as a
        on a.id = aa.activity_id
        where aa.nus_id = ? and (aa.round < ?);',
      [[$account->nus_id][0],$round]);
  echo gen_appl_table($rows, 'appl-table table table-hover', $f);
?>
</div>
</div>
</div>
</div>
</section>
</div>



<?php
//  var_dump([[$account->nus_id][0],$round]);
  page_end();
?>
