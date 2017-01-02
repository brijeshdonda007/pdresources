<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class certificate extends CI_Controller
{
	function certificate()
	{
		parent::__construct();		
		$this->mdl_common->checkUserSession();
		$this->load->model('mdl_customer');
		$this->load->model('mdl_config');
		$this->load->model('mdl_course');		
		$this->load->model('mdl_test');		
		$this->load->model('mdl_author');					
		$this->load->model('mdl_dashbord');							
	}	
	
	
		
	function html($course_id='',$order_id='')
	{
		$UserInfo=$this->mdl_dashbord->GetLoggedUserInfo();		
		$CourseInfo=$this->mdl_course->get_courseInfoByid($course_id);
		if($CourseInfo['course_author'])
			$AuthourInfo=$this->mdl_author->getAuthuonfoById($CourseInfo['course_author']);
		$responce['cust_id']=$UserInfo['cust_id'];
		$responce['course_id']=$CourseInfo['course_id'];
		$responce['order_id']=$order_id;		
		$TestPassingInfo=$this->mdl_test->GetPassedTestResponce($responce);		
		$data['UserInfo']=$UserInfo;	
		$data['CourseInfo']=$CourseInfo;
		$data['AuthourInfo']=$AuthourInfo;
		$data['TestPassingInfo']=$TestPassingInfo;
		
		$content=$this->load->view('header_certificate',array(),true);
		$content .=$this->load->view('certificate/certificate_content',$data,true);
		echo $content;
		//$certificate['str']=$content;
		//$content['str']='aadjshfdkjashfkjdashf	asdfkjdhasfkjdhasfkj	dasfkhasdkjfhdasfk	dasfhjdkjasfhkdasf';
		//$this->load->view('pdf/createpdf.php',$certificate);
	}	

	function printcertificate($course_id='',$order_id='')
	{
		$UserInfo=$this->mdl_dashbord->GetLoggedUserInfo();		
		$CourseInfo=$this->mdl_course->get_courseInfoByid($course_id);
		if($CourseInfo['course_author'])
			$AuthourInfo=$this->mdl_author->getAuthuonfoById($CourseInfo['course_author']);
		$responce['cust_id']=$UserInfo['cust_id'];
		$responce['course_id']=$CourseInfo['course_id'];
		$responce['order_id']=$order_id;		
		$TestPassingInfo=$this->mdl_test->GetPassedTestResponce($responce);		
		$data['UserInfo']=$UserInfo;	
		$data['CourseInfo']=$CourseInfo;
		$data['AuthourInfo']=$AuthourInfo;
		$data['TestPassingInfo']=$TestPassingInfo;
		
		$this->load->view('header_certificate');
		$this->load->view('certificate/print_content',$data);
	}	
	
	function download($course_id='',$order_id='')
	{
		$UserInfo=$this->mdl_dashbord->GetLoggedUserInfo();		
		$CourseInfo=$this->mdl_course->get_courseInfoByid($course_id);
		if($CourseInfo['course_author'])
			$AuthourInfo=$this->mdl_author->getAuthuonfoById($CourseInfo['course_author']);
		$responce['cust_id']=$UserInfo['cust_id'];
		$responce['course_id']=$CourseInfo['course_id'];
		$responce['order_id']=$order_id;		
		$TestPassingInfo=$this->mdl_test->GetPassedTestResponce($responce);		
		$data['UserInfo']=$UserInfo;	
		$data['CourseInfo']=$CourseInfo;
		$data['AuthourInfo']=$AuthourInfo;
		$data['TestPassingInfo']=$TestPassingInfo;
		
		$content=$this->load->view('header_certificate',array(),true);
		$content .=$this->load->view('certificate/certificate_content',$data,true);
		$certificate['str']=$content;
		$certificate['download_flag']=true;
		$certificate['title']=$CourseInfo['course_name'];		
		//$content['str']='aadjshfdkjashfkjdashf	asdfkjdhasfkjdhasfkj	dasfkhasdkjfhdasfk	dasfhjdkjasfhkdasf';
		$this->load->view('pdf/createpdf.php',$certificate);
	}
}
?>