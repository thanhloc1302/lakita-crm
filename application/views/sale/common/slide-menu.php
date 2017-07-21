<!-- menu profile quick info -->
<div class="profile">
    <div class="profile_pic">
        <img src="<?php echo $this->session->userdata('image_staff'); ?>" alt="..." class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>Xin chào,</span>
        <h2> <?php echo $this->session->userdata('name'); ?></h2>
    </div>
</div>
<!-- /menu profile quick info -->
<br />

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3><?php if (isset($role_name)) echo $role_name; ?></h3>
        <ul class="nav side-menu">
            <li>
                <a><i class="fa fa-bars"></i> Danh sách contact 
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li>
                        <a href="<?php echo base_url(); ?>">Danh sách contact mới (chưa gọi bao giờ) được phân cho bạn</a>
                    </li>
                    <li><a href="<?php echo base_url('tu-van-tuyen-sinh/contact-co-lich-hen.html'); ?>">Danh sách contact có lịch hẹn gọi lại tính đến thời điểm này </a></li>
                    <li><a href="<?php echo base_url('tu-van-tuyen-sinh/contact-con-cuu-duoc.html');?>">Danh sách contact còn cứu được </a></li>
                    <li><a href="<?php echo base_url('tu-van-tuyen-sinh/xem-tat-ca-contact.html'); ?>">Danh sách toàn bộ contact </a></li>
                </ul>
            </li>
             <li>
                <a href="<?php echo base_url('tu-van-tuyen-sinh/tim-kiem-contact.html'); ?>"><i class="fa fa-search"></i> Tìm kiếm contact </a>
            </li>
           <li>
                <a href="<?php echo base_url('tu-van-tuyen-sinh/them-contact.html'); ?>"><i class="fa fa fa-user">+</i> Thêm mới contact </a>
            </li>
            <li>
                <a href="<?php echo base_url('tu-van-tuyen-sinh/xem-bao-cao.html'); ?>">
                    <i class="fa fa-list"></i> Xem báo cáo <span class="fa fa-chevron-down"></span>
                </a>
            </li>
            <li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="tables.html">Tables</a></li>
                    <li><a href="tables_dynamic.html">Table Dynamic</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="chartjs.html">Chart JS</a></li>
                    <li><a href="chartjs2.html">Chart JS2</a></li>
                    <li><a href="morisjs.html">Moris JS</a></li>
                    <li><a href="echarts.html">ECharts</a></li>
                    <li><a href="other_charts.html">Other Charts</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="fixed_sidebar.html">Fixed Sidebar</a></li>
                    <li><a href="fixed_footer.html">Fixed Footer</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="menu_section">
        <h3>Live On</h3>
        <ul class="nav side-menu">
            <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="e_commerce.html">E-commerce</a></li>
                    <li><a href="projects.html">Projects</a></li>
                    <li><a href="project_detail.html">Project Detail</a></li>
                    <li><a href="contacts.html">Contacts</a></li>
                    <li><a href="profile.html">Profile</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="page_403.html">403 Error</a></li>
                    <li><a href="page_404.html">404 Error</a></li>
                    <li><a href="page_500.html">500 Error</a></li>
                    <li><a href="plain_page.html">Plain Page</a></li>
                    <li><a href="login.html">Login Page</a></li>
                    <li><a href="pricing_tables.html">Pricing Tables</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="#level1_1">Level One</a>
                    <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#level1_2">Level One</a>
                    </li>
                </ul>
            </li>                  
            <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
        </ul>
    </div>

</div>
<!-- /sidebar menu -->
