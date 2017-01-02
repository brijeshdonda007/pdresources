<?php
class mdl_accreditations extends CI_Model
{
	function get_accreditations($accreditations_id='',$srchKey='')
	{
		if($accreditations_id == "")
		{
			$where  = "";
			if($srchKey != '' && $srchKey != 'Search')
			{
				$srchKey = mysql_escape_string($srchKey);
				$where  = " and accreditations_fname like '%".$srchKey."%' or accreditations_lname like '%".$srchKey."%' or accreditations_title like '%".$srchKey."%'";
			}			
			$sql = "select * from pdr_accreditations_detail  where 1 ".$where." and accreditations_active <>'trash'";
		}
		else
			$sql = "select * from pdr_accreditations_detail  where accreditations_id='".mysql_escape_string($accreditations_id)."'";

		return $this->db->query($sql);
	}
	
	function deleteAccreditaions($id)
	{
		$empInfo=$this->get_accreditations($id)->row_array();
		if($empInfo['accreditations_avatar'])
			@unlink($empInfo['accreditations_avatar']);
		$data['accreditations_active'] = "trash";
		$this->db->where('accreditations_id',$id);
		$this->db->update('pdr_accreditations_detail',$data);						
	}
	function saveAccreditaions($accreditations_id,$data)
	{
		if($accreditations_id == "")
		{
			$this->db->insert('pdr_accreditations_detail',$data);
			$accreditations_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('accreditations_id',$accreditations_id);
			$this->db->update('pdr_accreditations_detail',$data);
		}
		return $accreditations_id;
	}
}