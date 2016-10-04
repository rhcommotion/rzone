<?php
  $page = "JCRC System Settings";
  require_once 'page-t2.php';

  if ($account->info['type'] !== 'jcrc') {
    throw new Exception('not jcrc. permission denied.');
  }
  page_start();
?>
<div id="content">
<section>
  <div class="section-header">
    <h2>R-Zone System Options</h2>
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
             <th>Option</th>
             <th>Description</th>
             <th>Value</th>
             <th>Operations</th>
             </tr></thead>
             <tbody>" . join(array_map($gen_row, $arr)) . "</tbody></table>";
           }
           $f = function ($a) {
             return "<tr k='$a[0]'>
               <td>$a[0]</td>
               <td>$a[1]</td>
               <td><input type=\"text\" class=\"option-val\" value=\"$a[2]\"></td>
               <td><button class=\"save-option btn ink-reaction btn-primary\">Save</button></td>
             </tr>";
           };
           $options = $db->query('select k, remark, v from options;');
           echo gen_options_table($options, 'table', $f);
         ?></div>
   </div></div>
</section></div>
<script>
var request;
  Array.from(document.body.querySelectorAll('.save-option')).forEach(function (button) {


    button.onclick = function(evt) {
      if(request){
          request.abort();
      }
      var row = evt.currentTarget.parentNode.parentNode;
      var k = row.getAttribute('k');
      var v = row.querySelector('.option-val').value;
      request = $.ajax({
        url: "api/jcrc/change-option.php",
        type: "post",
        data: {k: k, v: v}
      });
    
      request.done(function (response, textStatus, jqXHR){
          toastr.clear();
          toastr.options.positionClass = 'toast-bottom-left';
          toastr.options.showEasing = 'swing';
          toastr.options.hideEasing = 'swing';
          toastr.options.showMethod = 'slideDown';
          toastr.options.hideMethod = 'slideUp';
          toastr.success('System setting succsessfully updated.');
          
      });


    };
  });
</script>


<?php
  page_end();
?>
<script src="assets/js/libs/toastr/toastr.js"></script>