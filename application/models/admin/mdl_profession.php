<?php
class mdl_profession extends CI_Model
{
	function get_profession($profession_id ='')
	{
		if($profession_id == '')
			$sql = "select * from pdr_profession_master where profession_is_deleted ='N'";
		else
		{
			$sql = "select * from pdr_profession_master where profession_is_deleted ='N' and profession_id=".$profession_id;
		}

		return $this->db->query($sql);
	}
	
	function deleteProfession($id)
	{
		$data['profession_is_deleted'] = "Y";
		$this->db->where('profession_id',$id);
		$this->db->update('pdr_profession_master',$data);						
	}
}