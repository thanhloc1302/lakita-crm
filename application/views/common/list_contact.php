<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> <?php echo $titleListContact; ?> <sup> <span class="badge bg-red"> <?php echo $total_contact; ?> </span> </sup></h3>
    </div>
</div>
<form action="<?php echo base_url() . $actionForm; ?>" method="POST" id="action_contact" 
      class="form-inline <?php echo ($total_contact > 0) ? '' : 'empty'; ?>">
    <?php $this->load->view('common/content/filter'); ?>
    <?php $this->load->view('common/content/tbl_contact'); ?>
    <?php
    if (isset($informModal)) {
        foreach ($informModal as $modal) {
            //  $this->load->view('manager/modal/divide_contact');
            $this->load->view($modal);
        }
    }
    ?>
</form>

 <?php
    if (isset($outformModal)) {
        foreach ($outformModal as $modal) {
            //  $this->load->view('manager/modal/divide_contact');
            $this->load->view($modal);
        }
    }
    ?>
<?php
//$this->load->view('manager/modal/divide_one_contact');
