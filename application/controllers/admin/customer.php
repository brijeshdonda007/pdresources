<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class customer extends CI_Controller
{
	function customer()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_customer');
	}
	
	function index($start='0')
	{
		if($_POST || $start=='s')
		{			
			$start = 0;			
			$searchtext = $this->input->post('searchText');						
			$this->session->set_userdata('searchtext',$searchtext);			
		}
		else
		{			
			$searchtext = $this->session->userdata('searchtext');
		}		
		$res = $this->mdl_customer->get_customers('',$searchtext);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/customer/index/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		if($searchtext == "")
			$searchtext = "Search";
		
		$data['searchText'] = $searchtext;						
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/customer/customer_list',$data);
		$this->load->view('admin/footer');
	}	
	
	function addCustomer($custmer_id='')
	{		
		$this->form_validation->set_rules('cust_fname','First Name','trim|required');
		$this->form_validation->set_rules('cust_lname','Last Name','trim|required');	
		$this->form_validation->set_rules('cust_profession','Profession','trim|required|is_value[Select]');
		$this->form_validation->set_rules('cust_address','Address','trim|required');				
		$this->form_validation->set_rules('cust_state','State','trim|required|is_value[Select]');		
		$this->form_validation->set_rules('cust_avatar','Avtar','callback_validate_avtar');
		if(!$this->input->post('cust_id'))
		{
			$this->form_validation->set_rules('cust_email','Email','trim|required|valid_email|callback_email_exist');
			$this->form_validation->set_rules('cust_passwd','Password','trim|required');
			$this->form_validation->set_rules('cust_cpasswd','Confirm Password','trim|required|matches[cust_passwd]');
		}
		else
		{
			if($this->input->post('cust_passwd'))
				$this->form_validation->set_rules('cust_cpasswd','Confirm Password','trim|required|matches[cust_passwd]');
		}

		$sql = "select profession_id,profession_name from pdr_profession_master where profession_is_active='Y' and profession_is_deleted='N' order by profession_name";
		$profession = $this->mdl_common->dropDownAry($sql,'profession_id','profession_name');
		$sql = "select state_id,state_name from pdr_state_master where state_is_active='Y' and state_is_deleted='N' order by state_name";
		$state = $this->mdl_common->dropDownAry($sql,'state_id','state_name');
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($custmer_id !='')
			{
				$res = $this->mdl_customer->get_customers($custmer_id);
				$data = $res->row_array();																
			}			
			$data['profession']=$profession;
			$data['state']=$state;			
			
			$this->load->view('admin/header');
			$this->load->view('admin/customer/addCustomer',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			if($_FILES['cust_avatar']['error'] == 0)
			{
				if($this->input->post('pre_avatar_image'))
					@unlink('./'.$this->input->post('pre_avatar_image'));				
				$res = $this->mdl_common->uploadFile('cust_avatar','img','avatar');					
				if($res['success'])
				{						
					$u_data['cust_avatar'] = $res['path'];
				}
			}								
			$u_data['cust_fname']=$this->input->post('cust_fname');
			$u_data['cust_lname']=$this->input->post('cust_lname');
			$u_data['cust_profession']=$this->input->post('cust_profession');
			$u_data['cust_address']=$this->input->post('cust_address');
			$u_data['cust_state']=$this->input->post('cust_state');
			$u_data['is_active']=$this->input->post('is_active');			
			if(!$this->input->post('cust_id'))
			{
				$u_data['cust_email']=$this->input->post('cust_email');
				$u_data['cust_passwd']=md5($this->input->post('cust_passwd'));
			}
			else
			{
				if($this->input->post('cust_passwd'))
					$u_data['cust_passwd']=md5($this->input->post('cust_passwd'));
			}
			$this->mdl_customer->saveCustomer($custmer_id,$u_data);	
			redirect('admin/customer/index/'.$start);	
		}
	}
	
	function deleteCustomer($id='')
	{
		if($id == "")
			$users = $this->input->post('customers');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_customer->deleteCustomer($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/customer/index/'.$start);
	}
	
	function updateActive($id,$is_active)
	{
		$data['is_active'] = $is_active;
		$this->db->where('cust_id',$id);
		$this->db->update('pdr_customer_detail',$data);
	}
	
	function email_exist($str)
	{
		if($this->input->post('cust_id'))
			$this->db->where('cust_id !=',$this->input->post('cust_id'));
		
		$this->db->where('cust_email',$str);
		$prod = $this->db->get('pdr_customer_detail');
		
		if ($prod->row())
		{
			$this->form_validation->set_message('email_exist', 'This email is already registered with us.');
			return FALSE;
		}
		else
			return TRUE;
	}
	
	function validate_avtar()
	{
		if($_FILES['cust_avatar']['error'] == 0)
		{
			$ext=strtolower(end(explode('.',$_FILES['cust_avatar']['name'])));			
			$ValidExt=$this->mdl_constants->Image_ext();
			
			if(in_array($ext,$ValidExt))
			{
				return true;
			}
			else
			{
				$this->form_validation->set_message('validate_avtar', 'Please select valid avatar file');
				return false;
			}
		}
		else
			return TRUE;
	}
	
	function tests($cust_id,$start='s')
	{
		if($_POST || $start=='s')
		{			
			$start = 0;			
			$testtype = $this->input->post('testtype');						
			$this->session->set_userdata('testtype',$searchtext);			
		}
		else
		{			
			$testtype = $this->session->userdata('testtype');
		}		

		$res = $this->mdl_customer->get_tests($testtype,$cust_id);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/tests/'.$cust_id.'/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		$data['testtype']=$testtype;
		$data['cust_id']=$cust_id;
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();		
		$this->load->view('admin/header');
		$this->load->view('admin/customer/test_list',$data);
		$this->load->view('admin/footer');
	
	}
	
	function order($cust_id,$start='s')
	{
		if($_POST || $start=='s')
		{			
			$start = 0;			
			$ordertype = $this->input->post('ordertype');						
			$this->session->set_userdata('ordertype',$searchtext);			
		}
		else
		{			
			$ordertype = $this->session->userdata('ordertype');
		}		

		$res = $this->mdl_customer->get_orders($ordertype,$cust_id);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/order/'.$cust_id.'/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		$data['ordertype']=$ordertype;
		$data['cust_id']=$cust_id;
		
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		$this->load->view('admin/header');
		$this->load->view('admin/customer/order_list',$data);
		$this->load->view('admin/footer');
	
	}
	
	function coupons($cust_id,$start='s')
	{
		if($_POST || $start=='s')
		{			
			$start = 0;			
		}

		$res = $this->mdl_customer->get_coupons($cust_id);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/coupons/'.$cust_id.'/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		$data['Title']='Paused';
		$this->load->view('admin/header');
		$this->load->view('admin/customer/coupon_list',$data);
		$this->load->view('admin/footer');
	}
}
?>