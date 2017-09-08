<tr class="tbl_bank">
    <td class="text-right"> Đã gủi thông tin tài khoản Lakita cho khách vào học?</td>
    <td class="position-relative">  
        <select class="form-control send_mail selectpicker edit-send-account-lakita" name="send_mail" disabled="disabled">
             <option value="1" <?php if($rows['send_account_lakita'] == 1) echo 'selected';?>>
                 Rồi
             </option>
             <option value="0" <?php if($rows['send_account_lakita'] == 0) echo 'selected';?>>
                 Chưa
             </option>
        </select>
        <button class="btn btn-success btn-fixed btn-send-banking-info" contact_id="<?php echo $rows['id'];?>"> Click để gửi email</button>
    </td>
</tr>
