<?php
class mdl_login extends CI_Model
{
	function userloginvalidate($user,$pass)
	{
		//"select * from m_user_information where user_passwd = '".$pass."' and (user_name = '".$user."' or user_email = '".$user."') and user_active != 'trash'";
		//$sql = "select user_id,user_email,user_facebook_id,user_active,IF(user_name='',CONCAT(user_fname,' ',user_lname),user_name) as user_name from m_user_information ";
		//echo $sql .= "where user_passwd = '".$pass."' and (user_name = '".$user."' or user_email = '".$user."') and user_active != 'trash'";die;
		
	    $sql = "select * from pdr_customer_detail ";
	    $sql .= "where cust_passwd = '".mysql_escape_string($pass)."' and (cust_email = '".mysql_escape_string($user)."' or cust_uname = '".mysql_escape_string($user)."') and is_deleted = 'N'";
		//echo $sql;
		$q = $this->db->query($sql);
		$resData = $q->row();
		$user_active = $resData->is_active;
		if($q->num_rows() > 0 && $user_active == 'Y')
		{
			$userdata = array(
				  'cust_id'  => $resData->cust_id,
				  'cust_fname'  => $resData->cust_fname,
				  'cust_lname'  => $resData->cust_lname,
				  'cust_email'  => $resData->cust_email,
				  'cust_fb_profile_id' => $resData->cust_fb_profile_id,
  				  'cust_lnk_profile_id' => $resData->cust_lnk_profile_id,
  				  'offline_access_token' => $resData->offline_access_token,
				  'cust_avatar' => $resData->cust_avatar,
			);			
			$this->session->set_userdata($userdata);			
			$responce=$this->mdl_coupon->ApplyCouponUser();			
			$msg='Logged in';	
			$this->mdl_course->AddActivity($msg);			
			$data['flag'] = true;
			return $data;
		}
		else
		{
			$data['flag'] = false;
			if($user_active == 'N')
				$data['error'] = '4';
			else
			{
			    $sql1 = "select * from pdr_user as pu left join pdr_user_profile as uf on uf.user_id=pu.id ";
				$sql1 .= "where pu.password  = '".mysql_escape_string($pass)."' and (pu.user_email = '".mysql_escape_string($user)."' or pu.user_name  = '".mysql_escape_string($user)."') and pu.del_in = 'N'";
				//echo $sql;
				$q1 = $this->db->query($sql1);
				$resData1 = $q1->row();
				$user_status = $resData1->is_active;
				if($q1->num_rows() > 0 && $user_status == 'Y')
				{
					$userdata = array(
						  'cust_id'  => $resData1->user_id,
						  'cust_fname'  => $resData1->user_name ,
						  'cust_lname'  => '',
						  'cust_email'  => $resData1->user_email ,
						  'cust_fb_profile_id' => '',
						  'cust_lnk_profile_id' => '',
						  'offline_access_token' => '',
						  'cust_avatar' => '',
						  'is_admin'	=>	true,
					);			
					$this->session->set_userdata($userdata);			
					$data['flag'] = true;
					return $data;
				}
				else
				{
					$data['flag'] = false;
					if($user_active == 'N')
						$data['error'] = '4';
					else
						$data['error'] = '3';		
				}				
			}				
			return $data;
		}
	}
}