<tr>
    <td class="text-right">
        <?php echo h_find_name_display($key, $this->list_view); ?>
    </td>
    <td>
        <input type="text" name="edit_<?php echo $key;?>" class="form-control" value="<?php echo $row[$key];?>" />
    </td>
</tr>