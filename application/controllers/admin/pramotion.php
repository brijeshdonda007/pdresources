<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pramotion extends CI_Controller
{
	function pramotion()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_pramotion');
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
		$res = $this->mdl_pramotion->get_pramotion('',$searchtext);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/pramotion/index/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		if($searchtext == "")
			$searchtext = "Search";
		
		$data['searchText'] = $searchtext;						
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/pramotion/pramotion_list',$data);
		$this->load->view('admin/footer');
	}	
	function addPramotion($pramotion_id='')
	{		
	
		$this->form_validation->set_rules('pramotion_url','Link','trim|required|callback_validate_url');
		
		$this->form_validation->set_rules('pramotion_avatar','Avtar','callback_validate_avtar');
		
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($pramotion_id !='')
			{
				$res = $this->mdl_pramotion->get_pramotion($pramotion_id);
				$data = $res->row_array();																
			}			
			$data['profession']=$profession;
			$data['state']=$state;			
			
			$this->load->view('admin/header');
			$this->load->view('admin/pramotion/addPramotion',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			if($_FILES['pramotion_avatar']['error'] == 0)
			{
				if($this->input->post('pre_avatar_image'))
					@unlink('./'.$this->input->post('pre_avatar_image'));				
				$res = $this->mdl_common->uploadFile('pramotion_avatar','img','pramotion');					
				if($res['success'])
				{						
					$u_data['pramotion_avatar'] = $res['path'];
				}
			}								
			$u_data['pramotion_url']=$this->input->post('pramotion_url');
			$u_data['pramotion_active']=$this->input->post('pramotion_active');			

			$this->mdl_pramotion->savePramotion($pramotion_id,$u_data);	
			redirect('admin/pramotion/index/'.$start);	
		}
	}
	
	function deletePramotion($id='')
	{
		if($id == "")
			$users = $this->input->post('pramotion');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_pramotion->deletePramotion($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/pramotion/index/'.$start);
	}
	
	function updateActive($id,$is_active)
	{
		$data['pramotion_active'] = $is_active;
		$this->db->where('pramotion_id',$id);
		$this->db->update('pdr_pramotion_detail',$data);
	}		
	
	function validate_avtar()
	{
		if($_FILES['pramotion_avatar']['error'] == 0)
		{
			$ext=strtolower(end(explode('.',$_FILES['pramotion_avatar']['name'])));			
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
		{
			$this->form_validation->set_message('validate_avtar', 'Please select avatar file');
			return false;
		}
			
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