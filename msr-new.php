<?php
$page = "New Media Service Request";
include_once 'page-t2.php';
page_start();
?>
<div id="content">
    <section class="style-default-bright">
        <div class="section-header">
            <ol class="breadcrumb">
                <li>
                    RH Media Services
                </li>
                <li class="active">
                    New Request
                </li>
            </ol>
        </div>
        <div class="section-body">
            <!-- BEGIN INTRO -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-primary text-xl">
                        Terms and Conditions
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10">
                    <article class="margin-bottom-xxl">
                        <p>
                            RH Media Group aims to provide your activities and events with media-related support and coverage:
                        </p>
                        <dl class="dl-horizontal">
                            <dt>
                                BoP
                            </dt>
                            <dd>
                                Photography
                            </dd>
                            <dt>
                                MW
                            </dt>
                            <dd>
                                Video Recording
                            </dd>
                            <dt>
                                PP
                            </dt>
                            <dd>
                                Coverage in RH Publications
                            </dd>
                            <dt>
                                Tech
                            </dt>
                            <dd>
                                AV Equipment Support
                            </dd>
                        </dl>
                        <p>
                            To better serve you, please fill up this form
                            <b>
                                two weeks
                            </b>
                            in advance. After filling this form, you may track the progress through RZone (under Media Service Request).
                            <p>
                                Please understand that last-minute requests may be rejected.
                            </p>
                            <p>
                                Contact the respective head if you require further clarifcations:
                            </p>
                            <dl class="dl-horizontal">
                                <dt>
                                    Media Director
                                </dt>
                                <dd>
                                    9019 6905 (Jia Cheng)
                                </dd>
                                <dt>
                                    Tech Team
                                </dt>
                                <dd>
                                    8510 7372 (Xianyu)
                                </dd>
                                <dt>
                                    Pheonix Press
                                </dt>
                                <dd>
                                    9746 1029 (Marcus)
                                </dd>
                                <dt>
                                    Meteor Workshop
                                </dt>
                                <dd>
                                    9887 0023 (Yiran)
                                </dd>
                                <dt>
                                    Board of Photographers
                                </dt>
                                <dd>
                                    9746 1029 (Marcus)
                                </dd>
                                <dt>
                                    ComMotion
                                </dt>
                                <dd>
                                    8688 8731 (Chen Si) - for RZone system issues
                                </dd>
                            </dl>
                        </p>
                    </article>
                </div>
                <!--end .col -->
            </div>
            <!--end .row -->
            <!-- END INTRO -->
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-validate" role="form">
                            <div class="form-group">
                                <label class="control-label col-sm-2">
                                    Activity
                                </label>
                                <div class="col-sm-8">
                                <?php
                                    $rows = $db->query('call get_manageable_activities(?);', [$account->nus_id]);
                                    $f = function ($row) {echo "<div class=\"radio radio-styled\"><label><input name=\"activity_id\" type=\"radio\" value=\"row[0]\"><span>$row[1]</span></input></label></div>";
                                    };
                                    array_map($f, $rows);
                                ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="event-name" class="col-sm-2 control-label">
                                    Event Name
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="event-name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact-person" class="col-sm-2 control-label">
                                    Contact Person
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="contact-person">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact-number" class="col-sm-2 control-label">
                                    Contact Number
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="contact-number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact-number" class="col-sm-2 control-label">
                                    Event Date
                                </label>
                                <div class="col-sm-10">
                                    <div class="input-group-content">
                                    <input type="text" class="form-control" name="contact-number">
                                    </div>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <p class="help-block">Should be at least 2 weeks away</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="event-location" class="col-sm-2 control-label">
                                    Event Location
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="event-location">
                                    <p class="help-block">Include postal code for external location</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Service Required</label>
                                <div class="col-sm-8">
                                    <label class="checkbox-inline checkbox-styled">
                                        <input type="checkbox" value="BoP"><span>BoP</span>
                                    </label>
                                    <label class="checkbox-inline checkbox-styled">
                                        <input type="checkbox" value="MW"><span>MW</span>
                                    </label>
                                    <label class="checkbox-inline checkbox-styled">
                                        <input type="checkbox" value="PP"><span>PP</span>
                                    </label>
                                    <label class="checkbox-inline checkbox-styled">
                                        <input type="checkbox" value="Tech"><span>Tech</span>
                                    </label>
                                </div><!--end .col -->
                            </div>
                            <div class="form-group">
                                <label for="remark" class="col-sm-2 control-label">Event Description</label>
                                <div class="col-sm-8">
                                    <textarea name="remark" id="remark" class="form-control" rows="3" placeholder=""></textarea>
                                    <p class="help-block">e.g. scale/expected number of attendees, setting of event (formal/informal)</p>
                                </div>
                            </div>
                            <br>
                            <div class="card-actionbar">
                                <div class="card-actionbar-row">
                                    <button type="submit" class="btn btn-primary ink-reaction">Submit</button>
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
<script src="assets/js/libs/jquery/jquery-1.11.2.min.js">
</script>
<script src="assets/js/libs/jquery/jquery-migrate-1.2.1.min.js">
</script>
<script src="assets/js/libs/bootstrap/bootstrap.min.js">
</script>
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
<script src="assets/js/libs/d3/d3.min.js">
</script>
<script src="assets/js/libs/d3/d3.v3.js">
</script>
<script src="assets/js/libs/rickshaw/rickshaw.min.js">
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
<!-- END JAVASCRIPT -->
