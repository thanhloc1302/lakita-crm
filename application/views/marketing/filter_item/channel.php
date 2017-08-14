<?php if (isset($channels)) { ?>
    <tr>
        <td class="text-right"> Kênh nào? </td>
        <td>
            <select class="form-control channel_id selectpicker" name="filter_arr_multi_channel_id[]" multiple>
                <?php
                foreach ($channels as $key => $value) {
                    ?>
                    <option value="<?php echo $value['id']; ?>" 
                    <?php
                    if (isset($_GET['filter_arr_multi_channel_id'])) {
                        foreach ($_GET['filter_arr_multi_channel_id'] as $value2) {
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
<?php } ?>