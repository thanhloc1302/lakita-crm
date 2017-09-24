<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav class="" role="navigation">
            <ul class="nav navbar-nav">
                <a href="<?php echo base_url(); ?>" class="logo">
                    <img src="<?php echo base_url(); ?>style/img/logo5.png" class="logo-fix">
                </a>
                <form action="<?php echo base_url() . $controller; ?>/search" class="form-search" method="GET">
                    <input type="text" class="form-control" name="search_all" placeholder="Tìm mọi thứ...." 
                           value="<?php echo isset($_GET['search_all']) ? $_GET['search_all'] : ''; ?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </form>
                <li class="dropdown-hover float-right">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $this->session->userdata('image_staff'); ?>" alt=""> <?php echo $this->session->userdata('name'); ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
<!--                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?php echo base_url(); ?>home/logout"><i class="fa fa-sign-out pull-right"></i> Đăng xuất</a></li>
                    </ul>-->
                </li>
                <li class="dropdown mega-dropdown dropdown-hover pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> MENU <span class="caret"></span></a>				
                    <div id="filters" class="dropdown-menu mega-dropdown-menu">
                        <div class="container-fluid2">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="kids">
                                    <ul class="nav-list list-inline display-flex">
                                        <?php $this->load->view($this->router->directory . $this->controller . '/common/menu'); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>				
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->