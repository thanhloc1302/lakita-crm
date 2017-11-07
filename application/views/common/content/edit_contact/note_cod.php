<tr class="tbl_cod">
    <td class="text-right"> Ghi chú khi giao hàng </td>
    <td>  
        <div class="form-group">
            <label for="note-cod" class="sr-only"> Note COD </label>
            <!-- Single button -->
            <select class="form-control note-cod-sample selectpicker">
                <option value=""> Chọn mẫu ghi chú khi giao hàng </option>
                <option value="Liên hệ trước khi giao">
                    Liên hệ trước khi giao
                </option>
                <option value="Giao trong giờ hành chính">
                    Giao trong giờ hành chính
                </option>
                <option value="Giao ngoài giờ hành chính">
                    Giao ngoài giờ hành chính
                </option>
            </select>
            <textarea class="form-control margintop20" rows="3" name="note_cod"><?php echo trim($rows['note_cod']); ?></textarea> 
        </div>
    </td>
</tr>