<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Login extends CI_Controller
{
	function Login ()
	{
		parent::__construct();
		$this->load->model('mdl_customer');
		$this->load->model('mdl_page');
		$this->load->model('mdl_config');
		$this->load->model('mdl_pramotion');
		$this->load->model('mdl_course');		
		$this->load->model('mdl_profession');	
		$this->load->model('mdl_author');		
		$this->load->model('mdl_signup');		
		$this->load->model('mdl_login');
		$this->load->model('mdl_coupon');				
	}	
	
	function index($id='')
	{		
		if($this->session->userdata('cust_id'))
			redirect('home');		
		if($_POST)
		{								
			$user = $this->input->post('login_email');
			$pass = $this->input->post('login_password');
			$flag = $this->mdl_login->userloginvalidate($user,md5($pass));
			$data['login_username'] = $user;
			$data['login_password'] = $pass;
			if($flag['error'] == 20 || $flag['error'] == 4)
				$data['ResendActivation']=true;
			else
				$data['ResendActivation']=false;
			if($flag['error'])
			{
				$msg=$this->mdl_constants->Messages($flag['error']);
				if($id > 10)
					$data['sucMsg']=$msg;
				else
					$data['errorMsg']=$msg;
			}
			else
				redirect('home/ValidateCart');	
			/*{
				$url=$_SERVER['HTTP_REFERER'];
				header("location:".$url); 
			}*/				
			
			$data['login_error']=$this->mdl_constants->Messages($flag['error']);							
			$this->load->view('header');
			$this->load->view('register/login_view',$data);
			$this->load->view('footer');			
		}
		else
		{
			if($id)
			{
				$msg=$this->mdl_constants->Messages($id);
				if($id > 10)
					$data['sucMsg']=$msg;
				else
					$data['errorMsg']=$msg;
			}
			if($id == 20 || $id == 4)
				$data['ResendActivation']=true;
			else
				$data['ResendActivation']=false;
				
			$this->load->view('header');
			$this->load->view('register/login_view',$data);
			$this->load->view('footer');
		}	
	}
	
	function logout()
	{
		$msg='Logged Out';	
		$this->mdl_coupon->RemoveUnusedCoupoun();
		$this->mdl_course->AddActivity($msg);					
		$this->cart->destroy();
		$this->session->sess_destroy();		
		//if(strpos($_SERVER['HTTP_REFERER'],'home/21'))
			$url=site_url('home/');
		//else		
//		$url=$_SERVER['HTTP_REFERER'];
	//		echo 'test';die;
		//$url=site_url('home/');
		header("location:".$url); 
	}
			
}
?>