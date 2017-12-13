<?php

/**
 * Description of Sale
 *
 * @author CHUYEN
 * git ok
 */
class Cod extends MY_Controller {

    public $L = array();

    public function __construct() {
        parent::__construct();
        $this->data['top_nav'] = 'cod/common/top-nav';
        $data['time_remaining'] = 0;
        $input = array();
        $input['select'] = 'date_recall';
        $input['where']['date_recall >'] = time();
        $input['where']['cod_status_id >'] = '0';
        $input['order']['date_recall'] = 'ASC';
        $input['limit'] = array('1', '0');
        $noti_contact = $this->contacts_model->load_all($input);
        if (!empty($noti_contact)) {
            $time_remaining = $noti_contact[0]['date_recall'] - time();
            $data['time_remaining'] = ($time_remaining < 3600 * 3) ? $time_remaining : 0;
        }
        $this->load->vars($data);


        $this->load->model('L7_check_model');
        $this->_loadCountListContact();
    }

    function index($offset = 0) {
        $data = $this->_get_all_require_data();
        $get = $this->input->get();
        $conditional['where'] = array('ordering_status_id' => _DONG_Y_MUA_, 'cod_status_id' => '0',
            'date_expect_receive_cod <' => strtotime('tomorrow'), 'payment_method_rgt' => '1', 'is_hide' => '0');
        $conditional['order'] = array('date_confirm' => 'DESC');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];
        $data['left_col'] = array('sale', 'date_confirm');
        $data['right_col'] = array('provider');
        $this->table .= 'date_confirm date_expect_receive_cod note_cod';
        $data['table'] = explode(' ', $this->table); //array('selection', 'contact_id');

        /*
         * Các file js cần load
         */

        $data['load_js'] = array(
            'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
            'c_check_edit_contact', 'c_select_provider');

        $data['titleListContact'] = 'Danh sách contact chưa giao hàng';
        $data['actionForm'] = 'common/action_edit_multi_cod_contact';
        $informModal = 'cod/modal/edit_multi_contact cod/modal/reset_provider';
        $data['informModal'] = explode(' ', $informModal);

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function pending($offset = 0) {
        $data = $this->_get_all_require_data();
        $get = $this->input->get();
        $conditional['where'] = array('cod_status_id' => _DANG_GIAO_HANG_, 'payment_method_rgt' => '1', 'is_hide' => '0');
        $conditional['order'] = array('code_cross_check' => 'ASC');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];
        // echo $this->db->last_query();
        $data['left_col'] = array('date_confirm', 'date_print_cod');
        $data['right_col'] = array('provider');
        $this->table .= 'date_print_cod provider code_cross_check';
        $data['table'] = explode(' ', $this->table);
        /*
         * Các file js cần load
         */
        $data['load_js'] = array(
            'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
            'c_select_provider', 'c_export_to_string', 'c_export_excel');


