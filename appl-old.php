<?php
  require_once 'page-t.php';
  require_once("lib/activity.php");
  require_once("lib/appl.php");

	$max_sel = get_appl_max_num();
  page_start();

  if ($round < 0) {
    echo "Activity application is currently not open.";
    page_end();
    exit();
  }
  if ($phase !== 'A') {
    echo "This page is only available in A-rounds.
        The current round is $round$phase.";
    page_end();
    exit();
  }

  $c = $db->query_get1("select count(*) from members where (nus_id = ?) and
    (name = '' or phone = '' or email = '' or year_of_study = ''
     or course = '' or birthday = '0000-00-00' or shirt_size = '');",
      [$account->nus_id]);
  if ($c == 1) {
    echo "Please fill in missing information in your profile before applying for activities.";
    page_end();
    exit();
  }
?>

  <style>
	.activity-table td:first-child {
		width: 9em;
	}
	.activity-table tr:hover {
		background: #D1EEFC;
	}
	.activity-table tr[selected] {
		background: #E0F8D8;
	}
	.activity-table tr[selected]:hover {
    background: #a4e786;
	}
  table {
      width: 100%;
	}
	.selected-table tr:not([selected]) {
		display: none;
	}
	.selected-table td:first-child {
		width: 9em;
	}
	.selected-table td:nth-child(2) {
		width: 16em;
	}
	.selected-table td:first-child:hover {
		background: #FFD3E0;
	}
	#appl-all {
		position: absolute;
		right: 1px;
		font-size: 120%;
		padding: 6px;
	}
	.appl-remarks {
    width: 100%;
  }
  </style>
	<style>
		.activity-appl-title {
			text-align: center;
		}
		.activity-cat {
			text-align: center;
			margin: 1.5em 0 .5em 0;
		}
    /* only show activity name */
    .activity-table td:nth-child(2) {
      display: none;
    }
    .activity-table > tbody {
      position: relative;
      display: -webkit-flex;
      display: flex;
      -webkit-flex-wrap: wrap;
      flex-wrap: wrap;
    }
    .activity-table tr {
      width: 20%;
      display: -webkit-flex;
      display: flex;
    }
    .activity-table td:first-child {
      display: block;
      -webkit-flex: 1;
      flex: 1;
      margin: 2px;
      /display: -webkit-flex;
      /display: flex;
    }
	</style>

	<h2 class='activity-appl-title'>Activity Application</h2>
	<p>
		<h3>Select activities by clicking their names.</h3>
		<?php
      $f = function ($a) {
        return "<tr activity_id='$a[0]'><td>$a[2]</td><td>$a[3] &nbsp;</td></tr>";
      };
    	echo gen_activity_cats_tables('activity-table', $f);
		?>
	</p>
	<p style="margin-top: 2rem;border-top: 2px dashed silver;">
		<h3>Selected Activities</h3>
		<h4>
      To deselect an activity, please click its name below.
    </h4>
		<?php
      $f = function ($a) {
        return "<tr activity_id='$a[0]'><td>$a[2]</td><td>$a[4] &nbsp;</td>
          <td><textarea class='appl-remarks' placeholder='Application Remarks'></textarea></td>
        </tr>";
      };
      echo gen_activities_table(get_activities(), 'selected-table', $f);
		?>
		<p style="position: relative;">
			<button id='appl-all' onclick='submit();'>Submit</button>
		</p>
    <h4>
      * You can apply for up to
      <?php echo "$max_sel " . ($max_sel === 1 ? 'activity' : 'activities'); ?>
      in this round.
      <br>* You can only apply for one activity in the "Social Committees" category.
    </h4>
	</p>

	<script>
		var max_sel = <?php echo $max_sel; ?>;
		var submit_button = document.getElementById('appl-all');
		var submitting = 0;
		function submit() {
      if (submitting !== 0) {
        return;
      }
			var rows = document.querySelectorAll('.selected-table tr[selected]');

			if (rows.length > max_sel) {
        alert('Cannot apply for too many activities.');
        return;
      }

      submitting = rows.length;
      submit_button.setAttribute('disabled', '');
      function onload() {
        if (this.status !== 200) {
          alert('An error occurred during submission. The server will now redirect you to the "My Applications" page. ' +
            'Please check for missing applications there and apply again. Sorry about this.');
          window.location = 'my-appl.php';
        } else {
          submitting--;
          if (submitting === 0) {
            window.location = 'my-appl.php';
          }
        }
      }
      var rtn = Array.from(rows).forEach(function (row) {
        var activity_id = row.getAttribute('activity_id');
        var remark = row.querySelector('.appl-remarks').value;
        var xhr = xhr_post('api/appl/appl.php', {i: activity_id, r: remark}, onload);
      });
		}

		function check_max_sel() {
      var rows = document.querySelectorAll('.selected-table tr[selected]');
      var flag = (rows.length > max_sel);
      // check social committee restriction
      var rows2 = document.querySelectorAll('.activity-table[category="Social Committees"] tr[selected]');
      flag = flag || (rows2.length > 1);
      console.log('rows2', rows2);
      if (flag) {
        submit_button.setAttribute('disabled', '');
      } else if (submit_button.hasAttribute('disabled')) {
        submit_button.removeAttribute('disabled');
      }
    }

    function toggle_row(row0, class_name) {
      var activity_id = row0.getAttribute('activity_id');
			var row = document.querySelector(
				'.' + class_name + ' tr[activity_id="' + activity_id + '"]'
			);
			if (row.hasAttribute('selected')) {
				row0.removeAttribute('selected');
				row.removeAttribute('selected');
			} else {
				row0.setAttribute('selected', '1');
				row.setAttribute('selected', '1');
			}
			check_max_sel();
    }
	</script>

	<script>
		var rows = document.querySelectorAll('.activity-table tr');
		var len = rows.length;
		for (var i = 0; i < len; i++) {
			var row = rows[i];
			row.onclick = function (evt) {
				var row = evt.currentTarget;
				toggle_row(row, 'selected-table');
			};
		}
	</script>
	<script>
		var rows = document.querySelectorAll('.selected-table td:first-child');
		var len = rows.length;
		for (var i = 0; i < len; i++) {
			var row = rows[i];
			row.onclick = function (evt) {
				var row = evt.currentTarget.parentNode;
				toggle_row(row, 'activity-table');
			};
		}
	</script>

	<?php
	  page_end();
	?>
