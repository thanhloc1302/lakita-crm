<td class="center tbl_cod_status">
    <?php
    foreach ($cod_status as $key2 => $value2) {
        if ($value2['id'] == $value['cod_status_id']) {
            echo $value2['name'];
            break;
        }
    }
    ?>
</td>