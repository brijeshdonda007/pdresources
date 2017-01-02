<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Controller
{
	function Course()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_course');
		$this->load->model('admin/mdl_test');							
	}
	
	function index($start='0')
	{	
		if($_POST || $start=='s')
		{
			$start = 0;
			$searchKey = $this->input->post('searchText');						
			$this->session->set_userdata('searchKey',$searchKey);
		}
		else
		{
			$searchKey = $this->session->userdata('searchKey');
		}
			
		$res = $this->mdl_course->get_course('',$searchKey);
		
		if($start == "s")
			$start = 0;
		
		$data = $this->mdl_common->pagiationData('admin/course/index/',$res->num_rows(),$start,'4');
		
		$this->session->set_userdata('start',$start);									
		if($searchKey == "")
			$searchKey = "Search";
		
		$data['searchText'] = $searchKey;
		
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/course_list',$data);
		$this->load->view('admin/footer');
	}
	
	function addCourse($course_id='')
	{		
		$this->form_validation->set_rules('course_name','Course Name','trim|required');
		$this->form_validation->set_rules('course_ce_hours','Course Hours','trim|required|decimal');
		$this->form_validation->set_rules('course_expiry_date','Course Expiry Date','trim|required');
		$this->form_validation->set_rules('course_ce_hours','Course Hours','trim|required|numeric');
		$this->form_validation->set_rules('course_author','Course Author','trim|required');	
		$this->form_validation->set_rules('course_main_course_id','Main Course Id','trim|required|callback_match_course');		

		if($course_id == '')
		{	
			if($_FILES['course_image']['error'] != 0)
			{
				$file_error = "Please select Course Image";
			}
		}
		if($this->form_validation->run() == FALSE || $file_error!='')
		{
			$data['course_name'] = $this->input->post('course_name');
			$data['course_ce_hours'] = $this->input->post('course_ce_hours');				
			$data['course_target_audiance'] = $this->input->post('course_target_audiance');
			$data['course_expiry_date'] = $this->input->post('course_expiry_date');			
			$data['course_desc'] = $this->input->post('course_desc');
			$data['course_about_author'] = $this->input->post('course_about_author');						
			$data['course_online_desc'] = $this->input->post('course_online_desc');
			$data['course_testonly_desc'] = $this->input->post('course_testonly_desc');				
			$data['course_learning_objactive'] = $this->input->post('course_learning_objactive');
			$data['course_main_course_id'] = $this->input->post('course_main_course_id');			
			$data['course_author'] = $this->input->post('course_author');					
			$data['course_search_on_line'] = $this->input->post('course_search_on_line');
			$data['course_search_test_only'] = $this->input->post('course_search_test_only');				
			$data['course_is_new'] = $this->input->post('course_is_new');
			$data['course_is_best_seller'] = $this->input->post('course_is_best_seller');			
			$data['course_is_sell'] = $this->input->post('course_is_sell');
			$data['course_is_closeout'] = $this->input->post('course_is_closeout');						
			$data['course_is_ethics'] = $this->input->post('course_is_ethics');
			$data['course_is_medical_error'] = $this->input->post('course_is_medical_error');	
			if($this->input->post('pre_course_image'))
				$data['course_image'] = $this->input->post('pre_course_image');																
			//$data['course_id'] = $course_id;			
			if(!$_POST && $course_id != '')
			{
				$res = $this->mdl_course->get_course($course_id);
				$data = $res->row_array();								
			}
					
			$data['file_error']=$file_error;
			$this->load->view('admin/header');
			$this->load->view('admin/addCourse',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$data['course_name'] = $this->input->post('course_name');
			$data['course_ce_hours'] = $this->input->post('course_ce_hours');				
			$data['course_target_audiance'] = $this->input->post('course_target_audiance');
			$data['course_expiry_date'] = date('Y-m-d',strtotime($this->input->post('course_expiry_date')));		
			$data['course_desc'] = $this->input->post('course_desc');
			$data['course_about_author'] = $this->input->post('course_about_author');						
			$data['course_online_desc'] = $this->input->post('course_online_desc');
			$data['course_testonly_desc'] = $this->input->post('course_testonly_desc');				
			$data['course_learning_objactive'] = $this->input->post('course_learning_objactive');
			$data['course_author'] = $this->input->post('course_author');			
			$data['course_main_course_id'] = $this->input->post('course_main_course_id');
			$data['course_search_on_line'] = $this->input->post('course_search_on_line');
			$data['course_search_test_only'] = $this->input->post('course_search_test_only');				
			$data['course_is_new'] = $this->input->post('course_is_new');
			$data['course_is_best_seller'] = $this->input->post('course_is_best_seller');			
			$data['course_is_sell'] = $this->input->post('course_is_sell');
			$data['course_is_closeout'] = $this->input->post('course_is_closeout');						
			$data['course_is_ethics'] = $this->input->post('course_is_ethics');
			$data['course_is_medical_error'] = $this->input->post('course_is_medical_error');				
			if($course_id != "")
			{
				$res1 = $this->mdl_course->get_course($courseid);
				$row1 = $res1->row_array();				
				$image=$row1;
			}
			if($_FILES['course_image']['error'] == 0)
				{
					if($course_id != "") {
						@unlink('./'.$row1['course_image']);
					}																															
						$res = $this->mdl_common->uploadFile('course_image','img','course');					
					if($res['success'])
					{						
						$data['course_image'] = $res['path'];
					}
				}								
			$courseid = $this->mdl_course->saveCourse($course_id,$data);
			$start = $this->session->userdata('start');
			if($course_id != '')
				redirect('admin/course/index/'.$start);
			else
				redirect('admin/course/index/s');
		}
	}			
	function deleteCourse($id='')
	{
		if($id == "")
			$users = $this->input->post('course_id');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_course->deleteCourse($id);
		}
		
		$start = $this->session->userdata('start');
				
			redirect('admin/course/index/'.$start);
	}
	
	function updateActive($course_id,$is_active)
	{
		$data['course_is_active'] = $is_active;
		$this->db->where('course_id',$course_id);
		$this->db->update('pdr_course_master',$data);
	}	
	function match_course($str)
	{
		$arr=explode('-',$str);		
		
		if(count($arr) == 2 && is_numeric($arr[0]) && strlen($arr[0]) == 2 && is_numeric($arr[1]) && strlen($arr[1]) == 2 )
		{
			return TRUE;
		}
		else		
		{
			$this->form_validation->set_message('match_course', 'Unvalid course master id');
			return FALSE;
		}
	}	
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#																	For Course Profesion part		
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#	
	function profession($course_id,$start='0')
	{	
		if($_POST || $start=='s')
		{
			$start = 0;			
		}
		$param= ' and course_pro_course_id='.$course_id;	
		$res = $this->mdl_course->get_course_profession('','',$param);
		
		if($start == "s")
			$start = 0;
		
		$data = $this->mdl_common->pagiationData('admin/course/index/',$res->num_rows(),$start,'4');
		$this->session->set_userdata('start',$start);									
			
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		$data['course_id']=$course_id;
		#----------------------------------------------------------------------For State Dropdown----------------------------------------------------------------------#
			$sql = "select state_id,state_name from pdr_state_master where state_is_active='Y' and state_is_deleted='N' order by state_name";
			$data['state'] = $this->mdl_common->dropDownAry($sql,'state_id','state_name');
		#----------------------------------------------------------------------For Course Info----------------------------------------------------------------------#			
			$sql = "select course_id,course_name from pdr_course_master where course_id=".$course_id;
			$res=$this->db->query($sql);
			$courseInfo=$res->result_array();
			$data['cousrsename']=$courseInfo[0]['course_name'];
		$sql = "select profession_id,profession_name from pdr_profession_master where profession_is_active='Y' and profession_is_deleted='N' order by profession_name";
		$data['profession'] = $this->mdl_common->dropDownAry($sql,'profession_id','profession_name');

		$this->load->view('admin/header');
		$this->load->view('admin/course_prof_list',$data);
		$this->load->view('admin/footer');
	}
	function addProf($course_id='',$course_proid='')
	{		
		$this->form_validation->set_rules('course_pro_state_id','State Name','trim|required|is_value[Select]');
		$this->form_validation->set_rules('course_pro_prof_id','Profession Name','trim|required|is_value[Select]|callback_cheack_for_duplicate');		
		if($this->form_validation->run() == FALSE || $file_error!='')
		{
			$data['course_pro_state_id'] = $this->input->post('course_pro_state_id');
			$data['course_pro_course_id'] = $this->input->post('course_pro_course_id');
			$data['course_pro_prof_id'] = $this->input->post('course_pro_prof_id');				
			$data['course_pro_description'] = $this->input->post('course_pro_description');			
			if(!$_POST && $course_proid != '')
			{
				$res = $this->mdl_course->get_course_profession($course_proid);
				$data = $res->row_array();	
			}
			$sql="select course_pro_prof_id from pdr_course_profession_master where is_deleted='N' and course_pro_course_id=".$course_id;
			if($data['course_pro_state_id'])
				$sql .=' and course_pro_state_id ='.$data['course_pro_state_id'];	
			if($course_proid)
				$sql .=' and course_pro_id <>'.$course_proid;				
			$OPResultset=$this->db->query($sql);
			$tempresult=$OPResultset->result_array();
			foreach($tempresult as $key=>$val)
				$ProfIDs[]=$val['course_pro_prof_id'];
			$profession_id=implode($ProfIDs,',');
			if($profession_id)
				$param="and profession_id not in(".$profession_id.")";
			$data['course_id']	=$course_id;
			#----------------------------------------------------------------------For State Dropdown----------------------------------------------------------------------#
			$sql = "select state_id,state_name from pdr_state_master where state_is_active='Y' and state_is_deleted='N' order by state_name";
			$data['state'] = $this->mdl_common->dropDownAry($sql,'state_id','state_name','Y');
			#----------------------------------------------------------------------For Course Info----------------------------------------------------------------------#			
			$sql = "select course_id,course_name from pdr_course_master where course_id=".$course_id;
			$res=$this->db->query($sql);
			$courseInfo=$res->result_array();
			$data['cousrsename']=$courseInfo[0]['course_name'];
			$data['course_id']=$courseInfo[0]['course_id'];
			#----------------------------------------------------------------------For State Dropdown----------------------------------------------------------------------#			
			$sql = "select profession_id,profession_name from pdr_profession_master where profession_is_active='Y' and profession_is_deleted='N' ".$param." order by profession_name";
			$data['profession'] = $this->mdl_common->dropDownAry($sql,'profession_id','profession_name','Y');	
							
			$this->load->view('admin/header');
			$this->load->view('admin/addProf',$data);
			$this->load->view('admin/footer');
		}
		else
		{

			$user_data['course_pro_state_id'] = $this->input->post('course_pro_state_id');
			$user_data['course_pro_course_id'] = $this->input->post('course_pro_course_id');
			$user_data['course_pro_prof_id'] = $this->input->post('course_pro_prof_id');				
			$user_data['course_pro_description'] = $this->input->post('course_pro_description');						
			$course_id=$this->input->post('course_id');

			$course_prof = $this->mdl_course->saveProf($course_proid,$user_data);
			$start = $this->session->userdata('start');
			if($start != '')
				redirect('admin/course/profession/'.$course_id.'/'.$start);
			else
				redirect('admin/course/profession/'.$course_id.'/s');
		}
	}			
	function deleteProf($course_id='',$id='')
	{
		if($id == "")
			$users = $this->input->post('course_pro_id');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_course->deleteProf($id);
		}
		
		$start = $this->session->userdata('start');				
			redirect('admin/course/profession/'.$course_id.'/'.$start);
	}
	
	function updateProfActive($course_pro_id,$is_active)
	{
		$data['is_active'] = $is_active;
		$this->db->where('course_pro_id',$course_pro_id);
		$this->db->update('pdr_course_profession_master',$data);
	}
	function cheack_for_duplicate($prof_id)	
	{
		$course_id=$this->input->post('course_pro_course_id');
		$state_id=$this->input->post('course_pro_state_id');		
		$course_pro_id=$this->input->post('course_pro_id');
		if($course_id && $state_id && $prof_id)
			$param=' and is_deleted="N" and course_pro_course_id='.$course_id.' and course_pro_prof_id='.$prof_id.' and course_pro_state_id='.$state_id;
		$res = $this->mdl_course->get_course_profession('','',$param);
		if($res->num_rows() >0 && $course_pro_id='')
		{
			$this->form_validation->set_message('cheack_for_duplicate', 'Combination of state,course,profession already exits Please select another one');
			return FALSE;
		}
		else
			return TRUE;
	}
	function GetProfDropdown($state_id='',$course_id='',$selected='',$course_proid='')
	{
		if($selected == '0')
			$selected='';
		if($course_proid == '0')
			$course_proid='';
		$sql="select course_pro_prof_id from pdr_course_profession_master where is_deleted='N' and course_pro_course_id=".$course_id." and course_pro_state_id=".$state_id;
			if($course_proid)
				$sql .=' and course_pro_id <>'.$course_proid;				
				
			$OPResultset=$this->db->query($sql);
			$tempresult=$OPResultset->result_array();
			foreach($tempresult as $key=>$val)
				$ProfIDs[]=$val['course_pro_prof_id'];
			$profession_id=implode($ProfIDs,',');
			if($profession_id)
				$param="and profession_id not in(".$profession_id.")";
		$sql = "select profession_id,profession_name from pdr_profession_master where profession_is_active='Y' and profession_is_deleted='N' ".$param." order by profession_name";
		$profession = $this->mdl_common->dropDownAry($sql,'profession_id','profession_name','Y');				
		echo form_dropdown('course_pro_prof_id',$profession,$selected,'style="width:150px"'); 		
	}
}
?>