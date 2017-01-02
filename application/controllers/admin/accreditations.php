<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class accreditations extends CI_Controller
{
	function accreditations()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_accreditations');
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
		$res = $this->mdl_accreditations->get_accreditations('',$searchtext);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/accreditations/index/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		if($searchtext == "")
			$searchtext = "Search";
		
		$data['searchText'] = $searchtext;						
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/accreditations/accreditations_list',$data);
		$this->load->view('admin/footer');
	}	
	function addAccreditaions($accreditations_id='')
	{				
		$this->form_validation->set_rules('accreditations_title','Title','trim|required');
		//$this->form_validation->set_rules('accreditations_description','Biodata','trim|required');				
		$this->form_validation->set_rules('accreditations_avatar','Avtar','callback_validate_avtar');
		
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($accreditations_id !='')
			{
				$res = $this->mdl_accreditations->get_accreditations($accreditations_id);
				$data = $res->row_array();																
			}			
			$data['profession']=$profession;
			$data['state']=$state;			
			
			$this->load->view('admin/header');
			$this->load->view('admin/accreditations/addAccreditaions',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			if($_FILES['accreditations_avatar']['error'] == 0)
			{
				if($this->input->post('pre_avatar_image'))
					@unlink('./'.$this->input->post('pre_avatar_image'));				
				$res = $this->mdl_common->uploadFile('accreditations_avatar','img','accreditations');					
				if($res['success'])
				{						
					$u_data['accreditations_avatar'] = $res['path'];
				}
			}								
			$u_data['accreditations_title']=$this->input->post('accreditations_title');
			$u_data['accreditations_description']=$this->input->post('accreditations_description');
			$u_data['accreditations_active']=$this->input->post('accreditations_active');		


			$this->mdl_accreditations->saveAccreditaions($accreditations_id,$u_data);	
			redirect('admin/accreditations/index/'.$start);	
		}
	}
	
	function deleteAccreditaions($id='')
	{
		if($id == "")
			$users = $this->input->post('employee');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_accreditations->deleteAccreditaions($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/accreditations/index/'.$start);
	}
	
	function updateActive($id,$is_active)
	{
		$data['accreditations_active'] = $is_active;
		$this->db->where('accreditations_id',$id);
		$this->db->update('pdr_accreditations_detail',$data);
	}		
	
	function validate_avtar()
	{
		if($_FILES['accreditations_avatar']['error'] == 0)
		{
			$ext=strtolower(end(explode('.',$_FILES['accreditations_avatar']['name'])));			
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