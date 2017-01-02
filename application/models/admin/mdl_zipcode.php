<?php
class mdl_zipcode extends CI_Model
{
	function get_zipcode($zipcode_id ='')
	{
		if($zipcode_id == '')
			$sql = "select * from pdr_zipcode_master where zipcode_status <>'trash'";
		else
		{
			$sql = "select * from pdr_zipcode_master where zipcode_id=".$zipcode_id;
		}

		return $this->db->query($sql);
	}
	
	function deleteZipcode($id)
	{
		$data['zipcode_status'] = "trash";
		$this->db->where('zipcode_id',$id);
		$this->db->update('pdr_zipcode_master',$data);						
	}
	function saveZipcode($zipcode_id,$data)
	{
		if($zipcode_id == "")
		{
			$this->db->insert('pdr_zipcode_master',$data);
			$zipcode_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('zipcode_id',$zipcode_id);
			$this->db->update('pdr_zipcode_master',$data);
		}
		return $zipcode_id;
	}
}