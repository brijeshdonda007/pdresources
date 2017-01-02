<?php
class mdl_employee extends CI_Model
{
	function get_employee($employee_id='',$srchKey='')
	{
		if($employee_id == "")
		{
			$where  = "";
			if($srchKey != '' && $srchKey != 'Search')
			{
				$srchKey = mysql_escape_string($srchKey);
				$where  = " and employee_fname like '%".$srchKey."%' or employee_lname like '%".$srchKey."%' or employee_title like '%".$srchKey."%'";
			}			
			$sql = "select * from pdr_employee_detail  where 1 ".$where." and employee_active <>'trash'";
		}
		else
			$sql = "select * from pdr_employee_detail  where employee_id='".mysql_escape_string($employee_id)."'";

		return $this->db->query($sql);
	}
	
	function deleteEmployee($id)
	{
		$empInfo=$this->get_employee($id)->row_array();
		if($empInfo['employee_avatar'])
			@unlink($empInfo['employee_avatar']);
		$data['employee_active'] = "trash";
		$this->db->where('employee_id',$id);
		$this->db->update('pdr_employee_detail',$data);						
	}
	function saveEmployee($employee_id,$data)
	{
		if($employee_id == "")
		{
			$this->db->insert('pdr_employee_detail',$data);
			$employee_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('employee_id',$employee_id);
			$this->db->update('pdr_employee_detail',$data);
		}
		return $employee_id;
	}
}