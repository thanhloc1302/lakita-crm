<tr class="filter_date_handover_from">
    <td class="text-right"> Ngày nhận contact từ: </td>
    <td>
        <input type="text" class="form-control datepicker" name="filter_date_handover_from"
        <?php if (isset($_GET['filter_date_handover_from'])) { ?>
                   value="<?php echo $_GET['filter_date_handover_from']; ?>"
               <?php } ?> />
    </td>
</tr>
<tr class="filter_date_handover_end">
    <td class="text-right"> đến: </td>
    <td>
        <input type="text" class="form-control datepicker" name="filter_date_handover_end"
               <?php if (isset($_GET['filter_date_handover_end'])) { ?>
                   value="<?php echo $_GET['filter_date_handover_end']; ?>"
               <?php } ?> />
    </td>
</tr>