<div class="modal fade modal-preview-landingpage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 1300px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Xem trước landing page</h4>
            </div>
            <div class="modal-body modal-replace-preview-landingpage">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> <?php echo $list_title; ?> (<?php echo $total_rows; ?>)</h3>
    </div>
</div>
<form action="#" method="GET" class="form-inline" id="form_item">
    <!-- Các trường filter trong bảng-->
    <?php $this->load->view('base/filter_item/index'); ?>

    <!-- Các thông tin chung ở đầu bảng như :
        1. Phân trang
        2. Hiển thị thứ tự của các dòng đang hiện
        3. Xóa dòng
        Nếu muốn hiển thị thêm thì cần copy vào thư mục con của danh mục đó (ghi đè view)
    -->
    <?php $this->load->view('MANAGERS/campaign/show_table/base_header'); ?>

    <!-- Phần hiển thị bảng : chi tiết xem ở file show_table/index.php
        Nếu muốn hiển thị thêm thì cần copy vào thư mục con của danh mục đó (ghi đè view)
    -->
    <?php $this->load->view('base/show_table/index'); ?>

    <!-- Các thông tin chung ở đầu bảng như :
        1. Xóa dòng 
        2. Hiển thị thứ tự của các dòng đang hiện
        3. Phân trang
        Nếu muốn hiển thị thêm thì cần copy vào thư mục con của danh mục đó (ghi đè view)
    -->
    <?php $this->load->view('base/show_table/base_footer'); ?>

    <!-- Các URL cần chuyền vào khi ajax -->
    <?php $this->load->view('base/show_table/hidden_input'); ?>


</form>
<!-- Bắt sự kiện thêm 1 dòng -->
<?php $this->load->view('MANAGERS/campaign/add_item/index'); ?>

<!-- Bắt sự kiện xóa 1 dòng và xóa nhiều dòng -->
<?php $this->load->view('base/delete_item/index'); ?>

<!-- Bắt sự kiện sửa 1 dòng -->
<?php $this->load->view('base/edit_item/index'); ?>

<!-- Các mã nguồn javascript liên quan như: các thao tác với bảng (real filter, selection,...), 
cố định thanh tiêu đề phía trên của bảng khi người dùng cuộn chuột xuống dưới    
-->
<?php
$this->load->view('base/js');
