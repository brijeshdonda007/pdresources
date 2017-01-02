<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class State extends CI_Controller
{
	function State()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_state');
	}
	
	function index($start='0')
	{				
		$res = $this->mdl_state->get_state();
		
		if($start == "s")
			$start = 0;
		
		$data = $this->mdl_common->pagiationData('admin/state/index/',$res->num_rows(),$start,'4');
		$this->session->set_userdata('start',$start);			
		
		if($searchKey == "")
			$searchKey = "Search";
		
				
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/state_list',$data);
		$this->load->view('admin/footer');
	}
	
	function addState()
	{		
		$this->form_validation->set_rules('state_name','State Name','trim|required');
		$this->form_validation->set_rules('state_code','State Code','trim|required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['profession_name'] = $this->input->post('profession_name');
			$data['profession_description'] = $this->input->post('profession_description');			
			
			$this->load->view('admin/header');
			$this->load->view('admin/addState',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$user_data['state_name'] = $this->input->post('state_name');
			$user_data['state_code'] = $this->input->post('state_code');	
			$user_data['state_timestamp'] = date('Y-m-d H:i:s',time());			
			$this->db->insert('pdr_state_master',$user_data);
			
			redirect('admin/state');
		}
	}
	
	function editState($id)
	{
		$this->form_validation->set_rules('state_name','State Name','trim|required');
		$this->form_validation->set_rules('state_code','State Code','trim|required');
				
		if($this->form_validation->run() == FALSE)
		{
			$user_data['state_name'] = $this->input->post('state_name');
			$user_data['state_code'] = $this->input->post('state_code');			
			
			if(!$_POST)
			{
				$res = $this->mdl_state->get_state($id);
				$listArr = $res->result_array();				
				$user_data = $listArr[0];				
			}
			
			$this->load->view('admin/header');
			$this->load->view('admin/editState',$user_data);
			$this->load->view('admin/footer');
		}
		else
		{			
			//do update in database
			$data = array();
			$state_id=$this->input->post('state_id');
			$user_data['state_name'] = $this->input->post('state_name');
			$user_data['state_code'] = $this->input->post('state_code');
			
			$this->db->where('state_id ',$state_id);
			$this->db->update('pdr_state_master',$user_data);						
			
			$start = $this->session->userdata('start');
			redirect('admin/state/index/'.$start);
		}
	}
	
	function deleteState($id='')
	{
		if($id == "")
			$users = $this->input->post('state_id');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_state->deleteState($id);
		}
		
		$start = $this->session->userdata('start');
				
			redirect('admin/state/index/'.$start);
	}
	
	function updateActive($state_id,$is_active)
	{
		$data['state_is_active'] = $is_active;
		$this->db->where('state_id',$state_id);
		$this->db->update('pdr_state_master',$data);
	}		
}
?>