<?php
  require_once 'lib/appl.php';
  
  if ($round < 0) {
    echo "Activity application is currently not open.";
    ?>
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

    <?php exit();
  } else {
    echo "Current round: $round$phase";
  }
?>