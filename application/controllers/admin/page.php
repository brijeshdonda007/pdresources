<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class page extends CI_Controller
{
	function page()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_page');
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
		$res = $this->mdl_page->get_page('',$searchtext);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/page/index/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		if($searchtext == "")
			$searchtext = "Search";
		
		$data['searchText'] = $searchtext;						
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/page/page_list',$data);
		$this->load->view('admin/footer');
	}	
	function addPage($page_id='')
	{				
		$this->form_validation->set_rules('page_title','Title','trim|required');
		//$this->form_validation->set_rules('page_description','Biodata','trim|required');					
		
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($page_id !='')
			{
				$res = $this->mdl_page->get_page($page_id);
				$data = $res->row_array();																
			}			
			$data['profession']=$profession;
			$data['state']=$state;			
			
			$this->load->view('admin/header');
			$this->load->view('admin/page/addPage',$data);
			$this->load->view('admin/footer');
		}
		else
		{			
			$u_data['page_title']=$this->input->post('page_title');
			$u_data['page_description']=$this->input->post('page_description');
			$u_data['page_active']=$this->input->post('page_active');			
			$u_data['page_disp_header']=$this->input->post('page_disp_header');			
			
			$this->mdl_page->savePage($page_id,$u_data);	
			redirect('admin/page/index/'.$start);	
		}
	}
	
	function deletePage($id='')
	{
		if($id == "")
			$users = $this->input->post('page');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_page->deletePage($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/page/index/'.$start);
	}
	
	function updateActive($id,$is_active)
	{
		$data['page_active'] = $is_active;
		$this->db->where('page_id',$id);
		$this->db->update('pdr_page_detail',$data);
	}		
}
?>