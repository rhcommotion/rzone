<?php
  $page="Current Applications";
  require_once 'page-t2.php';
  require_once("lib/activity.php");
  require_once("lib/appl.php");  
  page_start();
?>
<!-- BEGIN SIMPLE MODAL MARKUP -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="cancelLabel">Confirm Action</h4>
      </div>
      <div class="modal-body">
        <p id="cancel-msg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" id="cfm-del">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END SIMPLE MODAL MARKUP -->
<!-- BEGIN Accept MODAL MARKUP -->
<div class="modal fade" id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="acceptLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="acceptLabel">Confirm Action</h4>
      </div>
      <div class="modal-body">
        <p id="accept-msg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="cfm-acc">Accept</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END SIMPLE MODAL MARKUP -->
<!-- BEGIN Decline MODAL MARKUP -->
<div class="modal fade" id="declineModal" tabindex="-1" role="dialog" aria-labelledby="declineLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="declineLabel">Confirm Action</h4>
      </div>
      <div class="modal-body">
        <p id="decline-msg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="cfm-dec">Decline</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END SIMPLE MODAL MARKUP -->

<div id="content">
<section>


        <div class="section-header">
            <h1 class="text-primary">
                    Current Applications
            </h1>
        </div>

        <div class="section-body">
            <!-- BEGIN INTRO -->
            <div class="row">
                <div class="col-sm-10">
                    <article class="margin-bottom-xxl">
                        <p>
                            <?php include_once('show-appl-round.php');?>
                        </p>
                    </article>
                </div>
                <!--end .col -->
            </div>
            <!--end .row -->
            <!-- END INTRO -->
      
              <div class="col-md-8">
              <div class="alert alert-callout alert-warning" role="alert">
              <p>You may only accept four offers through this system. To enroll in more than four activities, please ask the activity head to seek assistance from the JCRC in-charge.</p>
              </div>
                <?php
                $appls = get_current_appl();
               
                foreach($appls as $appl):
             
                ?>
              <?php if($appl['appl_result']=='1' && $phase == 'C'){?>
                <div class="card card-underline card-outlined style-success">
                  <div class="card-head">
                    <header><?php echo $appl['activity_name'];?></header>
                    <div class="tools">
                    <span class="text-success">Offered<?php echo $appl['offer_status'] == '1' ? ', Accepted' : '' ?><?php echo $appl['offer_status'] == '0' ? ', Declined' : '' ?></span>
                    </div>
                  </div>
              <?php } elseif ($appl['appl_result']!='1' && $phase == 'C'){?>
                <div class="card card-underline card-outlined style-default-dark">
                  <div class="card-head">
                    <header><?php echo $appl['activity_name'];?></header>
                    <div class="tools">
                    <span class="text-danger">Rejected</span>
                    </div>
                  </div>
              <?php } else { ?>
               <div class="card card-underline">
                  <div class="card-head">
                    <header><?php echo $appl['activity_name'];?></header>
                    <div class="tools">
                    <span>Pending Offer</span>
                    </div>
                  </div>
              <?php } ?>
                  <div class="card-body">

                  <form class="form">
                    <div class="form-group">
                      <textarea name="r" id="comment<?php echo $appl['activity_id']; ?>" class="form-control"<?php if($phase == 'B' || $phase == 'C') echo ''; ?>><?php echo $appl['appl_remark']; ?></textarea>
                      <label for="comment<?php echo $appl['activity_id'];?>">Application Remark</label>
                    </div>
                  </form>

                  </div><!--end .card-body -->
                  <?php if($phase == 'A'){?>
                  <div class="card-actionbar">
                    <div class="card-actionbar-row">
                      <button data-loading-text="<i class='fa fa-spinner fa-spin'></i> Wait..." class="btn btn-flat btn-danger ink-reaction btn-loading-state pull-left cancel-appl" data-aid="<?php echo $appl['activity_id'];?>" data-an="<?php echo $appl['activity_name'];?>">Cancel Application</button>
                      <button data-loading-text="<i class='fa fa-spinner fa-spin'></i> Wait..." class="btn btn-primary btn-loading-state ink-reaction update-remark" data-aid="<?php echo $appl['activity_id'];?>">Update Remark</button>
                    </div>
                  </div><!--end .card-actionbar -->
                  <?php }elseif($phase == 'C' && $appl['appl_result']=='1' && $appl['offer_status']==''){?>
                  <div class="card-actionbar">
                    <div class="card-actionbar-row">
                      <button data-loading-text="<i class='fa fa-spinner fa-spin'></i> Wait..." class="btn btn-flat btn-danger btn-loading-state ink-reaction pull-left decline-offer" data-aid="<?php echo $appl['activity_id'];?>" data-an="<?php echo $appl['activity_name'];?>">Decline Offer</button>
                      <button data-loading-text="<i class='fa fa-spinner fa-spin'></i> Wait..." class="btn btn-primary ink-reaction btn-loading-state accept-offer" data-aid="<?php echo $appl['activity_id'];?>" data-an="<?php echo $appl['activity_name'];?>">Accept Offer</button>
                      
                    </div>

                  </div><!--end .card-actionbar -->
                  <?php } ?>
                </div><!--end .card -->

                <?php endforeach;?>

              </div><!--end .col -->

            <!-- END STRUCTURE -->

