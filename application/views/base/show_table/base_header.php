<div class="pagination">
    <?php echo $this->pagination_link; ?>
</div>
<div class="number_paging"> 
    <?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' bản ghi'; ?>
</div>
<a class="add_item btn btn-primary" href="#"> Thêm 1 dòng mới </a> 
<a class="delete_multi_item btn btn-danger" href="#"> Xóa các dòng đã chọn </a> 