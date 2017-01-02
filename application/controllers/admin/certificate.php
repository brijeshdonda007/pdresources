<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Certificate extends CI_Controller
{
	function Certificate()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_certificate');
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
		$res = $this->mdl_certificate->get_accreditations('',$searchtext);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/certificate/index/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		if($searchtext == "")
			$searchtext = "Search";
		
		$data['searchText'] = $searchtext;						
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/certificate/certificate_list',$data);
		$this->load->view('admin/footer');
	}	
	function addCertificate($certificate_id='')
	{				
		$this->form_validation->set_rules('certificate_title','Title','trim|required');
		//$this->form_validation->set_rules('certificate_description','Biodata','trim|required');				

		
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($certificate_id !='')
			{
				$res = $this->mdl_certificate->get_accreditations($certificate_id);
				$data = $res->row_array();																
			}			
			$data['profession']=$profession;
			$data['state']=$state;			
			
			$this->load->view('admin/header');
			$this->load->view('admin/certificate/addCertificate',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$u_data['certificate_title']=$this->input->post('certificate_title');
			$u_data['certificate_description']=$this->input->post('certificate_description');
			$u_data['certificate_active']=$this->input->post('certificate_active');		


			$this->mdl_certificate->saveCertificate($certificate_id,$u_data);	
			redirect('admin/certificate/index/'.$start);	
		}
	}
	
	function deleteCertificate($id='')
	{
		if($id == "")
			$users = $this->input->post('employee');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_certificate->deleteCertificate($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/certificate/index/'.$start);
	}
	
	function updateActive($id,$is_active)
	{
		$data['certificate_active'] = $is_active;
		$this->db->where('certificate_id',$id);
		$this->db->update('pdr_certificate_detail',$data);
	}		
		
}
?>