<?php
  $page = "Activities Quota Report";
  require_once 'page-t2.php';

  page_start();
?>

<div id="content">
<section>
  <div class="section-header">
    <h2>Round 2 Activity Quota Report</h2>
  </div>
  <div class="section-body">
  <div class="col-sm-12">
             
<!--               <div class="alert alert-callout alert-success" role="alert">
              <p>'High' means the number of applicants exceeds the remaining quota. 'Very High' means the number of applicants is more than twice the remaining quota.</p>
              <p>The list below is sorted by remaining quota, from the highest to the lowest.</p>
              </div> -->
                
       
   <div class="card">
       <div class="card-body form-group"><?php
           function gen_options_table($arr, $class, $gen_row) {
             return "<table class='$class'><thead><tr>
             <th>Activity</th>
             <th>Head</th>
             <th>Remaining Quota</th>
             </tr></thead>
             <tbody>" . join(array_map($gen_row, $arr)) . "</tbody></table>";
           }
           $f = function ($a) {
           		if($a[2] <= 0)
           			$str2 = "<tr class=\"danger\"><td>$a[0]</td><td>$a[1]</td><td><i class=\"md md-close\"></i><strong>Zero Quota</strong></td></tr>";
             	elseif($a[2] < 3)
             		$str2 = "<tr class=\"warning\"><td>$a[0]</td><td>$a[1]</td><td>Limited</td></tr>";
              else
             		$str2 = "<tr><td>$a[0]</td><td>$a[1]</td><td>Available</td></tr>";
             	return $str2;
               
           };
           $options = $db->query('call get_appl_stats_residents();');
           echo gen_options_table($options, 'table table-condensed table-hover', $f);
         ?></div>
         <?php page_end();?>