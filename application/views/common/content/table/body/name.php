<td class="center tbl_name">
    <?php echo $value['name']; ?> 
    <?php if($value['star'] > 1) {?>
   <sup> <span class="badge badge-star" 
          contact_phone="<?php echo $value['phone'];?>"
          contact_course_code ="<?php echo $value['course_code'];?>"
          controller="<?php echo $controller;?>">
              <?php echo $value['star'];?>
       </span></sup>
    <?php }?>
</td>