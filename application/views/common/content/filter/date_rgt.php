<!--<tr class="filter_date_rgt_from">
    <td class="text-right"> Ngày contact đăng ký từ: </td>
    <td>
        <input type="text" class="form-control datepicker" name="filter_date_rgt_from"
        <?php if (isset($_GET['filter_date_rgt_from'])) { ?>
                   value="<?php echo $_GET['filter_date_rgt_from']; ?>"
               <?php } ?> />
    </td>
</tr>
<tr class="filter_date_rgt_end">
    <td class="text-right"> đến: </td>
    <td>
        <input type="text" class="form-control datepicker" name="filter_date_rgt_end"
               <?php if (isset($_GET['filter_date_rgt_end'])) { ?>
                   value="<?php echo $_GET['filter_date_rgt_end']; ?>"
               <?php } ?> />
    </td>
</tr>-->


<tr class="filter_date_date_rgt">
    <td class="text-right"> Ngày contact đăng ký : </td>
    <td>
        <input type="text" class="form-control daterangepicker" name="filter_date_date_rgt" style="position: static"
        <?php if (isset($_GET['filter_date_date_rgt'])) { ?>
                   value="07-07-2017 - 09-07-2017"
               <?php } ?> />
    </td>
</tr>