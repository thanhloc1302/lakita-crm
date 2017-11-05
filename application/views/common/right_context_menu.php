<div class="menu">
    <ul>
        <?php if ($controller == 'manager') { ?>
            <a href="#" class="divide_one_contact_achor" contact_id="" contact_name="">
                <li> <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> &nbsp; &nbsp; Phân contact này cho TVTS... </li>
            </a>
            <a href="#" class="divide_contact divide_multi_contact">
                <li> <i class="fa fa-hand-paper-o" aria-hidden="true"></i> &nbsp; &nbsp; Phân các contact đã chọn cho TVTS... </li>
            </a>
        <?php } else if ($controller == 'sale') { ?>
            <a href="#" 
               class="ajax-request-modal load-new-contact-id edit-one-contact"
               data-contact-id ="0"
               data-modal-name="edit-contact-div"
               data-url="common/show_edit_contact_modal">
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
        <?php } else if ($controller == 'cod') { ?>
            <a href="#" 
               class="ajax-request-modal load-new-contact-id edit-one-contact"
               data-contact-id ="0"
               data-modal-name="edit-contact-div"
               data-url="common/show_edit_contact_modal">
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
            <a href="#" class="change-form-submit-url2 jquery-confirm" 
               data-form-id="action_contact"
               data-action="cod/SendEmailToProvider"
               data-method="POST">
                <li> <i class="fa fa-envelope" aria-hidden="true"></i> &nbsp; &nbsp; Gửi mail cho Viettel các contact đã chọn </li>
            </a>
            <!--            <a href="#" class="btn-export-excel-for-viettel"> 
                            <li> <i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp; &nbsp; Xuất file excel để gửi cho Viettel </li>
                        </a>-->
            <a href="#" class="export_to_string"> 
                <li> <i class="fa fa-link" aria-hidden="true"></i> &nbsp; &nbsp; Xuất thành chuỗi đối soát </li>
            </a>
            <a href="#" class="btn-reset-provider"> 
                <li> <i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp; &nbsp; Reset trạng thái giao hàng </li>
            </a>
        <?php } else { //marketing ?>
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
        <?php } ?>
        <a href="#"  class="change-form-submit-url" 
           data-form-id="action_contact"
           data-action="common/ExportToExcel"
           data-method="POST">
            <li> 
                <i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; &nbsp; Xuất thành file excel
            </li>

        </a>
        <a href="#" 
           class="ajax-request-modal load-new-contact-id"
           data-contact-id ="0"
           data-modal-name="view-detail-contact-div"
           data-url="common/view_detail_contact">
            <li> 
                <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Chi tiết contact 
            </li>
        </a>
    </ul>
</div>