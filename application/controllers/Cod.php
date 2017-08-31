<?php

/**
 * Description of Sale
 *
 * @author CHUYEN
 * git ok
 */
class Cod extends MY_Controller {

    function index($offset = 0) {
        $data = $this->_get_all_require_data();
        $get = $this->input->get();
        $conditional['where'] = array('ordering_status_id' => _DONG_Y_MUA_, 'cod_status_id' => '0',
            'date_expect_receive_cod <' => strtotime('tomorrow'), 'payment_method_rgt' => '1', 'is_hide' => '0');
        $conditional['order'] = array('date_confirm' => 'DESC');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link('cod/index', $data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];
        $data['left_col'] = array('sale');
        //  $data['right_col'] = array('date_confirm');
        $this->table .= 'sale date_confirm date_expect_receive_cod note_cod';
        $data['table'] = explode(' ', $this->table); //array('selection', 'contact_id');

        /*
         * Các file js cần load
         */

        $data['load_js'] = array(
            'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
            'c_check_edit_contact', 'c_select_provider');

        $data['content'] = 'cod/index';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function pending($offset = 0) {
        $data = $this->_get_all_require_data();
        $get = $this->input->get();
        $conditional['where'] = array('cod_status_id' => _DANG_GIAO_HANG_, 'is_hide' => '0');
        $conditional['order'] = array('code_cross_check' => 'ASC');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link('cod/pending', $data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];
        // echo $this->db->last_query();
        $data['left_col'] = array('date_confirm', 'date_print_cod', 'date_receive_lakita');
        $data['right_col'] = array('provider', 'payment_method_rgt');
        $this->table .= 'date_print_cod provider code_cross_check';
        $data['table'] = explode(' ', $this->table);

        /*
         * Các file js cần load
         */

        $data['load_js'] = array(
            'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
            'c_select_provider', 'c_export_to_string', 'c_export_excel');

        $data['content'] = 'cod/pending';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function transfer($offset = 0) {
        $data = $this->_get_all_require_data();
        $get = $this->input->get();
        $conditional['where'] = array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
            'payment_method_rgt >' => '1', 'is_hide' => '0');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link('cod/transfer', $data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];
        // echo $this->db->last_query();
        $data['left_col'] = array('date_confirm');
        $data['right_col'] = array('cod_status');
        $this->table .= 'date_confirm cod_status';
        $data['table'] = explode(' ', $this->table);

        /*
         * Các file js cần load
         */

        $data['load_js'] = array(
            'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
            'c_check_edit_contact', 'c_select_provider', 'c_export_to_string', 'c_export_excel');

        $data['content'] = 'cod/transfer';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function find_contact() {
        $get = $this->input->get();
        $conditional = ''; //' AND `sale_staff_id` = ' . $this->user_id;
        $data = $this->_common_find_all($get, $conditional);
        $table = 'selection contact_id name phone address course_code price_purchase ';
        $table .= 'date_rgt date_last_calling call_stt ordering_stt action';
        $data['table'] = explode(' ', $table);
        $data['content'] = 'cod/find_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function export_for_send_provider() {
        /* ====================xuất file excel============================== */
        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            show_error_and_redirect('Vui lòng chọn contact cần xuất file excel', '', 0);
        }
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // $objPHPExcel->getActiveSheet()->getStyle("A1:H1")->getFont()->setSize(11)->setBold(true)->setName('Times New Roman');
        //     ->getColor()->setRGB('FFFFFF')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $styleArray = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size' => 15,
                'name' => 'Times New Roman'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle("A1:H1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:H1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('548235');
        $objPHPExcel->getActiveSheet()->getStyle("A1:H1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $objPHPExcel->getActiveSheet()->getStyle("A2:I100")->getFont()->setSize(15)->setName('Times New Roman');
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(73);

        foreach (range('A', 'G') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
        }

        //set độ rộng của các cột
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(55);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);

        //set tên các cột cần in
        $rowCount = 1;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Mã Bill');
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Nội dung');
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Tên người nhận');
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Số điện thoại người nhận');
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'Địa chỉ');
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Số tiền thu');
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Ghi chú');
        $rowCount++;

        //đổ dữ liệu ra file excel
        $contact_export = $this->_contact_export($post['contact_id']);
        foreach ($contact_export as $key => $value) {
            if ($value['cb'] > 1) {
                $course_name = 'Combo ' . $value['cb'] . ' khóa học';
            } else {
                $course_name = $value['course_name'];
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $key + 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value['code_cross_check']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $course_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value['address']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value['price_purchase']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value['note_cod']);
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(35);
            $BStyle = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK,
                        'color' => array('rgb' => '151313')
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount . ':H' . $rowCount)->applyFromArray($BStyle);
            $rowCount++;
        }
//die;
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="02.Lakita_gui_danh_sach_khach_hang v' . date('Y.m.d') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        die;
        /* ====================xuất file excel (end)============================== */
    }

