<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Order extends CI_Controller
{
	function Order()
	{
		parent::__construct();
		$this->load->model('mdl_customer');
		$this->load->model('mdl_coupon');
		$this->load->model('mdl_config');
		$this->load->model('mdl_course');		
	}
		
	function index()
	{		
		$order_id=$this->OrderInsert();
		$this->OrderCourseInsert($order_id);
		$this->UpdateCouponOrder($order_id);		
		$this->cart->destroy();
		redirect('dashboard');					
		//echo $this->db->last_query();
		//echo 'inserted';	
	}
	
	function OrderInsert()
	{
		$CoupounInfo=$this->cart->has_coupon();
		$SubTotal=$this->cart->sub_total();
		$DiscountTotal=$this->cart->discount_total();
		$GrandTotal=$this->cart->total();
		$TotalItems=$this->cart->total_items();
		
		$udata['order_cust_id']=$this->session->userdata('cust_id');
		$udata['order_coupon_info']=serialize($CoupounInfo);
		$udata['order_sub_total']=$SubTotal;
		$udata['order_discount_amt']=$DiscountTotal;
		$udata['order_total']=$GrandTotal;
		$udata['order_total_items']=$TotalItems;
		$udata['order_status']='Processing';
		$udata['order_visibility']='publish';
		$this->db->insert('pdr_order_details',$udata);
		return $this->db->insert_id();
	}
	
	function OrderCourseInsert($order_id)
	{
		$ItemInfo=$this->cart->contents();	
		foreach($ItemInfo as $key=>$val)
		{
			$udata=array();
			$udata['ocd_course_id']=$val['id'];
			$udata['ocd_course_sub_total']=$val['subtotal'];
			$udata['ocd_discount_amt']=$val['discount']?$val['discount']:0;
			$udata['ocd_course_total']=$val['total'];			
			$udata['ocd_order_id']=$order_id;
			$this->db->insert('pdr_order_course_detail',$udata);			
		}
	}
	
	function UpdateCouponOrder($order_id)
	{
		$CoupounInfo=$this->cart->has_coupon();		
		$user_id=$this->session->userdata('cust_id');
		$data['usage_order_id']=$order_id;
		$this->db->where('usage_coupon_id',$CoupounInfo['coupon_id']);
		$this->db->where('usage_user_id',$user_id);
		$this->db->where('usage_status','Used');
		$this->db->where('usage_order_id',0);		
		$this->db->like('usage_date',date('Y-m-d'));
		$this->db->update('pdr_coupon_usage_master',$data);	
	}
}
?>