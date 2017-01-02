<?php
class mdl_city extends CI_Model
{
	function get_city($city_id ='')
	{
		if($city_id == '')
			$sql = "select * from pdr_city_master where city_status <>'trash'";
		else
		{
			$sql = "select * from pdr_city_master where city_id=".$city_id;
		}

		return $this->db->query($sql);
	}
	
	function deleteCity($id)
	{
		$data['city_status'] = "trash";
		$this->db->where('city_id',$id);
		$this->db->update('pdr_city_master',$data);						
	}
	function saveCity($city_id,$data)
	{
		if($city_id == "")
		{
			$this->db->insert('pdr_city_master',$data);
			$city_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('city_id',$city_id);
			$this->db->update('pdr_city_master',$data);
		}
		return $city_id;
	}
}