<!-- URL hiện tại (dùng trong trường hợp redirect về trang web cũ) -->
<input type="hidden" value="" id="curr_url" />

<!-- Base URL -->
<input type="hidden" value="<?php echo base_url();?>" id="base_url" />

<!-- Controller -->
<input type="hidden" value="<?php  if(property_exists ($this, 'controller')) echo $this->controller;?>" id="input_controller" />

<!-- Method -->
<input type="hidden" value="<?php   if(property_exists($this, 'method')) echo $this->method;?>" id="input_method" />