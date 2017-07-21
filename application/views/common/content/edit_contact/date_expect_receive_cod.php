<tr>
    <td class="text-right">  Ngày dự kiến giao hàng (option) </td>
    <td style="position: relative;">  
        <input type="text" class="form-control datepicker date_recall" name="date_expect_receive_cod"
        <?php if ($rows['date_expect_receive_cod'] > 0) { ?>
                   value="<?php echo date('d-m-Y', $rows['date_expect_receive_cod']); ?>"
               <?php } ?>> <a href="#" class="reset_datepicker btn btn-primary"> Reset</a>
    </td>
</tr>