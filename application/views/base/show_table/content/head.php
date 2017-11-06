<!-- Cần tạo 2 phần head của bảng giống y sì nhau (chỉ khác class) để nếu số dòng quá nhiều khi cuộn chuột xuống 
thì người dùng vẫn có thể nhìn thấy các trường head là gì (dễ theo dõi) -->
<thead>
    <tr>
        <th class="tbl_selection_2 check_all">
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
<!--        <th class="tbl_action th_action" id="th_action">
            Thao tác
        </th>-->
    </tr>
</thead>

