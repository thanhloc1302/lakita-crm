<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav class="" role="navigation">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown-hover">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $this->session->userdata('image_staff'); ?>" alt=""> <?php echo $this->session->userdata('name'); ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?php echo base_url(); ?>">Danh sách contact mới đăng ký </a></li>
                        <li><a class="divide_contact">Phân riêng contact cho một TVTS</a></li>
                        <li><a href="#" class="divide_contact_even">Phân đều contact cho các TVTS</a></li>
                        <li><a class="cancel_multi_contact">Hủy phân nháp các contact đã chọn</a></li>
                        <li><a href="<?php echo base_url(); ?>manager/draft_divide_contact_even3">Các contact đang phân nháp (chưa hủy nháp)</a></li>
                        <li><a id="delete_contact">Xóa các contact đã chọn </a></li>
                        <li><a href="<?php echo base_url(); ?>home/logout"><i class="fa fa-sign-out pull-right"></i> Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->