</div>
</div>
</div>
</div>
</section>
</div>




<?php
  page_end();
?>
<script type="text/javascript">

var request;


$(".update-remark").click(function(){

    if(request){
        request.abort();
    }

    toastr.clear();
    toastr.options.positionClass = 'toast-bottom-left';
    toastr.options.showEasing = 'swing';
    toastr.options.hideEasing = 'swing';
    toastr.options.showMethod = 'slideDown';
    toastr.options.hideMethod = 'slideUp';

    var aid = $(this).data('aid');
    
    request = $.ajax({
    url: "api/appl/upd-remark.php",
    type: "post",
    data: {'i' : aid, 'r' : $("#comment" + aid).val()} 
    });

    $(this).button('loading');



    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        toastr.success(response);
        $(".update-remark").button('reset');
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        toastr.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
        $(".update-remark").button('reset');

    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $(this).button('reset');
    });

});


var del_id;

$('.cancel-appl').click(function(){
  $("#cancelModal").modal();
  del_id = $(this).data('aid');
  $('#cancel-msg').html('Do you really want to cancel your aplication for <b>' + $(this).data('an') + '<b>? This cannot be undone.');
});

$('#cfm-del').click(function(){

    if(request){
        request.abort();
    }
    request = $.ajax({
    url: "api/appl/appl-del.php",
    type: "post",
    data: {'i' : del_id} 
    });

    $('#cancelModal').modal('hide');

    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        window.location.reload()
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        toastr.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );

    });

  });

var dec_id;

$('.decline-offer').click(function(){
  $("#declineModal").modal();
  dec_id = $(this).data('aid');
  $('#decline-msg').html('Do you really want to decline your offer for <b>' + $(this).data('an') + '<b>? This cannot be undone.');
});

$('#cfm-dec').click(function(){

    if(request){
        request.abort();
    }
    request = $.ajax({
    url: "api/appl/decline-offer.php",
    type: "post",
    data: {'i' : dec_id} 
    });

    $('#declineModal').modal('hide');

    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        window.location.reload()
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        toastr.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );

    });

  });

var acc_id;

$('.accept-offer').click(function(){
  $("#acceptModal").modal();
  acc_id = $(this).data('aid');
  $('#accept-msg').html('Confirm accept <b>' + $(this).data('an') + '<b>? This cannot be undone.');
});

$('#cfm-acc').click(function(){

    if(request){
        request.abort();
    }
    request = $.ajax({
    url: "api/appl/accept-offer.php",
    type: "post",
    data: {'i' : acc_id} 
    });

    $('#acceptModal').modal('hide');

    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        window.location.reload()
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        toastr.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );

    });

  });

</script>