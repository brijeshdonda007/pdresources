<?php
class mdl_order extends CI_Model
{
	function get_orders($cust_ids,$startdate='',$enddate='',$status)
	{
		$param='';
		if($cust_ids)
			$param=" and order_cust_id IN($cust_ids)";
		if($startdate && $enddate)
			$param .=" and order_date between $startdate and $enddate ";
		if($status == 'Completed')
			$param .="and order_status like 'Completed'";
		else if($status == "Processing")
			$param .="and order_status like 'Processing'";
		else if($status == "Canceled")
			$param .="and order_status like 'Canceled'";
				
		$sql = "select *,(select CONCAT(cust_fname,' ',IFNULL(cust_lname,' ')) from pdr_customer_detail where cust_id=order_cust_id) as customer_name from pdr_order_details where order_visibility <> 'trash' $param order by order_date desc";	
		return $this->db->query($sql);
	}
	
	function get_orderInformation($order_id)
	{
		$sql="select * from pdr_order_details where order_id=".$order_id;
		$res=$this->db->query($sql);
		$OrderInfo=$res->row_array();
		
		$sql1="select *,(select course_name from pdr_course_master where course_id=ocd_course_id) as course_name from pdr_order_course_detail where ocd_order_id=".$order_id;
		$res1=$this->db->query($sql1);
		$OrderInfo['CourseInfo']=$res1->result_array();
		
		$sql2="select * from pdr_customer_detail where cust_id=".$OrderInfo['order_cust_id'];
		$res2=$this->db->query($sql2);
		$OrderInfo['CustomerInfo']=$res2->row_array();
		
		$sql1="select * from pdr_order_comment where comment_order_id=".$order_id;
		$res1=$this->db->query($sql1);
		$OrderInfo['CommentHistory']=$res1->result_array();
		return $OrderInfo;
	}
	
	function UpdateOrderInfo($id,$data)
	{
		$this->db->where('order_id',$id);
		$this->db->update('pdr_order_details',$data);
	}
	
	function InsertComment($data)
	{
		$this->db->insert('pdr_order_comment',$data);
	}
	
	function deleteOrder($id)
	{
		$data['order_visibility'] = "trash";
		$this->db->where('order_id',$id);
		$this->db->update('pdr_order_details',$data);						
	}
}