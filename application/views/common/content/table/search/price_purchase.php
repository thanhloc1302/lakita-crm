<!--<td class="search_more tbl_price_purchase"> 
    <input type="text" class="search_more" name="find_slection" disabled="disabled"/> 
</td>-->

<td class="search_more tbl_price_purchase"> 
    <input type="text" name="find_price_purchase" class="search_more" placeholder="Giá mua"
           value="<?php echo (filter_has_var(INPUT_GET, 'find_price_purchase'))? filter_input(INPUT_GET, 'find_price_purchase') : ''; ?>" /> 
</td>