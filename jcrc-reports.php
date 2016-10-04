<?php
  $page = "JCRC System Reports";
  require_once 'page-t2.php';

  if ($account->info['type'] !== 'jcrc') {
    throw new Exception('not jcrc. permission denied.');
  }
  page_start();
?>
<div id="content">
<section>
  <div class="section-header">
    <h2>R-Zone System Reports</h2>
  </div>
  <div class="section-body">
            <!-- BEGIN INTRO -->
            <div class="row">
                <div class="col-sm-10">
                    <article class="margin-bottom-xxl">
                        <p>
                          To report urgent system issues, contact ComMotion Head 86888731 (Chen Si).
                        </p>
                    </article>
                </div>
                <!--end .col -->
            </div>
            <!--end .row -->
            <!-- END INTRO -->
   <div class="col-sm-12"> <div class="card">
     <div class="card-body form-group"><?php
           function gen_options_table($arr, $class, $gen_row) {
             return "<table class='$class'><thead><tr>
             <th>id</th>
             <th>Description</th>
             <th>Argument 1</th>
             <th>Argument 2</th>
             <th class=\"text-right\">Action</th>
             </tr></thead>
             <tbody>" . join(array_map($gen_row, $arr)) . "</tbody></table>";
           }
           $f = function ($a) {
             return "<tr data-id='$a[0]'>
               <td>$a[0]</td>
               <td>$a[1]</td>
               <td><input type=\"text\" class=\"form-control\" id=\"$a[0]v1\" value=\"$a[3]\"></td>
               <td><input type=\"text\" class=\"form-control\" id=\"$a[0]v2\" value=\"$a[4]\"></td>
               <td><button class=\"save-option btn ink-reaction btn-primary\"><i class=\"fa fa-pencil\"></i></button></td>
             </tr>";
           };
           $options = $db->query('select * from jcrc_reports;');
           echo gen_options_table($options, 'table', $f);
         ?></div>
   </div></div>
</section></div>
<script>
var request;
  Array.from(document.body.querySelectorAll('.save-option')).forEach(function (button) {


    button.onclick = function(evt) {
      var row = evt.currentTarget.parentNode.parentNode;
      var k = row.getAttribute('data-id');
      var v1 = $('#' + k + 'v1').val();
      var v2 = $('#' + k + 'v2').val();
      window.open('api/jcrc/report-gen?id=' + k + '&var1=' + v1 + '&var2=' + v2);
          
  

    };
  });
</script>


<?php
  page_end();
?>
<script src="assets/js/libs/toastr/toastr.js"></script>