    function export_for_print() {
        /* ====================xuất file excel============================== */
        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            show_error_and_redirect('Vui lòng chọn contact cần xuất file excel', '', 0);
        }
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel = PHPExcel_IOFactory::createReader('Excel2007');
        $this->load->config('my_config');
        $template_file_print = $this->config->item('template_file_print');
        $objPHPExcel = $objPHPExcel->load($template_file_print); // Empty Sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 3;
        //đổ dữ liệu ra file excel
        $contact_export = $this->_contact_export($post['contact_id']);
        foreach ($contact_export as $key => $value) {
            if ($value['cb'] > 1)
                $course_code = 'CB' . $value['cb'] . '00';
            else
                $course_code = $value['course_code'];
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $key + 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $course_code);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['address']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, number_format($value['price_purchase'], 0, ",", ".") . " VNĐ");
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value['note_cod']);
            $rowCount++;
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Contact_' . date('d/m/Y') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        die;
        /* ====================xuất file excel (end)============================== */
    }

    function view_all_contact($offset = 0) {
        $data = $this->_get_all_require_data();
        $get = $this->input->get();
        $conditional['where'] = array('ordering_status_id' => _DONG_Y_MUA_, 'is_hide' => '0');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link('cod/view_all_contact', $data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        //print_arr($data['contacts']);
        $data['total_contact'] = $data_pagination['total_row'];
        $data['left_col'] = array('sale', 'date_print_cod', 'date_confirm', 'date_receive_cod', 'date_receive_lakita',);
        $data['right_col'] = array('provider', 'warning', 'payment_method_rgt', 'cod_status');
        $this->table .= 'date_print_cod provider code_cross_check cod_status';
        $data['table'] = explode(' ', $this->table);

        /*
         * Các file js cần load
         */

        $data['load_js'] = array(
            'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
            'c_check_edit_contact', 'c_select_provider', 'c_export_to_string');

        $data['content'] = 'cod/view_all_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function export_to_string() {
        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            $error = ('Vui lòng chọn đơn hàng!');
            show_error_and_redirect($error, '', false);
        }
        $result = '';
        foreach ($post['contact_id'] as $value) {
            $input = array();
            $input['select'] = 'code_cross_check';
            $input['where'] = array('id' => $value);
            $contact = $this->contacts_model->load_all($input);
            if ($contact[0]['code_cross_check'] != '') {
                $result .= $contact[0]['code_cross_check'] . ',' . PHP_EOL;
            }
        }
        echo $result;
    }

    private function _get_all_require_data() {
        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 1
                )
            ),
            'courses' => array(),
            'providers' => array(),
            'cod_status' => array(),
            'payment_method_rgt' => array()
        );
        return array_merge($this->data, $this->_get_require_data($require_model));
    }

    function read() {
        $this->load->library('PHPExcel');
        // $objPHPExcel = PHPExcel_IOFactory::load('C:/xampp/htdocs/CRM_GIT/public/upload/L7/data.xlsx');
        $objPHPExcel = PHPExcel_IOFactory::load('/home/lakita.com.vn/public_html/sub/crm2/public/upload/data.xlsx');
        $sheet = $objPHPExcel->getActiveSheet();
        $data1 = $sheet->rangeToArray('A1:V5970');
        $str = 'INSERT INTO tbl_contact 
                                        (`name` ,
                                            `email` ,  
                                            `phone` ,
                                            `address`,
                                            `course_code` ,
                                            `price_purchase`,
                                            `payment_method_rgt` ,
                                            `date_rgt`,
                                            `date_handover` ,
                                            `date_last_calling` ,
                                            `date_confirm` ,
                                            `call_status_id` ,
                                            `ordering_status_id` ,
                                            `cod_status_id` ,
                                            `sale_staff_id` ,
                                            `matrix` ,
                                            `date_deliver_cod`,
                                            `date_receive_cod`,
                                            `date_receive_lakita`,
                                            `date_receive_cancel_cod`,
                                            `provider_id`,
                                            `code_cross_check`)
                                        VALUES 
                                         ';
        /* 0 `name` , 
          1 `email` ,
          2 `phone` ,
          3 `address`,
          4 `course_code` ,
          5 `price_purchase`,
          6 `payment_method_rgt` ,
          7 `date_rgt`,
          8 `date_handover` ,
          9 `date_last_calling` ,
          10 `date_confirm` ,
          11 `call_status_id` ,
          12 `ordering_status_id` ,
          13 `cod_status_id` ,
          14 `sale_staff_id` ,
          15`matrix` ,
          16`date_deliver_cod`,
          17`date_receive_cod`,
          18`date_receive_lakita`,
          19`date_receive_cancel_cod`,
          20`provider_id`,
          21 `code_cross_check` */
        // print_r($data1);
        foreach ($data1 as $row) {
            $str .= '(';
            foreach ($row as $key => $value) {
                $data = str_replace("'", "''", $value);
                if ($key == 7 || $key == 8 || $key == 9 || $key == 10 || $key == 16 || $key == 17 || $key == 18 || $key == 19)
                    $data = intval($data);
                if ($key == 21)
                    $str .= "'$data'";
                else
                    $str .= "'$data',";
            }
            $str .= '), <br>';
        }
        echo $str;
    }

    private function _contact_export($ids) {
        $this->load->model('Courses_model');
        $contacts = array();
        $i = 0;
        foreach ($ids as $value) {
            $input = array();
            $input['select'] = 'phone, code_cross_check, course_code, name, address, price_purchase, note_cod';
            $input['where'] = array('id' => $value);
            $contact = $this->contacts_model->load_all($input);
            //tìm xem số đt của contact có trong mảng contacts hay chưa, 
            //nếu chưa thì thêm vào, nếu có thì cộng tiền
            $position = found_position_in_array($contact[0]['phone'], $contacts);
            if ($position == -1) {
                $contacts[$i] = array(
                    'code_cross_check' => $contact[0]['code_cross_check'],
                    'course_code' => $contact[0]['course_code'],
                    'course_name' => $this->Courses_model->find_course_name($contact[0]['course_code']),
                    'name' => $contact[0]['name'],
                    'phone' => $contact[0]['phone'],
                    'address' => $contact[0]['address'],
                    'price_purchase' => $contact[0]['price_purchase'],
                    'note_cod' => $contact[0]['note_cod'],
                    'cb' => 1
                );
                $i++;
            } else {
                $contacts[$position]['price_purchase'] += $contact[0]['price_purchase'];
                $contacts[$position]['course_name'] = 'Khóa học combo';
                $contacts[$position]['cb'] += 1;
            }
        }
        return $contacts;
    }

}
