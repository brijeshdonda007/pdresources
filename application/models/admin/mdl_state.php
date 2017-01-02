<?php
class mdl_state extends CI_Model
{
	function get_state($state_id ='')
	{
		if($state_id == '')
			$sql = "select * from pdr_state_master where state_is_deleted ='N'";
		else
		{
			$sql = "select * from pdr_state_master where state_id=".$state_id;
		}

		return $this->db->query($sql);
	}
	
	function deleteState($id)
	{
		$data['state_is_deleted'] = "Y";
		$this->db->where('state_id',$id);
		$this->db->update('pdr_state_master',$data);						
	}
}