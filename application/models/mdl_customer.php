<?php
class mdl_customer extends CI_Model
{
	function LoginValidate($user,$pass)
	{
		//$this->db->where('user_email','alpesh@artoonsolutions.com');
		$this->db->where('cust_email',$user);
		$this->db->where('cust_passwd',$pass);
		$this->db->where('is_active','Y');		
		$this->db->where('is_deleted','N');
		$q = $this->db->get('pdr_customer_detail');
		//echo $this->db->last_query();
		if($q->num_rows() > 0)
		{
			$resData = $q->row();			
			$userdata = array(
				  'cust_id'  => $resData->cust_id,
				  'user_name'  => $resData->cust_fname.'&nbsp;'.$resData->cust_lname,
				  'cust_email'  => $resData->cust_email,
				  'cust_fb_profile_id'  => $resData->cust_fb_profile_id,
				  'cust_lnk_profile_id'  => $resData->cust_lnk_profile_id,				  
				  'per_page' => '20'
			 );
			
			$this->session->set_userdata($userdata);			
			return true;
		}
		else
			return false;
	}
	
	function saveCustomer($cust_id,$data)
	{
		if($cust_id == "")
		{
			$this->db->insert('pdr_customer_detail',$data);
			$cust_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('cust_id',$cust_id);
			$this->db->update('pdr_customer_detail',$data);
		}
		return $cust_id;
	}
	
	function activeAccount($key)
	{
		$this->db->where('is_activation_key',$key);
		$this->db->where('is_deleted','N');
		$q = $this->db->get('pdr_customer_detail');
		//echo $this->db->last_query();
		if($q->num_rows() > 0)
		{
			$resData = $q->row();
			if($resData->is_active == 'Y')
				return 12;
			else
			{				
				$data['is_active']='Y';				
				$this->db->where('cust_id',$resData->cust_id);
				$this->db->update('pdr_customer_detail',$data);
				return 11;
			}
		}
		else 	
			return 2;
	}
	
	function ForgotPassword($email)
	{
		$is_activation_key=$u_data['is_activation_key']=md5(date('Y-m-d h:s:i'));
		$this->db->where('cust_email',$email);
		$this->db->update('pdr_customer_detail',$u_data);
		//echo $this->db->last_query();
		return $is_activation_key;
	}
	
	function GetCurrentLoginInfo()
	{
		$cust_id=$this->session->userdata('cust_id');
		if($cust_id)
		{
			$this->db->where('cust_id',$cust_id);			
			$q = $this->db->get('pdr_customer_detail');
			//echo $this->db->last_query();
			return $q->row_array();
		}
		else
			return false;
	}
	
	function ChangePassword()
	{
		$newPassword = $this->newPassword;		
		$db_array = array('password' => $newPassword);
		$this->db->where("id", $this->session->userdata("admin_id"));
		$this->db->update("pdr_user", $db_array);

	}		
}
