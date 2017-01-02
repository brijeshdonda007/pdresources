<?php
class mdl_order extends CI_Model
{
	function GetOrderDate($order_id='')
	{
		$this->db->where('order_id',$order_id);	
		$res=$this->db->get('pdr_order_details');	
		return $res->row_array();
	}	
}