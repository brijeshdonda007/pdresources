<?php
class mdl_page extends CI_Model
{
	function get_page($id='')
	{
		if($id) 
			$this->db->where('page_id',$id);	
		$this->db->like('page_active','publish');	
		$res = $this->db->get('pdr_page_detail');
		if($id)
			return $res->row_array();
		else
			return $res->result_array();
	}
	
	function get_header_page()
	{
		$this->db->where('page_disp_header','Yes');	
		$this->db->like('page_active','publish');	
		$res = $this->db->get('pdr_page_detail');		
		return $res->result_array();
	}				
}
