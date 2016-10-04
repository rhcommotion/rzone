<?php
// index.php displays profile.
require_once 'page-t.php';
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
</style>
<h2 class='profile-title'>Profile</h2>

<div class='profile-list'>
  <div>Name: <?php echo $account->info['name']; ?></div>
  <div>Room: Blk<?php echo $account->info['block'] . '-' . $account->info['room']; ?></div>
  <div>Phone: <?php echo $account->info['phone']; ?></div>
  <div>Email: <?php echo $account->info['email']; ?></div>
  <div>Birthday: <?php echo date_format(date_create($account->info['birthday']), 'j M Y'); ?></div>
    <div>Major / Course: <?php echo $account->info['course']; ?></div>
  <div>Year of Study: <?php echo $account->info['year_of_study']; ?></div>
  <div>Shirt Size: <?php echo $account->info['shirt_size']; ?></div>
</div>

<h4 class="edit-note">
  * To edit one row, please double click it.
</h4>

<script>
  var elem0 = document.body.query1('class', 'profile-list');
  var dict = ["", "", 'phone', 'email',
              'birthday (dd-mm-yyyy, e.g. 28-02-1994)', 'major / course name',
              'year of study', 'shirt size'];
  Array.from(elem0.children).for_each(function (row, i) {
    if (i < 2) {
      return;
    }
    row.ondblclick = function () {
      var str = 'Please enter your ' + dict[i] + ':';
      var new_val = window.prompt(str);
      if (new_val === null || new_val === '') {
        return;
      }
      if (i === 2) {
        // phone, check
        if (!new_val.match(/^\+?[0-9\-]+/)) {
          alert('The phone number is invalid.');
          return;
        }
      } else if (i === 3) {
        // email
        if (!new_val.match(/@/)) {
          alert('The email address is invalid.');
          return;
        }
      } else if (i === 4) {
        // date
        if (!new_val.match(/^[0-9]{2}-[0-9]{2}-[0-9]{4}/)) {
          alert('The date format is incorrect.');
          return;
        }
      } else if (i === 6) {

      }
      var xhr = xhr_post('api/profile/change.php', {i: i, v: new_val},
        onload);
      function onload() {
        if (xhr.status !== 200) {
          alert('Failed to change the content.');
        } else {
          document.location.reload(true);
        }
      }
    };
  });
</script>

<?php
//var_dump($account->info);
page_end();
?>
