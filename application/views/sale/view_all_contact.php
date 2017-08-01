<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> Danh sách toàn bộ contact (<?php echo $total_contact; ?>)</h3>
    </div>
</div>
<form action="<?php echo base_url(); ?>manager/divide_contact" method="POST" id="action_contact" class="form-inline">
    <?php $this->load->view('common/content/filter'); ?>
    <?php $this->load->view('common/content/tbl_contact'); ?>
    <?php $this->load->view('sale/modal/transfer_multi_contact'); ?> <br/>
</form>
<?php $this->load->view('sale/modal/transfer_one_contact'); ?>
<?php $this->load->view('sale/modal/show_script'); ?>

