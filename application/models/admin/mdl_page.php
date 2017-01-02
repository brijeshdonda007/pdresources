<?php
class mdl_page extends CI_Model
{
	function get_page($page_id='',$srchKey='')
	{
		if($page_id == "")
		{
			$where  = "";
			if($srchKey != '' && $srchKey != 'Search')
			{
				$srchKey = mysql_escape_string($srchKey);
				$where  = " and page_title like '%".$srchKey."%'";
			}			
			$sql = "select * from pdr_page_detail  where 1 ".$where." and page_active <>'trash'";
		}
		else
			$sql = "select * from pdr_page_detail  where page_id='".mysql_escape_string($page_id)."'";

		return $this->db->query($sql);
	}
	
	function deletePage($id)
	{
		$empInfo=$this->get_page($id)->row_array();
		if($empInfo['page_avatar'])
			@unlink($empInfo['page_avatar']);
		$data['page_active'] = "trash";
		$this->db->where('page_id',$id);
		$this->db->update('pdr_page_detail',$data);						
	}
	function savePage($page_id,$data)
	{
		if($page_id == "")
		{
			$this->db->insert('pdr_page_detail',$data);
			$page_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('page_id',$page_id);
			$this->db->update('pdr_page_detail',$data);
		}
		return $page_id;
	}
}