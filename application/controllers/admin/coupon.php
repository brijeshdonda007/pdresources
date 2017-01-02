<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends CI_Controller
{
	function Coupon()
	{
		parent::__construct();
		$this->mdl_common->checkAdminSession();
		$this->load->model('admin/mdl_coupon');
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
		$res = $this->mdl_coupon->get_coupons('',$searchtext);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/coupon/index/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		if($searchtext == "")
			$searchtext = "Search";
		
		$data['searchText'] = $searchtext;						
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();

		$this->load->view('admin/header');
		$this->load->view('admin/coupon/coupon_list',$data);
		$this->load->view('admin/footer');
	}	
	
	function addCoupon($coupon_id='')
	{
		$this->form_validation->set_rules('coupon_name','Name','trim|required');
		$this->form_validation->set_rules('coupon_code','Code','trim|required');
		$this->form_validation->set_rules('coupon_discount_amt','Amount/Percentage','trim|required|callback_validate_float');
		$this->form_validation->set_rules('coupon_expiry_date','Expiry Date','trim|required');
		//$this->form_validation->set_rules('coupon_description','Biodata','trim|required');					
		
		if($this->form_validation->run() == FALSE)
		{
			foreach($_REQUEST as $key=>$val)
			{
				$data[$key]=$val;
			}
			if($coupon_id !='')
			{
				$res = $this->mdl_coupon->get_coupons($coupon_id);
				$data = $res->row_array();																
			}			
			if($data['coupon_users'])
				$data['user_arr']=$this->GetUserById($data['coupon_users']);	
			if($data['coupon_course'])
				$data['course_arr']=$this->GetCourseById($data['coupon_course']);	
			$header['is_autofill']=true;	
			$this->load->view('admin/header',$header);
			$this->load->view('admin/coupon/addCoupon',$data);
			$this->load->view('admin/footer');
		}
		else
		{			
			$u_data['coupon_name']=$this->input->post('coupon_name');
			$u_data['coupon_code']=$this->input->post('coupon_code');
			$u_data['coupon_name']=$this->input->post('coupon_name');
			$u_data['coupon_users']=$this->input->post('coupon_users');
			$u_data['coupon_course']=$this->input->post('coupon_course');
			$u_data['coupon_type']=$this->input->post('coupon_type');
			$u_data['coupon_discount_amt']=$this->input->post('coupon_discount_amt');
			$u_data['coupon_expiry_date']=$this->input->post('coupon_expiry_date');
			$u_data['coupon_status']=$this->input->post('coupon_status');
			$u_data['coupon_usage_limit']=$this->input->post('coupon_usage_limit');
			
			$this->mdl_coupon->saveCoupon($coupon_id,$u_data);	
			redirect('admin/coupon/index/'.$start);	
		}
	}
	
	function deleteCoupon($id='')
	{
		if($id == "")
			$users = $this->input->post('city');
		else
			$users = array($id);
		
		foreach($users as $id)
		{
			$this->mdl_coupon->deleteCoupon($id);
		}
		
		$start = $this->session->userdata('start');
		redirect('admin/coupon/index/'.$start);
	}
	
	function updateActive($id,$is_active)
	{
		$data['coupon_status'] = $is_active;
		$this->db->where('coupon_id',$id);
		$this->db->update('pdr_coupon_master',$data);
	}	
	function validate_float($str)
	{	
		if(preg_match('/^[\d]+(\.[\d]+){0,1}$/',$str))
		{
			return TRUE;
		}
		else		
		{
			$this->form_validation->set_message('validate_float', 'Unvalid course ceus');
			return FALSE;
		}
	}
	
	function userlist($coupon_id,$start='s')
	{
		if($_POST || $start=='s')
		{			
			$start = 0;			
		}

		$res = $this->mdl_coupon->get_userlist($coupon_id);
		if($start == "s")
			$start = 0;		
		$data = $this->mdl_common->pagiationData('admin/coupons/'.$coupon_id.'/',$res->num_rows(),$start,'4');		
		$this->session->set_userdata('start',$start);
		
		$data['per_page_drop'] = $this->mdl_constants->per_page_drop();
		$this->load->view('admin/header');
		$this->load->view('admin/coupon/user_list',$data);
		$this->load->view('admin/footer');
	}
	
#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
															#	ADDITIONAL FUNCTION FOR THE AUTO SUGGEST
#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------	
	function GetUser()
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
	function GetUserById($author_cust_id)
	{
		$sql = "SELECT cust_id,cust_fname,cust_lname from pdr_customer_detail WHERE cust_id In (".$author_cust_id.") and is_deleted like 'N' and is_active like 'Y' ORDER BY cust_fname";
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
	function GetCourse()
	{
		$param=mysql_real_escape_string($_GET["q"]);
		$sql = "SELECT course_id,course_name from pdr_course_master WHERE (course_name LIKE '%$param%') and is_deleted like 'N' and course_is_active like 'Y' ORDER BY course_name ";

		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['course_id'];
			$temp['name']=$val['course_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
			echo $json_response;
	}	
	function GetCourseById($author_id)
	{
		$sql = "SELECT course_id,course_name from pdr_course_master WHERE course_id In (".$author_id.") and is_deleted like 'N' and course_is_active like 'Y' ORDER BY course_name";
		$Res=$this->db->query($sql)->result_array();
		$Result=array();
		foreach($Res as $key=>$val)
		{
			$temp['id']=$val['course_id'];
			$temp['name']=$val['course_name'];
			$Result[]=$temp;
		}

		# JSON-encode the response
		$json_response = json_encode($Result);		
		return $json_response;
	}

}
?>