<div id="Popup" class="popup-wrapper" style="display: none;">
    <div class="popup-loading">
        <div class="loading-container">

        </div>
    </div>
</div>

<!--<script src="<?php echo base_url(); ?>style/js/common/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>style/js/common/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>style/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>style/js/common/moment.min.js"></script>
<script src="<?php echo base_url(); ?>style/js/common/daterangepicker.min.js"></script>
<script src="<?php echo base_url(); ?>style/js/common/bootstrap-select.min.js"></script>
<script src="<?php echo base_url(); ?>style/js/common/notify.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>style/js/common/clipboard.min.js" type="text/javascript"></script>-->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" 
integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.25/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" >
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
 <script src="<?php echo base_url(); ?>style/js/common/shortcut.min.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url(); ?>style/js/common_view/filter_tbl_set_equal_height.min.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>vendors/build/js/custom.min.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url(); ?>style/js/common_view/view_contact_star.min.js" type="text/javascript"></script>-->
<?php if (ENVIRONMENT == 'production') { ?>
    <script src="<?php echo base_url(); ?>style/js3/built_obfuscated.min.js" type="text/javascript"></script>
<?php } else { ?>
    <script src="<?php echo base_url(); ?>style/js3/built.js" type="text/javascript"></script>
<?php } ?>
<?php
//if (isset($load_js) && is_array($load_js)) {
//    foreach ($load_js as $value) {
//        $this->load->view('common/js/' . $value);
//    }
//}
?>

