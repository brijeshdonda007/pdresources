<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Profession extends CI_Controller
{
	function Profession()
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
	function index($prof_id=0)
	{
		if($prof_id == 0)
		{
			if($_REQUEST['prof_id'])
				$prof_id=$_REQUEST['prof_id'];
			else
				$prof_id=0;
		}
		
		#To get All page links
		$ProfInfo=$this->mdl_profession->get_profession($prof_id);
		$course_ids=$this->mdl_profession->GetCourseIdByProfId($prof_id);
		if($course_ids)
			$AuthorInfo=$this->mdl_author->GetAuthourforProfession($prof_id,$course_ids);
		
		$data['AuthorInfo']=$AuthorInfo;
		$data['ProfInfo']=$ProfInfo;		
		$header['page_title']=$ProfInfo['profession_name'];
		$this->load->view('header',$header);
		$this->load->view('profession/home',$data);
		$this->load->view('footer',$footer);
	}		
}
?>