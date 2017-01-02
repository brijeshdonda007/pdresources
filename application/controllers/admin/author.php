<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class author extends CI_Controller
{
	function author()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_author');
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
		$res = $this->mdl_author->get_author('',$searchtext);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/author/index/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		if($searchtext == "")
			$searchtext = "Search";
		
		$data['searchText'] = $searchtext;						
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/author/author_list',$data);
		$this->load->view('admin/footer');
	}	
	function addAuthor($author_id='')
	{		
		$this->form_validation->set_rules('author_fname','First Name','trim|required');
		$this->form_validation->set_rules('author_lname','Last Name','trim|required');	
		//$this->form_validation->set_rules('author_title','Title','trim|required');
		//$this->form_validation->set_rules('author_description','Biodata','trim|required');				
		$this->form_validation->set_rules('author_avatar','Avtar','callback_validate_avtar');
		
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($author_id !='')
			{
				$res = $this->mdl_author->get_author($author_id);
				$data = $res->row_array();																
			}			
			$data['profession']=$profession;
			$data['state']=$state;			
			
			$this->load->view('admin/header');
			$this->load->view('admin/author/addAuthor',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			if($_FILES['author_avatar']['error'] == 0)
			{
				if($this->input->post('pre_avatar_image'))
					@unlink('./'.$this->input->post('pre_avatar_image'));				
				$res = $this->mdl_common->uploadFile('author_avatar','img','author');					
				if($res['success'])
				{						
					$u_data['author_avatar'] = $res['path'];
				}
			}								
			$u_data['author_fname']=$this->input->post('author_fname');
			$u_data['author_lname']=$this->input->post('author_lname');
			$u_data['author_title']=$this->input->post('author_title');
			$u_data['author_description']=$this->input->post('author_description');
			$u_data['author_active']=$this->input->post('author_active');			

			$this->mdl_author->saveAuthor($author_id,$u_data);	
			redirect('admin/author/index/'.$start);	
		}
	}
	
	function deleteAuthor($id='')
	{
		if($id == "")
			$users = $this->input->post('author');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_author->deleteAuthor($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/author/index/'.$start);
	}
	
	function updateActive($id,$is_active)
	{
		$data['author_active'] = $is_active;
		$this->db->where('author_id',$id);
		$this->db->update('pdr_author_detail',$data);
	}		
	
	function validate_avtar()
	{
		if($_FILES['author_avatar']['error'] == 0)
		{
			$ext=strtolower(end(explode('.',$_FILES['author_avatar']['name'])));			
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