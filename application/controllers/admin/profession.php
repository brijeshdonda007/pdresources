<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profession extends CI_Controller
{
	function Profession()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_profession');
	}
	
	function index($start='0')
	{				
		$res = $this->mdl_profession->get_profession();
		
		if($start == "s")
			$start = 0;
		
		$data = $this->mdl_common->pagiationData('admin/profession/index/',$res->num_rows(),$start,'4');
		$this->session->set_userdata('start',$start);			
		
		if($searchKey == "")
			$searchKey = "Search";
		
				
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/profession_list',$data);
		$this->load->view('admin/footer');
	}
	
	function addProfession()
	{		
		$this->form_validation->set_rules('profession_name','Profession name','trim|required');
		$this->form_validation->set_rules('profession_description','Profession Description','trim|required');
		$this->form_validation->set_rules('profession_avatar','Avtar','callback_validate_avtar');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['profession_name'] = $this->input->post('profession_name');
			$data['profession_description'] = $this->input->post('profession_description');			
			
			$this->load->view('admin/header');
			$this->load->view('admin/addProfession',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			if($_FILES['profession_avatar']['error'] == 0)
			{
				if($this->input->post('pre_avatar_image'))
					@unlink('./'.$this->input->post('pre_avatar_image'));				
				$res = $this->mdl_common->uploadFile('profession_avatar','img','employee');					
				if($res['success'])
				{						
					$user_data['profession_avatar'] = $res['path'];
				}
			}	
			$user_data['profession_name'] = $this->input->post('profession_name');
			$user_data['profession_description'] = $this->input->post('profession_description');	
			$user_data['profession_timestamp'] = date('Y-m-d H:i:s',time());			
			$this->db->insert('pdr_profession_master',$user_data);
			
			redirect('admin/profession');
		}
	}
	
	function editProfession($id)
	{
		$this->form_validation->set_rules('profession_name','Profession name','trim|required');
		$this->form_validation->set_rules('profession_description','Profession Description','trim|required');
		$this->form_validation->set_rules('profession_avatar','Avtar','callback_validate_avtar');
				
		if($this->form_validation->run() == FALSE)
		{
			$user_data['profession_name'] = $this->input->post('profession_name');
			$user_data['profession_description'] = $this->input->post('profession_description');			
			$user_data['profession_is_active'] = $this->input->post('profession_is_active');			
			if(!$_POST)
			{
				$res = $this->mdl_profession->get_profession($id);
				$listArr = $res->result_array();				
				$user_data = $listArr[0];				
			}
			
			
			$this->load->view('admin/header');
			$this->load->view('admin/editProfession',$user_data);
			$this->load->view('admin/footer');
		}
		else
		{			
			//do update in database
			$data = array();
			$profession_id=$this->input->post('profession_id');
			if($_FILES['profession_avatar']['error'] == 0)
			{
				if($this->input->post('pre_avatar_image'))
					@unlink('./'.$this->input->post('pre_avatar_image'));				
				$res = $this->mdl_common->uploadFile('profession_avatar','img','profession');					
				if($res['success'])
				{						
					$user_data['profession_avatar'] = $res['path'];
				}
			}	
			$user_data['profession_name'] = $this->input->post('profession_name');
			$user_data['profession_description'] = $this->input->post('profession_description');
			$user_data['profession_is_active'] = $this->input->post('profession_is_active');
			$this->db->where('profession_id ',$profession_id);
			$this->db->update('pdr_profession_master',$user_data);						
			
			$start = $this->session->userdata('start');
			redirect('admin/profession/index/'.$start);
		}
	}
	
	function deleteProfession($id='')
	{
		if($id == "")
			$users = $this->input->post('profession_id');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_profession->deleteProfession($id);
		}
		
		$start = $this->session->userdata('start');
				
			redirect('admin/profession/index/'.$start);
	}
	
	function updateActive($profession_id,$is_active)
	{
		$data['profession_is_active'] = $is_active;
		$this->db->where('profession_id',$profession_id);
		$this->db->update('pdr_profession_master',$data);
	}
	function validate_avtar()
	{
		
		if($_FILES['profession_avatar']['error'] == 0)
		{
			$ext=strtolower(end(explode('.',$_FILES['profession_avatar']['name'])));			
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
}
?>