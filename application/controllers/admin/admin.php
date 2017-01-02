<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function Admin()
	{
		parent::__construct();
		$this->load->model('admin/mdl_admin');
	}
	
	function index()
	{
		if($this->session->userdata('admin_id'))
			redirect('admin/admin/dashboard');
		
		if($_POST)
		{
			$user = $this->input->post('username');
			$pass = md5($this->input->post('password'));
			
			if($this->mdl_admin->loginvalidate($user,$pass))
				redirect('admin/admin/dashboard');
			else
			{
				$data['username'] = $this->input->post('username');
				$data['password'] = $this->input->post('password');			
				$data['error'] = "Username or password is wrong";
				$this->load->view('admin/login',$data);
			}
		}
		else
			$this->load->view('admin/login');
	}
	
	function dashboard()
	{	
		$this->mdl_common->checkAdminSession();
		
		$this->load->view('admin/header');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/footer');
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('admin/admin');
	}
	
	function change_pwd()
	{
		$this->mdl_common->checkAdminSession();
		
		$data = array('error'  => '');
		$this->form_validation->set_rules('oldPassword','Old Password','trim|required|callback_password_exist');
		$this->form_validation->set_rules('newPassword','New Password','trim|required');
		$this->form_validation->set_rules('retypePassword','Retype Password','trim|required|matches[newPassword]');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['oldPassword'] = $this->input->post('oldPassword');
			$data['newPassword'] = $this->input->post('newPassword');
			$data['retypePassword'] = $this->input->post('retypePassword');
			
			$this->load->view("admin/header", $data);
			$this->load->view("admin/chagepass_form", $data);
			$this->load->view("admin/footer", $data);
		}
		else
		{
			$this->mdl_admin->oldPassword = md5($this->input->post("oldPassword"));
			$this->mdl_admin->newPassword = md5($this->input->post("newPassword"));
			
			$this->mdl_admin->change_pwd();
			
			$data = array('error' => 'Your Password has been changed successfully');
			
			$this->load->view("admin/header", $data);
			$this->load->view("admin/chagepass_form", $data);
			$this->load->view("admin/footer", $data);	
		}
	}
	
	function password_exist($str)
	{
		$this->db->where('password',md5($str));
		$this->db->where("id", $this->session->userdata("admin_id"));
		$this->db->select('password');
		$prod = $this->db->get('pdr_user');
		if ($prod->row())
			return TRUE;
		else
		{
			$this->form_validation->set_message('password_exist', 'Please enter correct password');
			return FALSE;
		}
	}
	
	function updatePerPage($per_page)
	{
		$this->session->set_userdata('per_page',$per_page);
	}
	
	function config($configId = '')
	{
		$res = $this->mdl_admin->get_config($configId);
		$data['listArr'] = $res->result_array();
		$data['msg'] = "";
		
		$this->load->view('admin/header',$data);
		$this->parser->parse('admin/config_list',$data);
		$this->load->view('admin/footer',$data);
	}
	
	function config_form($configId = '')
	{
		$this->form_validation->set_rules('value','Value','trim|required');
		$res = $this->mdl_admin->get_config($configId);
		$resData = $res->row();
		
		$data['value'] = $resData->value;
		$data['title'] = $resData->title;
		
		if($this->form_validation->run() == FALSE)
		{	
			//$data['value'] = $this->input->post('value');
			$data['msg'] = "";
			$data['configId'] = $configId;
			
			$this->load->view('admin/header',$data);
			$this->load->view('admin/config_form',$data);
			$this->load->view('admin/footer',$data);				
		}
		else // insert or update data
		{
			$data['value'] = $this->input->post('value');
			
			$this->mdl_admin->save_config($data,$configId);
			redirect('admin/admin/config');
		}
	}		
}
?>