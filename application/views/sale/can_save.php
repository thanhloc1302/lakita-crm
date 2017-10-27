<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom35"> Danh sách contact còn cứu được <sup> <span class="badge bg-red"> <?php echo $total_contact; ?> </span> </sup></h3>
    </div>
</div>
<form action="<?php echo base_url(); ?>sale/transfer_contact" method="POST" id="action_contact" 
      class="form-inline <?php echo ($total_contact > 0) ? '' : 'empty';?>">
    <?php $this->load->view('common/content/filter'); ?>
    <?php $this->load->view('common/content/tbl_contact'); ?>
    <?php $this->load->view('sale/modal/transfer_multi_contact'); ?> <br>
</form>
<?php $this->load->view('sale/modal/transfer_one_contact'); ?>
<?php $this->load->view('sale/modal/show_script'); ?>