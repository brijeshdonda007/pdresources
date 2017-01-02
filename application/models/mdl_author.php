<?php
class mdl_author extends CI_Model
{
	function GetAuthourforProfession($prof_id,$corse_id)
	{
		$sql='select *,(select count(*) from pdr_course_master where course_author=author_id and course_is_active like "publish" and course_id in('.$corse_id.')) as count from pdr_author_detail where author_active like "publish" order by count desc limit 0,1';
		$res=$this->db->query($sql);
		return $res->row_array();
	}	
	function getAuthuonfoById($author_id)		
	{
		$this->db->where_in('author_id',$author_id);
		$this->db->where('author_active','publish');
		$res=$this->db->get('pdr_author_detail');
		return $res->row_array();
	}
}
