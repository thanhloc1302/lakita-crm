<?php
foreach ($rows as $row) {
    ?>
    <tr class="<?php echo (isset($row['warning_class'])) ? $row['warning_class'] : ''; ?>">
        <td class="center tbl_selection">
            <input type="checkbox" name="item_id[]" value="<?php echo $row['id']; ?>" />
        </td>
        <?php
        foreach ($head_tbl as $columm_name => $column_type) {
            if (isset($column_type['display']) && $column_type['display'] == 'none') {
                continue;
            }
            if (!isset($column_type['type'])) {
                echo "<td class='tbl_".$columm_name."'> {$row[$columm_name]} </td>";
            } else {
                switch ($column_type['type']) {
                    case 'currency': {
                            echo '<td class="tbl_'.$columm_name.'">' . number_format($row[$columm_name], 0, ",", ".") . '</td>';
                            break;
                        }
                    case 'datetime': {
                            echo '<td class="tbl_'.$columm_name.'">' . date('H:i:s d/m/Y', $row[$columm_name]) . '</td>';
                            break;
                        }
                    case 'custom' : {
                            $data['row'] = $row;
                            $this->load->view($this->view_path . '/show_table/' . $columm_name, $data);
                            break;
                        }
                }
            }
        }
        ?>
        <td class="center tbl_action">
            <div class="btn-group">
                <a href="#"
                   class="btn btn-danger delete_item"
                   item_id="<?php echo $row['id']; ?>"
                   title="Xóa dòng"> 
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </a>
                <a href="#"
                   class="btn btn-warning edit_item"
                   item_id="<?php echo $row['id']; ?>"
                   title="Chỉnh sửa dòng"> 
                    <i class="fa fa-pencil-square" aria-hidden="true"></i>
                </a>
            </div>
        </td>
    </tr>
<?php }
?>
</tr>
