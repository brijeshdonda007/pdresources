<?php
class mdl_customer extends CI_Model
{
	function get_customers($cust_id='',$srchKey='')
	{
		if($cust_id == "")
		{
			$where  = "";
			if($srchKey != '' && $srchKey != 'Search')
			{
				$srchKey = mysql_escape_string($srchKey);
				$where  = " and cust_fname like '%".$srchKey."%' or cust_lname like '%".$srchKey."%' or cust_email like '%".$srchKey."%'";
			}			
			$sql = "select * from pdr_customer_detail  where 1 ".$where." and is_deleted='N'";
		}
		else
			$sql = "select * from pdr_customer_detail  where cust_id='".mysql_escape_string($cust_id)."'";

		return $this->db->query($sql);
	}
	
	function deleteCustomer($id)
	{
		$data['is_deleted'] = "Y";
		$this->db->where('cust_id',$id);
		$this->db->update('pdr_customer_detail',$data);						
	}
	
	function saveCustomer($cust_id,$data)
	{
		if($cust_id == "")
		{
			$this->db->insert('pdr_customer_detail',$data);
			$cust_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('cust_id',$cust_id);
			$this->db->update('pdr_customer_detail',$data);
		}
		return $cust_id;
	}
	
	function get_tests($status='',$cust_id)
	{
		if($status == 'Completed')
			$param="and current_responce like 'Completed'";
		else if($status == "Stop")
			$param="and current_responce like 'Stop'";
		else
			$param='';
		
		$sql="select *,(select IFNULL(test_name,'') from pdr_test_master where test_id=cr.test_id and is_active like 'Y' and is_deleted like 'N') as test_name
				,(select count(*) from pdr_customer_test_response_detail where cust_id=cr.cust_id and course_id=cr.course_id and test_id=cr.test_id and order_id=cr.order_id and is_correct like 'right') as right_count 
				,(select count(*) from pdr_customer_test_response_detail where cust_id=cr.cust_id and course_id=cr.course_id and test_id=cr.test_id and order_id=cr.order_id and is_correct like 'wrong') as wrong_count
				,(select count(*) from pdr_customer_test_response_detail where cust_id=cr.cust_id and course_id=cr.course_id and test_id=cr.test_id and order_id=cr.order_id and is_correct like 'skip') as skip_count
				from pdr_customer_test_response as cr where cust_id=$cust_id and responce_status <> 'trash' $param order by test_date desc";
		return $this->db->query($sql);
		
	}
	
	function get_coupons($cust_id)
	{
		$sql="select *,(select coupon_name from pdr_coupon_master where coupon_id=usage_coupon_id ) as coupon_name from pdr_coupon_usage_master where usage_user_id=$cust_id and usage_status='used'";
		return $this->db->query($sql);
	}
	
	function get_orders($status='',$cust_id)
	{
		if($status == 'Completed')
			$param="and order_status like 'Completed'";
		else if($status == "Processing")
			$param="and order_status like 'Processing'";
		else if($status == "Canceled")
			$param="and order_status like 'Canceled'";	
		else
			$param='';
		
		$sql="select * from pdr_order_details where order_cust_id=$cust_id and order_visibility <> 'trash' $param order by order_date desc";
		return $this->db->query($sql);
		
	}
}