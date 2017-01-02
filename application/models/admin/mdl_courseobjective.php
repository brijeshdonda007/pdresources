<?php
class mdl_courseobjective extends CI_Model
{
	function get_Courseobjective($objective_id ='')
	{
		if($objective_id == '')
			$sql = "select * from pdr_courseobjective_master where objective_status <>'trash'";
		else
		{
			$sql = "select * from pdr_courseobjective_master where objective_id=".$objective_id;
		}

		return $this->db->query($sql);
	}
	
	function deleteCourseobjective($id)
	{
		$data['objective_status'] = "trash";
		$this->db->where('objective_id',$id);
		$this->db->update('pdr_courseobjective_master',$data);						
	}
	function saveCourseobjective($objective_id,$data)
	{
		if($objective_id == "")
		{
			$this->db->insert('pdr_courseobjective_master',$data);
			$objective_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('objective_id',$objective_id);
			$this->db->update('pdr_courseobjective_master',$data);
		}
		return $objective_id;
	}
}