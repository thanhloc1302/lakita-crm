<?php if ($rows['date_recall'] > 0) { ?>
    <tr>
        <td class="text-right"> Ngày khách hẹn gọi lại </td>
        <td>   <?php if ($rows['date_recall'] > 0) echo date('d-m-Y', $rows['date_recall']); ?>  
        </td>
    </tr>
<?php } ?>