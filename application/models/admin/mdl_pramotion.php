<?php
class mdl_pramotion extends CI_Model
{
	function get_pramotion($pramotion_id='',$srchKey='')
	{
		if($pramotion_id == "")
		{
			$where  = "";
			if($srchKey != '' && $srchKey != 'Search')
			{
				$srchKey = mysql_escape_string($srchKey);
				$where  = " and pramotion_url like '%".$srchKey."%'";
			}			
			$sql = "select * from pdr_pramotion_detail  where 1 ".$where." and pramotion_active <>'trash'";
		}
		else
			$sql = "select * from pdr_pramotion_detail  where pramotion_id='".mysql_escape_string($pramotion_id)."'";

		return $this->db->query($sql);
	}
	
	function deletePramotion($id)
	{
		$empInfo=$this->get_pramotion($id)->row_array();
		if($empInfo['pramotion_avatar'])
			@unlink($empInfo['pramotion_avatar']);
		$data['pramotion_active'] = "trash";
		$this->db->where('pramotion_id',$id);
		$this->db->update('pdr_pramotion_detail',$data);						
	}
	function savePramotion($pramotion_id,$data)
	{
		if($pramotion_id == "")
		{
			$this->db->insert('pdr_pramotion_detail',$data);
			$pramotion_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('pramotion_id',$pramotion_id);
			$this->db->update('pdr_pramotion_detail',$data);
		}
		return $pramotion_id;
	}
}