<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zipcode extends CI_Controller
{
	function Zipcode()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_zipcode');
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
		$res = $this->mdl_zipcode->get_zipcode('',$searchtext);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/zipcode/index/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		if($searchtext == "")
			$searchtext = "Search";
		
		$data['searchText'] = $searchtext;						
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/zipcode/zipcode_list',$data);
		$this->load->view('admin/footer');
	}	
	function addZipcode($zipcode_id='')
	{
		$this->form_validation->set_rules('zipcode_name','Zipcode','trim|required|numeric');
		
		//$this->form_validation->set_rules('zipcode_description','Biodata','trim|required');					
		
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($zipcode_id !='')
			{
				$res = $this->mdl_zipcode->get_zipcode($zipcode_id);
				$data = $res->row_array();																
			}			
			
			$this->load->view('admin/header');
			$this->load->view('admin/zipcode/addZipcode',$data);
			$this->load->view('admin/footer');
		}
		else
		{			
			$u_data['zipcode_name']=$this->input->post('zipcode_name');
			$u_data['zipcode_status']=$this->input->post('zipcode_status');
			$this->mdl_zipcode->saveZipcode($zipcode_id,$u_data);	
			redirect('admin/zipcode/index/'.$start);	
		}
	}
	
	function deleteZipcode($id='')
	{
		if($id == "")
			$users = $this->input->post('city');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_zipcode->deleteZipcode($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/zipcode/index/'.$start);
	}
	
	function updateActive($id,$is_active)
	{
		$data['zipcode_status'] = $is_active;
		$this->db->where('zipcode_id',$id);
		$this->db->update('pdr_zipcode_master',$data);
	}	
}
?>