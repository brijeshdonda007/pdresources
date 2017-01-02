<?php
class mdl_pramotion extends CI_Model
{
	function get_pramotion()
	{
		$this->db->not_like('pramotion_active','trash');	
		$this->db->order_by('pramotion_id','desc');	
		$this->db->limit(1);
		$res = $this->db->get('pdr_pramotion_detail');		

		return $res->row_array();
	}		
}
