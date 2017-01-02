<?php
class mdl_certificate extends CI_Model
{
	function get_accreditations($certificate_id='',$srchKey='')
	{
		if($certificate_id == "")
		{
			$where  = "";		
			$sql = "select * from pdr_certificate_detail  where 1 ".$where." and certificate_active <>'trash'";
		}
		else
			$sql = "select * from pdr_certificate_detail  where certificate_id='".mysql_escape_string($certificate_id)."'";

		return $this->db->query($sql);
	}
	
	function deleteCertificate($id)
	{
		$data['certificate_active'] = "trash";
		$this->db->where('certificate_id',$id);
		$this->db->update('pdr_certificate_detail',$data);						
	}
	function saveCertificate($certificate_id,$data)
	{
		if($certificate_id == "")
		{
			$this->db->insert('pdr_certificate_detail',$data);
			$certificate_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('certificate_id',$certificate_id);
			$this->db->update('pdr_certificate_detail',$data);
		}
		return $certificate_id;
	}
}