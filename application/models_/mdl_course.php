<?php
class mdl_course extends CI_Model
{
	function get_course($id='')
	{
		if($id) 
			$this->db->where('course_id',$id);	
		$res = $this->db->get('course_master');
		if($id)
			return $res->row_array();
		else
			return $res->result_array();
	}	
		
}
