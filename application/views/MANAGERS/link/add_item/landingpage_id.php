<tr>
    <td class="text-right">
        Chọn landing page
    </td>
    <td>
        <select class="form-control selectpicker" name="add_<?php echo $key;?>">
            <option value="0"> Chọn landing page </option>
            <?php foreach ($arr as $key => $value) {
                ?>
                <option value="<?php echo $value['id'] ?>"> <?php echo $value['url'] ?></option>
                <?php
            }
            ?>
        </select>
    </td>
</tr>
