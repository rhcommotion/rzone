<?php
  require_once 'page-t.php';
  require_once("lib/activity.php");
  require_once("lib/appl.php");

  $activity_id = $_GET['i'];

  $is_head = $db->query_get1('select is_activity_head_of(?, ?);', [$account->info['nus_id'], $activity_id]);
  if($is_head == 0){
    throw new Exception('Access Denied. Violation has been recorded. lol');
  }

  $activity = new Activity($activity_id);
  page_start();

  ensure_appl_open();
?>

<style>
	.profile-title {
		text-align: center;
	}
	.profile-list {
		font-size: 120%;
		line-height: 1.5;
	}
</style>
<style>
  .applicant-table {
    margin-top: 1rem;
  }
  .applicant-table:not([type='jcrc']) th:last-child,
  .applicant-table:not([type='jcrc']) th:nth-last-child(2),
  .applicant-table:not([type='jcrc']) td:last-child,
  .applicant-table:not([type='jcrc']) td:nth-last-child(2)  {
    display: none;
  }
</style>

<h2 class='profile-title'>Activity Management</h2>
<h2 class='profile-title'><?php echo $activity->name; ?></h2>

<?php
if ($account->info['type'] === 'jcrc') {
?>
  <button id='add-member'>Add Members</button>
  <script>
    document.query('id', 'add-member').onclick = function (evt) {
      window.location = 'jcrc-residents.php?&i=<?php echo $activity_id; ?>';
    };
  </script>
<?php
}
?>

<?php
  $applicants = $db->query('call get_activity_members(?);', [$activity_id]);
  $f = function ($a) {
    return "<tr nus_id='$a[0]' type='$a[8]'>
        <td>$a[1]</td><td>$a[2]</td><td>$a[0]</td>
        <td>$a[5]</td><td>$a[6]</td><td class='role-cell'>$a[9]</td>
        <td class='permission-cell'>$a[10]</td>
        <td>
          <button class='delete-button'>Delete Member</button>
        </td>
      </tr>";
  };
  $user_type = $account->info['type'];
  echo "<table class='applicant-table' type='$user_type'>
    <thead>
      <tr>
        <th>Name</th>
        <th>Gender</th>
        
        <th>NUSNET</th>
        
      
        <th>Course</th>
        <th>Year of Study</th>
        <th>Role<br>(double click to edit)</th>
        <th>Permission<br>(double click to edit)</th>
        <th>Operations</th>
      </tr>
    </thead>
    <tbody>"
      . join(array_map($f, $applicants)) .
    "</tbody>
    </table>";
?>
<h4>
Number of members: <?php echo count($applicants); ?>
</h4>

<script>
  var activity_id = <?php echo $activity_id; ?>;
</script>

<script>
  Array.from(document.body.querySelectorAll('.role-cell')).forEach(function (cell) {
    cell.ondblclick = function(evt) {
      var row = evt.currentTarget.parentNode;
      var member_nus_id = row.getAttribute('nus_id');
      var val = window.prompt('Please enter the role of this member:');
      if (val === null || val === '') {
        return;
      }
      var xhr = xhr_post('api/activity/change-role.php',
        {i: activity_id, n: member_nus_id, r: val},
        onload);
      function onload() {
        if (this.status === 200) {
          document.location.reload(true);
        } else {
          alert("Failed to update the member's role.");
        }
      }
    };
  });
</script>
<script>
  Array.from(document.body.querySelectorAll('.permission-cell')).forEach(function (cell) {
    cell.ondblclick = function(evt) {
      var row = evt.currentTarget.parentNode;
      var member_nus_id = row.getAttribute('nus_id');
      var val = window.prompt('Please enter the permission of this member ("jcrc", "head", or "member"):');
      if (val === null || val === '') {
        return;
      }
      if (val !== 'jcrc' && val !== 'head' && val !== 'member') {
        alert('Invalid permission name.');
        return;
      }
      if (!window.confirm('Please confirm this operation.'
        + ' Misconfiguration might prevent you from using this admin panel.')) {
          return;
      }
      var xhr = xhr_post('api/activity/change-permission.php',
        {i: activity_id, n: member_nus_id, p: val},
        onload);
      function onload() {
        if (this.status === 200) {
          document.location.reload(true);
        } else {
          alert("Failed to update the member's permission.");
        }
      }
    };
  });
</script>

<script>
  Array.from(document.body.querySelectorAll('.delete-button')).forEach(function (button) {
    button.onclick = function(evt) {
      var row = evt.currentTarget.parentNode.parentNode;
      var member_nus_id = row.getAttribute('nus_id');
      if (!window.confirm('Are you sure that you want to remove this member from the activity?')) {
        return;
      }
      var xhr = xhr_post('api/activity/remove-member.php',
        {i: activity_id, n: member_nus_id},
        onload);
      function onload() {
        if (this.status === 200) {
          document.location.reload(true);
        } else {
          alert("Failed to remove the member.");
        }
      }
    };
  });
</script>

<?php
  page_end();
?>
