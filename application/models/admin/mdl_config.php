<?php
class mdl_config extends CI_Model
{
	function get_config($config_id='',$srchKey='')
	{
		if($config_id == "")
		{
			$where  = "";
			if($srchKey != '' && $srchKey != 'Search')
			{
				$srchKey = mysql_escape_string($srchKey);
				$where  = " and config_title like '%".$srchKey."%' or config_description like '%".$srchKey."%'";
			}			
			$sql = "select * from pdr_config_detail  where 1 ".$where." and config_active <>'trash'";
		}
		else
			$sql = "select * from pdr_config_detail  where config_id='".mysql_escape_string($config_id)."'";

		return $this->db->query($sql);
	}
	
	function deleteConfig($id)
	{
		$empInfo=$this->get_config($id)->row_array();
		if($empInfo['config_avatar'])
			@unlink($empInfo['config_avatar']);
		$data['config_active'] = "trash";
		$this->db->where('config_id',$id);
		$this->db->update('pdr_config_detail',$data);						
	}
	function saveConfig($config_id,$data)
	{
		if($config_id == "")
		{
			$this->db->insert('pdr_config_detail',$data);
			$config_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('config_id',$config_id);
			$this->db->update('pdr_config_detail',$data);
		}
		return $config_id;
	}
}