<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class ajax_courselisting extends CI_Controller
{
	function ajax_courselisting()
	{
		parent::__construct();
		$this->load->model('mdl_customer');
		$this->load->model('mdl_page');
		$this->load->model('mdl_config');
		$this->load->model('mdl_pramotion');
		$this->load->model('mdl_course');		
		$this->load->model('mdl_profession');		
	}	
	function GetNewCourseByProfId()
	{
		$prof_id=$_REQUEST['prof_id'];
							
		$courseIds=$this->mdl_profession->GetCourseIdByProfId($prof_id);

		if($courseIds)
			$courseInfo=$this->mdl_course->GetCourseInfos($courseIds,'course_is_new');
		else
			$courseInfo='';
		$data['CourseInfo']=$courseInfo;	
		$data['prof_id']=$prof_id;	
		$this->load->view('ajax/course/newarrival',$data);		
	}		
	function GetMostPopularCourseByProfId()
	{
		$prof_id=$_REQUEST['prof_id'];
					
		$courseIds=$this->mdl_profession->GetCourseIdByProfId($prof_id);
		if($courseIds)
			$courseInfo=$this->mdl_course->GetCourseInfos($courseIds,'popular');
		else
			$courseInfo='';
		$data['CourseInfo']=$courseInfo;		
		$this->load->view('ajax/profession/popular',$data);		
	}	
	function GetCourseComments()
	{
		$course_id=$_REQUEST['id'];
		$data['CommentInfo']=$this->mdl_course->GetCourseComments($course_id);
		$this->load->view('ajax/course/comments',$data);		
	}
}
?>