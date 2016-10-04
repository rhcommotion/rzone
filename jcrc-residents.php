<?php
  $page = "JCRC Residents Management";
  require_once 'page-t2.php';

  if ($account->
info['type'] !== 'jcrc') {
    throw new Exception('not jcrc. permission denied.');
  }
 
  page_start();
?>


  <div id="content">
      <section class="style-default-bright">
          <div class="section-header">
              <h2 class="activity-appl-title">
                  Residents List
              </h2>
          </div>
          <div class="section-body" >
              <div class="table-responsive" style=" overflow-x:initial;">
                  <table class="table order-column hover" id="datatable2" data-source="api/jcrc/residents-db" data-swftools="assets/js/libs/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf">
                      <thead>
                          <tr>
                              <th></th>
                              <th style="width:20%">Name</th>
                              <th style="width:5%">Sex</th>
                              <th style="width:9%">Rm#</th>
                              <th style="width:13%">Phone</th>
                              <th style="width:13%">NUSNET ID</th>
                              <th style="width:10%">Email</th>
                              <th style="width:20%">Course</th>
                              <th style="width:5%">Year</th>
                              <th style="width:5%">Shirt</th>
                          </tr>
                      </thead>
                  </table>
              </div>
  
              <?php if (isset($_GET['u'])) { ?>
              <button id="submit">
                  Submit
              </button>
              <?php
                }
                ?>
          </div>
      </section>
  </div>

</div>



  <!-- BEGIN JAVASCRIPT -->
    <script src="assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
    <script src="assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/libs/bootstrap/bootstrap.min.js"></script>
    <script src="assets/js/libs/spin.js/spin.min.js"></script>
    <script src="assets/js/libs/autosize/jquery.autosize.min.js"></script>
    <script src="assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
    <script src="assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
    <script src="assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
    <script src="assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
    <script src="assets/js/core/source/App.js"></script>
    <script src="assets/js/core/source/AppNavigation.js"></script>
    <script src="assets/js/core/source/AppOffcanvas.js"></script>
    <script src="assets/js/core/source/AppCard.js"></script>
    <script src="assets/js/core/source/AppForm.js"></script>
    <script src="assets/js/core/source/AppNavSearch.js"></script>
    <script src="assets/js/core/source/AppVendor.js"></script>
    <script src="assets/js/libs/toastr/toastr.js"></script>


<script type="text/javascript">
<?php if(isset($_GET['i'])){?>
  function addmbr(id){
    var request;

    request = $.ajax({
        url: "add-members.php",
        type: "post",
        data: {'i' : <?php echo (isset($_GET['i']) ? $_GET['i'] : "")?>,
               'ns' : id}


    });

    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        toastr.success(response);
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        toastr.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });


    $("#cca" + id).load('api/jcrc/residents-db?action=list&uid='+ id);
  }
    


 <?php } ?>

$(document).ready(function () {
      toastr.clear();
      toastr.options.positionClass = 'toast-bottom-left';
      toastr.options.showEasing = 'swing';
      toastr.options.hideEasing = 'swing';
      toastr.options.showMethod = 'slideDown';
      toastr.options.hideMethod = 'slideUp';
      var table = $('#datatable2').DataTable({
      "dom": 'T<"clear">lfrtip',
      "ajax": $('#datatable2').data('source'),
      "columns": [
        {
          "class": 'details-control',
          "orderable": false,
          "data": null,
          "defaultContent": ''
        },
        {"data": "name"},
        {"data": "sex"},
        {"data": "room"},
        {"data": "phone"},
        {"data": "nus_id"},
        {"data": "email"},
        {"data": "course"},
        {"data": "year_of_study"},
        {"data": "shirt_size"}
      ],
      "tableTools": {
        "sSwfPath": $('#datatable2').data('swftools')
      },
  
      "language": {
        "lengthMenu": '_MENU_ entries per page',
        "search": '<i class="fa fa-search"></i>',
        "paginate": {
          "previous": '<i class="fa fa-angle-left"></i>',
          "next": '<i class="fa fa-angle-right"></i>'
        }
      }
    });



    formatDetails = function(d) {



    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Date of Birth</td>' +
        '<td>' + d.birthday + '</td>' +
        '<td>Nationality</td>' +
        '<td>' + d.nationality + '</td>' +
        '</tr>' +
        '<tr><td>Current Applications</td>' +
        '<td id="appl' + d.nus_id + '"></td></tr>' +
        '<tr>' +
        '<td>Member of</td>' +
        '<td id="cca' + d.nus_id + '"></td>' <?php if(isset($_GET['i'])){?>+
        '<td><button class="btn btn-raised ink-reaction btn-primary add-mb-btn" onclick="addmbr(\'' + d.nus_id + '\');">Add to <?php echo $db->query_get1('select get_activity_by_id(?);',[$_GET['i']]);?></a></td>' <?php } ?>+
        '</tr>' +
        '</table>';
  };


        //Add event listener for opening and closing details
    $('#datatable2 tbody').on('click', 'td.details-control', function() {
      var tr = $(this).closest('tr');
      var row = table.row(tr);

      if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
      }
      else {
        // Open this row
        row.child(formatDetails(row.data())).show();
        tr.addClass('shown');
        $("#cca" + row.data().nus_id).load('api/jcrc/residents-db?action=list&uid='+ row.data().nus_id);
        $("#appl" + row.data().nus_id).load('api/jcrc/residents-db?action=applist&uid='+ row.data().nus_id);
      }
    });

});
</script>
  </body>
</html>