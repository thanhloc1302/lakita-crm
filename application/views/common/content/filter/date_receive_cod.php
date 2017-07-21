<tr class="filter_date_receive_cod_from">
    <td class="text-right"> Ngày nhận tiền COD từ: </td>
    <td>
        <input type="text" class="form-control datepicker" name="filter_date_receive_cod_from"
        <?php if (isset($_GET['filter_date_receive_cod_from'])) { ?>
                   value="<?php echo $_GET['filter_date_receive_cod_from']; ?>"
               <?php } ?> />
    </td>
</tr>
<tr class="filter_date_receive_cod_end">
    <td class="text-right"> đến: </td>
    <td>
        <input type="text" class="form-control datepicker" name="filter_date_receive_cod_end"
               <?php if (isset($_GET['filter_date_receive_cod_end'])) { ?>
                   value="<?php echo $_GET['filter_date_receive_cod_end']; ?>"
               <?php } ?> />
    </td>
</tr>