<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
	function User()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_user');
	}
	
	function index($start='0')
	{
		if($_POST || $start=='s')
		{
			$start = 0;
			$searchKey = $this->input->post('searchText');
			$country = $this->input->post('country');
			$onlineSearch = $this->input->post('onlineSearch');
			
			$this->session->set_userdata('searchKey',$searchKey);
			$this->session->set_userdata('country',$country);
			$this->session->set_userdata('onlineSearch',$onlineSearch);
		}
		else
		{
			$searchKey = $this->session->userdata('searchKey');
			$country = $this->session->userdata('country');
			$onlineSearch = $this->session->userdata('onlineSearch');
		}
		
		$res = $this->mdl_user->get_users('',$searchKey,$country,$onlineSearch);
		if($start == "s")
			$start = 0;
		
		$data = $this->mdl_common->pagiationData('admin/user/index/',$res->num_rows(),$start,'4');
		
		$this->session->set_userdata('start',$start);
		
		$i=0;
		foreach($data['listArr'] as $list)
		{
			$data['listArr'][$i]['login_ip'] = $this->mdl_constants->lastLoginIP($list['id']);
			$i++;
		}
		
		if($searchKey == "")
			$searchKey = "Search";
		
		$data['searchText'] = $searchKey;		
				
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/user_list',$data);
		$this->load->view('admin/footer');
	}
	
	function addUser()
	{		
		$this->form_validation->set_rules('user_email','User Email','trim|required|valid_email|callback_email_exist');
		$this->form_validation->set_rules('user_name','User Name','trim|required|callback_uname_exist');
		$this->form_validation->set_rules('password','Password','trim|required');
		$this->form_validation->set_rules('retypePassword','Retype Password','trim|required|matches[password]');
		$this->form_validation->set_rules('birth_date','Birth Date','trim|required');
		$this->form_validation->set_rules('gender','Gender','trim|required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['user_email'] = $this->input->post('user_email');
			$data['user_name'] = $this->input->post('user_name');
			$data['password'] = $this->input->post('password');
			$data['retypePassword'] = $this->input->post('retypePassword');
			$data['birth_date'] = $this->input->post('birth_date');
			$data['gender'] = $this->input->post('gender');
			
			$this->load->view('admin/header');
			$this->load->view('admin/addUser',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			$user_data['user_email'] = $this->input->post('user_email');
			$user_data['user_name'] = $this->input->post('user_name');
			$user_data['password'] = md5($this->input->post('password'));
			$user_data['member_since'] = date('Y-m-d H:i:s',time());
			$user_data['register_ipaddress'] = $this->input->ip_address();
			$user_data['is_active'] = "Y";
			if($_REQUEST['is_admin_user'] == 'Y')
				$user_data['is_admin'] = 'Y';						
			$this->db->insert('pdr_user',$user_data);
			$user_id = $this->db->insert_id();									
			//entry in user_profile table
			$profile_data['user_id'] = $user_id;
			$profile_data['birth_date'] = date('Y-m-d',strtotime($this->input->post('birth_date')));
			$profile_data['gender'] = $this->input->post('gender');
			$this->db->insert('pdr_user_profile',$profile_data);
			
			$toEmail = $user_data['user_email'];
			$subject = "Artoon Games - Your account created by administrator.";
			
			$body = "Hello ".$user_data['user_name'].", <br/><br/>";
			$body .= "The administrator of site has created your account for artoongames.com (A great gaming portal) . <br/><br/>";
			$body .= "Your account information are as below : <br/><br/>";
			$body .= "User Email : ".$user_data['user_email']."<br/>";
			$body .= "User Name : ".$user_data['user_name']."<br/>";
			$body .= "Password : ".$this->input->post('password')."<br/><br/>";
			$body .= "Thank You , <br/> artoongames.com<br/><br/>";
			
			$this->mdl_common->sendMail($toEmail,$subject,$body);  //send email to new user , which contains user's account information
			redirect('admin/user');
		}
	}
	
	function editUser($id)
	{
		$this->form_validation->set_rules('user_email','User Email','trim|required|valid_email|callback_email_exist');
		$this->form_validation->set_rules('user_name','User Name','trim|required|callback_uname_exist');
		$this->form_validation->set_rules('birth_date','Birth Date','trim|required');
		
		if($this->input->post('password') != "")
		{
			$this->form_validation->set_rules('password','Password','trim|required');
			$this->form_validation->set_rules('retypePassword','Retype Password','trim|required|matches[password]');
		}
		
		if($this->form_validation->run() == FALSE)
		{
			$data['user_email'] = $this->input->post('user_email');
			$data['user_name'] = $this->input->post('user_name');
			$data['password'] = $this->input->post('password');
			$data['retypePassword'] = $this->input->post('retypePassword');
			$data['birth_date'] = $this->input->post('birth_date');
			$data['gender'] = $this->input->post('gender');
			$data['country'] = $this->input->post('country');			
			
			if(!$_POST)
			{
				$res = $this->mdl_user->get_users($id);
				$listArr = $res->result_array();
				$data = $listArr[0];				
				$data['password'] = "";
				$data['birth_date'] = date('m-d-Y',strtotime($data['birth_date']));
			}
			
			
			$this->load->view('admin/header');
			$this->load->view('admin/editUser',$data);
			$this->load->view('admin/footer');
		}
		else
		{			
			//do update in database
			$data = array();
			$data['user_email'] = $this->input->post('user_email');
			$data['user_name'] = $this->input->post('user_name');
			
			if($this->input->post('password') != "")
				$data['password'] = md5($this->input->post('password'));
			if($_REQUEST['is_admin_user'] == 'Y')
				$data['is_admin'] = 'Y';
			else
				$data['is_admin'] = 'N';
			//update in user table
			$this->db->where('id',$id);
			$this->db->update('pdr_user',$data);
			
			$data = array();
			$data['birth_date'] = date('Y-m-d H:i:s',strtotime($this->input->post('birth_date')));
			$data['gender'] = $this->input->post('gender');			
							
			//update in user_profile table
			$this->db->where('user_id',$id);
			$this->db->update('pdr_user_profile',$data);
			
			$start = $this->session->userdata('start');
			redirect('admin/user/index/'.$start);
		}
	}
	
	function deleteUser($id='')
	{
		if($id == "")
			$users = $this->input->post('users');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_user->deleteUser($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/user/index/'.$start);
	}
	
	function updateActive($id,$is_active)
	{
		$data['is_active'] = $is_active;
		$this->db->where('id',$id);
		$this->db->update('user',$data);
	}
	
	function email_exist($str)
	{
		if($this->input->post('editUser'))
			$this->db->where('id !=',$this->input->post('user_id'));
		
		$this->db->where('user_email',$str);
		$prod = $this->db->get('pdr_user');
		
		if ($prod->row())
		{
			$this->form_validation->set_message('email_exist', 'This email is already registered with us.');
			return FALSE;
		}
		else
			return TRUE;
	}
	
	function uname_exist($str)
	{
		if($this->input->post('editUser'))
			$this->db->where('id !=',$this->input->post('user_id'));
		
		$this->db->where('user_name',$str);
		$prod = $this->db->get('pdr_user');
		
		if ($prod->row())
		{
			$this->form_validation->set_message('uname_exist', 'This Username is already registered with us.');
			return FALSE;
		}
		else
			return TRUE;
	}
}
?>