        $data['titleListContact'] = 'Danh sách contact đang giao hàng';
        $data['actionForm'] = 'common/action_edit_multi_cod_contact';
        $informModal = 'cod/modal/edit_multi_contact';
        $data['informModal'] = explode(' ', $informModal);

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function tracking($offset = 0) {
        $this->load->model('viettel_log_model');
        $data = $this->_get_all_require_data();
        $get = $this->input->get();
        $conditional['where'] = array('payment_method_rgt' => '1', 'is_hide' => '0', 'provider_id' => 1);
        $conditional['order'] = array('date_print_cod' => 'DESC');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['total_contact'] = $data_pagination['total_row'];
        $contacts = $data_pagination['data'];
        foreach ($contacts as &$value) {
            $input = [];
            $input['where'] = ['code_cross_check' => $value['code_cross_check']];
            $input['order'] = ['date_info' => 'ASC', 'status' => 'ASC'];
            $value['vietel_log'] = $this->viettel_log_model->load_all($input);
        }
        unset($value);
        $data['contacts'] = $contacts;
        $data['left_col'] = array('date_print_cod', 'viettel_status');
        $data['right_col'] = array('cod_status');
        $this->table = 'contact_info viettel_log';
        $data['table'] = explode(' ', $this->table);

        /*
         * Các file js cần load
         */

        $data['load_js'] = array(
            'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
            'c_select_provider', 'c_export_to_string', 'c_export_excel');

        $data['titleListContact'] = 'Theo dõi hành trình dơn hàng Viettel';
        $data['actionForm'] = 'common/action_edit_multi_cod_contact';
        $informModal = 'cod/modal/edit_multi_contact';
        $data['informModal'] = explode(' ', $informModal);

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function transfer($offset = 0) {
        $data = $this->_get_all_require_data();
        $get = $this->input->get();
        $conditional['where'] = array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
            'cod_status_id' => '0', 'payment_method_rgt >' => '1', 'is_hide' => '0');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
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


        $data['titleListContact'] = 'Danh sách contact chuyển khoản';
        $data['actionForm'] = 'common/action_edit_multi_cod_contact';
        $informModal = 'cod/modal/edit_multi_contact';
        $data['informModal'] = explode(' ', $informModal);

        $data['content'] = 'common/list_contact';
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
        foreach (range('A', 'H') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="02.Lakita_gui_danh_sach_khach_hang v' . date('Y.m.d') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $fileName = FCPATH . 'public/upload/EmailViettel/02.Lakita_gui_danh_sach_khach_hang v' . date('Y.m.d') . '.xlsx';
        if (file_exists($fileName)) {
            $fileName = FCPATH . 'public/upload/EmailViettel/02.Lakita_gui_danh_sach_khach_hang v' . date('Y.m.d-H.i.s') . '.xlsx';
            $objWriter->save($fileName);
        } else {
            $objWriter->save($fileName);
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="02.Lakita_gui_danh_sach_khach_hang v' . date('Y.m.d') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        die;
        /* ====================xuất file excel (end)============================== */
    }

    public function SendEmailToProvider() {
        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            show_error_and_redirect('Vui lòng chọn contact cần xuất file excel', '', 0);
        }
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
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
            if ($value['provider_id'] != 1) {
                show_error_and_redirect('Cần chọn đúng đơn vị giao hàng Viettel!', $post['back_location'], false);
            }
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
        foreach (range('A', 'H') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="02.Lakita_gui_danh_sach_khach_hang v' . date('Y.m.d') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $fileName = FCPATH . 'public/upload/EmailViettel/02.Lakita_gui_danh_sach_khach_hang v' . date('Y.m.d') . '.xlsx';
        if (file_exists($fileName)) {
            $fileName = FCPATH . 'public/upload/EmailViettel/02.Lakita_gui_danh_sach_khach_hang v' . date('Y.m.d-H.i.s') . '.xlsx';
            $objWriter->save($fileName);
        } else {
            $objWriter->save($fileName);
        }
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = '6000';
        $config['smtp_user'] = 'lakitavn@gmail.com';
        $config['smtp_pass'] = 'lakita2016';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html';
        $config['validation'] = TRUE;
        $this->load->library("email");
        $this->email->initialize($config);
        $this->email->from('cskh@lakita.vn', "lakita.vn");
        $this->email->to('dieuhanhminhkhai@gmail.com'); // dieuhanhminhkhai@gmail.com
        $this->email->subject('Lakita gửi danh sách đơn ngày ' . date('d/m/Y'));
        $this->email->message('Anh cho em gửi  danh sách COD ngày ' . date('d/m/Y') . '. Anh giúp em với ạ. Em cảm ơn ạ!');
        $this->email->attach($fileName);
        $this->email->send();

        show_error_and_redirect('Gửi email thành công', $post['back_location']);
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
        $template_file_print = $this->config->item('template_file_print');
        $objPHPExcel = $objPHPExcel->load($template_file_print); // Empty Sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 3;
        $contact_export = $this->_contact_export($post['contact_id']);
        foreach ($contact_export as $key => $value) {
            if ($value['cb'] > 1) {
                $course_code = 'CB' . $value['cb'] . '00';
            } else {
                $course_code = $value['course_code'];
            }
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
    }

    function view_all_contact($offset = 0) {
        $data = $this->_get_all_require_data();
        $get = $this->input->get();
        $conditional['where'] = array('ordering_status_id' => _DONG_Y_MUA_, 'is_hide' => '0');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
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

        $data['titleListContact'] = 'Danh sách toàn bộ contact';
        $data['actionForm'] = 'common/action_edit_multi_cod_contact';
        $informModal = 'cod/modal/edit_multi_contact';
        $data['informModal'] = explode(' ', $informModal);

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    public function export_to_string() {
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
                $result .= trim($contact[0]['code_cross_check']) . ',' . PHP_EOL;
            }
        }
        $data['result'] = $result;
        $this->load->view('cod/modal/export_to_string', $data);
    }

    public function ResetBillCode() {
        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            $error = ('Vui lòng chọn đơn hàng!');
            show_error_and_redirect($error, '', false);
        }
        $this->load->model('cod_cross_check_model');
        $today = date('dm');
        $where = array('date_print_cod' => $today, 'provider_id' => $post['provider_id_reset']);
        $this->cod_cross_check_model->delete($where);

        foreach ($post['contact_id'] as $value) {
            $where = array('date_print_cod' => $today,
                'phone' => $this->contacts_model->get_contact_phone($value));
            $this->cod_cross_check_model->delete($where);

            $where = array('id' => $value);
            $data = array('code_cross_check' => '');
            $this->contacts_model->update($where, $data);
        }
        show_error_and_redirect('Đặt lại đơn hàng thành công!');
    }

    private function _get_all_require_data() {
        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 1
                )
            ),
           'courses' => array(
                'where' => array('active' => '1'),
                'order' => array(
                    'course_code' => 'ASC'
                )
            ),
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
            $input['select'] = 'phone, code_cross_check, course_code, name, address, price_purchase, note_cod, provider_id';
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
                    'cb' => 1,
                    'provider_id' => $contact[0]['provider_id']
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

