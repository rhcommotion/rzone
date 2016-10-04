<?php
  $page = "Router Management";
  require_once 'page-t2.php';
  include_once 'lib/router.php';
  page_start();

  if(get_router_priv() == 0)
    exit('ERROR');
?>


  <div id="content">
      <section class="style-default-bright">
          <div class="section-header">
              <h2 class="activity-appl-title">
                  Router Management
              </h2>
          </div>
          <div class="section-body" >
              <div class="table-responsive" style=" overflow-x:initial;">
                  <table class="table order-column hover" id="datatable2" data-source="api/router/router-db" data-swftools="assets/js/libs/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf">
                      <thead>
                          <tr>
                              <th style="width:2%""></th>
                              <th style="width:20%">Name</th>
                              <th style="width:12%">Model</th>
                              <th style="width:10%">Mac</th>
                              <th style="width:5%">Status</th>
                              <th style="width:10%">Config by</th>
                              <th style="width:10%">Registered by</th>
                              <th style="width:30%">Remark</th>

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

  function configmbr(id){
    var request;

    request = $.ajax({
        url: "api/router/status?action=config",
        type: "post",
        data: {'n' : id}


    });

    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        toastr.success(response);
        $('#datatable2').DataTable().ajax.reload();
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        toastr.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

  }

  function sharepointmbr(id){
    var request;

    request = $.ajax({
        url: "api/router/status?action=sharepoint",
        type: "post",
        data: {'n' : id}


    });

    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        toastr.success(response);
        $('#datatable2').DataTable().ajax.reload();
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        toastr.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });


  }
 
    



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
        {"data": "model"},
        {"data": "mac"},
        {"data": "status"},
        {"data": "config_ic"},
        {"data": "sharepoint_ic"},
        {"data": "remark"},
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
        '<td>Config Date</td>' +
        '<td>' + d.config_date + '</td>' +
        '<td>SharePoint Submission</td>' +
        '<td>' + d.sharepoint_date + '</td><td></td>' +
        '</tr>' +

        '<tr><td>Operations</td>' +
        '<td><button class="btn btn-default btn-raised config" onclick="configmbr(\'' + d.nus_id + '\');">Config Finished</button></td>' +
        '<td><button class="btn btn-default btn-raised sharepoint"  onclick="sharepointmbr(\'' + d.nus_id + '\');">SharePoint Submitted</button></td>' +
        '<td><a class="btn btn-default btn-raised edit" target="_blank" href="router-edit?n='+ d.nus_id + '">Edit Info</a></td>' +
        '</tr></table>';
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

      }
    });



});
</script>
  </body>
</html>