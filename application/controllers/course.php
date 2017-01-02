<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Course extends CI_Controller
{
	function Course()
	{
		parent::__construct();
		$this->load->model('mdl_customer');
		$this->load->model('mdl_page');
		$this->load->model('mdl_config');
		$this->load->model('mdl_pramotion');
		$this->load->model('mdl_course');		
		$this->load->model('mdl_profession');	
		$this->load->model('mdl_author');		
	}
		
	function index($course_id)
	{
		if($course_id <=0)
			redirect('home/index/7');
					
		#To get All page links
		$CourseInfo=$this->mdl_course->get_courseInfoByid($course_id);
		if(!$CourseInfo)
			redirect('home/index/7');
		$this->session->set_userdata('continue_url',current_url());
		if($CourseInfo['course_author'])
			$AuthourInfo=$this->mdl_author->getAuthuonfoById($CourseInfo['course_author']);
		$CommentCount=$this->mdl_course->getcourseCommentCount($course_id);

		$header['page_title']=$CourseInfo['course_name'];
		$data['AuthourInfo']=$AuthourInfo;
		$data['CourseInfo']=$CourseInfo;
		$data['CommentCount']=$CommentCount;
		$this->load->view('header',$header);
		$this->load->view('course/home',$data);
		$this->load->view('footer',$footer);
	}
		
	function SearchCourse()
	{
		$course_id=$_REQUEST['header_course_id'];
		if($course_id <=0)
			redirect('home/index/7');					
		#To get All page links
		$CourseInfo=$this->mdl_course->get_courseInfoByid($course_id);
		if(!$CourseInfo)
			redirect('home/index/7');
		if($CourseInfo['course_author'])
			$AuthourInfo=$this->mdl_author->getAuthuonfoById($CourseInfo['course_author']);
		$CommentCount=$this->mdl_course->getcourseCommentCount($course_id);

		$header['page_title']=$CourseInfo['course_name'];
		$data['AuthourInfo']=$AuthourInfo;
		$data['CourseInfo']=$CourseInfo;
		$data['CommentCount']=$CommentCount;
		$this->load->view('header',$header);
		$this->load->view('course/home',$data);
		$this->load->view('footer',$footer);
	}
	
	function GetCourseListwithoutImage()
	{
		$counter=1;			
		$this->db->where('course_is_active','Y');	
		$this->db->where('is_deleted','N');			
		$res = $this->db->get('pdr_course_master');	
		$courseInfo= $res->result_array();
		foreach($courseInfo as $key=>$val)
		{
			if(!file_exists($val['course_image']))
			{				
				echo 'course_id='.$val['course_id'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				echo 'course_name='.$val['course_name'].'<br>';
				$counter++;
			}
		}
		$counter--;
		echo 'Total Couses='.$counter;
	}
	
	function RemoveCourseListwithoutImage()
	{
		$counter=1;			
		$this->db->where('course_is_active','Y');	
		$this->db->where('is_deleted','N');			
		$res = $this->db->get('pdr_course_master');	
		$courseInfo= $res->result_array();
		$CourseIdArr=array();
		foreach($courseInfo as $key=>$val)
		{
			if(!file_exists($val['course_image']))
			{
				$CourseIdArr[]=	$val['course_id'];							
				$counter++;
			}
		}
		$counter--;
		echo 'Total Couses='.$counter;
		$CourseIds=implode(',',$CourseIdArr);
		$sql="Update pdr_course_master set course_is_active='N' where course_id IN(".$CourseIds.")";
		$res=$this->db->query($sql);
		//$data['course_is_active']='N';
		//$this->db->where_in('course_id',$CourseIds);
		//$this->db->update('pdr_course_master',$data);
		//echo $this->db->last_query();
/*		echo '<pre>';
print_r($res->affected_rows());
echo '</pre>';
*/		
		/*echo '<pre>';
print_r($CourseIdArr);
echo '</pre>';*/
	}
}
?>