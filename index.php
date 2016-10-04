<?php
// index.php displays profile.
$page = "Resident Profile";
include_once 'page-t2.php';
page_start();
?>
<div id="content">
    <section>
        <div class="section-header">
            <h1 class="text-primary">
                    Resident Profile
            </h1>
        </div>
        <div class="section-body">
        
            <!-- BEGIN INTRO -->
            <div class="row">
                <div class="col-sm-10">
                    <article class="margin-bottom-xxl">
                        <p>
                            You must fill in your personal particulars below to use this system. All fields are mandatory.
                        </p>
                    </article>
                </div>
                <!--end .col -->
            </div>
            <!--end .row -->
            <!-- END INTRO -->
            <div class="col-md-12 col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <form class="form form-validate" id="profile">
                            <div class="row">
                            <div class="col-sm-5">
                            <div class="form-group">
                                <label>
                                    Name
                                </label>
                                <p class="form-control-static">
                                    <?php echo ucwords(strtolower($account->
                                    info['name'])); ?>
                                </p>
                            </div>
                            </div>
                            <div class="col-sm-5">
                            <div class="form-group">
                                <label>
                                    Room
                                </label>
                                <p class="form-control-static">
                                    RH
                                    <?php echo $account->
                                    info['block'] . '-' . $account->info['room']; ?>
                                </p>
                            </div>
                            </div>
                            </div>
<!--                             <div class="row">
                            <div class="col-sm-5">
                            <div class="form-group">
                                <input class="form-control" data-rule-digits="true" id="phone" name="phone" required type="text" value="<?php echo $account->info['phone']; ?>">
                                    <label for="phone">
                                        Phone
                                    </label>
                                </input>
                            </div>
                            </div>
                            <div class="col-sm-5">
                            <div class="form-group">
                                <input class="form-control" id="email" required name="email" required="" type="email" value="<?php echo $account->info['email']; ?>">
                                    <label for="email">
                                        Preferred Email
                                    </label>
                                </input>
                            </div>
                            </div>
                            </div> -->
                            <div class="row">
                            <div class="col-sm-5">
                            <div class="form-group">
                                    <select name="course[]" class="form-control select2-list" id="select2-list" multiple required>
                                    <optgroup label="NUS Business School">
                                    <option>Business Admin</option>
                                    <option>Accountancy</option>
                                    </optgroup>
                                    <optgroup label="Faculty of Arts &amp; Social Sciences">
                                    <option>FASS (Major Unknown)</option>
                                    <option>Chinese Language</option>
                                    <option>Chinese Studies</option>
                                    <option>Japanese Studies</option>
                                    <option>Malay Studies</option>
                                    <option>South Asian Studies</option>
                                    <option>English Language</option>
                                    <option>English Literature</option>
                                    <option>Theatre Studies</option>
                                    <option>History</option>
                                    <option>Philosophy</option>
                                    <option>Communications and New Media</option>
                                    <option>Economics</option>
                                    <option>Geography</option>
                                    <option>Political Science</option>
                                    <option>Psychology</option>
                                    <option>Social Work</option>
                                    <option>Sociology</option>
                                    <option>European Studies</option>
                                    <option>Global Studies</option>
                                    <optgroup label="Faculty of Engineering">
                                    <option>Engineering</option>
                                    <option>Biomedical Engineering</option>
                                    <option>Chemical Engineering</option>
                                    <option>Civil Engineering</option>
                                    <option>Electrical Engineering</option>
                                    <option>Environmental Engineering</option>
                                    <option>Engineering Science</option>
                                    <option>Industrial &amp; Systems Engineering</option>
                                    <option>Materials Science &amp; Engineering</option>
                                    <option>Mechanical Engineering</option>
                                    <option>Mechanical Engineering (Aeronautical)</option>
                                    </optgroup>
                                    <optgroup label="School of Computing">
                                    <option>Business Analytics</option>
                                    <option>Computer Science</option>
                                    <option>Information Security</option>
                                    <option>Information Systems</option>
                                    </optgroup>
                                    <optgroup label="Faculty of Engineering &amp; School of Computing">
                                    <option>Computer Engineering</option>
                                    </optgroup>
                                    <optgroup label="Faculty of Law">
                                    <option>Law</option>
                                    </optgroup>
                                    <optgroup label="Yong Loo Lin School of Medicine">
                                    <option>Medicine</option>
                                    <option>Nursing</option>
                                    </optgroup>
                                    <optgroup label="Faculty of Dentistry">
                                    <option>Dentistry </option>
                                    </optgroup>
                                    <optgroup label="School of Design &amp; Environment">
                                    <option>Architecture</option>
                                    <option>Industrial Design</option>
                                    <option>Project &amp; Facilities Management</option>
                                    <option>Real Estate</option>
                                    </optgroup>
                                    <optgroup label="Faculty of Science">
                                    <option>Science (Major Unknown)</option>
                                    <option>Chemistry</option>
                                    <option>Computational Biology</option>
                                    <option>Data Science &amp; Analytics</option>
                                    <option>Food Science &amp; Technology</option>
                                    <option>Life Sciences</option>
                                    <option>Mathematics</option>
                                    <option>Applied Mathematics</option>
                                    <option>Physics</option>
                                    <option>Pharmacy</option>
                                    <option>Quantitative Finance</option>
                                    <option>Statistics</option>
                                    </optgroup>
                                    <optgroup label="Faculty of Arts &amp; Social Science and Faculty of Science">
                                    <option>Environmental Studies</option>
                                    </optgroup>
                                    <optgroup label="Yong Siew Toh Conservatory of Music">
                                    <option>Music</option>
                                    </optgroup>
                                    <optgroup label="Others">
                                    <option>Exchange/Non-Graduate</option>
                                    <option>Others</option>
                                    </optgroup>

                                                </select>

                            <label for="course">Course/Major</label>
                            </div>
                            </div>
                            <div class="col-sm-5">
                            <div class="form-group">
                            <select class="form-control" id="year_of_study" name="year_of_study">
                                <option<?php if($account->info['year_of_study'] == '1'){echo(" selected");}?>>1</option>
                                <option<?php if($account->info['year_of_study'] == '2'){echo(" selected");}?>>2</option>
                                <option<?php if($account->info['year_of_study'] == '3'){echo(" selected");}?>>3</option>
                                <option<?php if($account->info['year_of_study'] == '4'){echo(" selected");}?>>4</option>
                                <option<?php if($account->info['year_of_study'] == '5'){echo(" selected");}?>>5</option>
                            </select>
                            <label for="year_of_study">Year of Study</label>
                            </div>
                            </div>
                            </div>

                            <div class="form-group">
                                <select class="form-control" id="shirt_size" name="shirt_size">
                                    <option value="XS" <?php if($account->info['shirt_size'] == 'XS'){echo("selected");}?>>
                                        XS
                                    </option>
                                    <option value="S" <?php if($account->info['shirt_size'] == 'S'){echo("selected");}?>>
                                        S
                                    </option>
                                    <option value="M" <?php if($account->info['shirt_size'] == 'M'){echo("selected");}?>>
                                        M
                                    </option>
                                    <option value="L" <?php if($account->info['shirt_size'] == 'L'){echo("selected");}?>>
                                        L
                                    </option>
                                    <option value="XL" <?php if($account->info['shirt_size'] == 'XL'){echo("selected");}?>>
                                        XL
                                    </option>
                                </select>
                                <label for="shirt_size">
                                    T-Shirt Size
                                </label>
                            </div>
