<?php
class mdl_config extends CI_Model
{
	function get_allconfig($id='')
	{
		if($id)
			$this->db->where('config_id',$id);	
		$this->db->not_like('config_active','trash');	
		$res = $this->db->get('pdr_config_detail');
		if($id)
			return $res->row_array();
		else
			return $res->result_array();
	}		
	function getAllUrlConfig()
	{
		$this->db->like('config_type','url');	
		$this->db->not_like('config_active','trash');	
		$res = $this->db->get('pdr_config_detail');
		return $res->result_array();
	}
}
