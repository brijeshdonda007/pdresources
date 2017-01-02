<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Signup extends CI_Controller
{
	function Signup ()
	{
		parent::__construct();
		$this->load->model('mdl_customer');
		$this->load->model('mdl_page');
		$this->load->model('mdl_config');
		$this->load->model('mdl_pramotion');
		$this->load->model('mdl_course');		
		$this->load->model('mdl_profession');	
		$this->load->model('mdl_author');		
		$this->load->model('mdl_signup');		
	}	
	
	function index($id='')
	{
		if(!$_POST)
		{
			if($id)
			{
				$msg=$this->mdl_constants->Messages($id);
				if($id > 10)
					$data['sucMsg']=$msg;
				else
					$data['errorMsg']=$msg;
			}
			$this->load->view('header');
			$this->load->view('register/about',$data);
			$this->load->view('footer');
		}
		else
		{

			$this->form_validation->set_rules('signup_name','User Name','trim|required');
			$this->form_validation->set_rules('signup_email','Email','trim|required|valid_email|callback_email_check');	
			$this->form_validation->set_rules('signup_password','Password','trim|required');
			$this->form_validation->set_rules('signup_profession','Profession','trim|required');
			if($this->form_validation->run() == FALSE)		
			{
				$str = validation_errors();
						
				$error = substr($str,3,strpos($str,'</p>')-3);
				$data['errorMsg'] = $error;
				$data['signup_name']=$this->input->post('signup_name');					
				$data['signup_email']=$this->input->post('signup_email');					
				if($this->input->post('signup_profession'))
					$selectedprof=$this->getProfInfoById($this->input->post('signup_profession'));
				$this->load->view('header',$header);
				$this->load->view('register/about',$data);
				$this->load->view('footer',$footer);
			}
			else
			{
				$data['cust_fname'] = $this->input->post('signup_name');
				$data['cust_email'] = $this->input->post('signup_email');
				$data['cust_passwd'] = md5($this->input->post('signup_password'));
				$data['cust_profession'] = $this->input->post('signup_profession');
				$data['cust_register_ip'] = $this->input->ip_address();
				$data['is_activation_key'] = md5(time());
				//$data['user_active'] = 'draft';
				
				if($this->mdl_signup->saveUserData($data))
				{
					$act_key = $data['is_activation_key'];
					$user_name = $data['cust_fname'];
					$toEmail = $data['cust_email'];
					$subject = "Welcome to the pdr";
					$url=base_url()."signup/activation/".$act_key;
					
					$body=$this->registerMail($user_name,$toEmail,$url);
					//$body = "Hello ".$user_name.", <br/><br/>";
					//$body.= " Thank you for signing up with muvireviews.com.<br/><br/>";
					//$body.= "Your account information are as below : <br/><br/>";
					//$body.= "User Name : ".$user_name."<br/>";
					//$body.= "User Email : ".$toEmail."<br/>";
					//$body.= "Password : ".$this->input->post('signup_password')."<br/><br/>";
					//$body.= "User Name : ".$data['first_name']."<br/>";
					//$body.= " Please click the link below to activate your account :<br/> <a href='".base_url()."register/signup/activation/".$act_key."'>CLICK HERE</a><br/><br/>";
					
					//$body.= "Thank You , <br/> muvireviews.com";
					
					$this->sendMail1('brijesh.donda@artoonsolutions.com',$subject,$body);  //send email to new user , which contains user's account information
					//$this->mdl_common->sendMail($toEmail,$subject,$body);  //send email to new user , which contains user's account information
					redirect('login/index/20');
				}
			
			}
		}
	}	
	
	function forgot_pass($id)
	{
		if(!$_POST)
		{
			if($id)
			{
				$msg=$this->mdl_constants->Messages($id);
				if($id > 10)
					$data['sucMsg']=$msg;
				else
					$data['errorMsg']=$msg;
			}
			$this->load->view('header');
			$this->load->view('register/forgot_password_view',$data);
			$this->load->view('footer');
		}
		else
		{
			$this->form_validation->set_rules('forgot_email','Email','trim|required|valid_email');	
			if($this->form_validation->run() == FALSE)		
			{
				$str = validation_errors();						
				$error = substr($str,3,strpos($str,'</p>')-3);
				$data['errorMsg'] = $error;
				$data['signup_email']=$this->input->post('signup_email');					
				$this->load->view('header',$header);
				$this->load->view('register/forgot_password_view',$data);
				$this->load->view('footer',$footer);
			}
			else
			{
				$cust_email = $this->input->post('forgot_email');
				$res = $this->db->query('select * from pdr_customer_detail where (cust_email = "'.mysql_escape_string($cust_email).'") and is_deleted <> "Y"');
				$total = $res->num_rows();
				$row = $res->row_array();
							
				$is_active  = $row['is_active'];
				if($total > 0 && $is_active == 'Y')
				{
					$act_key = md5(time());
					//$user_name = $row['user_name']?$row['user_name']:$row['user_fname'].' '.$row['user_lname'];
					$user_name = $row['cust_fname'].' '.$row['cust_lname'];
					$toEmail = $row['cust_email'];
					$subject = "Reset Password Confirmation for the pdr";
					$url=base_url()."signup/activation/".$act_key."/reset";
					
					$body=$this->ForgetPasswordMail($user_name,$toEmail,$url);
					
	/*				$body = "Hello ".$user_name.", <br/><br/>";
					$body.= " Thank you for signing up with muvireviews.com.<br/><br/>";
					$body.= "Your account information are as below : <br/><br/>";
					$body.= "User Name : ".$user_name."<br/>";
					$body.= "User Email : ".$toEmail."<br/>";
					//$body.= "User Name : ".$data['first_name']."<br/>";
					$body.= " Please click the link below to Reset your password :<br/> <a href='".base_url()."register/signup/activation/".$act_key."/reset'>CLICK HERE</a><br/><br/>";
					
					$body.= "Thank You , <br/> muvireviews.com";
	*/				
					$this->sendMail1('brijesh.donda@artoonsolutions.com',$subject,$body);  //send email to new user , which contains user's account information
					//$this->mdl_common->sendMail($toEmail,$subject,$body);  //send email to new user , which contains user's account information
					$data['is_activation_key'] = $act_key;
					$this->mdl_signup->saveUserData($data,$row['cust_id']);
					redirect('login/index/13');
				}
				else
				{
					$data['forgot_password_email'] = $user_or_email;
					if($is_active == 'N')
						redirect('login/index/4');
					else
						redirect('signup/forgot_pass/5');
				}
			}
		}
	}
	
	function ResendActivationLink($id='')
	{
		if(!$_POST)
		{			
			if($id)
			{
				$msg=$this->mdl_constants->Messages($id);
				if($id > 10)
					$data['sucMsg']=$msg;
				else
					$data['errorMsg']=$msg;
			}
			$this->load->view('header');
			$this->load->view('register/resend_activation_view',$data);
			$this->load->view('footer');
		}
		else
		{
			$user_or_email = $this->input->post('resend_email');
			$res = $this->db->query('select * from pdr_customer_detail where (cust_email = "'.mysql_escape_string($user_or_email).'") and is_deleted <> "Y"');
			$total = $res->num_rows();
			$row = $res->row_array();
			$is_active=$row['is_active'];	
			if($total > 0 && $is_active == 'N') 
			{
				$act_key = md5(time());
				//$user_name = $row['user_name']?$row['user_name']:$row['user_fname'].' '.$row['user_lname'];
				$user_name = $row['cust_fname'].' '.$row['cust_lname'];
				$toEmail = $row['cust_email'];
				$subject = "Reset Password Confirmation for the muvireviews.com";
				$url=base_url()."signup/activation/".$act_key."";
								
				$body=$this->registerMail($user_name,$toEmail,$url);

				$this->sendMail1('brijesh.donda@artoonsolutions.com',$subject,$body);  //send email to new user , which contains user's account information
				//$this->mdl_common->sendMail($toEmail,$subject,$body);  //send email to new user , which contains user's account information
				$data['is_activation_key'] = $act_key;
				$this->mdl_signup->saveUserData($data,$row['cust_id']);
				redirect('login/index/20');
			}
			else
			{				
				if($is_active == 'Y')
					redirect('login/index/6');
				else
					redirect('signup/ResendActivationLink/5');
			}
		}
	}
	
	function ResetPassword()
	{					
		if(!$_POST)
		{
			$this->load->view('header');
			$this->load->view('register/reset_password_view');
			$this->load->view('footer');
		}
		else
		{
			  $activationKey = $this->session->userdata('activation_key');
			  $this->session->unset_userdata('activation_key');
			  $this->db->where('is_activation_key',$activationKey);
			  $this->db->where('is_active','Y');
			  $q = $this->db->get('pdr_customer_detail');			
			  if($q->num_rows() > 0)
			  {
				  $this->form_validation->set_rules('reset_new_pass','Password','trim|required');
				  $this->form_validation->set_rules('reset_confirm_pass','Confirm Password','trim|required|matches[reset_new_pass]');	
				  if($this->form_validation->run() == FALSE)		
				  {
					  //$data['cust_email']=$_REQUEST['cust_email'];
					  $this->load->view('header');
					  $this->load->view('register/reset_password_view');
					  $this->load->view('footer');	
				  }
				  else
				  {
					  $u_data['is_activation_key']='';
					  $u_data['cust_passwd']=md5($this->input->post('reset_new_pass'));
					  $this->db->where('is_activation_key',$activationKey);
					  $this->db->update('pdr_customer_detail',$u_data);
					  redirect('login/index/14');	
				  }
			  }
			  else 
				  redirect('login/index/2');

		}
	}
	
	function activation($keyword,$flag = '')
	{
		if($keyword == '')
			redirect('signup/index/1');
		else{
			$this->session->set_userdata('activation_key',$keyword);			
			if($flag == 'reset')
				redirect('signup/ResetPassword');
			else
			{
				$this->db->where('is_activation_key',$keyword);
				$res = $this->db->get('pdr_customer_detail');
				$temp=$res->row_array();
				if($res->num_rows() >0 && $temp['cust_id']>0)
				{
					$data['is_activation_key'] = '';
					$data['is_active'] = 'Y';
					$this->db->where('cust_id',$temp['cust_id']);
					$this->db->update('pdr_customer_detail',$data);
					redirect('login/index/11');
				}				
				else
					redirect('login/index/2');
			}
		}
	}	
	
	function registerMail($u_name,$email,$link)
	{
		$body='';
		$body='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Reset Password</title>
				</head>
				
				<body>
				<div style=" width:596px; border:2px solid #131516; margin:auto;" >
				<table width="596" border="0" cellspacing="0" cellpadding="0" bordercolor="#131516" align="center">
				  <tr>
					<td width="596" style="margin:0px; padding:0px;"><img src="'.base_url().'images/header.jpg" width="596" height="75" /></td>
				  </tr>
				  <tr>
					 <td width="596" height="45" style="background:#2d3032; margin:0px; padding:0px; border-bottom:2px solid #131516; border-top:2px solid #131516; padding-left:18px; font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#FFF; font-weight:bold;"><span style="color:#00a4e8;">W</span>elcome to MuviReviews.com</td>
				  </tr>
				  
				  <tr>
					<td width="596" bgcolor="#2d3032">
					
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					<td style="margin:0px; padding:5px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-weight:bold;" >Hi '.$u_name.'</td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#9c9b9b;" >Thank you for signing up with MuviReviews.com.We welcome you to MuviReviews.com</td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#9c9b9b;" >Your account information with MuviReviews.com is as below:</td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 8px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Username <span style="margin-left:19px;">:</span> <span style="margin-left:10px;">'.$u_name.'</span></td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Email Add	<span style="margin-left:20px;">:</span> <span style="margin-left:10px;">'.$email.'</span></td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 10px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#9c9b9b;">Please click the following link to activate your account :</td>
					</tr>
					<tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#00b7ff; text-decoration:underline;"><a style="color:#00b7ff;" href="'.$link.'">ACTIVATE MY ACCOUNT</a></td>
					</tr>
					<tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 10px 20px; font-size:14px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Thank You,</td>
					</tr>
					<tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#00b7ff;" ><a style="color:#00b7ff;" href="'.site_url().'">MuviReviews.com</a><br /><br/><br/></td>
					</tr>
					<tr>
					</table>
					
					</td>
				  </tr>
				</table>
				</div>
				</body>
				</html>';
				
		return $body;
	}
	
	function ForgetPasswordMail($u_name,$email,$link)
	{
		$body='';
		$body='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Reset Password</title>
				</head>
				
				<body>
				<div style=" width:596px; border:2px solid #131516; margin:auto;" >
				<table width="596" border="0" cellspacing="0" cellpadding="0" bordercolor="#131516" align="center">
				  <tr>
					<td width="596" style="margin:0px; padding:0px;"><img src="'.base_url().'images/header.jpg" width="596" height="75" /></td>
				  </tr>
				  <tr>
					 <td width="596" height="45" style="background:#2d3032; margin:0px; padding:0px; border-bottom:2px solid #131516; border-top:2px solid #131516; padding-left:18px; font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#FFF; font-weight:bold;"><span style="color:#00a4e8;">R</span>eset password for MuviReviews Account</td>
				  </tr>
				  
				  <tr>
					<td width="596" bgcolor="#2d3032">
					
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					<td style="margin:0px; padding:5px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-weight:bold;" >Hello</td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#9c9b9b;" >Your account information with MuviReviews.com is as below :</td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 8px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="margin-left:19px;">:</span> <span style="margin-left:10px;">'.$u_name.'</span></td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Email Add	<span style="margin-left:20px;">:</span> <span style="margin-left:10px;">'.$email.'</span></td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 10px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#9c9b9b;">Please click the following link to reset your password :</td>
					</tr>
					<tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#00b7ff; text-decoration:underline;"><a style="color:#00b7ff;" href="'.$link.'">RESET MY PASSWORD</a></td>
					</tr>
					<tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 10px 20px; font-size:14px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Thank You,</td>
					</tr>
					<tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#00b7ff;" ><a style="color:#00b7ff;" href="'.site_url().'">MuviReviews.com</a><br /><br/><br/></td>
					</tr>
					<tr>
					</table>
					
					</td>
				  </tr>
				</table>
				</div>
				</body>
				</html>';
				
		return $body;
	}
	
	function getProfInfoById($id)
	{
		$this->db->where_in('profession_id',$id);
		$this->db->where('profession_is_active','Y');
		$this->db->where('profession_is_deleted','N');			
		$Res = $this->db->get('pdr_profession_master')->result_array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['profession_id'];
			$temp['name']=$val['profession_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
		
	}
	
	function email_check($str)
	{
		$this->db->where('cust_email',$str);
//		$this->db->like('user_active','publish');
		$res = $this->db->get('pdr_customer_detail');
		if ($res->num_rows() > 0)
		{
			$this->form_validation->set_message('email_check', '%s already exist');
			return FALSE;
		}
		else
			return TRUE;
	}
	
	function sendMail1($emailId,$subject,$mail_body)
	{
		   //$fromEmail = $this->queryResult('select value from configuration where name="from_email"','value');
		   
		   $this->load->helper('phpmailer');
		   $mail = new PHPMailer();
			
		   $mail->IsSMTP();
		   $mail->IsHTML(true); // send as HTML
		   
		   $mail->SMTPAuth   = true;                  // enable SMTP authentication
		   $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		   $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		   $mail->Port       = 465;                   // set the SMTP port 
		   $mail->Username   = "niraj@artoonsolutions.com";                                     // GMAIL username
		   $mail->Password   = "artoon123";                                           // GMAIL password
	
		   $mail->From       = 'niraj@artoonsolutions.com';
		   $mail->FromName   = "Muvi Reviews";
		   $mail->Subject    = $subject;
		   $mail->Body       = $mail_body;           //HTML Body
		   
		   $emails  = explode(",",$emailId);
		   foreach($emails as $email)
				   $mail->AddAddress($email);
		   
		   if(!$mail->Send())
			 echo "Mailer Error: " . $mail->ErrorInfo;
	}	
}

?>