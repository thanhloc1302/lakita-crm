<!-- Cần tạo 2 phần head của bảng giống y sì nhau (chỉ khác class) để nếu số dòng quá nhiều khi cuộn chuột xuống 
thì người dùng vẫn có thể nhìn thấy các trường head là gì (dễ theo dõi) -->
<thead class="fixed-table" style="display: none;">
    <tr>
        <th class="tbl_selection check_all" id="f_th_check_all">
            Chọn <i class="fa fa-check" aria-hidden="true"></i>
        </th>
        <!-- Hiển thị thông tin các trường của bảng, mặc định trường đầu là "chọn", trường cuối là "thao tác" -->
        <?php
        foreach ($head_tbl as $key => $value) {
            $data['key'] = $key;
            $data['value'] = $value;
            /*
             * Nếu tồn tại display = none thì không hiển thị trường đó ra
             */
            if (isset($value['display']) && $value['display'] == 'none') {
                continue;
            }
            /*
             * Nếu tồn tại order = 1 thì thêm nút để sắp xếp
             */
            if (isset($value['order']) && $value['order'] == '1') {
                $this->load->view('base/show_table/content/f_head/head_order', $data);
            }
            /*
             * Còn lại thì hiển thị bình thường
             */ else {
                $this->load->view('base/show_table/content/f_head/head_stadard', $data);
            }
        }
        ?>
        <th class="tbl_action" id="f_th_action">
            Thao tác
        </th>
    </tr>
</thead>
<thead class="table-head-pos">
    <tr>
        <th class="tbl_selection check_all" id="th_check_all">
            Chọn <i class="fa fa-check" aria-hidden="true"></i>
        </th>
        <?php
        foreach ($head_tbl as $key => $value) {
            $data['key'] = $key;
            $data['value'] = $value;
            if (isset($value['display']) && $value['display'] == 'none') {
                continue;
            }
            if (isset($value['order']) && $value['order'] == '1') {
                $this->load->view('base/show_table/content/s_head/head_order', $data);
            } else {
                $this->load->view('base/show_table/content/s_head/head_stadard', $data);
            }
        }
        ?>
        <th class="tbl_action th_action" id="th_action">
            Thao tác
        </th>
    </tr>
</thead>

