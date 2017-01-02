<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller
{
	function Test()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_test');
	}
	
	function index($course_id='0',$start='s')
	{	
		$this->session->set_userdata('course_id',$course_id);
		if($_POST || $start=='s')
		{
			$start = 0;		
		}
			
		$res = $this->mdl_test->get_test($course_id);
		if($start == "s")
			$start = 0;
		
		$data = $this->mdl_common->pagiationData('admin/test/index/',$res->num_rows(),$start,'4');
		
		$this->session->set_userdata('start',$start);												
		$data['course_id']=$course_id;
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		if($res->num_rows >0)
			$data['Add_flag']=true;

		$this->load->view('admin/header');
		$this->load->view('admin/test_list',$data);
		$this->load->view('admin/footer');
	}
	
	function addTest($course_id='',$test_id='')
	{		
		$this->form_validation->set_rules('test_name','Test Name','trim|required');			

		if($test_id == '')
		{	
			if($_FILES['test_image']['error'] != 0)
			{
				$file_error = "Please select Test Image";
			}
		}
		if($this->form_validation->run() == FALSE || $file_error!='')
		{
			$data['test_name'] = $this->input->post('test_name');
			
			if(!$_POST && $test_id != '')
			{
				$res = $this->mdl_test->get_test($course_id,$test_id);
				$data = $res->row_array();								
			}
			
			$data['course_id']=$course_id;								
			$data['file_error']=$file_error;
			$this->load->view('admin/header');
			$this->load->view('admin/addTest',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$data['test_course_id']=$this->input->post('test_course_id');
			$data['test_name'] = $this->input->post('test_name');			
			if($test_id != "")
			{
				$res1 = $this->mdl_test->get_test($course_id,$testid);
				$row1 = $res1->row_array();				
				$image=$row1;
			}
								
			$testid = $this->mdl_test->saveTest($test_id,$data);
			$start = $this->session->userdata('start');			
				redirect('admin/test/index/'.$course_id);
		}
	}			
	function deleteTest($course_id='',$id='')
	{
		if($id == "")
			$users = $this->input->post('test_id');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_test->deleteTest($id);
		}
		
		$start = $this->session->userdata('start');
				
			redirect('admin/test/index/'.$course_id);
	}
	
	function updateActive($test_id,$is_active)
	{
		$data['is_active'] = $is_active;
		$this->db->where('test_id',$test_id);
		$this->db->update('pdr_test_master',$data);
	}	
	
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Test Question part		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#	
	function question($test_id,$start='0')
	{
		if($this->session->userdata['course_id'] == '')
			redirect('admin/course/index/s');
		if($_POST || $start=='s')
		{
			$start = 0;			
		}
		$param= ' and question_test_id='.$test_id." order by question_order";	
		$res = $this->mdl_test->get_questions('',$param);
		
		if($start == "s")
			$start = 0;
		$data['start']=$start;
		$data = $this->mdl_common->pagiationData('admin/test/question/'.$test_id.'/',$res->num_rows(),$start,'4');
		$this->session->set_userdata('start',$start);									
			
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		$data['test_id']=$test_id;
	
		$this->load->view('admin/header');
		$this->load->view('admin/test_question_list',$data);
		$this->load->view('admin/footer');
	}
	function addQuest($test_id='',$test_questid='')
	{		
		if($this->session->userdata['course_id'] == '')
			redirect('admin/course/index/s');
		$this->form_validation->set_rules('question_text','Question','trim|required');
		if($this->form_validation->run() == FALSE || $file_error!='')
		{
			$data['question_text'] = $this->input->post('question_text');
			if(!$_POST && $test_questid != '')
			{				
				$res = $this->mdl_test->get_questions($test_questid);
				$data = $res->row_array();	
				$data['test_questid']=$test_questid;
			}
			$data['test_id']=$test_id;			
										
			$this->load->view('admin/header');
			$this->load->view('admin/addQuest',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$user_data['question_text'] = $this->input->post('question_text');
			$user_data['question_test_id'] = $this->input->post('test_id');									
			$test_id=$this->input->post('test_id');

			$test_prof = $this->mdl_test->saveQuse($test_questid,$user_data);
			if($test_questid == '')
			{
				$data['question_order'] = $test_prof;
				$this->db->where('question_id',$test_prof);
				$this->db->update('pdr_question_master',$data);
			}
			$start = $this->session->userdata('start');
			if($start != '')
				redirect('admin/test/question/'.$test_id.'/'.$start);
			else
				redirect('admin/test/question/'.$test_id.'/s');
		}
	}			
	function deleteQuest($test_id='',$id='')
	{
		if($this->session->userdata['course_id'] == '')
			redirect('admin/course/index/s');
		if($id == "")
			$users = $this->input->post('question_id');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_test->deleteQuse($id);
		}
		
		$start = $this->session->userdata('start');				
			redirect('admin/test/question/'.$test_id.'/'.$start);
	}
	
	function updateQuestActive($question_id ,$is_active)
	{
		if($this->session->userdata['course_id'] == '')
			redirect('admin/course/index/s');		
		$data['is_active'] = $is_active;
		$this->db->where('question_id',$question_id);
		$this->db->update('pdr_question_master',$data);
	}
	function quest_sort($test_id,$sort_order,$up_down)
	{
		if($this->session->userdata['course_id'] == '')
			redirect('admin/course/index/s');		
		if($up_down == "up")
			$sql1 = "SELECT question_order FROM pdr_question_master WHERE question_order < '$sort_order' and is_deleted ='N' and question_test_id=".$test_id." ORDER BY question_order DESC LIMIT 1";
		else
			$sql1 = "SELECT question_order FROM pdr_question_master WHERE question_order > '$sort_order' and is_deleted ='N' and question_test_id=".$test_id." ORDER BY question_order LIMIT 1";
		$result1 = mysql_query($sql1);
		
		if(mysql_num_rows($result1) != 0)
		{
			$move1 = $sort_order;
			$row1 = mysql_fetch_array($result1);
			$move2 = $row1['question_order'];
			
			$sql = "UPDATE pdr_question_master SET question_order = ? WHERE question_order = ?";

			$this->db->query($sql, array(0, $move1));
			$this->db->query($sql, array($move1, $move2));
			$this->db->query($sql, array($move2,0));
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/test/question/'.$test_id.'/'.$start);
	}
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Test Question Options part		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#	
	function option($test_id,$question_id,$start='0')
	{	
		if($this->session->userdata['course_id'] == '')
			redirect('admin/course/index/s');

		if($_POST || $start=='s')
		{
			$start = 0;			
		}
		$param= ' and option_question_id='.$question_id." order by option_order";	
		$res = $this->mdl_test->get_option('',$param);
		
		if($start == "s")
			$start = 0;
		$data['start']=$start;
		$data = $this->mdl_common->pagiationData('admin/test/option/'.$test_id.'/'.$question_id.'/',$res->num_rows(),$start,'4');
		$this->session->set_userdata('start',$start);									
			
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		$data['test_id']=$test_id;
		$data['question_id']=$question_id;		
		$this->cheackopt($question_id);		
		$this->load->view('admin/header');
		$this->load->view('admin/question_option_list',$data);
		$this->load->view('admin/footer');
	}
	function addOption($test_id='',$question_id='',$ques_option_id='')
	{		
		if($this->session->userdata['course_id'] == '')
			redirect('admin/course/index/s');	
		$this->form_validation->set_rules('option_text','Option','trim|required');
		if($this->form_validation->run() == FALSE || $file_error!='')
		{
			$data['question_text'] = $this->input->post('question_text');
			if(!$_POST && $ques_option_id != '')
			{				
				$res = $this->mdl_test->get_option($ques_option_id);
				$data = $res->row_array();	
				$data['ques_option_id']=$ques_option_id;				
			}
			$data['test_id']=$test_id;			
			$data['question_id']=$question_id;
													
			$this->load->view('admin/header');
			$this->load->view('admin/addOption',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$user_data['option_text'] = $this->input->post('option_text');
			$user_data['option_question_id'] = $this->input->post('question_id');									
			$test_id=$this->input->post('test_id');
			$question_id=$this->input->post('question_id');			
			if($_REQUEST['is_active'] == 'Y')
			{
				if($_REQUEST['is_right_option'] == 'Yes')
					$this->RemoveAllright($question_id);
				$user_data['is_right_option'] = $this->input->post('is_right_option');				
			}
			else
				$user_data['is_right_option'] = 'No';
			$test_prof = $this->mdl_test->saveOpt($ques_option_id,$user_data);
			if($ques_option_id == '')
			{
				$data['option_order'] = $test_prof;
				$this->db->where('option_id',$test_prof);
				$this->db->update('pdr_option_master',$data);
			}
			$this->cheackopt($question_id);	
			$start = $this->session->userdata('start');
			if($start != '')
				redirect('admin/test/option/'.$test_id.'/'.$question_id.'/'.$start);
			else
				redirect('admin/test/option/'.$test_id.'/'.$question_id.'/s');
		}
	}			
	function deleteOpt($test_id='',$question_id='',$id='')
	{			
		if($this->session->userdata['course_id'] == '')
			redirect('admin/course/index/s');
	
		if($id == "")
			$users = $this->input->post('option_id');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_test->deleteOpt($id);
		}
		$this->cheackopt($question_id);		
		$start = $this->session->userdata('start');				
			redirect('admin/test/option/'.$test_id.'/'.$question_id.'/'.$start);
	}
	
	function updateOptActive($test_id,$question_id,$option_id ,$is_active)
	{
		if($this->session->userdata['course_id'] == '')
			redirect('admin/course/index/s');
		
		$data['is_active'] = $is_active;
		if($is_active == 'N')
			$data['is_right_option'] = 'No';
		$this->db->where('option_id',$option_id);
		$this->db->update('pdr_option_master',$data);	
		$this->cheackopt($question_id);		
		$start = $this->session->userdata('start');
		redirect('admin/test/option/'.$test_id.'/'.$question_id.'/'.$start);	
	}
	function RemoveAllright($question_id)
	{
		if($this->session->userdata['course_id'] == '')
			redirect('admin/course/index/s');
		
		$data['is_right_option'] = 'No';
		$this->db->where('option_question_id',$question_id);
		$this->db->update('pdr_option_master',$data);			
	}
	function opt_sort($test_id,$question_id,$sort_order,$up_down)
	{
		if($this->session->userdata['course_id'] == '')
			redirect('admin/course/index/s');
		
		if($up_down == "up")
			$sql1 = "SELECT option_order FROM pdr_option_master WHERE option_order < '$sort_order' and is_deleted ='N' and option_question_id=".$question_id." ORDER BY option_order DESC LIMIT 1";
		else
			$sql1 = "SELECT option_order FROM pdr_option_master WHERE option_order > '$sort_order' and is_deleted ='N' and option_question_id=".$question_id." ORDER BY option_order LIMIT 1";
		$result1 = mysql_query($sql1);
		
		if(mysql_num_rows($result1) != 0)
		{
			$move1 = $sort_order;
			$row1 = mysql_fetch_array($result1);
			$move2 = $row1['option_order'];
			
			$sql = "UPDATE pdr_option_master SET option_order = ? WHERE option_order = ?";

			$this->db->query($sql, array(0, $move1));
			$this->db->query($sql, array($move1, $move2));
			$this->db->query($sql, array($move2,0));
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/test/option/'.$test_id.'/'.$question_id.'/'.$start);
	}
	function cheackopt($question_id)
	{
		$sql="select * from pdr_option_master where is_deleted ='N' and is_right_option='Yes' and is_active ='Y' and option_question_id=".$question_id;
		$res= $this->db->query($sql);
		if($res->num_rows() >0)
			return true;
		else
		{
			$this->RemoveAllright($question_id);
			$sql1="select min(option_id) as option_id from pdr_option_master where is_deleted ='N' and is_active ='Y' and option_question_id=".$question_id;
			$res1 = mysql_query($sql1);
			$row=mysql_fetch_assoc($res1);			
			if($row['option_id'] > 0)
			{				
				$data['is_right_option'] = 'Yes';
				$this->db->where('option_id',$row['option_id']);
				$this->db->update('pdr_option_master',$data);
				return true;
			}
			else
			{
				$sql2="select min(option_id) as option_id from pdr_option_master where is_deleted ='N' and option_question_id=".$question_id;
				$res2 = mysql_query($sql2);
				if(mysql_num_rows($res2) >0)
				{
					$row=mysql_fetch_assoc($res2);
					$data['is_right_option'] = 'Yes';
					$this->db->where('option_id',$row['option_id']);
					$this->db->update('pdr_option_master',$data);
					return true;
				}
			}			
		}
	}		
}
?>