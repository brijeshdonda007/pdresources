<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Page extends CI_Controller
{
	function Page()
	{
		parent::__construct();
		$this->load->model('mdl_customer');
		$this->load->model('mdl_page');
		$this->load->model('mdl_config');
		$this->load->model('mdl_pramotion');
		$this->load->model('mdl_course');		
		$this->load->model('mdl_employee');		
		$this->load->model('mdl_profession');	
	}	
	function index($page_id='')
	{
		if($page_id <=0)
			redirect('home');
		else if($page_id == 5)
		{
			$this->courselisting();
		}
		else
		{
			$PageInfo=$this->mdl_page->get_page($page_id);
			if(!is_array($PageInfo) && !$PageInfo)
				redirect('home');		
	
			#To get All page links
			$header['page_title']=$PageInfo['page_title'];
			$data['PageInfo']=$PageInfo;
			$this->load->view('header',$header);
			$this->load->view('page/home',$data);
			$this->load->view('footer',$footer);
		}
	}	
	
	function courselisting()
	{
		$ProfInfo=$this->mdl_profession->get_profession('',true);			
		$data['ProfInfo']=$ProfInfo;		
		$header['page_title']=$ProfInfo['profession_name'];
		$this->load->view('header',$header);
		$this->load->view('course/allcourselisting',$data);
		$this->load->view('footer',$footer);
	}	
	
}
?>