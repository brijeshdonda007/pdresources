<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class employee extends CI_Controller
{
	function employee()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_employee');
	}
	
	function index($start='0')
	{
		if($_POST || $start=='s')
		{			
			$start = 0;			
			$searchtext = $this->input->post('searchText');						
			$this->session->set_userdata('searchtext',$searchtext);			
		}
		else
		{			
			$searchtext = $this->session->userdata('searchtext');
		}		
		$res = $this->mdl_employee->get_employee('',$searchtext);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/employee/index/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		if($searchtext == "")
			$searchtext = "Search";
		
		$data['searchText'] = $searchtext;						
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/employee/employee_list',$data);
		$this->load->view('admin/footer');
	}	
	function addEmployee($employee_id='')
	{		
		$this->form_validation->set_rules('employee_fname','First Name','trim|required');
		$this->form_validation->set_rules('employee_email','Email','trim|required|valid_email');	
		//$this->form_validation->set_rules('employee_title','Title','trim|required');
		//$this->form_validation->set_rules('employee_description','Biodata','trim|required');				
		$this->form_validation->set_rules('employee_avatar','Avtar','callback_validate_avtar');
		if($_POST['employee_linkedin_url'])
			$this->form_validation->set_rules('employee_linkedin_url','Linked in Url','callback_validate_url');
		
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($employee_id !='')
			{
				$res = $this->mdl_employee->get_employee($employee_id);
				$data = $res->row_array();																
			}			
			$data['profession']=$profession;
			$data['state']=$state;			
			
			$this->load->view('admin/header');
			$this->load->view('admin/employee/addEmployee',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			if($_FILES['employee_avatar']['error'] == 0)
			{
				if($this->input->post('pre_avatar_image'))
					@unlink('./'.$this->input->post('pre_avatar_image'));				
				$res = $this->mdl_common->uploadFile('employee_avatar','img','employee');					
				if($res['success'])
				{						
					$u_data['employee_avatar'] = $res['path'];
				}
			}								
			$u_data['employee_fname']=$this->input->post('employee_fname');
			$u_data['employee_email']=$this->input->post('employee_email');
			$u_data['employee_title']=$this->input->post('employee_title');
			$u_data['employee_description']=$this->input->post('employee_description');
			$u_data['employee_active']=$this->input->post('employee_active');		
			$u_data['employee_diplay_home']=$this->input->post('employee_diplay_home');		
			$u_data['employee_linkedin_url']=$this->input->post('employee_linkedin_url');		

			$this->mdl_employee->saveEmployee($employee_id,$u_data);	
			redirect('admin/employee/index/'.$start);	
		}
	}
	
	function deleteEmployee($id='')
	{
		if($id == "")
			$users = $this->input->post('employee');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_employee->deleteEmployee($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/employee/index/'.$start);
	}
	
	function updateActive($id,$is_active)
	{
		$data['employee_active'] = $is_active;
		$this->db->where('employee_id',$id);
		$this->db->update('pdr_employee_detail',$data);
	}		
	
	function validate_avtar()
	{
		if($_FILES['employee_avatar']['error'] == 0)
		{
			$ext=strtolower(end(explode('.',$_FILES['employee_avatar']['name'])));			
			$ValidExt=$this->mdl_constants->Image_ext();
			
			if(in_array($ext,$ValidExt))
			{
				return true;
			}
			else
			{
				$this->form_validation->set_message('validate_avtar', 'Please select valid avatar file');
				return false;
			}
		}
		else
			return TRUE;
	}
	
	function validate_url($str)
	{
		if(strlen(trim($str)) != 0)
		{
			if(preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $str))
			{
				return true;
			}
			else
			{
				$this->form_validation->set_message('validate_url', 'Please enter valid url');
				return false;
			}
		}
		else
			return TRUE;
	}
}
?>