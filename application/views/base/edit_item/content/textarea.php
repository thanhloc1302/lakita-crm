<tr>
    <td class="text-right">
        <?php echo h_find_name_display($key, $this->list_view); ?>
    </td>
    <td>
        <div class="form-group">
            <textarea class="form-control" rows="5" name="edit_<?php echo $key; ?>"> <?php echo $row[$key];?></textarea>
        </div>
    </td>
<tr>

