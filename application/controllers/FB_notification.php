<?php 
	class FB_notification extends CI_Controller 
	{
		function index()
		{
			// verification
			// if ($_GET['hub_verify_token'] === 'huynv') {
  	// 			echo $_GET['hub_challenge'];
  	// 		}
  	// 		
  			if (file_get_contents('php://input')) {
	            $comment = json_decode(file_get_contents('php://input'));
	            $commentId = $comment->entry[0]->changes[0]->value->id;
	            $pageId = explode('_', $commentId);
	            $input = [];
	            $input['where'] = array('comment_id' => $commentId);
	            $this->load->model('facebook_comment_plugin_model');
	            $commentExist = $this->facebook_comment_plugin_model->load_all($input);
	            if (empty($commentExist)) {
	                $this->facebook_comment_plugin_model->insert(['comment_id' => $commentId, 'time' => date(_DATE_FORMAT_)]);
	                $url = [
	                    '1732177853493516' => 'https://lakita.vn/bao-hiem-xa-hoi-tien-luong-thue-thu-nhap-ca-nhan-2018.html',
	                    '1298443350192736' => 'https://lakita.vn/ky-thuat-quyet-toan-thue.html',
	                    '1242593289171565' => 'https://lakita.vn/quyet-toan-thue-tu-a-den-z.html',
	                    '1778639972164393' => 'https://lakita.vn/lap-bao-cao-tai-chinh-2016.html',
	                    '1062159213912728' => 'https://lakita.vn/lap-bao-cao-tai-chinh-2017.html',
	                    '1665697290129137' => 'https://lakita.vn/tron-bo-lap-bao-cao-tai-chinh-2017.html',
	                    '1526592320757326' => 'https://lakita.vn/tron-bo-lap-bao-cao-tai-chinh-2017-trinhbtk2.html',
	                    '1820232718010252' => 'https://lakita.vn/tron-bo-lap-bao-cao-tai-chinh-2017-345k.html',
	                    '1270921559703857' => 'https://lakita.vn/cach-xac-dinh-chi-phi-hop-ly.html',
	                    '1784191251590929' => 'https://lakita.vn/cach-xac-dinh-chi-phi-hop-ly-candh.html',
	                    '1567273619971559' => 'https://lakita.vn/quan-tri-ke-toan.html',
	                    '1883385008373014' => 'https://lakita.vn/quan-tri-ke-toan-candh.html',
	                    '1281082322018331' => 'https://lakita.vn/bao-cao-tai-chinh-nang-cao.html',
	                    '2054579071235903' => 'https://lakita.vn/bao-cao-tai-chinh-nang-cao-candh.html',
	                    '1499953153417907' => 'https://lakita.vn/tron-bo-quyet-toan-thue-tu-a-den-z.html',
	                    '1572938529454084' => 'https://lakita.vn/tron-bo-quyet-toan-thue-tu-a-den-z-dangph.html',
	                    '1765719676802437' => 'https://lakita.vn/tron-bo-quyet-toan-thue-tu-a-den-z-candh1.html',
	                    '1478323028949878' => 'https://lakita.vn/tron-bo-quyet-toan-thue-tu-a-den-z-candh2.html',
	                    '1436597719799600' => 'https://lakita.vn/ke-toan-cho-nguoi-moi-bat-dau.html',
	                    '1574470682649315' => 'https://lakita.vn/ke-toan-cho-nguoi-moi-bat-dau-hanhnm.html',
	                    '1356504991125130' => 'https://lakita.vn/ke-toan-danh-cho-giam-doc.html',
	                    '1441397425925456' => 'https://lakita.vn/bi-quyet-lam-chu-excel-2017.html',
	                    '1370473353071832' => 'https://lakita.vn/excel-tu-a-den-z.html',
	                    '1331503243639074' => 'https://lakita.vn/combo-ke-toan-excel-van-phong-2017.html',
	                    '1530375550351116' => 'https://lakita.vn/combo-qua-khung-dip-giang-sinh.html',
	                    '1789918514418799' => 'https://lakita.vn/quan-tri-tai-chinh-ke-toan.html',
	                    '1341661405963380' => 'https://lakita.vn/yoga-danh-cho-nguoi-lam-van-phong.html',
	                    '1542421495847416' => 'https://lakita.vn/yoga-danh-cho-nguoi-lam-van-phong-2.html',
	                    '1455312594567068' => 'https://lakita.vn/yoga-danh-cho-nguoi-lam-van-phong-6.html',
	                    '1622160844507152' => 'https://lakita.vn/yoga-danh-cho-nguoi-lam-van-phong-3.html',
	                    '1628748463856832' => 'https://lakita.vn/yoga-danh-cho-nguoi-lam-van-phong-4.html',
	                    '1625298554180109' => 'https://lakita.vn/yoga-danh-cho-nguoi-lam-van-phong-5.html',
	                    '1739851282726831' => 'https://lakita.vn/combo-qua-khung-tet-nguyen-dan.html',
	                    '1584950161542159' => 'https://lakita.vn/tron-bo-thuc-hanh-ke-toan-tong-hop-tren-phan-mem-excel.html',
	                    '1594205084033500' => 'https://lakita.vn/chia-se-tat-tan-tat-kinh-nghiem-bao-ve-giai-trinh-so-lieu-khi-thanh-tra-thue.html',
	                    '2391237814250616' => 'https://lakita.vn/tron-bo-ky-thuat-lap-kiem-tra-phan-tich-bctc.html',
	                    '1872401092812322' => 'https://lakita.vn/chia-se-tat-tan-tat-kinh-nghiem-bao-ve-giai-trinh-so-lieu-khi-thanh-tra-thue-2.html',
	                    '2170475322979155' => 'https://lakita.vn/phat-hien-rui-do-tiem-an-khi-quyet-toan-3-luat-thue-2017.html',
	                    '1930688790275091' => 'https://lakita.vn/combo-qua-khung-chao-mung-30-04.html',
	                    '1493559494083709' => 'https://lakita.vn/tron-bo-ky-thuat-huong-dan-quyet-toan-thue-tncn.html',
	                    '2083433138366035' => 'https://lakita.vn/bao-hiem-xa-hoi-tien-luong-thue-tncn-2018.html'
	                ];

	                $replyComment = '';
	                if (!empty($comment->entry[0]->changes[0]->value->parent)) {
	                    $replyComment .= '<br> Trả lời comment: ' . $comment->entry[0]->changes[0]->value->parent->message .
	                            '<br> của ' . $comment->entry[0]->changes[0]->value->parent->message->from->name;
	                }
	                $page = json_decode(file_get_contents('https://graph.facebook.com/v2.11/' . $pageId[0] . '?access_token=' . ACCESS_TOKEN));
	                $urlTitle = isset($url[$pageId[0]]) ? $url[$pageId[0]] : $pageId[0];




	                $uid = $comment->entry[0]->changes[0]->value->from->id;
	                $fullSizePicture = (('https://graph.facebook.com/v2.11/' . $uid . '/picture?width=500'));


	                $this->load->library("email");
	                $this->email->from('cskh@lakita.vn', "lakita.vn");
	                $this->email->to('phuongtravel46@gmail.com, kenshiner96@gmail.com, ngoccongtt1@gmail.com, trinhnv@lakita.vn');
	                // $this->email->to('kenshiner96@gmail.com');
	                $this->email->subject('Có cmt fb mới ở landing page ' . $urlTitle . ' (' . date(_DATE_FORMAT_) . ')');

	                $uMessage = $comment->entry[0]->changes[0]->value->message;
	                $uName = $comment->entry[0]->changes[0]->value->from->name;


	                $this->email->message('<table cellspacing="0" class="MsoTableGrid" style="border-collapse:collapse; border:undefined"> <tbody> <tr> <td style="vertical-align:top; width:134.75pt"> <p style="margin-left:0in; margin-right:0in"><span style="font-size:11pt"><span style="font-family:Roboto"><img src="' . $fullSizePicture . '" style="height:271px; width:271px"/></span></span> </p></td><td style="vertical-align:top; width:600pt"> <p style="margin-left:1in; margin-right:0in"><span style="font-size:11pt"><span style="font-family:Roboto">' . $uName . '</span></span> </p><p style="margin-left:1in; margin-right:0in"><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Roboto"><strong><span style="font-size:24.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:#222222">' . $uMessage . '</span></span></span></strong></span></span></span> </p><p style="margin-left:1in; margin-right:0in">&nbsp;</p><a style="margin-left:1in; margin-right:0in" href="' . $urlTitle . '"> Landing Page: ' . $urlTitle . '</a><p style="margin-left:1in; margin-right:0in">' . $replyComment . '</p></td></tr></tbody></table>');
	                
	                if ($this->email->send())
	                {
	                    echo 'ok';
	                }
	                $this->email->clear(TRUE);


	                require_once APPPATH . 'libraries/Pusher.php';
	                $options = array(
	                    'cluster' => 'ap1',
	                    'encrypted' => true
	                );
	                $pusher = new Pusher(
	                        'e37045ff133e03de137a', 'f3707885b7e9d7c2718a', '428500', $options
	                );

	                $data2 = [];
	                $data2['title'] = 'Có comment FB mới ở landing page';
	                $data2['message'] = $page->title;
	                $data2['image'] = $fullSizePicture;
	                $data2['url'] = $urlTitle;
	                $pusher->trigger('my-channel', 'notice', $data2);
	            }
	        }
		}
	}
 ?>