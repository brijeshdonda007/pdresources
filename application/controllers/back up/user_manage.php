<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class user_manage extends CI_Controller
{
	function user_manage()
	{
		parent::__construct();
		if(!$this->session->userdata('cust_id'))			
			redirect('home/index');
		$this->load->model('mdl_customer');
	}	
	function index($msg_id='')
	{		
		echo 'test';
	}	
	function EditProfile($msg_id='')
	{
		$this->form_validation->set_rules('cust_fname','First Name','trim|required');
		$this->form_validation->set_rules('cust_lname','Last Name','trim|required');	
		$this->form_validation->set_rules('cust_profession','Profession','trim|required|is_value[Select]');
		$this->form_validation->set_rules('cust_address','Address','trim|required');				
		$this->form_validation->set_rules('cust_state','State','trim|required|is_value[Select]');		
		$this->form_validation->set_rules('cust_avatar','Avtar','callback_validate_avtar');			
		
		$sql = "select profession_id,profession_name from pdr_profession_master where profession_is_active='Y' and profession_is_deleted='N' order by profession_name";
		$data['profession'] = $this->mdl_common->dropDownAry($sql,'profession_id','profession_name');
		$sql = "select state_id,state_name from pdr_state_master where state_is_active='Y' and state_is_deleted='N' order by state_name";
		$data['state'] = $this->mdl_common->dropDownAry($sql,'state_id','state_name');
						
		if($this->form_validation->run() == FALSE)		
		{
			$CustInfo=$this->mdl_customer->GetCurrentLoginInfo();
			foreach($CustInfo as $key=>$val)
				$data[$key]=$val;
			if($msg_id > 0)
			{
				$Messages=$this->mdl_constants->Messages();			
				$data['success']=$Messages[$msg_id];					
			}
			$this->load->view('editprofile',$data);	
		}
		else
		{
			$cust_id=$this->session->userdata['cust_id'];
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
			$this->mdl_customer->saveCustomer($cust_id,$u_data);
			redirect('user_manage/EditProfile/15');
		}		
	}
	function ChangePassword($msg_id='')
	{
		if($msg_id > 0)
		{
			$Messages=$this->mdl_constants->Messages();			
			$data['success']=$Messages[$msg_id];					
		}
		$this->form_validation->set_rules('cust_passwd','Password','trim|required');
		$this->form_validation->set_rules('cust_cpasswd','Confirm Password','trim|required|matches[cust_passwd]');	
		if($this->form_validation->run() == FALSE)		
		{			
			$data['cust_email']=$_REQUEST['cust_email'];
			$this->load->view('changepassword',$data);	
		}
		else
		{
			$cust_id=$this->session->userdata['cust_id'];			
			$u_data['cust_passwd']=md5($this->input->post('cust_passwd'));
			$this->db->where('cust_id',$cust_id);
			$this->db->update('pdr_customer_detail',$u_data);
			redirect('user_manage/ChangePassword/16');	
		}	
	}
	function UpdateFacebookId($facebook_id=0)
	{
		if($facebook_id == 0)
			echo '<script type="text/javascript">window.location ="javascript:history.go(-1);";</script>';
		else
		{			
			$cust_id=$this->session->userdata['cust_id'];						
			$u_data['cust_fb_profile_id']=$facebook_id;			
			$this->db->where('cust_id',$cust_id);
			$this->db->update('pdr_customer_detail',$u_data);							
			$CurSessionInfo=$this->session->userdata;
			$CustInfo=$this->mdl_customer->GetCurrentLoginInfo();
			
			if($CustInfo['cust_avatar'])
				@unlink('./'.$CustInfo['cust_avatar']);
			
			$CurSessionInfo['cust_fb_profile_id']=$facebook_id;
			$this->session->set_userdata($CurSessionInfo);
			copy('https://graph.facebook.com/'.$facebook_id.'/picture?type=large','./uploads/avatar/'.$facebook_id.'.jpg');
			$u_data['cust_avatar']='uploads/avatar/'.$facebook_id.'.jpg';			
			$this->db->where('cust_id',$cust_id);
			$this->db->update('pdr_customer_detail',$u_data);										
			echo '<script type="text/javascript">window.location ="javascript:history.go(-1);";</script>';
		}
	}
	function UpdateLinkedinId($linkedin_id='',$pic_url='')
	{		
		if($linkedin_id == '')
			echo '<script type="text/javascript">window.location ="javascript:history.go(-1);";</script>';
		else
		{	
			//echo $linkedin_id;die;
			$pic_url=base64_decode($pic_url);						
			$cust_id=$this->session->userdata['cust_id'];						
			$u_data['cust_lnk_profile_id']=$linkedin_id;			
			$this->db->where('cust_id',$cust_id);
			$this->db->update('pdr_customer_detail',$u_data);							
			$CurSessionInfo=$this->session->userdata;
			$CustInfo=$this->mdl_customer->GetCurrentLoginInfo();
			
			if($CustInfo['cust_avatar'])
				@unlink('./'.$CustInfo['cust_avatar']);
			
			$CurSessionInfo['cust_lnk_profile_id']=$linkedin_id;
			$this->session->set_userdata($CurSessionInfo);
			copy($pic_url,'./uploads/avatar/'.$linkedin_id.'.jpg');
			$u_data['cust_avatar']='uploads/avatar/'.$linkedin_id.'.jpg';			
			$this->db->where('cust_id',$cust_id);
			$this->db->update('pdr_customer_detail',$u_data);										
			echo '<script type="text/javascript">window.location ="javascript:history.go(-1);";</script>';
		}
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
}
?>