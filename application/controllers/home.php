<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Home extends CI_Controller
{
	function Home()
	{
		parent::__construct();
		$this->load->model('mdl_customer');
		$this->load->model('mdl_page');
		$this->load->model('mdl_config');
		$this->load->model('mdl_pramotion');
		$this->load->model('mdl_course');		
		$this->load->model('mdl_employee');		
		$this->load->model('mdl_test');		
	}	
	
	function index($msg_id='')
	{
		#To get All page links
		$data['EmployeeInfo']=$this->mdl_employee->GetHomePageEmployee();	
		$data['PramotionInfo']=$this->mdl_pramotion->get_pramotion();			
		$header['page_title']=$ProfInfo['profession_name'];
		$this->load->view('header',$header);
		$this->load->view('home',$data);
		$this->load->view('footer',$footer);
	}	
	
	function ValidateCart()
	{
		#To get All page links
		$data['EmployeeInfo']=$this->mdl_employee->GetHomePageEmployee();	
		$data['PramotionInfo']=$this->mdl_pramotion->get_pramotion();			
		
		$header['ErrMsg']=$this->GetCartErrors();		
		
		$this->load->view('header',$header);
		$this->load->view('home',$data);
		$this->load->view('footer',$footer);
	}	
	
	function GetEmployeeInfo($employee_id)
	{
		$EmployeeInfo=$this->mdl_employee->GetEmployeeInfoById($employee_id);
		$data['EmployeeInfo']=$EmployeeInfo;
		$this->load->view('home_employee',$data);
	}
	
	function GetCartErrors()
	{
		$oldcourses=$this->mdl_course->GetAllOldCourse();
		$AllCourses=$this->mdl_course->GetAllOldCourse(true);		
		$activearray=$nonenrolarray=$msg='';
		
		foreach($this->cart->contents() as $key=>$val)
        {
			$item_id=$val['id'];
			$CourseInfo=$this->mdl_course->get_courseInfoByid($item_id);
			if(in_array($item_id,$oldcourses))
				$activearray[]=$CourseInfo['course_name'];
			else if($CourseInfo['course_reenrolment'] == 'No')
			{
				if(in_array($item_id,$AllCourses))
				{
					$data = array(
						   'rowid' => $item_id,
						   'qty'   => 0
						);
					$this->cart->update($data); 			
					$nonenrolarray[]=$CourseInfo['course_name'];
				}																								
			}			
		}
		if(is_array($activearray))
			$activearray=implode(',',$activearray);
		if(is_array($nonenrolarray))	
			$nonenrolarray=implode(',',$nonenrolarray);		
		if($activearray || $nonenrolarray)
		{
			if($activearray)
				$msg=$this->mdl_constants->CartMessages(11).'<br>/t'.$activearray;
			if($nonenrolarray)
				$msg .=$this->mdl_constants->CartMessages(12).'<br>/t'.$nonenrolarray;			
			return $msg;
		}
		else 
			return false;
			
	}
	
	function buggyMail()
	{
		if(strlen(trim($_REQUEST['buggy_email']))<=0)
			echo 1;
		else if(!filter_var($_REQUEST['buggy_email'], FILTER_VALIDATE_EMAIL))
			echo 2;
		else if(strlen(trim($_REQUEST['buggy_msg']))<=0)
			echo 3;
		else
		{
			$flag=$this->BuggyMailContent();
			echo 'Information submitted successfully';	
		}
	}
	
	function BuggyMailContent()
	{		
		$toEmail = $_REQUEST['buggy_email'];
		$subject = "Reporting issue";						
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
					<td width="596" style="margin:0px; padding:0px;"></td>
				  </tr>
				  <tr>
					 <td width="596" height="45" style="background:#2d3032; margin:0px; padding:0px; border-bottom:2px solid #131516; border-top:2px solid #131516; padding-left:18px; font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#FFF; font-weight:bold;"><span style="color:#00a4e8;">R</span>eporing about PDR</td>
				  </tr>
				  
				  <tr>
					<td width="596" bgcolor="#2d3032">
					
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					<td style="margin:0px; padding:5px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-weight:bold;" >Hello Administrator,</td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#9c9b9b;" > Following information is got for the reporting issue</td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 8px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Email Add &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="margin-left:19px;">:</span> <span style="margin-left:10px;">'.$_REQUEST['buggy_email'].'</span></td>
					</tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Message	<span style="margin-left:20px;">:</span> <span style="margin-left:10px;">'.$_REQUEST['buggy_msg'].'</span></td>
					</tr>
					<tr>
						<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Location: <span style="margin-left:20px;">:</span> <span style="margin-left:10px;">'.$_REQUEST['current_location'].'</span></td>
					</tr>
					<tr>
						<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Report time: <span style="margin-left:20px;">:</span> <span style="margin-left:10px;">'.date('Y-m-d h:i:s',time()).'</span></td>
					</tr>
					<tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 10px 20px; font-size:14px; font-family:Tahoma, Geneva, sans-serif; color:#FFF;" >Thank You,</td>
					</tr>
					<tr>
					<tr>
					<td style="margin:0px; padding:0px 0px 20px 20px; font-size:12px; font-family:Tahoma, Geneva, sans-serif; color:#00b7ff;" ><a style="color:#00b7ff;" href="'.site_url().'">PDR</a><br /><br/><br/></td>
					</tr>
					<tr>
					</table>					
					</td>
				  </tr>
				</table>
				</div>
				</body>
				</html>';			
				$toEmail=$this->mdl_constants->AdminMail();			
		//$this->sendMail1('brijesh.donda@artoonsolutions.com',$subject,$body);  //send buggy mail
		$this->mdl_common->sendMail($toEmail,$subject,$body);  //send buggy mail
		return true;
	}
	
	function getProession()
	{
		$this->db->where('profession_is_active','Y');
		$this->db->where('profession_is_deleted','N');		
		$this->db->like('profession_name',$_GET["q"]);
		$res=$this->db->get('pdr_profession_master');		
		$Res=$res->result_array();
		//$sql = sprintf("SELECT movie_cat_id,movie_cat_title from m_movie_cat WHERE movie_cat_title LIKE '%%%s%%' and movie_cat_status Like 'publish' ORDER BY movie_cat_title ", mysql_real_escape_string($_GET["q"]));
		//$Res=$this->db->query($sql)->result_array();
		//$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['profession_id'];
			$temp['name']=$val['profession_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}
	
	function getProessionHome()
	{
		$this->db->where('profession_is_active','Y');
		$this->db->where('profession_is_deleted','N');		
		$this->db->like('profession_name',$_GET["q"]);
		$res=$this->db->get('pdr_profession_master');		
		$Res=$res->result_array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['profession_id'];
			$temp['name']=$val['profession_name'];
			$Result[]=$temp;
		}
		foreach($Res as $r)
			echo $r['profession_name']."|".$r['profession_id']."\n";
	}
	
	function GetNewArrivalCourse()
	{
		/*$temp=$this->mdl_course->getNewArrival();
		foreach($temp as $key=>$val)
		{
			$CourseInfo[]=$val;
		}
				foreach($temp as $key=>$val)
		{
			$CourseInfo[]=$val;
		}

		foreach($temp as $key=>$val)
		{
			$CourseInfo[]=$val;
		}

		$data['CourseInfo']=$CourseInfo;*/
		
		$data['CourseInfo']=$this->mdl_course->getNewArrival();
		$this->load->view('ajax/home_what_new',$data);
	}
	
	function Getpopupcart()
	{
		$flag=$_REQUEST['flag'];
		if($flag === 'popup')
			$this->load->view('cart/popupcartcontent');
		elseif($flag)
			$this->load->view('cart/cartcontent');
		else
			$this->load->view('cart/popupcart');
	
	}	
		
	function GetCourseHeader()
	{
		$this->db->where('course_is_active','Y');
		$this->db->where('is_deleted','N');		
		$this->db->like('course_name',$_GET["q"]);
		$this->db->or_like('course_desc',$_GET["q"]);
		$res=$this->db->get('pdr_course_master');		
		$Res=$res->result_array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['course_name'];
			$temp['name']=$val['course_id'];
			$Result[]=$temp;
		}
		foreach($Res as $r)
			echo $r['course_name']."|".$r['course_id']."\n";
	}
	
	function clearcart()
	{
		$this->cart->destroy();
	}
	
	function Showcart()
	{
		echo '<pre>';
print_r($this->session->userdata('cart_contents'));
echo '</pre>';

/*echo '<pre>';
print_r($this->cart->cartcontent());
echo '</pre>';
*/	}

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
		   $mail->Username   = "brijesh.donda@artoonsolutions.com";                                     // GMAIL username
		   $mail->Password   = "9924051212";                                           // GMAIL password
	
		   $mail->From       = 'brijesh.donda@artoonsolutions.com';
		   $mail->FromName   = "PDR";
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