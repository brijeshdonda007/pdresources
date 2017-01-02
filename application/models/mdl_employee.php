<?php
class mdl_employee extends CI_Model
{
	function GetHomePageEmployee()
	{
		$this->db->where('employee_active','publish');	
		$this->db->where('employee_diplay_home','Yes');	
		$this->db->order_by('RAND()');	
		$this->db->limit(3);
		$res = $this->db->get('pdr_employee_detail');		

		return $res->result_array();
	}		
	function GetEmployeeInfoById($employee_id)
	{
		$this->db->where('employee_id',$employee_id);	
		$this->db->where('employee_active','publish');			
		$res = $this->db->get('pdr_employee_detail');		
		return $res->row_array();
	}		
}
