<div id="Popup" class="popup-wrapper" style="display: none;">
    <div class="popup-loading">
        <div class="loading-container">

        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>style/js/common_view/filter_tbl_set_equal_height.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>vendors/build/js/custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>style/js/common_view/view_contact_star.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>style/js/common/notify.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>style/js/my.min.js" type="text/javascript"></script>
<?php
if (isset($load_js) && is_array($load_js)) {
    foreach ($load_js as $value) {
        $this->load->view('common/js/' . $value);
    }
}