<!--                             <div class="form-group control-width-normal">
                                <div class="input-group date" id="demo-date">
                                    <div class="input-group-content">
                                        <input class="form-control" type="text" required name="birthday" id="birthday" data-inputmask="'alias': 'date'" value="<?php echo $account->info['birthday'] !== '0000-00-00'? date("d/m/Y", strtotime($account->info['birthday'])) : ""; ?>">
                                            <label>
                                                Date of Birth
                                            </label>
                                        </input>
                                       
                                    </div>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar">
                                        </i>
                                    </span>
                                </div>
                            </div> -->
                            <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" class="input-sm" id="pdpa">
                                <span class="text-sm">PDPA Declaration <br><b>Purpose of Personal Data Collection</b> Please provide the requested information by completing this form if you whish to take part in Raffles Hall activities.<b>Consent to provide Personal Data</b> By indicating your consent to provide your personal data in this form, you agree to receive updates and important announcement regarding your hall activities by email, telephone and/or SMS from the JCRC and activity heads. All personal information will be kept confidential and used for the purpose(s) stated only. <b>Withdrawal of Consent</b> To help you make an informed decision, withdrawing consent will result in voiding of your registration. Should you wish to withdraw your consent for Raffles Hall JCRC and activity heads to contact you for all or any of the purposes stated above, please notify us in writing to i.chan@u.nus.edu. We will then remove your personal information from our database. Please allow 5 business days for your request to take effect. <br><b>I agree to provide my personal data for the purposes stated above.</b></span>
                            </label>
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

</body>


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
    $('#birthday').datepicker({autoclose: true, todayHighlight: false, format: "dd/mm/yyyy"})<?php echo $account->info['birthday'] == '0000-00-00' ? ".val('')" : "" ?>; 
    $(".select2-list").select2({
        placeholder: 'Type to search',
        allowClear: true,
        maximumSelectionSize: 2,
        selectOnBlur: false
    });
    $(".select2-list").select2('val', <?php echo json_encode(explode(',',$account->info['course'])); ?>);

    $("#birthday").inputmask();
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
    if(!$form.valid() || !$("#pdpa").is(":checked") || $.isEmptyObject($(".select2-list").select2('val'))){
        toastr.error('Form incomplete or invalid');
        return false;
    };
    $("#submit").button('loading');
    var $inputs = $form.find("input, select, textarea");
    var serializedData = $form.serialize();
    $inputs.prop("disabled", true);

        request = $.ajax({
        url: "api/profile/changeall.php",
        type: "post",
        data: serializedData
    });



    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        toastr.success('Personal information succsessfully updated.');
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
</html>