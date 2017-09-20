<li class="dropdown mega-dropdown dropdown-hover">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-space-shuttle"></i> MENU <span class="caret"></span></a>				
    <div id="filters" class="dropdown-menu mega-dropdown-menu">
        <div class="container-fluid2">
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="kids">
                    <ul class="nav-list list-inline display-flex">
                        <li>
                            <a data-filter=".97" href="<?php echo base_url(); ?>">
                                <img src="<?php echo base_url(); ?>public/images/new.png"> 
                                <span> Danh sách contact ngày hôm nay </span>
                            </a>
                        </li>
                        <li>
                            <a data-filter=".97" href="<?php echo base_url('marketer/view_all'); ?>">
                                <img src="<?php echo base_url(); ?>public/images/view-all.png"> 
                                <span> Danh sách toàn bộ contact </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('MANAGERS/campaign'); ?>">
                                <img src="<?php echo base_url(); ?>public/images/campaign.png">
                                <span> Quản lý campaign</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo base_url('MANAGERS/adset'); ?>">
                                 <img src="<?php echo base_url(); ?>public/images/adset.png">
                                <span> Quản lý Adset </span></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('MANAGERS/ad'); ?>">
                                 <img src="<?php echo base_url(); ?>public/images/qc.png">
                                <span> Quản lý Ad </span></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('MANAGERS/link'); ?>">
                                 <img src="<?php echo base_url(); ?>public/images/link.png">
                                <span> Quản lý link </span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo base_url('home/logout'); ?>">
                                <img src="<?php echo base_url(); ?>public/images/logout.png"> 
                                <span> Đăng xuất  </span>
                            </a>
                        </li>
    <!--                                        <li><a data-filter=".94" href="#"><img src="http://content.nike.omensTraining.png"><span>Series</span></a></li>-->
                    </ul>
                </div>
            </div>
        </div>
    </div>				
</li>