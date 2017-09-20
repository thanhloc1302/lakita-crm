<div class="menu">
    <ul>
        <?php if ($controller == 'manager') { ?>
            <a href="#" class="divide_one_contact_achor" contact_id="" contact_name="">
                <li> <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> &nbsp; &nbsp; Phân contact này cho TVTS... </li>
            </a>
            <a href="#" class="divide_contact divide_multi_contact">
                <li> <i class="fa fa-hand-paper-o" aria-hidden="true"></i> &nbsp; &nbsp; Phân các contact đã chọn cho TVTS... </li>
            </a>
        <?php } ?>
        <?php if ($controller == 'sale') { ?>
            <a href="#" class="edit_contact" contact_id="0">
                <li> <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chăm sóc contact</li>
            </a>
            <a href="#" contact_id="0" contact_name="0" class="transfer_one_contact" >
                <li> <i class="fa fa-exchange" aria-hidden="true"></i>  &nbsp; &nbsp; Chuyển nhượng </li>
            </a>
            <a href="#" contact_name="0" contact_phone="0" class="send_to_mobile" >
                <li> <i class="fa fa-phone-square" aria-hidden="true"></i> &nbsp; &nbsp;  Gửi số điện thoại vào mobile </li>
            </a>
            <a href="#" class="transfer_contact">
                <li>  <i class="fa fa-exchange" aria-hidden="true"></i>  &nbsp; &nbsp; Chuyển nhượng các contact đã chọn </li>
            </a>
        <?php } ?>
        <?php if ($controller == 'cod') { ?>
            <a href="#" class="edit_contact" contact_id="0"> 
                <li> <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chăm sóc contact</li>
            </a>
            <a href="#" contact_name="0" contact_phone="0" class="send_to_mobile" >
                <li> <i class="fa fa-phone-square" aria-hidden="true"></i> &nbsp; &nbsp;  Gửi số điện thoại vào mobile </li>
            </a>
            <a href="#" class="select_provider"> 
                <li> <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chăm sóc các contact đã chọn </li>
            </a>
            <a href="#" class="btn-export-excel"> 
                <li> <i class="fa fa-print" aria-hidden="true"></i> &nbsp; &nbsp; Xuất file excel để in </li>
            </a>
            <a href="#" class="btn-export-excel-for-viettel"> 
                <li> <i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp; &nbsp; Xuất file excel để gửi cho Viettel </li>
            </a>
            <a href="#" class="export_to_string"> 
                <li> <i class="fa fa-link" aria-hidden="true"></i> &nbsp; &nbsp; Xuất thành chuỗi đối soát </li>
            </a>
        <?php } ?>
<!--        <a href="#" class="view_duplicate" duplicate_id="0">
            <li> <i class="fa fa-files-o" aria-hidden="true"></i> &nbsp; &nbsp; Xem contact trùng </li>
        </a>-->
        <a href="#" class="action_view_detail_contact" contact_id="0">
            <li> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Chi tiết contact </li>
        </a>
    </ul>
</div>

<div class="menu-item">
    <ul>
        <a href="#"
           class="edit_item"
           item_id="0">
            <li>  <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chỉnh sửa</li>
        </a>
        <a href="#"
           class="delete_item"
           item_id="0">
            <li>  <i class="fa fa-trash-o" aria-hidden="true"></i> &nbsp; &nbsp; Xóa dòng </li>
        </a>
        <a class="delete_multi_item" href="#"> 
            <li>  <i class="fa fa-trash-o" aria-hidden="true"></i> &nbsp; &nbsp; Xóa các dòng đã chọn </li>
        </a> 
    </ul>
</div>