<tr>
    <td class="text-right">  Ngày khách hẹn gọi lại </td>
    <td style="position: relative;">  
        <input type="text" class="form-control datetimepicker date_recall" name="date_recall"
        <?php if ($rows['date_recall'] > 0) { ?>
                   value="<?php echo date('d-m-Y H:i', $rows['date_recall']); ?>"
               <?php } ?>> <a href="#" class="reset_datepicker btn btn-primary"> Reset</a>
    </td>
</tr>