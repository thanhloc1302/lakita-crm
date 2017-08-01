<div class="menu">
    <ul>
        <?php if ($controller == 'manager') { ?>
            <a href="#" class="divide_one_contact_achor" contact_id="" contact_name="">
                <li> Phân contact này cho TVTS... </li> 
            </a>
            <a href="#" class="divide_contact divide_multi_contact"> 
                <li>Phân các contact đã chọn cho TVTS... </li> 
            </a> 
        <?php } ?>
        <?php if ($controller == 'sale') { ?>
            <a href="#" class="edit_contact" contact_id="0"> 
                <li> Chăm sóc </li>
            </a>
            <a href="#" contact_id="0" contact_name="0" class="transfer_one_contact" > 
                <li> Chuyển nhượng </li>
            </a>
            <a href="#" contact_id="0" class="send_to_mobile" > 
                <li> Gửi số điện thoại vào mobile </li>
            </a>
            <a href="#" class="transfer_contact">
                <li> Chuyển nhượng các contact đã chọn </li>
            </a> 
        <?php } ?>
        <a href="#" class="view_duplicate" duplicate_id="0"> 
            <li> Xem contact trùng </li> 
        </a>
        <a href="#" class="action_view_detail_contact" contact_id="0"> 
            <li> Chi tiết contact </li> 
        </a>
    </ul>
</div>