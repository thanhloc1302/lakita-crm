<?php $name = 'filter_arr_multi_' . $key . '_id'; ?>
<tr>
    <td class="text-right"> <?php echo h_find_name_display($key, $this->list_view); ?> ?  </td>
    <td>
        <select class="form-control channel_id selectpicker" name="<?php echo $name; ?>[]" multiple>
            <?php
            foreach ($channel as $key => $value) {
                ?>
                <option value="<?php echo $value['id']; ?>" 
                <?php
                if ((filter_has_var(INPUT_GET, $name))) {
                    foreach (filter_input(INPUT_GET, $name) as $value2) {
                        if ($value2 == $value['id']) {
                            echo 'selected';
                            break;
                        }
                    }
                }
                ?>>
                            <?php echo $value['name']; ?>
                </option>
                <?php
            }
            ?>
        </select>
    </td>
</tr>
