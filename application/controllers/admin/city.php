<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City extends CI_Controller
{
	function City()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_city');
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
		$res = $this->mdl_city->get_city('',$searchtext);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/city/index/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		if($searchtext == "")
			$searchtext = "Search";
		
		$data['searchText'] = $searchtext;						
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/city/city_list',$data);
		$this->load->view('admin/footer');
	}	
	function addCity($city_id='')
	{
		$this->form_validation->set_rules('city_name','Title','trim|required');
		
		//$this->form_validation->set_rules('city_description','Biodata','trim|required');					
		
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($city_id !='')
			{
				$res = $this->mdl_city->get_city($city_id);
				$data = $res->row_array();																
			}			
			
			$this->load->view('admin/header');
			$this->load->view('admin/city/addCity',$data);
			$this->load->view('admin/footer');
		}
		else
		{			
			$u_data['city_name']=$this->input->post('city_name');
			$u_data['city_status']=$this->input->post('city_status');
			$this->mdl_city->saveCity($city_id,$u_data);	
			redirect('admin/city/index/'.$start);	
		}
	}
	
	function deleteCity($id='')
	{
		if($id == "")
			$users = $this->input->post('city');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_city->deleteCity($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/city/index/'.$start);
	}
	
	function updateActive($id,$is_active)
	{
		$data['city_status'] = $is_active;
		$this->db->where('city_id',$id);
		$this->db->update('pdr_city_master',$data);
	}	
}
?>