<?php
class mdl_coupon extends CI_Model
{
	function get_coupons($coupon_id ='')
	{
		if($coupon_id == '')
			$sql = "select * from pdr_coupon_master where coupon_status <>'trash'";
		else
		{
			$sql = "select * from pdr_coupon_master where coupon_id=".$coupon_id;
		}

		return $this->db->query($sql);
	}
	
	function deleteCoupon($id)
	{
		$data['coupon_status'] = "trash";
		$this->db->where('coupon_id',$id);
		$this->db->update('pdr_coupon_master',$data);						
	}
	function saveCoupon($coupon_id,$data)
	{
		if($coupon_id == "")
		{
			$this->db->insert('pdr_coupon_master',$data);
			$coupon_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('coupon_id',$coupon_id);
			$this->db->update('pdr_coupon_master',$data);
		}
		return $coupon_id;
	}
	function get_userlist($coupon_id)
	{
		$sql="select *,(select CONCAT(cust_fname ,' ',cust_lname ) from pdr_customer_detail where cust_id=usage_user_id ) as user_name from pdr_coupon_usage_master where usage_coupon_id=$coupon_id and usage_status='used'";
		return $this->db->query($sql);
	}
}