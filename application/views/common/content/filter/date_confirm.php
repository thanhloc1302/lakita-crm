<tr class="filter_date_confirm_from">
    <td class="text-right"> Ngày chốt đơn từ: </td>
    <td>
        <input type="text" class="form-control datepicker" name="filter_date_confirm_from"
        <?php if (isset($_GET['filter_date_confirm_from'])) { ?>
                   value="<?php echo $_GET['filter_date_confirm_from']; ?>"
               <?php } ?> />
    </td>
</tr>
<tr class="filter_date_confirm_end">
    <td class="text-right"> đến: </td>
    <td>
        <input type="text" class="form-control datepicker" name="filter_date_confirm_end"
               <?php if (isset($_GET['filter_date_confirm_end'])) { ?>
                   value="<?php echo $_GET['filter_date_confirm_end']; ?>"
               <?php } ?> />
    </td>
</tr>