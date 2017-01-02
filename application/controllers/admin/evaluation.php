<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class evaluation extends CI_Controller
{
	function evaluation()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_evaluation');
	}
	
	function index($start='s')
	{	
		if($_POST || $start=='s')
		{
			$start = 0;		
		}
			
		$res = $this->mdl_evaluation->get_evaluation();
		if($start == "s")
			$start = 0;
		$data = $this->mdl_common->pagiationData('admin/evaluation/index/',$res->num_rows(),$start,'4');

		$this->session->set_userdata('start',$start);												
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		if($res->num_rows >0)
			$data['Add_flag']=true;

		$this->load->view('admin/header');
		$this->load->view('admin/evaluation/evaluation_list',$data);
		$this->load->view('admin/footer');
	}
	
	function addEvaluation($evaluation_id='')
	{		
		$this->form_validation->set_rules('evaluation_name','Evaluation Name','trim|required');			

		if($evaluation_id == '')
		{	
			if($_FILES['test_image']['error'] != 0)
			{
				$file_error = "Please select Evaluation Image";
			}
		}
		if($this->form_validation->run() == FALSE || $file_error!='')
		{
			$data['evaluation_name'] = $this->input->post('evaluation_name');
			
			if(!$_POST && $evaluation_id != '')
			{
				$res = $this->mdl_evaluation->get_evaluation($course_id,$evaluation_id);
				$data = $res->row_array();								
			}
			
			$data['course_id']=$course_id;								
			$data['file_error']=$file_error;
			$this->load->view('admin/header');
			$this->load->view('admin/evaluation/addEvaluation',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$data['evaluation_name'] = $this->input->post('evaluation_name');			
			if($evaluation_id != "")
			{
				$res1 = $this->mdl_evaluation->get_evaluation($course_id,$testid);
				$row1 = $res1->row_array();				
				$image=$row1;
			}
								
			$testid = $this->mdl_evaluation->saveEvaluation($evaluation_id,$data);
			$start = $this->session->userdata('start');			
				redirect('admin/evaluation/index/'.$start);
		}
	}
				
	function deleteEvaluation($id='')
	{
		if($id == "")
			$users = $this->input->post('evaluation_id');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_evaluation->deleteEvaluation($id);
		}
		
		$start = $this->session->userdata('start');			
		redirect('admin/evaluation/index/'.$start);
	}
	
	function updateActive($evaluation_id,$is_active)
	{
		$data['is_active'] = $is_active;
		$this->db->where('evaluation_id',$evaluation_id);
		$this->db->update('pdr_evaluation_master',$data);
	}	
	
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Evaluation Question part		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#	
	function question($evaluation_id,$start='s')
	{		
		if($_POST || $start=='s')
		{
			$start = 0;			
		}
		$param= ' and question_evaluation_id='.$evaluation_id." order by question_order";	
		$res = $this->mdl_evaluation->get_questions('',$param);
		
		if($start == "s")
			$start = 0;
		$data['start']=$start;
		$data = $this->mdl_common->pagiationData('admin/evaluation/question/'.$evaluation_id.'/',$res->num_rows(),$start,'4');
		$this->session->set_userdata('start',$start);									
			
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		$data['evaluation_id']=$evaluation_id;
	
		$this->load->view('admin/header');
		$this->load->view('admin/evaluation/evaluation_question_list',$data);
		$this->load->view('admin/footer');
	}
	
	function addQuest($evaluation_id='',$test_questid='')
	{		
		
		$this->form_validation->set_rules('question_text','Question','trim|required');
		if($this->form_validation->run() == FALSE || $file_error!='')
		{
			$data['question_text'] = $this->input->post('question_text');
			if(!$_POST && $test_questid != '')
			{				
				$res = $this->mdl_evaluation->get_questions($test_questid);
				$data = $res->row_array();	
				$data['test_questid']=$test_questid;
			}
			$data['evaluation_id']=$evaluation_id;			
										
			$this->load->view('admin/header');
			$this->load->view('admin/evaluation/addQuest',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$user_data['question_text'] = $this->input->post('question_text');
			$user_data['question_evaluation_id'] = $this->input->post('evaluation_id');									
			$evaluation_id=$this->input->post('evaluation_id');

			$test_prof = $this->mdl_evaluation->saveQuse($test_questid,$user_data);
			if($test_questid == '')
			{
				$data['question_order'] = $test_prof;
				$this->db->where('question_id',$test_prof);
				$this->db->update('pdr_evaluation_question_master',$data);
			}
			$start = $this->session->userdata('start');
			if($start != '')
				redirect('admin/evaluation/question/'.$evaluation_id.'/'.$start);
			else
				redirect('admin/evaluation/question/'.$evaluation_id.'/s');
		}
	}	
			
	function deleteQuest($evaluation_id='',$id='')
	{
		
		if($id == "")
			$users = $this->input->post('question_id');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_evaluation->deleteQuse($id);
		}
		
		$start = $this->session->userdata('start');				
			redirect('admin/evaluation/question/'.$evaluation_id.'/'.$start);
	}
	
	function updateQuestActive($question_id ,$is_active)
	{
				
		$data['is_active'] = $is_active;
		$this->db->where('question_id',$question_id);
		$this->db->update('pdr_evaluation_question_master',$data);
	}
	
	function quest_sort($evaluation_id,$sort_order,$up_down)
	{
				
		if($up_down == "up")
			$sql1 = "SELECT question_order FROM pdr_evaluation_question_master WHERE question_order < '$sort_order' and is_deleted ='N' and question_evaluation_id=".$evaluation_id." ORDER BY question_order DESC LIMIT 1";
		else
			$sql1 = "SELECT question_order FROM pdr_evaluation_question_master WHERE question_order > '$sort_order' and is_deleted ='N' and question_evaluation_id=".$evaluation_id." ORDER BY question_order LIMIT 1";
		$result1 = mysql_query($sql1);
		
		if(mysql_num_rows($result1) != 0)
		{
			$move1 = $sort_order;
			$row1 = mysql_fetch_array($result1);
			$move2 = $row1['question_order'];
			
			$sql = "UPDATE pdr_evaluation_question_master SET question_order = ? WHERE question_order = ?";

			$this->db->query($sql, array(0, $move1));
			$this->db->query($sql, array($move1, $move2));
			$this->db->query($sql, array($move2,0));
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/evaluation/question/'.$evaluation_id.'/'.$start);
	}
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Evaluation Question Options part		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#	
	function option($evaluation_id,$question_id,$start='0')
	{	
		if($_POST || $start=='s')
		{
			$start = 0;			
		}
		$param= ' and option_question_id='.$question_id." order by option_order";	
		$res = $this->mdl_evaluation->get_option('',$param);
		
		if($start == "s")
			$start = 0;
		$data['start']=$start;
		$data = $this->mdl_common->pagiationData('admin/evaluation/option/'.$evaluation_id.'/'.$question_id.'/',$res->num_rows(),$start,'4');
		$this->session->set_userdata('start',$start);									
			
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		$data['evaluation_id']=$evaluation_id;
		$data['question_id']=$question_id;		
		$this->cheackopt($question_id);		
		$this->load->view('admin/header');
		$this->load->view('admin/evaluation/question_option_list',$data);
		$this->load->view('admin/footer');
	}
	
	function addOption($evaluation_id='',$question_id='',$ques_option_id='')
	{		
			
		$this->form_validation->set_rules('option_text','Option','trim|required');
		if($this->form_validation->run() == FALSE || $file_error!='')
		{
			$data['question_text'] = $this->input->post('question_text');
			if(!$_POST && $ques_option_id != '')
			{				
				$res = $this->mdl_evaluation->get_option($ques_option_id);
				$data = $res->row_array();	
				$data['ques_option_id']=$ques_option_id;				
			}
			$data['evaluation_id']=$evaluation_id;			
			$data['question_id']=$question_id;
													
			$this->load->view('admin/header');
			$this->load->view('admin/evaluation/addOption',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$user_data['option_text'] = $this->input->post('option_text');
			$user_data['option_question_id'] = $this->input->post('question_id');									
			$evaluation_id=$this->input->post('evaluation_id');
			$question_id=$this->input->post('question_id');			
			if($_REQUEST['is_active'] == 'Y')
			{
				if($_REQUEST['is_right_option'] == 'Yes')
					$this->RemoveAllright($question_id);
				$user_data['is_right_option'] = $this->input->post('is_right_option');				
			}
			else
				$user_data['is_right_option'] = 'No';
			$test_prof = $this->mdl_evaluation->saveOpt($ques_option_id,$user_data);
			if($ques_option_id == '')
			{
				$data['option_order'] = $test_prof;
				$this->db->where('option_id',$test_prof);
				$this->db->update('pdr_evaluation_option_master',$data);
			}
			$this->cheackopt($question_id);	
			$start = $this->session->userdata('start');
			if($start != '')
				redirect('admin/evaluation/option/'.$evaluation_id.'/'.$question_id.'/'.$start);
			else
				redirect('admin/evaluation/option/'.$evaluation_id.'/'.$question_id.'/s');
		}
	}	
			
	function deleteOpt($evaluation_id='',$question_id='',$id='')
	{			
		
	
		if($id == "")
			$users = $this->input->post('option_id');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_evaluation->deleteOpt($id);
		}
		$this->cheackopt($question_id);		
		$start = $this->session->userdata('start');				
			redirect('admin/evaluation/option/'.$evaluation_id.'/'.$question_id.'/'.$start);
	}
	
	function updateOptActive($evaluation_id,$question_id,$option_id ,$is_active)
	{
		
		
		$data['is_active'] = $is_active;
		if($is_active == 'N')
			$data['is_right_option'] = 'No';
		$this->db->where('option_id',$option_id);
		$this->db->update('pdr_evaluation_option_master',$data);	
		$this->cheackopt($question_id);		
		$start = $this->session->userdata('start');
		redirect('admin/evaluation/option/'.$evaluation_id.'/'.$question_id.'/'.$start);	
	}
	
	function RemoveAllright($question_id)
	{
		
		
		$data['is_right_option'] = 'No';
		$this->db->where('option_question_id',$question_id);
		$this->db->update('pdr_evaluation_option_master',$data);			
	}
	
	function opt_sort($evaluation_id,$question_id,$sort_order,$up_down)
	{
		
		
		if($up_down == "up")
			$sql1 = "SELECT option_order FROM pdr_evaluation_option_master WHERE option_order < '$sort_order' and is_deleted ='N' and option_question_id=".$question_id." ORDER BY option_order DESC LIMIT 1";
		else
			$sql1 = "SELECT option_order FROM pdr_evaluation_option_master WHERE option_order > '$sort_order' and is_deleted ='N' and option_question_id=".$question_id." ORDER BY option_order LIMIT 1";
		$result1 = mysql_query($sql1);
		
		if(mysql_num_rows($result1) != 0)
		{
			$move1 = $sort_order;
			$row1 = mysql_fetch_array($result1);
			$move2 = $row1['option_order'];
			
			$sql = "UPDATE pdr_evaluation_option_master SET option_order = ? WHERE option_order = ?";

			$this->db->query($sql, array(0, $move1));
			$this->db->query($sql, array($move1, $move2));
			$this->db->query($sql, array($move2,0));
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/evaluation/option/'.$evaluation_id.'/'.$question_id.'/'.$start);
	}
	
	function cheackopt($question_id)
	{
		$sql="select * from pdr_evaluation_option_master where is_deleted ='N' and is_right_option='Yes' and is_active ='Y' and option_question_id=".$question_id;
		$res= $this->db->query($sql);
		if($res->num_rows() >0)
			return true;
		else
		{
			$this->RemoveAllright($question_id);
			$sql1="select min(option_id) as option_id from pdr_evaluation_option_master where is_deleted ='N' and is_active ='Y' and option_question_id=".$question_id;
			$res1 = mysql_query($sql1);
			$row=mysql_fetch_assoc($res1);			
			if($row['option_id'] > 0)
			{				
				$data['is_right_option'] = 'Yes';
				$this->db->where('option_id',$row['option_id']);
				$this->db->update('pdr_evaluation_option_master',$data);
				return true;
			}
			else
			{
				$sql2="select min(option_id) as option_id from pdr_evaluation_option_master where is_deleted ='N' and option_question_id=".$question_id;
				$res2 = mysql_query($sql2);
				if(mysql_num_rows($res2) >0)
				{
					$row=mysql_fetch_assoc($res2);
					$data['is_right_option'] = 'Yes';
					$this->db->where('option_id',$row['option_id']);
					$this->db->update('pdr_evaluation_option_master',$data);
					return true;
				}
			}			
		}
	}		
}
?>