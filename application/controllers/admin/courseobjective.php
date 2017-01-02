<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courseobjective extends CI_Controller
{
	function Courseobjective()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_courseobjective');
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
		$res = $this->mdl_courseobjective->get_Courseobjective('',$searchtext);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/courseobjective/index/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		if($searchtext == "")
			$searchtext = "Search";
		
		$data['searchText'] = $searchtext;						
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/courseobjective/courseobjective_list.php',$data);
		$this->load->view('admin/footer');
	}	
	function addCourseObjective($objective_id='')
	{
		$this->form_validation->set_rules('objective_name','Course Objective','trim|required');
		
		//$this->form_validation->set_rules('objective_description','Biodata','trim|required');					
		
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($objective_id !='')
			{				
				$res = $this->mdl_courseobjective->get_Courseobjective($objective_id);
				$data = $res->row_array();																
			}			
			
			$this->load->view('admin/header');
			$this->load->view('admin/courseobjective/addCourseobjective',$data);
			$this->load->view('admin/footer');
		}
		else
		{			
			$u_data['objective_name']=$this->input->post('objective_name');
			$u_data['objective_description']=$this->input->post('objective_description');
			$u_data['objective_status']=$this->input->post('objective_status');
			$this->mdl_courseobjective->saveCourseobjective($objective_id,$u_data);				
			redirect('admin/courseobjective/index/'.$start);	
		}
	}
	
	function deleteCourseobjective($id='')
	{
		if($id == "")
			$users = $this->input->post('city');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_courseobjective->deleteCourseobjective($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/courseobjective/index/'.$start);		
	}
	
	function updateActive($id,$is_active)
	{
		$data['objective_status'] = $is_active;
		$this->db->where('objective_id',$id);
		$this->db->update('pdr_courseobjective_master',$data);
	}	
}
?>