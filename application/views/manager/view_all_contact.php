<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> Danh sách contact toàn bộ (<?php echo $total_contact; ?>)</h3>
    </div>
</div>
<form action="<?php echo base_url(); ?>manager/divide_contact" method="POST" id="action_contact" class="form-inline">
    <?php $this->load->view('common/content/filter'); ?>
    <?php $this->load->view('common/content/tbl_contact'); ?>
    <?php $this->load->view('manager/modal/divide_contact'); ?>
</form>
<div class="view_duplicate">
    
</div>
<?php $this->load->view('manager/modal/divide_one_contact'); ?>

    <input type="submit" class="btn btn-success btn-export-excel-for-viettel" value="Xuất file excel để gửi cho Viettel" />
    <script>
     $(".btn-export-excel-for-viettel").click(function (e) {
        e.preventDefault();
        $("#action_contact").attr("action", baseURL + "manager/export_for_send_provider");
        $("#action_contact").submit();
    });
    </script>