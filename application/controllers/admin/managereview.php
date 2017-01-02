<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managereview extends CI_Controller
{
	function Managereview()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_managereview');
	}
	
	function index($course_id=0,$start='0')
	{
		if($_POST || $start=='s')
			$start = 0;			
		
		if($course_id)
		{
			$this->session->set_userdata(array('course_id'=>$course_id));
		}
		else
			$course_id=$this->session->userdata('course_id');
			
		if($course_id <=0)
			redirect('admin/course/');
		
		$res = $this->mdl_managereview->get_reviews('',$course_id);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/managereview/index/'.$course_id.'/',$res->num_rows(),$start,'5');		
		$this->session->set_userdata('start',$start);
		
		$data['course_id']=$course_id;
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/managereview/review_list',$data);
		$this->load->view('admin/footer');
	}	
	function addManagereview($comment_id='')
	{				
		$course_id=$this->session->userdata('course_id');			
		if($course_id <=0)
			redirect('admin/course/');
	
		$this->form_validation->set_rules('comment_description','Review','trim|required');					
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($comment_id !='')
			{
				$res = $this->mdl_managereview->get_reviews($comment_id);
				$data = $res->row_array();																
			}			
			$data['profession']=$profession;
			$data['state']=$state;			
			$data['course_id']=$course_id;
			$this->load->view('admin/header');
			$this->load->view('admin/managereview/addManagereview',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$u_data['comment_description']=$this->input->post('comment_description');
			$u_data['comment_approved']=$this->input->post('comment_approved');		
			$u_data['comment_course_id']=$course_id;		

			$this->mdl_managereview->saveManagereview($comment_id,$u_data);	
			redirect('admin/managereview/index/'.$course_id.'/'.$start);	
		}
	}
	
	function deleteManagereview($id='')
	{
		$course_id=$this->session->userdata('course_id');			
		if($course_id <=0)
			redirect('admin/course/');

		if($id == "")
			$users = $this->input->post('employee');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_managereview->deleteManagereview($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/managereview/index/'.$course_id.'/'.$start);	
	}
	
	function updateActive($id,$is_active)
	{
		$data['comment_approved'] = $is_active;
		$this->db->where('comment_id',$id);
		$this->db->update('pdr_user_comments',$data);
	}		
		
}
?>