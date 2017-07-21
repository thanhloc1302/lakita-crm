<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom35"> Danh sách contact đồng ý mua (<?php echo $total_contact; ?>)</h3>
    </div>
</div>
<form action="<?php echo base_url(); ?>common/action_edit_multi_cod_contact" method="POST" id="action_contact" class="form-inline"> 
    <?php $this->load->view('common/content/filter'); ?>
    <a href="form.html" class="btn btn-success select_provider"> Chăm sóc các contact đã chọn </a> <br/>
    <?php $this->load->view('common/content/tbl_contact'); ?>
    <?php $this->load->view('cod/modal/edit_multi_contact'); ?> <br/>
    <a href="form.html" class="btn btn-success select_provider"> Chăm sóc các contact đã chọn </a>
</form>
