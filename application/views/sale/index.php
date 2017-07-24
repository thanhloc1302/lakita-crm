<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom35"> Danh sách contact mới (<?php echo $total_contact; ?>)</h3>
    </div>
</div>
<form action="<?php echo base_url(); ?>sale/transfer_contact" method="POST" id="action_contact" class="form-inline"> 
    <?php $this->load->view('common/content/filter'); ?>
    <a href="form.html" class="transfer_contact btn btn-success"> Chuyển nhượng các contact đã chọn </a> <br>
    <?php $this->load->view('common/content/tbl_contact'); ?>
    <?php $this->load->view('sale/modal/transfer_multi_contact'); ?> <br/>
    <a href="form.html" class="transfer_contact btn btn-success"> Chuyển nhượng các contact đã chọn </a>
</form>
<div class="view_duplicate">
    
</div>
<?php $this->load->view('sale/modal/transfer_one_contact'); ?>
<?php $this->load->view('sale/modal/show_script'); ?>