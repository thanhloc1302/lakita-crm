<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$date_from = 'filter_date_from_' . $key;
$date_end = 'filter_date_end_' . $key;
?>
<tr class="filter_date_rgt_from">
    <td class="text-right"> <?php echo h_find_name_display($key, $this->list_view); ?> từ: </td>
    <td>
        <input type="text" class="form-control datepicker" name="<?php echo $date_from; ?>"
        <?php if (filter_has_var(INPUT_GET, $date_from)) { ?>
                   value="<?php echo filter_input(INPUT_GET, $date_from); ?>"
               <?php } ?> />
    </td>
</tr>
<tr class="filter_date_rgt_end">
    <td class="text-right"> đến: </td>
    <td>
        <input type="text" class="form-control datepicker" name="<?php echo $date_end; ?>"
               <?php if (filter_has_var(INPUT_GET, $date_end)) { ?>
                   value="<?php echo filter_input(INPUT_GET, $date_end); ?>"
               <?php } ?> />
    </td>
</tr>