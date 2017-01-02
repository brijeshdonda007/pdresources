<?php
class Mdl_common extends CI_Model
{
	var $documentRoot;
	function Mdl_common()
	{
		$this->documentRoot = $_SERVER['DOCUMENT_ROOT'].'artoongames/';
		date_default_timezone_set('Asia/Calcutta');
	}
	
	function checkAdminSession()
	{
		if(!$this->session->userdata('admin_id'))
			redirect('admin/admin');
	}
	
	function checkSession()
	{
		if($this->session->userdata('id') == "")
			redirect('member/login');
	}
	
	function pagiationData($str,$num,$start,$segment)
	{
		$config['base_url'] = base_url().$str;
		$config['total_rows'] = $num;
		$config['per_page'] = $this->session->userdata('per_page');
		$config['uri_segment'] = $segment;
		$config['full_tag_open'] = '<div id="pagination" style="display:inline;">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config); 
		
		$query = $this->db->last_query()." LIMIT ".$start." , ".$config['per_page'];
		$res = $this->db->query($query);
	
		$data['listArr'] = $res->result_array();
		$data['num'] = $res->num_rows();
		$data['links'] =  $this->pagination->create_links();
		return $data;
	}
	
	function getField($field,$table,$colname,$colval)
	{
		$sql = "select $field from $table where $colname='".mysql_escape_string($colval)."'";
		$res = $this->db->query($sql);
		$resRow = $res->row();
		
		return $resRow->$field;
	}
	
	function getField1($sql,$field)
	{
		$res = $this->db->query($sql);
		$resRow = $res->row();
		return $resRow->$field;
	}
	
	function getTableData($table,$colname,$colval)
	{
		$sql = "select * from $table where $colname='".mysql_escape_string($colval)."'";
		$res = $this->db->query($sql);
		$resRow = $res->row_array();
		
		return $resRow;
	}
	
	function queryResult($sql)
	{
		$res = $this->db->query($sql);
		$result = $res->result_array();
		
		return $result;
	}

	function dropDownAry($sql,$keyField,$valueField,$selectFiled="Y")
	{
		$dropDown = array();
		
		//if select is required in drop down
		if($selectFiled == "Y")
			$dropDown['Select'] = "Select";
		else if($selectFiled != "")
			$dropDown['Select'] = $selectFiled;
		
		$result = $this->db->query($sql);
		foreach($result->result_array() as $res)
		{
			$key = $res[$keyField];
			$dropDown[$key] = $res[$valueField];
		}
		return $dropDown;
	}
	
	function uploadFile($uploadFile,$filetype,$folder,$fileName='')
	{
		$resultArr = array();
		
		$config['max_size'] = '1024000';
		if($filetype == 'img') 	$config['allowed_types'] = 'gif|jpg|png|jpeg';
		if($filetype == 'All') 	$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|zip|xls';
		if($filetype == 'csv') 	$config['allowed_types'] = 'csv';
		if($filetype == 'swf') 	$config['allowed_types'] = 'swf';
		if($filetype == 'html') 	$config['allowed_types'] = 'html|htm';
		
		if(strpos($folder,'application/views') !== FALSE)
			$config['upload_path'] = './'.$folder.'/';
		else
			$config['upload_path'] = './uploads/'.$folder.'/';

		if($fileName != "")
			$config['file_name'] = $fileName;
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if(!$this->upload->do_upload($uploadFile))
		{
			$resultArr['success'] = false;
			$resultArr['error'] = $this->upload->display_errors();
		}	else	{
			$resArr = $this->upload->data();
			$resultArr['success'] = true;
			
			if(strpos($folder,'application/views') !== FALSE)
				$resultArr['path'] = $folder."/".$resArr['file_name'];
			else
				$resultArr['path'] = "uploads/".$folder."/".$resArr['file_name'];
		}
		return $resultArr;
	}
	
