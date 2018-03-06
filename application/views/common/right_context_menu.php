<div class="menu">
    <ul>
        <?php if ($controller == 'manager') { ?>
            <a href="#" class="divide_one_contact_achor one-item-selected" contact_id="" contact_name="">
                <li> <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> &nbsp; &nbsp; Phân contact này cho TVTS... </li>
            </a>
            <a href="#" class="divide_contact divide_multi_contact multi-item-selected">
                <li> <i class="fa fa-hand-paper-o" aria-hidden="true"></i> &nbsp; &nbsp; Phân các contact đã chọn cho TVTS... </li>
            </a>
            <a href="#"  class="btn-export-all-contact-to-excel one-item-selected" 
               data-form-id="action_contact">
                <li> 
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; &nbsp; Xuất toàn bộ dữ liệu
                </li>
            </a>
        <?php } else if ($controller == 'sale') { ?>
            <a href="#" 
               class="ajax-request-modal load-new-contact-id edit-one-contact one-item-selected"
               data-contact-id ="0"
               data-modal-name="edit-contact-div"
               data-url="common/show_edit_contact_modal">
                <li> <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chăm sóc contact này </li>
            </a>
            <a href="#" contact_name="0" contact_phone="0" class="send-banking-info-multi-course multi-item-selected" >
                <li> <i class="fa fa-credit-card-alt" aria-hidden="true"></i> &nbsp; &nbsp;  
                    Gửi email thông tin ngân hàng khóa combo cho các contact đã chọn </li>
            </a>
            <a href="#" contact_id="0" contact_name="0" class="transfer_one_contact one-item-selected" >
                <li> <i class="fa fa-exchange" aria-hidden="true"></i>  &nbsp; &nbsp; Chuyển nhượng contact này</li>
            </a>
            <a href="#" contact_name="0" contact_phone="0" class="send_to_mobile one-item-selected" >
                <li> <i class="fa fa-phone-square" aria-hidden="true"></i> &nbsp; &nbsp;  Gửi số điện thoại vào mobile </li>
            </a>
            <a href="#" class="transfer_contact multi-item-selected">
                <li>  <i class="fa fa-exchange" aria-hidden="true"></i>  &nbsp; &nbsp; Chuyển nhượng các contact đã chọn </li>
            </a>
        <?php } else if ($controller == 'cod') { ?>
            <a href="#" 
               class="ajax-request-modal load-new-contact-id edit-one-contact one-item-selected"
               data-contact-id ="0"
               data-modal-name="edit-contact-div"
               data-url="common/show_edit_contact_modal">
                <li> <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chăm sóc contact này </li>
            </a>
            <a href="#" contact_name="0" contact_phone="0" class="send_to_mobile one-item-selected" >
                <li> <i class="fa fa-phone-square" aria-hidden="true"></i> &nbsp; &nbsp;  Gửi số điện thoại vào mobile </li>
            </a>
            <a href="#" class="select_provider multi-item-selected"> 
                <li> <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chăm sóc các contact đã chọn </li>
            </a>
            <a href="#" class="btn-export-excel multi-item-selected"> 
                <li> <i class="fa fa-print" aria-hidden="true"></i> &nbsp; &nbsp; Xuất file excel để in </li>
            </a>
            <a href="#" class="send-email-to-viettel multi-item-selected" 
               data-form-id="action_contact"
               data-action="cod/SendEmailToProvider"
               data-method="POST">
                <li> <i class="fa fa-envelope" aria-hidden="true"></i> &nbsp; &nbsp; Gửi mail cho Viettel các contact đã chọn </li>
            </a>
            <a href="#" class="btn-export-excel-for-viettel"> 
                <li> <i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp; &nbsp; Xuất file excel để gửi cho Viettel </li>
            </a>
            <a href="#" class="export_to_string multi-item-selected"> 
                <li> <i class="fa fa-link" aria-hidden="true"></i> &nbsp; &nbsp; Xuất thành chuỗi đối soát </li>
            </a>
            <a href="#" class="btn-reset-provider multi-item-selected"> 
                <li> <i class="fa fa-refresh" aria-hidden="true"></i> &nbsp; &nbsp; Reset trạng thái giao hàng </li>
            </a>
            <a href="#" class="send-lakita-account-combo-course multi-item-selected"> 
                <li> <i class="fa fa-user" aria-hidden="true"></i> &nbsp; &nbsp; Tạo tài khoản Lakita và gửi email cho các contact đã chọn </li>
            </a>
        <?php } else if ($controller == 'admin') { ?>
            <a href="#" 
               class="action-contact-admin load-new-contact-id"
               data-contact-id ="0"
               data-answer="Thu hồi thành công contact!"
               data-url="admin/retrieve_contact"> 
                <li> 
                    <i class="fa fa-retweet" aria-hidden="true"></i> &nbsp; &nbsp; Thu hồi 
                </li>
            </a>
            <a href="#" class="action-contact-admin load-new-contact-id" 
               data-contact-id ="0"
               data-answer="Xóa contact thành công (thùng rác)!"
               data-url="admin/delete_one_contact"> 
                <li> 
                    <i class="fa fa-recycle" aria-hidden="true"></i> &nbsp; &nbsp; Thùng rác 
                </li>
            </a>
            <a href="#" class="action-contact-admin load-new-contact-id" 
               data-answer="Xóa contact thành công (xóa hẳn)!"
               data-url="admin/delete_forever_one_contact"> 
                <li> <i class="fa fa-trash" aria-hidden="true"></i> &nbsp; &nbsp; Xóa hẳn 
                </li> 
            </a>
        <?php } else { //marketing ?>
            <a href="#"
               class="edit_item"
               edit-url=""
               data-modal-name="edit-item-modal"
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
        <a href="#"  class="export-to-excel multi-item-selected" 
           data-form-id="action_contact"
           data-action="common/ExportToExcel"
           data-method="POST">
            <li> 
                <i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; &nbsp; Xuất dữ liệu
            </li>
        </a>
        <a href="#" 
           class="ajax-request-modal load-new-contact-id one-item-selected"
           data-contact-id ="0"
           data-modal-name="view-detail-contact-div"
           data-url="common/view_detail_contact">
            <li> 
                <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Chi tiết contact 
            </li>
        </a>
    </ul>
</div>