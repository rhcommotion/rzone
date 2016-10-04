<?php
  require_once 'page-t.php';

  if ($account->info['type'] !== 'jcrc') {
    throw new Exception('not jcrc. permission denied.');
  }
  page_start();
?>

  <style>
	.residents-table tr:hover {
		background: #D1EEFC;
	}
	.residents-table tr[selected] {
		background: #E0F8D8;
	}
	.residents-table tr[selected]:hover {
    background: #a4e786;
	}
  table {
      width: 100%;
	}
  #submit {
    display: block;
    margin-left: auto;
    margin-right: 2px;
    font-size: 120%;
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
      -webkit-flex: 1;
      flex: 1;
      margin: 2px;
      /display: -webkit-flex;
      /display: flex;
    }
	</style>

	<h2 class='activity-appl-title'>Residents</h2>
	<p>
		<?php
    $residents = $db->query('select nus_id, name, sex, block, room, 
          phone, email, course, year_of_study, shirt_size from members;');
    $f = function ($a) {
      return "<tr nus_id='$a[0]'>
          <td>$a[1]</td><td>$a[2]</td><td>Blk$a[3]-$a[4]</td><td>$a[5]</td>
          <td>$a[0]</td><td>$a[6]</td><td>$a[7]</td><td>$a[8]</td>
          <td>$a[9]</td>
        </tr>";
    };
    echo "<table class='residents-table' type='$user_type'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Gender</th>
          <th>Room</th>
          <th>Phone</th>
          
          <th>NUSNET ID</th>
          <th>Personal Email</th>
          <th>Course</th>
          <th>Year of Study</th>
          <th>Shirt Size</th>
        </tr>
      </thead>
      <tbody>"
        . join(array_map($f, $residents)) .
      "</tbody>
      </table>";
		?>
	</p>
  
  <?php if ($_GET['u']) {
  ?>
    <button id='submit'>Submit</button>
  <?php
  }
  ?>
  
  <script>
    Array.from(document.body.query('.residents-table > tbody > tr')).for_each(function (row) {
      row.onclick = function() {
        if (row.hasAttribute('selected')) {
          row.removeAttribute('selected');
        } else {
          row.setAttribute('selected', '');
        }
      };
    });
  </script>
  <script>
    var submit_button = document.query('id', 'submit');
    var submitted = false;
    submit_button.onclick = function() {
      if (submitted) {
        return;
      }
      submitted = true;
      var str = Array.from(
        document.body.query('.residents-table > tbody > tr[selected]')
      ).map(function(row) {
        return row.getAttribute('nus_id');
      }).join(',');
      post(<?php echo "'" . $_GET['u'] . "', {ns: str, " . $_GET['q'] . "}"; ?>)
      
      function post(path, params, method) {
       method = method || "post"; // Set method to post by default if not specified.

       // The rest of this code assumes you are not using a library.
       // It can be made less wordy if you use one.
       var form = document.createElement("form");
       form.setAttribute("method", method);
       form.setAttribute("action", path);

       for(var key in params) {
           if(params.hasOwnProperty(key)) {
               var hiddenField = document.createElement("input");
               hiddenField.setAttribute("type", "hidden");
               hiddenField.setAttribute("name", key);
               hiddenField.setAttribute("value", params[key]);

               form.appendChild(hiddenField);
            }
       }

       document.body.appendChild(form);
       form.submit();
   }
      
    };
  </script>
	

	<?php
	  page_end();
	?>