	function game_info($game_id)
	{
		$game_id = mysql_escape_string($game_id);
		
		$res = $this->db->query("select * from games as g,game_images as gi,game_swfs as gs where g.game_id='$game_id' and g.game_id=gi.game_id and g.game_id=gs.game_id");
		$gameData = $res->row_array();
		
		$res1 = $this->db->query("select * from game_starhunt where game_id='$game_id' order by sort_order");
		$gameData['starhunt'] = $res1->result_array();
		
		$res1 = $this->db->query("select * from head_tournaments as ht,game_tournaments as gt where ht.type_id=gt.type_id and ht.game_id='$game_id' and ht.del_in='N'");
		$gameData['head_tours'] = $res1->result_array();
		
		$sql = "select jt.*,gt.*,IFNULL(ut.player_count,0) as players from jackpot_tournaments as jt left join user_jackpot_tours as ut on jt.jt_id=ut.jt_id,game_tournaments as gt where jt.type_id=gt.type_id and game_id='$game_id' and jt.del_in='N' order by end_time";
		$res1 = $this->db->query($sql);
		$gameData['jackpot_tours'] = $res1->result_array();
		
		$res1 = $this->db->query("select * from  cup_tournaments as ct,game_tournaments as gt where ct.type_id=gt.type_id and ct.game_id='$game_id' and ct.del_in='N'");
		$gameData['cup_tours'] = $res1->result_array();
		
		return $gameData;
	}
	
	function sendMail($toEmail,$subject,$mail_body,$ccEmails='')
	{
		$this->load->library('email');
		$fromEmail = "info@artoonsolutions.com";
		
		$config['mailtype'] = 'html';
		$config['protocol'] = 'mail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$this->email->initialize($config);
		
		$this->email->from($fromEmail , 'Artoon Games');
		$this->email->to($toEmail);
		$this->email->subject($subject);
		$this->email->message($mail_body);
		//$this->email->reply_to($replyToEmail,'');
		
		if($ccEmails != "")
			$this->email->cc($ccEmails);
		
		$this->email->send();
		//echo $this->email->print_debugger();
	}
	
    function getUniqueCode($length = "")
    {	
		$code = md5(uniqid(rand(), true));
		if ($length != "") 
			return substr($code, 0, $length);
		else
			return $code;
    } 
	
	function daysInMonth($month, $year)
	{
		// calculate number of days in a month
		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
	}
	
	function remainingTime($dateTime)
	{
		$curTime = time();
		$endTime = strtotime($dateTime);
		
		if($curTime < $endTime)
		{
			$dateDiff = $endTime - $curTime;
			$minuteDiff = $dateDiff/60;
			if($minuteDiff > 60)
			{
				$hourDiff = $minuteDiff/60;
				if($hourDiff >24)
				{
					$daysDiff = $hourDiff/24;
					return floor($daysDiff)." days";
				}
				else
					return floor($hourDiff)." hours";
			}
			else
				return floor($minuteDiff)." Minutes";
		}
		else
			return "Closed";
	}
	
	function remainingDays()
	{
		 $totaldays=$this->daysInMonth(date('m',time()),date('y',time()));
		 $today = date('d')-1;
		 $remaingdays = ($totaldays-$today);
		 return $remaingdays;
	}
	
	function generateCode($dataArr)
	{
		$str = '<iframe scrolling="no" style="overflow-x: hidden; overflow-y: hidden; height:'.$dataArr['height'].'px; width: '.$dataArr['width'].'px; border:none" class="fb_ltr"
		src="http://www.facebook.com/plugins/likebox.php?href='.$dataArr['facebookPageUrl'].'&show_faces=true&stream='.$dataArr['stream'].'&width='.$dataArr['width'].'&colorscheme='.$dataArr['color_scheme'].'&header='.$dataArr['header'].'&height='.$dataArr['height'].'allowTransparency="false" frameborder="0"></iframe>';
	
	return htmlentities($str);
	
	}
	//$this->output->cache(n);   //To cache the page , Where n is the number of minutes you wish the page to remain cached between refreshes.
}