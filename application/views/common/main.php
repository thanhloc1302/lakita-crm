<?php $this->load->view('common/head'); ?>
<body class="nav-sm">
    <?php
    if ($this->agent->is_mobile()) {
        $this->load->view('common/hidden_input'); 
        $this->load->view('common/mobile');
    } else {
        ?>
        <div class="container body">
            <div class="main_container">
                <?php $this->load->view('common/left_col'); ?>

                <?php
                if (isset($top_nav)) {
                    $this->load->view($top_nav);
                }
                ?>

                <div class="right_col" role="main">
                    <?php
                    $this->load->view('common/alert.php');
                    $this->load->view($content);
                    $this->load->view('common/script/view_detail_contact');
                    $this->load->view('common/script/edit_contact');
                    $this->load->view('common/script/view_contact_star');
                    ?>
                </div>

                <footer>
                    <div class="pull-right">
                        CRM LAKITA - BY <a href="">CHUYENPN</a>
                    </div>
                    <div class="clearfix"></div>
                </footer>

        <?php $this->load->view('common/content/notification'); ?>
            </div>
        </div>
        <?php $this->load->view('common/hidden_input'); ?>
        <?php $this->load->view('common/right_context_menu'); ?>
    <?php $this->load->view('common/footer'); ?>
<?php } ?>
</body>
</html> 

