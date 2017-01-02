<?php
class mdl_author extends CI_Model
{
	function get_author($author_id='',$srchKey='')
	{
		if($author_id == "")
		{
			$where  = "";
			if($srchKey != '' && $srchKey != 'Search')
			{
				$srchKey = mysql_escape_string($srchKey);
				$where  = " and author_fname like '%".$srchKey."%' or author_lname like '%".$srchKey."%' or author_title like '%".$srchKey."%'";
			}			
			$sql = "select * from pdr_author_detail  where 1 ".$where." and author_active <>'trash'";
		}
		else
			$sql = "select * from pdr_author_detail  where author_id='".mysql_escape_string($author_id)."'";

		return $this->db->query($sql);
	}
	
	function deleteAuthor($id)
	{
		$empInfo=$this->get_author($id)->row_array();
		if($empInfo['author_avatar'])
			@unlink($empInfo['author_avatar']);
		$data['author_active'] = "trash";
		$this->db->where('author_id',$id);
		$this->db->update('pdr_author_detail',$data);						
	}
	function saveAuthor($author_id,$data)
	{
		if($author_id == "")
		{
			$this->db->insert('pdr_author_detail',$data);
			$author_id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('author_id',$author_id);
			$this->db->update('pdr_author_detail',$data);
		}
		return $author_id;
	}
}