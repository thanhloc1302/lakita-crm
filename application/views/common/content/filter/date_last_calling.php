<tr class="filter_date_last_calling_from">
    <td class="text-right"> Ngày gọi từ: </td>
    <td>
        <input type="text" class="form-control datepicker" name="filter_date_last_calling_from"
        <?php if (isset($_GET['filter_date_last_calling_from'])) { ?>
                   value="<?php echo $_GET['filter_date_last_calling_from']; ?>"
               <?php } ?> />
    </td>
</tr>
<tr class="filter_date_last_calling_end">
    <td class="text-right"> đến: </td>
    <td>
        <input type="text" class="form-control datepicker" name="filter_date_last_calling_end"
               <?php if (isset($_GET['filter_date_last_calling_end'])) { ?>
                   value="<?php echo $_GET['filter_date_last_calling_end']; ?>"
               <?php } ?> />
    </td>
</tr>