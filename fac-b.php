<?php
  require_once 'page-t.php';
  require_once("lib/activity.php");
  require_once 'lib/account.php';
  
  $venue = $_GET['v'];
  $date = $_GET['d'];
  
  page_start();
?>

<style>
	.profile-title {
		text-align: center;
	}
	.profile-list {
		font-size: 120%;
		line-height: 1.5;
	}
  .booking-table {
    min-width: 40%;
    margin-bottom: 1em;
  }
  .booking-table[user_type='resident'] .account-type, 
  .booking-table[user_type='resident'] td:nth-child(3), 
  .booking-table:not([user_type='jcrc']) .approval-button {
    display: none;
  }
  #book {
    margin-bottom: 1.5em;
  }
  #time-op, #time-ed {
    width: 5.5ch;
  }
  #submit {
    margin-top: 1ch;
    margin-left: 24em;
  }
  #new-booking {
    opacity: 0;
    transition: opacity 0.618s;
    margin-top: .75rem;
    margin-left: 2ch;
  }
  #new-booking.show {
    opacity: 1;
  }
</style>

<h2 class='profile-title'>Facilities Booking</h2>

<div style='font-size: 120%;'>
  Venue:
  <select id='venue-sel'>
    <?php
      $fac_list = $db->query('call get_facilities();');
      foreach ($fac_list as $row) {
        $id = $row['id'];
        $name = $row['name'];
        echo "<option value='$id'" . ($id == $venue ? " selected='selected'" : "") . ">$name</option>";
      }
    ?>
  </select>
</div>

<div style='font-size: 120%; margin-top: 1ch;'>
  Date:
  <select id='date-sel'>
    <?php
      $date0 = new DateTime('now');
      $intv = new DateInterval('P1D');
      $date1 = new DateTime('2016-1-1');
      $p = new DatePeriod($date0, $intv, $date1);
      foreach ($p as $date1) {
        $date_str1 = $date1->format("Y-m-d");
        echo "<option" . ($date == $date_str1 ? " selected='selected'" : "") 
        . " value='" . $date_str1 . 
        "'>" . $date1->format("j M Y") . "</option>";
      }
    ?>
  </select>
</div>

<h3>Bookings</h3>

<?php
  $t = $account->info['type'];
  if ($t === 'resident') {
    $is_head = $db->query_get1('select is_activity_head(?);', [$account->nus_id]);
    if ($is_head) {
      $t = 'head';
    }
  }
  //
  $bk_list = $db->query("call get_fac_booking('$venue', '$date');");
  echo "<table class='booking-table' user_type='$t'>
    <thead>
      <tr>
        <th>Timeslot</th>
        <th>Booked By</th>
        <th class='account-type'>Account Type</th>
        <th>Approval</th>
      </tr>
    </thead>
    <tbody>";
    foreach($bk_list as $row) {
      $dt = new DateTime($row['time']);
      $time0 = $dt->format('H:i');
      $dt->modify('+ ' . $row['duration'] . 'minute');
      $time1 = $dt->format('H:i');
      $bk_id = $row[0];
      echo "<tr bk_id='$bk_id'>
          <td>$time0 - $time1</td>
          <td>$row[1]</td>
          <td>";
      if ($t !== 'resident') {
        $t1 = $db->query_get1('select type from members where nus_id = ?;', [$row[1]]);
        if ($t1 === 'resident') {
          $is_head = $db->query_get1('select is_activity_head(?);', [$row[1]]);
          if ($is_head) {
            $t1 = 'head';
          }
        }
        echo $t1;
      }
      echo "</td>
          <td class='approval-td' status='$row[4]'>
            $row[4]
            <button class='approval-button'>Approve</button>
          </td>
        </tr>";
    }
    echo "</tbody>
        </table>";
?>


<button id='book-new'>New Booking</button>
<div id='new-booking'>
  <div>
    Timeslot (24-hour format):
    <input id='time-op' type='number' min='0' max='23'> : 00
    -
    <input id='time-ed' type='number' min='1' max='24'> : 00
  </div>
  <button id='submit'>Submit</button>
</div>

<script>
  var appr_btns = document.body.getElementsByClassName('approval-button');
  appr_btns.for_each(function(btn) {
    btn.onclick = function() {
      var id = btn.parentNode.parentNode.getAttribute('bk_id');
      var xhr = xhr_post('api/fac-b/approve.php', {i:id});
      if (xhr.status !== 200) {
        alert('Operation failed due to server error.');
      } else {
        document.location.reload(true);
      }
    };
  });
</script>

<script>
  var venue_sel = document.getElementById('venue-sel');
  var date_sel = document.getElementById('date-sel');
  //var time_op = document.getElementById('time-op');
  //var time_ed = document.getElementById('time-ed');
  
  venue_sel.onchange = f_refresh;
  date_sel.onchange = f_refresh;
  function f_refresh() {
    window.location = 'fac-b.php?v=' + venue_sel.value
                      + '&d=' + date_sel.value;
  }

</script>

<script>
  var button_new = document.getElementById('book-new');
  var new_sec = document.getElementById('new-booking');
  button_new.onclick = function () {
    new_sec.classList.toggle('show');
  };
</script>

<script>
  var bk_list = JSON.parse('<?php
    echo json_encode($bk_list);
  ?>');
  var user_type = '<?php echo $t; ?>';
  
  var time_op = document.getElementById('time-op');
  var time_ed = document.getElementById('time-ed');
  
  var submit_button = document.getElementById('submit');
  submit_button.onclick = f_submit;
  
  var submitted = false;
  function f_submit() {
    var t0 = Math.round(+time_op.value);
    var t1 = Math.round(+time_ed.value);
    if (t1 === 0) {
      t1 = 24;
    }
    if (t0 >= t1 || t0 < 0 || t0 > 23 || t1 < 1 || t1 > 24) {
      alert('The time range is invalid.');
      return;
    }
    if (!confirm('The timeslot is ' + t0 + ':00 - ' + t1 + ':00. Confirm?')) {
      return;
    }
    //
    if (submitted) {
      return;
    }
    submitted = true;
    var xhr = xhr_post('api/fac-b/book.php', 
      {v: venue_sel.value, 
       s: date_sel.value + ' ' + t0 + ':00:00',
       d: (t1 - t0)
     }, 
      onload);
      function onload() {
        if (xhr.status === 200) {
          document.location.reload(true);
        } else {
          alert('Sorry, the booking was not successful due to server error.');
          submitted = false;
        }
      }
  }
</script>

<?php
  page_end();
?>