    public function test() {
//        $param = 'hih';
//        if ($param != 1) {
//            throw new Exception("$param should be an Foo instance.");
//        }
        // throw new Exception('Tự xác ở đây...');
        require_once APPPATH . "vendor/autoload.php";
        $client = new GuzzleHttp\Client(['base_uri' => 'https://sheets.googleapis.com/v4/spreadsheets/18x9FB074aMpgm66PbaPMtmol6HgG6eeidl3P5wJcH6w/values/Sheet1!A1:C?key=AIzaSyCdjll4ib79ZGtUEEEAxksl6zff2NkLCII']);
        $response = $client->request('GET');
        $body = $response->getBody();
        print_arr(GuzzleHttp\json_decode($body));
    }

    private function _loadCountListContact() {
        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('ordering_status_id' => _DONG_Y_MUA_, 'cod_status_id' => '0',
            'date_expect_receive_cod <' => strtotime('tomorrow'), 'payment_method_rgt' => '1', 'is_hide' => '0');
        $this->L['L6'] = count($this->contacts_model->load_all($input));

        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('cod_status_id' => _DANG_GIAO_HANG_, 'payment_method_rgt' => '1', 'is_hide' => '0');
        $this->L['pending'] = count($this->contacts_model->load_all($input));

        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
            'cod_status_id' => '0', 'payment_method_rgt >' => '1', 'is_hide' => '0');
        $this->L['transfer'] = count($this->contacts_model->load_all($input));


        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('ordering_status_id' => _DONG_Y_MUA_, 'is_hide' => '0');
        $this->L['all'] = count($this->contacts_model->load_all($input));
    }

}
