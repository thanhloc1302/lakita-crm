<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> Kết quả tìm kiếm (<?php echo $total_contact; ?>)</h3>
    </div>
</div>
<form action="<?php echo base_url(); ?>manager/divide_contact" method="POST" id="action_contact" class="form-inline">
    <?php $this->load->view('common/content/tbl_contact'); ?>
    <?php $this->load->view('manager/modal/divide_contact'); ?>
    <?php $this->load->view('sale/modal/transfer_multi_contact'); ?> 
    <?php $this->load->view('cod/modal/edit_multi_contact'); ?> 
</form>
<?php $this->load->view('manager/modal/divide_one_contact'); ?>
<?php $this->load->view('sale/modal/transfer_one_contact'); ?>
<div class="view_duplicate">

</div>
