<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Courselisting extends CI_Controller
{
	function Courselisting()
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
	function index()
	{
		$ProfInfo=$this->mdl_profession->get_profession('',true);			
		$data['ProfInfo']=$ProfInfo;		
		$header['page_title']=$ProfInfo['profession_name'];
		$this->load->view('header',$header);
		$this->load->view('course/allcourselisting',$data);
		$this->load->view('footer',$footer);
	}	
	function newarrival($prof_id,$start=0)
	{		
		$ProfInfo=$this->mdl_profession->get_profession($prof_id);
		$course_ids=$this->mdl_profession->GetCourseIdByProfId($prof_id);
		if($course_ids)
		{
			$res=$this->mdl_course->GetCourseInfos($course_ids,'is_new_arrival',true);		
			$perpage=30;
			//$this->session->set_userdata('per_page',$perpage);
			$data = $this->mdl_common->pagiationData('courselisting/newarrival/'.$prof_id.'/',$res->num_rows(),$start,4,$perpage);
		}
		/*foreach($data['listArr'] as $key=>$val)
		{
			array_push($data['listArr'],$val);
		}*/
		
		$data['ProfInfo']=$ProfInfo;		

		$header['page_title']=$ProfInfo['profession_name'];
		$this->load->view('header',$header);
		$this->load->view('profession/listing_home',$data);
		$this->load->view('footer',$footer);	
	}
	
	function mostpopular($prof_id,$start=0)
	{
		$ProfInfo=$this->mdl_profession->get_profession($prof_id);
		$course_ids=$this->mdl_profession->GetCourseIdByProfId($prof_id);
		if($course_ids)
		{
			$res=$this->mdl_course->GetCourseInfos($course_ids,'popular',true);		
			$perpage=30;
			//$this->session->set_userdata('per_page',$perpage);
			$data = $this->mdl_common->pagiationData('courselisting/newarrival/'.$prof_id.'/',$res->num_rows(),$start,4,$perpage);
		}
		/*foreach($data['listArr'] as $key=>$val)
		{
			array_push($data['listArr'],$val);
		}*/
		
		$data['ProfInfo']=$ProfInfo;		

		$header['page_title']=$ProfInfo['profession_name'];
		$this->load->view('header',$header);
		$this->load->view('profession/listing_home',$data);
		$this->load->view('footer',$footer);	
	}
}
?>