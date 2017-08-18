<?php
if (isset($rows[0]['price_purchase'])) {
    ?>
    <div class="number_paging" > 
        Tổng tiền: <?php echo display_money(h_caculate_money($rows)) . " VNĐ"; ?>
    </div>
<?php } ?>
<a class="delete_multi_item btn btn-danger" href="#"> Xóa các dòng đã chọn </a>
<div class="number_paging"> 
    <?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' bản ghi'; ?>
</div>
<div class="pagination">
    <?php echo $this->pagination_link; ?>
</div>
