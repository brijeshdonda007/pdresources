<?php
class mdl_admin extends CI_Model
{
	var $srchKey;
	
	function loginvalidate($user,$pass)
	{
		//$this->db->where('user_email','alpesh@artoonsolutions.com');
		$this->db->where('user_name',$user);
		$this->db->where('password',$pass);
		$this->db->where('is_active','Y');
		$this->db->where('is_admin','Y');
		$this->db->where('del_in','N');
		$q = $this->db->get('pdr_user');
		
		if($q->num_rows() > 0)
		{
			$resData = $q->row();
			
			$userdata = array(
				  'admin_id'  => $resData->id,
				  'user_name'  => $resData->user_name,
				  'user_email'  => $resData->user_email,
				  'per_page' => '20'
			 );
			 
			$this->session->set_userdata($userdata);
			return true;
		}
		else
			return false;
	}
	
	function change_pwd()
	{
		$newPassword = $this->newPassword;
		
		$db_array = array('password' => $newPassword);
		$this->db->where("id", $this->session->userdata("admin_id"));
		$this->db->update("pdr_user", $db_array);

	}		
}