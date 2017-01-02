<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Dashboard extends CI_Controller
{
	function Dashboard()
	{
		parent::__construct();		
		$this->mdl_common->checkUserSession();
		$this->load->model('mdl_customer');
		$this->load->model('mdl_page');
		$this->load->model('mdl_config');
		$this->load->model('mdl_pramotion');
		$this->load->model('mdl_course');		
		$this->load->model('mdl_employee');		
		$this->load->model('mdl_dashbord');		
		$this->load->model('mdl_test');		
		$this->load->model('mdl_coupon');		
		$this->load->model('mdl_author');		
		$this->load->model('mdl_order');				
	}	
	
	function index()
	{
		$RecentActivity=$this->mdl_dashbord->GetRecentActivity();
		$UserInfo=$this->mdl_dashbord->GetLoggedUserInfo();
		$ActiveCourseInfo=$this->mdl_dashbord->GetUserCorseInfo();		
		$CompleteCourseInfo=$this->mdl_dashbord->GetUserCorseInfo(true);

		//$UserProfInfo==$this->mdl_dashbord->GetUserProfInfo();		

		if($this->cart->has_coupon())
		{
			$TempInfo=$this->cart->has_coupon();
			$CouponInfo=$this->mdl_coupon->GetCouponInfoByCode('',$TempInfo['coupon_id']);
		}

		$data['RecentActivity'] = $RecentActivity;
		$data['UserInfo'] = $UserInfo;
		$data['ActiveCourseInfo'] = $ActiveCourseInfo;
		$data['CompleteCourseInfo'] = $CompleteCourseInfo;
		$data['CouponInfo']=$CouponInfo;
		$header['page_title'] = 'Dashboard';

		$this->load->view('header',$header);
		$this->load->view('dashboard/home',$data);
		$this->load->view('footer');				
	}	
	
	function update_account()
	{
		$cust_id=$this->session->userdata('cust_id');
		$post_data = $this->input->post();

		if($post_data['cust_passwd'] != "") 
		{
			$UserInfo = $this->mdl_dashbord->GetLoggedUserInfo();
			if($UserInfo['cust_passwd'] == md5($post_data['cust_passwd']))
			{
				if($post_data['cust_npasswd'] == "")
					die("New Password can not be blank.");
				else if($post_data['cust_npasswd'] != $post_data['cust_rpasswd'])
					die("New Password and Confirm Password fields must match.");
				else
				{
					$post_data['cust_passwd'] = md5($post_data['cust_npasswd']);
					unset($post_data['cust_npasswd']);
					unset($post_data['cust_rpasswd']);
				}
			}
			else
				die("You have entered wrong Password.");
		}
		else
		{
			unset($post_data['cust_passwd']);
			unset($post_data['cust_npasswd']);
			unset($post_data['cust_rpasswd']);
		}

		$this->mdl_customer->saveCustomer($cust_id,$post_data);
		echo "Profile data saved successfully.";
	}
	
	function facebookLogin()
	{
		$cust_id=$this->session->userdata('cust_id');		
		$post_data = $this->input->post();		
		$CustInfo=$this->mdl_customer->GetCurrentLoginInfo();
		if($CustInfo['cust_avatar'])
			@unlink('./'.$CustInfo['cust_avatar']);				
		$url='http://graph.facebook.com/'.$this->input->post('fb_facebook_id').'/picture?type=large';
		$image_path='./uploads/avatar/'.$this->input->post('fb_facebook_id').'.jpg';
		$databasepath='uploads/avatar/'.$this->input->post('fb_facebook_id').'.jpg';
		copy($url,$image_path);	
		$udata['cust_avatar']=$databasepath;
		$udata['cust_fb_profile_id']=$post_data['fb_facebook_id'];
		$udata['cust_fb_access_token']=$post_data['fb_facebook_offline_token'];
		$this->mdl_customer->saveCustomer($cust_id,$udata);
		redirect('dashboard');
	}
	
	function ChangeImage()
	{
		$UserInfo=$this->mdl_dashbord->GetLoggedUserInfo();		
		$this->form_validation->set_rules('new_image','Avtar','callback_validate_avtar');
		if($this->form_validation->run() == FALSE)
		{
			$data['UserInfo']=$UserInfo;
			$this->load->view('dashboard/updateimage',$data);						
		}
		else
		{
			if($_FILES['new_image']['error'] == 0)
			{
				if($this->input->post('old_image'))
					@unlink('./'.$this->input->post('old_image'));				
				$res = $this->mdl_common->uploadFile('new_image','img','avatar');					
				if($res['success'])
				{						
					$u_data['cust_avatar'] = $res['path'];
				}
			}
			$this->db->where('cust_id',$this->session->userdata('cust_id'));
			$this->db->update('pdr_customer_detail',$u_data);
			$this->CropImage();			
		}		
	}
	
	function CropImage($flag='')
	{				
		$UserInfo=$this->mdl_dashbord->GetLoggedUserInfo();		
		$data['UserInfo']=$UserInfo;				
		$data['flag']=$flag;				
		$this->load->view('dashboard/cropimage',$data);								
	}
		
	function SaveCropImage()
	{
		$UserInfo=$this->mdl_dashbord->GetLoggedUserInfo();		
		if($_POST['scale_image_fix'])
		{
			$this->load->library('imageResize');			

			$info= getimagesize($UserInfo['cust_avatar']); 	
			$scale=$info[1]/$info[0];									
  		    $thumb = $this->imageresize->resizeImage($UserInfo['cust_avatar'],400,400,'exact');
		}

		//$targ_w = $targ_h = 400;
		$targ_w = 231;
		$targ_h = 294;
		$jpeg_quality = 100;
	
		$src = $UserInfo['cust_avatar'];
		$img_r = imagecreatefromjpeg($src);
		$dst_r = imagecreatetruecolor( $targ_w, $targ_h );
	
		imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);

		//header('Content-type: image/jpeg');
		imagejpeg($dst_r,$UserInfo['cust_avatar'],$jpeg_quality);
		//imagejpeg($dst_r,null,$jpeg_quality);
		echo '<script language="javascript">window.parent.closebox("'.$UserInfo['cust_avatar'].'");</script>';
	}
	
	function GetProfileImage()
	{
		$UserInfo=$this->mdl_dashbord->GetLoggedUserInfo();			
		if($UserInfo['cust_avatar'])
			echo base_url().$UserInfo['cust_avatar'];
		else
			echo base_url().'images/user_default_logo.png';
	}
        
	function submitreview($course_id='')
	{
		$this->form_validation->set_rules('comment_description','Review','required|trim');
		if($this->form_validation->run() == FALSE)
		{
			$data['course_id']=$course_id;
			$this->load->view('dashboard/givereview',$data);						
		}
		else
		{
			$udata['comment_description']=$_POST['comment_description'];		
			$udata['comment_user_id']=$this->session->userdata('cust_id');
			$udata['comment_course_id']=$course_id;
			$udata['comment_approved']='draft';
			$this->db->insert('pdr_user_comments',$udata);
			echo '<script language="javascript">window.parent.CloseReview();</script>';
		}
		
	}
	
	function validate_avtar()
	{
		if($_FILES['new_image']['error'] == 0)
		{
			$ext=strtolower(end(explode('.',$_FILES['new_image']['name'])));			
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
		{
			$this->form_validation->set_message('validate_avtar', 'Please select valid avatar file');
			return false;			
		}
	}
	
	function getCity()
	{
		$this->db->where('city_status','publish');
		$this->db->like('city_name',$_GET["q"]);
		$res=$this->db->get('pdr_city_master');
		
		foreach($res->result_array() as $res)
			echo $res['city_name']."|".$res['city_id']."\n";
	}
	
	function getState()
	{
		$this->db->where('state_is_active','Y');
		$this->db->where('state_is_deleted','N');
		$this->db->like('state_name',$_GET["q"]);
		$res=$this->db->get('pdr_state_master');
		
		foreach($res->result_array() as $res)
			echo $res['state_name']."|".$res['state_id']."\n";
	}
	
	function getZip()
	{
		$this->db->where('zipcode_status','publish');
		$this->db->like('zipcode_name',$_GET["q"]);
		$res=$this->db->get('pdr_zipcode_master');
		
		foreach($res->result_array() as $res)
			echo $res['zipcode_name']."|".$res['zipcode_id']."\n";
	}
}
?>