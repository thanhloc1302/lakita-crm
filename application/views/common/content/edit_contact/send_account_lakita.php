<tr class="tbl_bank">
    <td class="text-right"> Đã gủi thông tin tài khoản Lakita cho khách vào học?</td>
    <td class="position-relative">  
        <div class="input-group">
            <input type="text" class="form-control" disabled="disabled" 
                   value="<?php echo ($rows['send_account_lakita'] == 1) ? 'Rồi' : 'Chưa'; ?>" />
            <div class="input-group-btn">
                <button class="btn btn-success btn-fixed btn-send-account-lakita" contact_id="<?php echo $rows['id']; ?>"> Click để tạo khóa học và gửi email</button>
            </div><!-- /btn-group -->
        </div><!-- /input-group -->
    </td>
</tr>
