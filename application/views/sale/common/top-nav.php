
<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav class="" role="navigation">
            <ul class="nav navbar-nav">
                <a href="<?php echo base_url(); ?>">
                    <img src="<?php echo base_url(); ?>style/img/logo5.png" class="logo-fix">
                </a>

                <li class="dropdown mega-dropdown dropdown-hover">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-space-shuttle"></i> MENU <span class="caret"></span></a>				
                    <div id="filters" class="dropdown-menu mega-dropdown-menu">
                        <div class="container-fluid2">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="kids">
                                    <ul class="nav-list list-inline">
                                        <li>
                                            <a data-filter=".97" href="<?php echo base_url(); ?>">
                                                <img src="<?php echo base_url(); ?>public/images/new.jpg"> 
                                                <span> Danh sách contact mới </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('tu-van-tuyen-sinh/contact-con-cuu-duoc.html'); ?>">
                                                <img src="<?php echo base_url(); ?>public/images/can-save.png"> 
                                                <span>Danh sách contact còn cứu được  </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-filter=".97" href="<?php echo base_url('tu-van-tuyen-sinh/xem-tat-ca-contact.html'); ?>">
                                                <img src="<?php echo base_url(); ?>public/images/view-all.jpg"> 
                                                <span> Danh sách toàn bộ contact </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('tu-van-tuyen-sinh/them-contact.html'); ?>">
                                                <img src="<?php echo base_url(); ?>public/images/add-contact.png"> 
                                                <span> Thêm mới contact </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('tu-van-tuyen-sinh/xem-bao-cao.html'); ?>">
                                                <img src="<?php echo base_url(); ?>public/images/report.png"> 
                                                <span> Xem báo cáo </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('home/logout'); ?>">
                                                <img src="<?php echo base_url(); ?>public/images/logout.png"> 
                                                <span> Đăng xuất  </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>				
                </li>

                <form action="<?php echo base_url() . $controller; ?>/search" class="form-search" method="GET">
                    <input type="text" class="form-control" name="search_all" placeholder="Tìm mọi thứ...." 
                           value="<?php echo isset($_GET['search_all']) ? $_GET['search_all'] : ''; ?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </form>
                <li class="dropdown-hover">
                    <a href="javascript:;" class="noti dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="position: relative"> 
                        <i class="fa fa-volume-control-phone" aria-hidden="true"></i> &nbsp;
                        Contact cần gọi lại <sup> <span class="badge bg-red" id="num_noti"></span> </sup>
                    </a>
                    <ul class="dropdown-menu" id="noti_contact_recall">
                    </ul>
                </li>
                <li class="dropdown-hover float-right">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $this->session->userdata('image_staff'); ?>" alt=""> <?php echo $this->session->userdata('name'); ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?php echo base_url(); ?>home/logout"><i class="fa fa-sign-out pull-right"></i> Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->