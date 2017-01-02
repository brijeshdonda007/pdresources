<?php
class mdl_signup extends CI_Model
{
	function saveUserData($data,$cust_id = '')
	{
		if($cust_id != ''){
			$this->db->where('cust_id',$cust_id);
			return $this->db->update('pdr_customer_detail',$data);
		}
		else
			return $this->db->insert('pdr_customer_detail',$data);
	}
	
	function get_user_info($cust_id = '',$select = '',$value = '')
	{
		if($cust_id != '')
			$this->db->where('cust_id',$cust_id);
		if($select != '' && $value != '')
			$this->db->where($select,$value);
		$this->db->select($select);
		$res = $this->db->get('pdr_customer_detail');

		if($cust_id != '' || ($select != '' && $value != ''))
			return $res->row_array();
		else
			return $res->result();
	}	
}
?>