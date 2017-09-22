<?php if ($rows['code_cross_check'] != '') { ?>
    <tr>
        <td class="text-right"> Mã Bill </td>
        <td>  
            <a href="https://www.viettelpost.com.vn/Tracking?KEY=<?php echo $rows['code_cross_check']; ?>" target="_blank">
                <?php echo $rows['code_cross_check']; ?></a>
        </td>
    </tr>
<?php } ?>