<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller
{
	function Order()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_order');
	}
	
	function index($start='0')
	{								
		if($_POST || $start=='s')
		{			
			$start = 0;			
			$ordertype = $this->input->post('ordertype');						
			$order_cust = $this->input->post('order_cust');	
			$start_date = $this->input->post('start_date');									
			$end_date = $this->input->post('end_date');
															
			$this->session->set_userdata('ordertype',$ordertype);			
			$this->session->set_userdata('order_cust',$order_cust);			
			$this->session->set_userdata('start_date',$start_date);			
			$this->session->set_userdata('end_date',$end_date);												
		}
		else
		{			
			$ordertype=$this->session->set_userdata('ordertype',$ordertype);			
			$order_cust=$this->session->set_userdata('order_cust',$order_cust);			
			$start_date=$this->session->set_userdata('start_date',$start_date);			
			$end_date=$this->session->set_userdata('end_date',$end_date);												
		}			
		
		$res = $this->mdl_order->get_orders($order_cust,strtotime($start_date),strtotime($end_date),$ordertype);
		$data = $this->mdl_common->pagiationData('admin/profession/index/',$res->num_rows(),$start,'4');
		$this->session->set_userdata('start',$start);			
		
		$data['ordertype']=$ordertype;
		$data['order_cust']=$order_cust;
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;
		if($order_cust)
			$data['customer_arr']=$this->GetCustomerById($order_cust);
				
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		$header['is_autofill']=true;	
		$this->load->view('admin/header',$header);
		$this->load->view('admin/order/order_list',$data);
		$this->load->view('admin/footer');
	}
			
	function editOrder($id)
	{
		$this->form_validation->set_rules('order_status','Status','trim|required');	
		if(isset($_REQUEST['comment_notify']))
			$this->form_validation->set_rules('comment_text','Comment','trim|required');	
				
		if($this->form_validation->run() == FALSE)
		{
			$user_data = $this->mdl_order->get_orderInformation($id);			
			$user_data['comment_notify'] = $this->input->post('comment_notify');			
			$this->load->view('admin/header');
			$this->load->view('admin/order/editOrder',$user_data);
			$this->load->view('admin/footer');
		}
		else
		{			
			//do update in database
			$order_id=$_REQUEST['order_id'];
			$customer_email=$_REQUEST['customer_email'];
			$comment_text=$_REQUEST['comment_text'];	
			$order_status=$_REQUEST['order_status'];
			
			$udata['order_status']=$order_status;
			$this->mdl_order->UpdateOrderInfo($id,$udata);
			
			$cdata['comment_status']=$order_status;
			$cdata['comment_text']=$comment_text;
			$cdata['comment_order_id']=$order_id;
			if($_REQUEST['comment_notify'])
				$cdata['comment_notify']='Notified';
			else
				$cdata['comment_notify']='Notification Not Applicable';
			$this->mdl_order->InsertComment($cdata);
			
			if($_REQUEST['comment_notify'])
			{
				$toEmail = $customer_email;
				//$toEmail = 'brijesh.donda@artoonsolutions.com';
				$subject = "Notification Mail";						
				$body=$comment_text;
				$this->sendMail1('brijesh.donda@artoonsolutions.com',$subject,$body);  //send notification mail
			    //$this->mdl_common->sendMail($toEmail,$subject,$body);  //send buggy mail
			}			
			
			$start = $this->session->userdata('start');
			redirect('admin/order/index/'.$start);
		}
	}
	
	function deleteOrder($id='')
	{
		if($id == "")
			$users = $this->input->post('orders');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_order->deleteOrder($id);
		}
		
		$start = $this->session->userdata('start');
				
			redirect('admin/profession/index/'.$start);
	}
	
	
	function GetCustomer()
	{
		$param=mysql_real_escape_string($_GET["q"]);
		$sql = "SELECT cust_id,cust_fname,cust_lname from pdr_customer_detail WHERE (cust_fname LIKE '%$param%' or cust_lname LIKE '%$param%') and is_deleted like 'N' and is_active like 'Y' ORDER BY cust_fname ";

		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['cust_id'];
			$temp['name']=$val['cust_fname'].' '.$val['cust_lname'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}	
	
	function GetCustomerById($cust_id)
	{
		$sql = "SELECT cust_id,cust_fname,cust_lname from pdr_customer_detail WHERE cust_id In (".$cust_id.") and is_deleted like 'N' and is_active like 'Y' ORDER BY cust_fname";
		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['cust_id'];
			$temp['name']=$val['cust_fname'].' '.$val['cust_lname'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
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