<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Register extends CI_Controller
{
	function Register()
	{
		parent::__construct();
		$this->load->model('mdl_customer');
	}	
	function index()
	{
		$this->form_validation->set_rules('cust_fname','First Name','trim|required');
		$this->form_validation->set_rules('cust_lname','Last Name','trim|required');	
		$this->form_validation->set_rules('cust_profession','Profession','trim|required|is_value[Select]');
		$this->form_validation->set_rules('cust_address','Address','trim|required');				
		$this->form_validation->set_rules('cust_state','State','trim|required|is_value[Select]');		
		$this->form_validation->set_rules('cust_avatar','Avtar','callback_validate_avtar');
		$this->form_validation->set_rules('cust_email','Email','trim|required|valid_email|callback_email_exist');
		$this->form_validation->set_rules('cust_passwd','Password','trim|required');
		$this->form_validation->set_rules('cust_cpasswd','Confirm Password','trim|required|matches[cust_passwd]');				
		$sql = "select profession_id,profession_name from pdr_profession_master where profession_is_active='Y' and profession_is_deleted='N' order by profession_name";
		$data['profession'] = $this->mdl_common->dropDownAry($sql,'profession_id','profession_name');
		$sql = "select state_id,state_name from pdr_state_master where state_is_active='Y' and state_is_deleted='N' order by state_name";
		$data['state'] = $this->mdl_common->dropDownAry($sql,'state_id','state_name');
		if($this->form_validation->run() == FALSE)		
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			$this->load->view('register',$data);	
		}
		else
		{
			if($_FILES['cust_avatar']['error'] == 0)
			{
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
			$u_data['cust_email']=$this->input->post('cust_email');
			$u_data['cust_passwd']=md5($this->input->post('cust_passwd'));
			$u_data['is_activation_key']=md5(date('Y-m-d h:s:i'));																								
			$u_data['cust_register_ip']=$this->input->ip_address();
			$this->mdl_customer->saveCustomer('',$u_data);		

			$body='';
			$body = "Hello ".$u_data['cust_fname'].'&nbsp;'.$u_data['cust_lname'].", <br/><br/>";
			$body .= "The administrator of site has created your account for artoongames.com (A great gaming portal) . <br/><br/>";
			$body .= "Your account information are as below : <br/><br/>";
			$body .= "User Name : ".$u_data['cust_email']."<br/>";
			$body .= "To activate your account Please click following link<br>";
			$body .= site_url('register/ActivateAccount/'.$u_data['is_activation_key']).'<br>';			
			$body .= "Thank You , <br/> ".site_url('home/index')."<br/><br/>";			
			
			$this->load->helper('phpmailer');
			$mail = new PHPMailer();
			
			$mail->IsSMTP();
			$mail->IsHTML(true); // send as HTML
			
			$mail->SMTPAuth = true; // enable SMTP authentication
			$mail->SMTPSecure = "ssl"; // sets the prefix to the servier
			$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
			$mail->Port = 465; // set the SMTP port
			$mail->Username = "brijesh.donda@artoonsolutions.com"; // GMAIL username
			$mail->Password = "9924051212"; // GMAIL password
			
			$mail->From = $u_data['cust_email'];
			$mail->FromName = $u_data['cust_fname'].' '.$u_data['cust_lname'];
			$mail->Subject = "Welcome to pdr";
			$mail->Body = $body; //HTML Body
			$emailId='brijesh.donda@artoonsolutions.com';
			$emails = explode(",",$emailId);			
			foreach($emails as $email)
			$mail->AddAddress($email);
			
			if(!$mail->Send())
				echo "Mailer Error: " . $mail->ErrorInfo;
			else
				redirect('home/index');
			
			//$toEmail = $u_data['cust_email'];
			//$subject =  "Welcome to pdr";
			//$frommail=  '';
			//$fromname='';									
			//$this->mdl_common->sendMail($toEmail,$subject,$body,$frommail,'',$fromname);  //send email to new user , which contains user's account information			
		}		
	}		
	function forgetpasswd($msg_id='')
	{
		if($msg_id > 0)
		{
			$Messages=$this->mdl_constants->Messages();			
				$data['success']=$Messages[$msg_id];	
		}
		$this->form_validation->set_rules('cust_email','Email','trim|required|valid_email|callback_email_there');		
		if($this->form_validation->run() == FALSE)		
		{
			$data['cust_email']=$_REQUEST['cust_email'];
			$this->load->view('forgetpassword',$data);	
		}
		else
		{
			$cust_email=$this->input->post('cust_email');
			
			$flag=$this->mdl_customer->ForgotPassword($cust_email);
			if($flag)
			{
				$this->db->where('cust_email',$cust_email);
				$this->db->where('is_deleted','N');		
				$Info = $this->db->get('pdr_customer_detail');
				$resData = $Info->row();

				$body='';
				$body = "Hello ".$resData->cust_fname.'&nbsp;'.$resData->cust_lname.", <br/><br/>";				
				$body .= "Your account information are as below : <br/><br/>";
				$body .= "User Name : ".$resData->cust_email."<br/>";
				$body .= "To reset your account password Please click following link<br>";
				$body .= site_url('register/ResetPassword/'.$flag).'<br>';			
				$body .= "Thank You , <br/> ".site_url('home/index')."<br/><br/>";			
				
				$this->load->helper('phpmailer');
				$mail = new PHPMailer();
				
				$mail->IsSMTP();
				$mail->IsHTML(true); // send as HTML
				
				$mail->SMTPAuth = true; // enable SMTP authentication
				$mail->SMTPSecure = "ssl"; // sets the prefix to the servier
				$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
				$mail->Port = 465; // set the SMTP port
				$mail->Username = "brijesh.donda@artoonsolutions.com"; // GMAIL username
				$mail->Password = "9924051212"; // GMAIL password
				
				$mail->From = $u_data['cust_email'];
				$mail->FromName = $u_data['cust_fname'].' '.$u_data['cust_lname'];
				$mail->Subject = "Welcome to pdr";
				$mail->Body = $body; //HTML Body
				$emailId='brijesh.donda@artoonsolutions.com';
				$emails = explode(",",$emailId);			
				foreach($emails as $email)
				$mail->AddAddress($email);
				
				if(!$mail->Send())
					echo "Mailer Error: " . $mail->ErrorInfo;
				else
					redirect('register/forgetpasswd/13');
				
				//$toEmail = $u_data['cust_email'];
				//$subject =  "Welcome to pdr";
				//$frommail=  '';
				//$fromname='';									
				//$this->mdl_common->sendMail($toEmail,$subject,$body,$frommail,'',$fromname);  //send email to new user , which contains user's account information		
			}
			else
				redirect('home/index');
		}
	}
	function ActivateAccount($activationKey)
	{
		if($activationKey == '')
			redirect('home/index/1');
		else
		{
			$flag=$this->mdl_customer->activeAccount($activationKey);
			redirect('home/index/'.$flag);
		}
	}
	function ResetPassword($activationKey)
	{	
		if($activationKey == '')
			redirect('home/index/1');
		else
		{
			$this->db->where('is_activation_key',$activationKey);
			$this->db->where('is_deleted','N');
			$q = $this->db->get('pdr_customer_detail');			
			if($q->num_rows() > 0)
			{
				$this->form_validation->set_rules('cust_passwd','Password','trim|required');
				$this->form_validation->set_rules('cust_cpasswd','Confirm Password','trim|required|matches[cust_passwd]');	
				if($this->form_validation->run() == FALSE)		
				{
					$data['cust_email']=$_REQUEST['cust_email'];
					$this->load->view('resetpassword',$data);	
				}
				else
				{
					$u_data['is_activation_key']='';
					$u_data['cust_passwd']=md5($this->input->post('cust_passwd'));
					$this->db->where('is_activation_key',$activationKey);
					$this->db->update('pdr_customer_detail',$u_data);
					redirect('home/index/14');	
				}
			}
			else 
				redirect('home/index/2');
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
	function email_exist($str)
	{				
		$this->db->where('cust_email',$str);
		$this->db->where('is_deleted','N');		
		$prod = $this->db->get('pdr_customer_detail');
		
		if ($prod->num_rows() > 0)
		{
			$this->form_validation->set_message('email_exist', 'This email is already registered with us.');
			return FALSE;
		}
		else
			return TRUE;
	}
	function email_there($str)
	{				
		$this->db->where('cust_email',$str);
		$this->db->where('is_deleted','N');		
		$prod = $this->db->get('pdr_customer_detail');
		//echo $this->db->last_query();			
		if ($prod->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('email_there', 'This email is not found in database.');
			return FALSE;
		}
	}
}
?>