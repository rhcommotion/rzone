<?php
  require_once 'page-t.php';
  require_once("lib/activity.php");
  require_once("lib/appl.php");

  $activity_id = $_GET['i'];
  $activity = new Activity($activity_id);
  page_start();

  ensure_appl_open();
?>

<div id="content">
    <section>

<style>
  .applicant-table[phase='B'] tr[appl_result='0'] {
    background: #FFD3E0;
  }
  .applicant-table[phase='B'] tr[appl_result='1'] {
    background: #E0F8D8;
  }
  .applicant-table[phase='C'] tr[offer_status='0'] {
    background: #FFD3E0;
  }
  .applicant-table[phase='C'] tr[offer_status='1'] {
    background: #E0F8D8;
  }
  .applicant-table:not([phase='B']) th:last-child,
  .applicant-table:not([phase='B']) td:last-child {
    display: none;
  }
</style>

<h2 class='profile-title'>Application Management</h2>
<h2 class='profile-title'><?php echo $activity->name; ?></h2>

<?php
  if ($phase === 'B') {
?>
<h3>Note: red background means the application was rejected, and green means it was approved.</h3>
<h3>You can make any changes to application status during Round <?php echo $round; ?>B.</h3>
<?php
  } else if ($phase === 'C') {
?>
<h3>Note: red background means the offer was declined by the applicant, and green means it was accepted.</h3>
<?php
  }
?>


<?php
  $applicants = $db->query('call get_activity_applicants(?);', [$activity_id]);
  $f = function ($a) {
    return "<tr nus_id='$a[0]' appl_result='$a[7]' offer_status='$a[8]'>
        <td>$a[1]</td><td>$a[2]</td><td>$a[3]</td>
        <td>$a[4]</td><td>$a[5]</td><td>$a[9]</td><td>$a[6]</td>
        <td>
          <button class='approve-button'>Approve</button>
          <button class='reject-button'>Reject</button>
        </td>
      </tr>";
  };
  echo "<table class='applicant-table' phase='$phase'>
    <thead>
      <tr>
        <th>Name</th>
        <th>Gender</th>
        <th>Phone</th>
        
        <th>Personal Email</th>
        <th>Course</th>
        <th>Year of Study</th>
        <th>Application Remarks</th>
        
        <th>Operations</th>
      </tr>
    </thead>
    <tbody>"
      . join(array_map($f, $applicants)) .
    "</tbody>
    </table>";
?>
<h4>
Number of applications: <?php echo count($applicants); ?>
</h4>

<script>
  var activity_id = <?php echo $activity_id; ?>;
</script>

<script>
  Array.from(document.body.querySelectorAll('.approve-button')).forEach(function (button) {
    button.onclick = function(evt) {
      var row = evt.currentTarget.parentNode.parentNode;
      var appl_nus_id = row.getAttribute('nus_id');
      var xhr = xhr_post('api/appl/process-appl.php',
        {i: activity_id, n: appl_nus_id, r: 1},
        onload);
      function onload() {
        if (this.status === 200) {
          row.setAttribute('appl_result', 1);
        } else {
          alert('Failed to update application status.');
        }
      }
    };
  });
</script>
<script>
  Array.from(document.body.querySelectorAll('.reject-button')).forEach(function (button) {
    button.onclick = function(evt) {
      var row = evt.currentTarget.parentNode.parentNode;
      var appl_nus_id = row.getAttribute('nus_id');
      var xhr = xhr_post('api/appl/process-appl.php',
        {i: activity_id, n: appl_nus_id, r: 0},
        onload);
      function onload() {
        if (this.status === 200) {
          row.setAttribute('appl_result', 0);
        } else {
          alert('Failed to update application status.');
        }
      }
    };
  });
</script>
</section>
</div>
<?php
  page_end();
?>
