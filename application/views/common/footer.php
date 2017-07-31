<div class="menu">
    <ul>
        <?php if ($controller == 'manager') { ?>
            <a href="#" class="view_duplicate" duplicate_id="0"> 
                <li> Xem contact bị trùng </li> 
            </a>
            <a href="#" class="divide_one_contact_achor" contact_id="" contact_name="">
                <li> Phân contact này cho TVTS </li> 
            </a>
            <a href="#" class="action_view_detail_contact" contact_id="0"> 
                <li> Chi tiết contact </li> 
            </a>
            <a href="#" class="divide_contact divide_multi_contact"> 
                <li>Phân các contact đã chọn cho TVTS</li> 
            </a> 
        <?php } ?>
    </ul>
</div>
<div id="Popup" class="popup-wrapper" style="display: none;">
    <div class="popup-loading">
        <div class="loading-container">

        </div>
    </div>
</div>
<!--<script src="<?php echo base_url(); ?>style/js/common_view/filter_tbl_set_equal_height.min.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>vendors/build/js/custom.min.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url(); ?>style/js/common_view/view_contact_star.min.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>style/js/common/notify.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>style/js3/built.js" type="text/javascript"></script>
<?php
//if (isset($load_js) && is_array($load_js)) {
//    foreach ($load_js as $value) {
//        $this->load->view('common/js/' . $value);
//    }
//}

