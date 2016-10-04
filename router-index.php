<?php
// index.php displays profile.
$page = "Router Info";
include_once 'page-t2.php';
include_once 'lib/router.php';
page_start();
?>
<div id="content">
    <section>
        <div class="section-header">
            <h1 class="text-primary">
                    Router Info
            </h1>
        </div>
        <div class="section-body">
        
            <!-- BEGIN INTRO -->
            <div class="row">
                <div class="col-sm-10">
                    <article class="margin-bottom-xxl">
                        <p>
                            Please fill in this page for free router configuration by RH volunteers.
                        </p>
                    </article>
                </div>
                <!--end .col -->
            </div>
            <!--end .row -->
            <!-- END INTRO -->
            <div class="col-md-12 col-lg-10">
            <div class="alert alert-callout alert-info" role="alert">
                <ul>
                <li>A router's model and MAC address are typically found on a label at the bottom.</li>
                <li>The MAC address comprises 12 digits of numbers 0~9 and letters A~F.</li>
                <li>If more than one MAC address is printed, enter the WAN MAC address.</li>
                <li>If in doubt, leave the field blank and consult volunteers during the configuration</li>
                </ul>
            </div>
                <div class="card">
                    <div class="card-body">
                        <form class="form form-validate" id="profile">
                            <div class="row">
                            <div class="col-sm-5">
                            <div class="form-group">
                                <label>
                                    Room
                                </label>
                                <p class="form-control-static">
                                    <?php echo get_room_number(); ?>
                                </p>
                            </div>
                            </div>
                            <div class="col-sm-5">
                            <div class="form-group">
                                <label>
                                    Router Status
                                </label>
                                <p class="form-control-static">
                                    <?php echo get_router_status();?>
                                </p>
                            </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-5">
                            <div class="form-group">
                                <input class="form-control" id="model" name="model" type="text" value="<?php echo get_router_model();?>" placeholder="e.g. TP-Link WR841N">
                                    <label for="model">
                                        Router Brand &amp; Model
                                    </label>
                                </input>
                            </div>
                            </div>
                            <div class="col-sm-5">
                            <div class="form-group">
                                <input class="form-control" id="mac" required name="mac" type="text" value="<?php echo get_router_mac();?>" data-inputmask="'mask': '**-**-**-**-**-**'">
                                    <label for="email">
                                        Mac Address
                                    </label>
                                </input>
                            </div>
                            </div>
                            </div>
                            <div class="row">
                                
                                    <div class="form-group">
                                    <div class="col-sm-10">
                                        <div class="checkbox checkbox-styled">
                                            <label>
                                                <input type="checkbox" name="coop" value="">
                                                <span>The router has been configured by IT Coop</span>
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-styled">
                                            <label>
                                                <input type="checkbox" name="wpa" value="">
                                                <span>The router is set to WPA2-PSK encryption</span>
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-styled">
                                            <label>
                                                <input type="checkbox" name="adminpw" value="">
                                                <span>I have changed the router's default admin password</span>
                                            </label>
                                        </div>
<!--                                         <div class="checkbox checkbox-styled">
                                            <label>
                                                <input type="checkbox" name="defaults" value="">
                                                <span>Everything else is left to the default settings beside wireless password</span>
                                            </label>
                                        </div> -->
                                    </div><!--end .col -->
                                </div><!--end .form-group -->
                                
                            </div>

                            <!--end .form-group -->
                           <div class="card-actionbar">
                                <div class="card-actionbar-row">
                                    <button type="submit" id="submit" class="btn btn-primary btn-raised ink-reaction btn-loading-state" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Wait...">Submit</button>
                                </div>
                            </div><!--end .card-actionbar -->
                        </form>
                    </div>
                    <!--end .card-body -->
                </div>
                <!--end .card -->
            </div>
        </div>
        <!--end .section-body -->
    </section>
</div>
<!--end #base-->
<!-- END BASE -->
<!-- BEGIN JAVASCRIPT -->
<script src="assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
<script src="assets/js/libs/bootstrap/bootstrap.min.js"></script>
<script src="assets/js/libs/spin.js/spin.min.js">
</script>
<script src="assets/js/libs/autosize/jquery.autosize.min.js">
</script>
<script src="assets/js/libs/moment/moment.min.js">
</script>
<script src="assets/js/libs/jquery-knob/jquery.knob.min.js">
</script>
<script src="assets/js/libs/nanoscroller/jquery.nanoscroller.min.js">
</script>

<script src="assets/js/core/source/App.js">
</script>
<script src="assets/js/core/source/AppNavigation.js">
</script>
<script src="assets/js/core/source/AppOffcanvas.js">
</script>
<script src="assets/js/core/source/AppCard.js">
</script>
<script src="assets/js/core/source/AppForm.js">
</script>
<script src="assets/js/core/source/AppNavSearch.js">
</script>
<script src="assets/js/core/source/AppVendor.js">
</script>
<script src="assets/js/libs/jquery-validation/dist/jquery.validate.min.js">
</script>
<script src="assets/js/libs/jquery-validation/dist/additional-methods.min.js">
</script>
<script src="assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js">
</script>
<script src="assets/js/libs/select2/select2.min.js"></script>
<script src="assets/js/libs/inputmask/jquery.inputmask.bundle.min.js"></script>
<script src="assets/js/libs/toastr/toastr.js"></script>


<!-- END JAVASCRIPT -->

<script type="text/javascript">

$(document).ready(function () {
   
    $("#mac").inputmask();

});

var request;
$("#profile").submit(function(event){
    event.preventDefault(); 
    if(request){
        request.abort();
    }

    toastr.clear();
    toastr.options.positionClass = 'toast-bottom-left';
    toastr.options.showEasing = 'swing';
    toastr.options.hideEasing = 'swing';
    toastr.options.showMethod = 'slideDown';
    toastr.options.hideMethod = 'slideUp';

    var $form = $(this);

    $("#submit").button('loading');
    var $inputs = $form.find("input, select, textarea");
    var serializedData = $form.serialize();
    $inputs.prop("disabled", true);

        request = $.ajax({
        url: "api/router/user-update",
        type: "post",
        data: serializedData
    });



    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        toastr.success('Router information succsessfully updated.');
        $("#submit").button('reset');
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        toastr.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
        $("#submit").button('reset');
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

    // Prevent default posting of form
      

});

</script> 
