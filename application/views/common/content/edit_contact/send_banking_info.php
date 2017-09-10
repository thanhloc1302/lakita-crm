<tr class="tbl_bank">
    <td class="text-right"> Đã gủi email tài khoản ngân hàng cho khách ?</td>
    <td class="position-relative">  
        <select class="form-control send_mail selectpicker edit_send_mail" name="send_mail" disabled="disabled">
             <option value="1" <?php if($rows['send_banking_info'] == 1) echo 'selected';?>>
                 Rồi
             </option>
             <option value="0" <?php if($rows['send_banking_info'] == 0) echo 'selected';?>>
                 Chưa
             </option>
        </select>
        <button class="btn btn-success btn-fixed btn-send-banking-info" contact_id="<?php echo $rows['id'];?>"> Click để gửi email</button>
    </td>
</tr>
