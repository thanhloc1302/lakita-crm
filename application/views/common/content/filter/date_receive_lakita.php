<tr class="filter_date_receive_lakita_from">
    <td class="text-right"> Ngày nhận tiền lakita từ: </td>
    <td>
        <input type="text" class="form-control datepicker" name="filter_date_receive_lakita_from"
        <?php if (isset($_GET['filter_date_receive_lakita_from'])) { ?>
                   value="<?php echo $_GET['filter_date_receive_lakita_from']; ?>"
               <?php } ?> />
    </td>
</tr>
<tr class="filter_date_receive_lakita_end">
    <td class="text-right"> đến: </td>
    <td>
        <input type="text" class="form-control datepicker" name="filter_date_receive_lakita_end"
               <?php if (isset($_GET['filter_date_receive_lakita_end'])) { ?>
                   value="<?php echo $_GET['filter_date_receive_lakita_end']; ?>"
               <?php } ?> />
    </td>
</tr>