<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Home extends CI_Controller
{
	function Home()
	{
		parent::__construct();
		$this->load->model('mdl_customer');
	}	
	function index($msg_id='')
	{
		if($this->session->userdata('cust_id'))
			redirect('home/dashboard');
		if($msg_id > 0)
		{
			$Messages=$this->mdl_constants->Messages();
			if($msg_id >0 && $msg_id<=10)
				$data['error']=$Messages[$msg_id];	
			else if($msg_id > 10)
				$data['success']=$Messages[$msg_id];	
		}
		$this->form_validation->set_rules('uname','User Name','trim|required|valid_email');
		$this->form_validation->set_rules('passwd','Password','trim|required');
		if($this->form_validation->run() == FALSE)		
		{
			$this->load->view('login',$data);	
		}
		else
		{
			$uname=$this->input->post('uname');
			$passwd=md5($this->input->post('passwd'));
			if($this->mdl_customer->LoginValidate($uname,$passwd))
			{
				redirect('home/dashboard');
			}
			else
			{	
				$data['username'] = $this->input->post('uname');				
				$data['error'] = "Username or password is wrong";				
				$this->load->view('login',$data);
			}			
		}			
	}	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('home/');
	}
	function dashboard()
	{		
		$this->load->view('home');		
	}
}
?>