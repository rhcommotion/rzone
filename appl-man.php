<?php
  $page = "Applications Management";
  require_once 'page-t2.php';
  require_once("lib/activity.php");
  require_once("lib/appl.php");


  $activity_id = $_GET['i'];

  $is_head = $db->query_get1('select is_activity_head_of(?, ?);', [$account->info['nus_id'], $activity_id]);
  if($is_head == 0){
    throw new Exception('Access Denied. Violation has been recorded');
  }


  $quota = $db->query_get1('select size from activities where id = ?', [$activity_id]);
  $num_member = intval($db->query_get1('select get_activity_member_count(?)', [$activity_id]));
  $remain_quota = $quota - $num_member;
  $activity = new Activity($activity_id);
  page_start();

  ensure_appl_open();
?>
<style>
  .applicant-table[phase='B'] tr[data-appl-result='0'] {
    background: #FFD3E0;
  }
  .applicant-table[phase='B'] tr[data-appl-result='1'] {
    background: #E0F8D8;
  }
  .applicant-table[phase='C'] tr[data-offer-status='0'] {
    background: #FFD3E0;
  }
  .applicant-table[phase='C'] tr[data-offer-status='1'] {
    background: #E0F8D8;
  }
  .applicant-table:not([phase='B']) th:last-child,
  .applicant-table:not([phase='B']) td:last-child {
    display: none;
  }
</style>


  <div id="content">
      <section class="style-default-bright">
          <div class="section-header">


        <ol class="breadcrumb">
                  <li>Applications Management</li>
                        <li class="active"><?php echo $activity->name; ?>
                        (<?php 
                        $applicants = $db->query('call get_activity_applicants(?);', [$activity_id]);
                        echo count($applicants); ?>)
                        </li>
            </ol>

        </div>

              <div class="alert alert-callout alert-success" role="alert">

        
<?php
  if ($phase === 'B') {
?>
Note: red background means the application was rejected, and green means it was approved.
You may update your decision anytime during Round <?php echo $round; ?>B. <br> Applicants will only see the outcome in round C.
</div><div class="alert alert-callout alert-warning">You are to issue <?php echo $remain_quota;?> offer(s) in this round unless there are insufficient applicants.
<?php
  } else if ($phase === 'C') {
?>
Note: red background means the offer was declined by the applicant, and green means it was accepted.
<?php
  }
?>

      </div>
<?php
  
  $f = function ($a) {
    return "<tr nus_id=\"$a[0]\" data-appl-result=\"$a[7]\" data-offer-status=\"$a[8]\">
        <td>$a[1]</td><td>$a[2]</td><td>$a[5] / $a[9]</td><td>$a[6]</td>
        <td class=\"text-right\">
          <button type=\"button\" class=\"btn btn-icon-toggle approve-button\"><i class=\"md md-check\"></i></button>
          <button type=\"button\" class=\"btn btn-icon-toggle reject-button\"><i class=\"md md-close\"></i></button>
        </td>
      </tr>";
  };
  echo "<table class=\"applicant-table table table-responsive table-hover table-condensed\" phase=\"$phase\">
    <thead>
      <tr>
        <th style=\"width:36%\">Name</th>
        <th style=\"width:5%\">Sex</th>

        <th style=\"width:25%\">Course</th>
        <th style=\"width:24%\">Application Remarks</th>
        
        <th style=\"width:10%\">Offer</th>
      </tr>
    </thead>
    <tbody>"
      . join(array_map($f, $applicants)) .
    "</tbody>
    </table>";
?>


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
        if (this.response.substring(0,7) == 'Success') {
          row.setAttribute('data-appl-result', 1);
          toastr.success(this.response);
        } else {
          toastr.error(this.response);
        }
      }
    };
  });
</script>

</section>

<?php
  page_end();
?>

<script>
  Array.from(document.body.querySelectorAll('.reject-button')).forEach(function (button) {
    button.onclick = function(evt) {
      var row = evt.currentTarget.parentNode.parentNode;
      var appl_nus_id = row.getAttribute('nus_id');
      var xhr = xhr_post('api/appl/process-appl.php',
        {i: activity_id, n: appl_nus_id, r: 0},
        onload);
      function onload() {
        if (this.response.substring(0,7) == 'Success') {
          row.setAttribute('data-appl-result', 0);
          toastr.info(this.response);
        } else {
          toastr.error(this.response);
        }
      }
    };
  });

  function xhr_post(url, obj, cb) {
  var xhr = new XMLHttpRequest();
  if (cb === void 0) {
    xhr.open('POST', url, false);
  } else {
    xhr.onload = cb;
    xhr.open("POST", url, true);
  }
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  var str = Object.keys(obj).map(function (k) {
    return k + '=' + encodeURIComponent(obj[k]);
  }).join('&');
  xhr.send(str);
  return xhr;
};

$(document).ready(function () {
    toastr.clear();
    toastr.options.positionClass = 'toast-bottom-left';
    toastr.options.showEasing = 'swing';
    toastr.options.hideEasing = 'swing';
    toastr.options.showMethod = 'slideDown';
    toastr.options.hideMethod = 'slideUp';
  });
</script>