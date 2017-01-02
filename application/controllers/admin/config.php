<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class config extends CI_Controller
{
	function config()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_config');
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
		$res = $this->mdl_config->get_config('',$searchtext);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/config/index/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		if($searchtext == "")
			$searchtext = "Search";
		
		$data['searchText'] = $searchtext;						
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/config/config_list',$data);
		$this->load->view('admin/footer');
	}	
	function addConfig($config_id='')
	{
		$this->form_validation->set_rules('config_title','Title','trim|required');
		if($_REQUEST['config_type'] == 'url')
			$this->form_validation->set_rules('config_description','Description','trim|required|callback_validate_url');									
		
		//$this->form_validation->set_rules('config_description','Biodata','trim|required');					
		
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($config_id !='')
			{
				$res = $this->mdl_config->get_config($config_id);
				$data = $res->row_array();																
			}			
			$data['profession']=$profession;
			$data['state']=$state;			
			
			$this->load->view('admin/header');
			$this->load->view('admin/config/addConfig',$data);
			$this->load->view('admin/footer');
		}
		else
		{			
			$u_data['config_title']=$this->input->post('config_title');
			$u_data['config_description']=$this->input->post('config_description');
			$u_data['config_active']=$this->input->post('config_active');			

			$this->mdl_config->saveConfig($config_id,$u_data);	
			redirect('admin/config/index/'.$start);	
		}
	}
	
	function deleteConfig($id='')
	{
		if($id == "")
			$users = $this->input->post('page');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_config->deleteConfig($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/config/index/'.$start);
	}
	
	function updateActive($id,$is_active)
	{
		$data['config_active'] = $is_active;
		$this->db->where('config_id',$id);
		$this->db->update('pdr_config_detail',$data);
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